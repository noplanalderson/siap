<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Running_text extends SIAP_Backend {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();

		$this->load->model('running_text_m');
	}

	public function index()
	{
		if($this->input->is_ajax_request() == true)
		{
			if(!empty($this->input->post('text_id', TRUE)))
			{
				$this->form_validation->set_rules('text_id', 'ID Text', 'required|exact_length[13]|alpha_numeric');
				if ($this->form_validation->run() == TRUE) 
				{
					$status = 1;
					$data 	= $this->running_text_m->text($this->input->post('text_id', TRUE));
					$msg  	= empty($data) ? 'Text tidak ditemukan.' : '';
				} 
				else 
				{
					$status = 0;
					$data 	= [];
					$msg  	= validation_errors();
				}

				$token 	= $this->security->get_csrf_hash();
				$result = array('result' => $status, 'token' => $token, 'msg' => $msg, 'text' => $data);
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}
			else
			{
				$result = ['data' => $this->running_text_m->texts()];
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}
		}
		else
		{
			$this->css_plugin = array(
				'datatables/datatables.min'
			);

			$this->js_plugin = array(
				'datatables/datatables.min'
			);
			$this->_module 	= 'backend/v_running_text';
			
			$this->js 		= 'running_text';

			$this->_data 	= array(
				'title' 	=> $this->app->site_name . ' - Running Text',
				'btn_tambah'=> $this->app_m->getContentMenu('tambah-teks')
			);

			$this->load_view();
		}
	}

	public function tambah()
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules('text', 'Text', 'required|max_length[255]|regex_match[/[a-zA-Z0-9 \/\-_,.&@?()]+/]');
		$this->form_validation->set_rules('status', 'Status', 'required|in_list[show,hide]');

		if ($this->form_validation->run() == TRUE) 
		{
	        $text_id 	= uniqidReal();
			$status 	= $this->running_text_m->tambah($text_id, $post);
			$msg 		= ($status === 1) ? 'Running text ditambahkan.' : 'Gagal menambahkan running text.';
		} 
		else 
		{
			$msg = validation_errors();
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function ubah()
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules('text_id', 'ID Teks', 'required|exact_length[13]|alpha_numeric');
		$this->form_validation->set_rules('text', 'Text', 'required|max_length[255]|regex_match[/[a-zA-Z0-9 \-_,.&@?()]+/]');
		$this->form_validation->set_rules('status', 'Status', 'required|in_list[show,hide]');

		if ($this->form_validation->run() == TRUE) 
		{
			$status = $this->running_text_m->ubah($post);
			$msg 	= ($status === 1) ? 'Running text disimpan.' : 'Gagal menyimpan running text.';
		} 
		else 
		{
			$msg = validation_errors();
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function hapus()
	{
		$status 	= 0;
		$text_id 	= $this->input->post('text_id', TRUE);

		$this->form_validation->set_rules('text_id', 'ID Text', 'required|alpha_numeric|exact_length[13]');
		if ($this->form_validation->run() == TRUE) 
		{
			$status = $this->running_text_m->hapus($text_id);
			$msg = ($status === 1) ? 'Text dihapus.' : 'Text gagal dihapus.';
		} 
		else 
		{
			$msg = validation_errors();
		}

		$result = array('result' => $status, 'msg' => $msg, 'token' => $this->security->get_csrf_hash());
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}