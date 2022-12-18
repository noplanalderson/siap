<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_user extends SIAP_Backend {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();
		$this->load->model('user_m');
	}

	public function index()
	{
		if($this->input->is_ajax_request() == true)
		{	
			if(!empty($this->input->post('user_id', TRUE)))
			{
				$this->form_validation->set_rules(
					'user_id', 
					'ID User',
					'required|alpha_numeric|exact_length[13]',
				);

				if ($this->form_validation->run() == TRUE) 
				{
					$status = 1;
					$data 	= $this->user_m->user($this->input->post('user_id', TRUE));
					$msg  	= empty($data) ? 'User tidak ditemukan.' : '';
				} 
				else 
				{
					$status = 0;
					$data 	= [];
					$msg  	= validation_errors();
				}

				$token 	= $this->security->get_csrf_hash();
				$result = array('result' => $status, 'token' => $token, 'msg' => $msg, 'user' => $data);
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}
			else
			{
				$result = ['data' => $this->user_m->daftarUser()];
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}
		}
		else
		{
			$this->css_plugin = 'datatables/datatables.min';

			$this->js_plugin = 'datatables/datatables.min';

			$this->_module 	= 'backend/v_manajemen_user';
			
			$this->js 		= 'manajemen_user';

			$this->_data 	= array(
				'title' 	=> $this->app->site_name . ' - Manajemen User',
				'user_group'=> $this->user_m->userGroup(),
				'btn_tambah'=> $this->app_m->getContentMenu('tambah-user')
			);

			$this->load_view();
		}
	}

	private function __rules()
	{
		$rules = array(
			array(
				'field' => 'group_id',
				'label' => 'ID Grup',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'employee_name',
				'label' => 'Nama Petugas',
				'rules' => 'trim|required|regex_match[/[a-zA-Z ,.\']+$/]|min_length[3]|max_length[255]',
				'errors'=> array(
					'regex_match' => 'Karakter yang diizinkan untuk {field} adalah [a-zA-Z ,.\'].'
				)
			),
			array(
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'trim|required|regex_match[/[a-z0-9_]+/]|min_length[3]|max_length[255]',
				'errors'=> array(
					'regex_match' => 'Karakter yang diizinkan untuk {field} adalah [a-z0-9_].'
				)
			),
			array(
				'field' => 'user_password',
		        'label' => 'Kata Sandi',
		        'rules' => 'required'
			),
			array(
				'field' => 'repeat_password',
		        'label' => 'Kata Sandi',
		        'rules' => 'required|matches[user_password]'
			),
			array(
				'field' => 'status',
		        'label' => 'Status Akun'
			)
		);

		return $rules;
	}

	public function tambah()
	{
		$status = 0;
		$msg 	= [];
		$post 	= $this->input->post(null, TRUE);
		$user_id= uniqidReal();

		$this->form_validation->set_rules(
			'username', 
			'Username', 
			'trim|required|regex_match[/[a-z0-9_]+$/]|min_length[3]|max_length[255]|is_unique[tb_user.username]',
			[
				'regex_match' => 'Karakter yang diizinkan untuk {field} adalah [a-zA-Z0-9_].',
			]
		);
		$this->form_validation->set_rules($this->__rules());
		
		if ($this->form_validation->run() == TRUE) 
		{
			$userdir = './_/uploads/users/' . $user_id .'/';
			if(!is_dir($userdir)) mkdir($userdir, 0755);

			$config = array(
				'upload_path' => $userdir,
				'file_ext_tolower' => true,
				'allowed_types' => 'jpeg|jpg|png',
				'max_size' => '5028',
				'detect_mime' => true,
				'remove_spaces' => true
			);
			
			$this->load->library('upload');
			$this->load->initialize($config);
			
			if ( ! $this->upload->do_upload('foto'))
			{
				$msg[] 	= $this->upload->display_errors('<p>', '</p>');
				$foto 	= 'user.jpg';

				@copy(FCPATH . '_/img/user.jpg', $userdir.'.user.jpg');
			}
			else
			{
				$data = $this->upload->data();
				$foto = $data['file_name'];
			}

			$status = $this->user_m->tambah($post, $user_id, $foto);
			$msg[] 	= ($status === 1) ? 'User berhasil ditambahkan.' : 'User gagal ditambahkan.';
		} 
		else 
		{
			$msg[] = validation_errors();
		}

		$result = array('token' => $this->security->get_csrf_hash(), 'result' => $status, 'msg' => implode('', $msg));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function ubah()
	{
		$status = 0;
		$msg 	= [];
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->__rules());
		
		if ($this->form_validation->run() == TRUE) 
		{
			if($this->user_m->cekUsername($post) == 0)
			{
				$path = FCPATH . '_/uploads/users/'.$post['user_id'].'/';
				if(!is_dir($path)) mkdir($path, 0755);

				$config = array(
					'upload_path' => $path,
					'file_ext_tolower' => true,
					'allowed_types' => 'jpeg|jpg|png',
					'max_size' => '5200',
					'remove_spaces' => true,
					'max_filename' => '250',
					'detect_mime' => true
				);
				
				$this->load->library('upload');
				$this->upload->initialize($config);
				
				if ( ! $this->upload->do_upload('foto'))
				{
					$msg[] = $this->upload->display_errors('<p>','</p>');
					$foto  = 'user.jpg';
				}
				else
				{
					$data = $this->upload->data();
					$foto = $data['file_name'];
				}

				$status = $this->user_m->ubah($post, $foto);
				$msg[] 	= ($status === 1) ? 'User berhasil diperbarui.' : 'User gagal diperbarui.';
			}
			else
			{
				$msg[] = 'Username sudah terdaftar.';
			}
		} 
		else 
		{
			$msg[] = validation_errors();
		}

		$result = array('token' => $this->security->get_csrf_hash(), 'result' => $status, 'msg' => implode('', $msg));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function hapus()
	{
		$status 	= 0;
		$user_id = $this->input->post('user_id', TRUE);

		$this->form_validation->set_rules('user_id', 'ID User', 'required|exact_length[13]|alpha_numeric');
		if ($this->form_validation->run() == TRUE) 
		{
			remove_dir(FCPATH . '_/uploads/users/'.$user_id);
			
			$status = $this->user_m->hapus($user_id);
			$msg 	= ($status === 1) ? 'User dihapus.' : 'User gagal dihapus.';
		} 
		else 
		{
			$msg = validation_errors();
		}

		$result = array('result' => $status, 'msg' => $msg, 'token' => $this->security->get_csrf_hash());
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}