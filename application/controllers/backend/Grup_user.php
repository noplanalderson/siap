<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grup_user extends SIAP_Backend {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();
		$this->load->model('grup_user_m');
	}

	public function index()
	{
		if($this->input->is_ajax_request() == true)
		{	
			if(!empty($this->input->post('group_id', TRUE)))
			{
				$this->form_validation->set_rules(
					'group_id', 
					'ID Grup',
					'required|integer'
				);

				if ($this->form_validation->run() == TRUE) 
				{
					$status = 1;
					$data 	= $this->grup_user_m->grup($this->input->post('group_id', TRUE));
					$msg  	= empty($data) ? 'Grup user tidak ditemukan.' : '';
				} 
				else 
				{
					$status = 0;
					$data 	= [];
					$msg  	= validation_errors();
				}

				$token 	= $this->security->get_csrf_hash();
				$result = array('result' => $status, 'token' => $token, 'msg' => $msg, 'grup' => $data);
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}
			else
			{
				foreach ($this->grup_user_m->grup() as $grup) {
					$ug[] = array(
						'group_name' => $grup->group_name,
						'group_id' => $grup->group_id,
						'fitur' => $this->grup_user_m->getFeaturesByGroupID($grup->group_id),
						'mode' => $grup->mode,
						'index_menu' => $this->grup_user_m->getIndexMenu($grup->group_id, $grup->index_menu)
					);
				}
				$this->output->set_content_type('application/json')->set_output(json_encode(['data' => $ug]));
			}
		}
		else
		{
			$this->css_plugin = 'datatables/datatables.min';

			$this->js_plugin = 'datatables/datatables.min';

			$this->_module 	= 'backend/v_grup_user';
			
			$this->js 		= 'grup_user';

			$this->_data 	= array(
				'title' 	=> $this->app->site_name . ' - Grup User',
				'btn_tambah'=> $this->app_m->getContentMenu('tambah-grup')
			);

			$this->load_view();
		}
	}

	public function menu()
	{
		if($this->input->is_ajax_request() == true)
		{
			$mode = $this->input->get('mode', TRUE);
			$mode = ($mode !== '') ? (($mode == 'rw') ? 'w' : 'r') : null;

			$result = $this->grup_user_m->getFeatures($mode);
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	private function __rules()
	{
		$rules = array(
			array(
				'field' => 'mode',
				'label' => 'Mode Grup',
				'rules' => 'required|in_list[r,rw]'
			),
			array(
				'field' => 'fitur[]',
				'label' => 'Fitur',
				'rules' => 'required|alpha_dash'
			)
		);

		return $rules;
	}

	public function tambah()
	{
		$status = 0;
		$msg 	= '';
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules([
			'field' => 'group_name',
			'label' => 'Nama Grup',
			'rules' => 'trim|required|alpha_numeric|max_length[100]|is_unique[tb_user_group.group_name]'
		]);
		$this->form_validation->set_rules($this->__rules());

		if ($this->form_validation->run() == TRUE) 
		{
			$status = $this->grup_user_m->tambah($post);
			$msg 	= ($status === 1) ? 'Grup '.$post['group_name'] .' ditambahkan.' : 'Grup gagal ditambahkan.';
		} 
		else 
		{
			$msg = validation_errors();
		}

		$result = array('token' => $this->security->get_csrf_hash(), 'result' => $status, 'msg' => $msg);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function ubah()
	{
		$status = 0;
		$msg 	= '';
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules(array([
			'field' => 'group_name',
			'label' => 'Nama Grup',
			'rules' => 'trim|required|alpha_numeric|max_length[100]'
		],
		[
			'field' => 'group_id',
			'label' => 'ID Grup',
			'rules' => 'required|integer'
		]));
		$this->form_validation->set_rules($this->__rules());

		if ($this->form_validation->run() == TRUE) 
		{
			if($this->grup_user_m->checkGroup($post) == 0)
			{
				$status = $this->grup_user_m->ubah($post);
				$msg 	= ($status === 1) ? 'Perubahan disimpan.' : 'Gagal menyimpan perubahan.';

				$this->cache->delete('simpok_menu_'.$this->user_hash);
			}
			else
			{
				$msg = 'Grup sudah ada.';
			}
		} 
		else 
		{
			$msg = validation_errors();
		}

		$result = array('token' => $this->security->get_csrf_hash(), 'result' => $status, 'msg' => $msg);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function hapus()
	{
		$status	= 0;
		$msg 	= '';
		$post 	= $this->input->post(null, TRUE);
		
		$this->form_validation->set_rules(
			'group_id',
			'ID Grup',
			'required|integer',
			array(
				'required' => '{field} wajib diisi.',
				'integer' => '{field} tidak valid.'
			)
		);

		if ($this->form_validation->run() == FALSE) 
		{
			$msg = validation_errors();
		}
		else
		{
			$status = ($this->grup_user_m->hapus($post['group_id']) === true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Grup dihapus.' : 'Gagal menghapus grup.';
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update_index()
	{
		$data 	= $this->input->post(null, TRUE);
		$status = 0;

		$this->form_validation->set_rules(
			'group_id',
			'ID Grup',
			'required|integer'
		);
		$this->form_validation->set_rules(
			'index_menu',
			'Index',
			'trim|required|regex_match[/[a-z\-]+$/]'
		);

		if ($this->form_validation->run() == TRUE) 
		{
			$status = ($this->grup_user_m->updateIndex($data) === true) ? 1 : 0;
			$msg = ($status === 1) ? 'Index berhasil diubah.' : 'Gagal merubah index.';
		}
		else
		{
			$msg = validation_errors();
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'token' => $token, 'msg' => $msg);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}