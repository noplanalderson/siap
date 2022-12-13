<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operator extends SIAP_Backend {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();

		$this->load->model('operator_m');
	}

	public function index()
	{
		if($this->input->is_ajax_request() == true)
		{
			if(!empty($this->input->post('operator_id', TRUE)))
			{
				$this->form_validation->set_rules('operator_id', 'ID Operator', 'required|exact_length[13]|alpha_numeric');
				if ($this->form_validation->run() == TRUE) 
				{
					$status = 1;
					$data 	= $this->operator_m->operator($this->input->post('operator_id', TRUE));
					$msg  	= empty($data) ? 'Operator tidak ditemukan.' : '';
				} 
				else 
				{
					$status = 0;
					$data 	= [];
					$msg  	= validation_errors();
				}

				$token 	= $this->security->get_csrf_hash();
				$result = array('result' => $status, 'token' => $token, 'msg' => $msg, 'operator' => $data);
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}
			else
			{
				$result = ['data' => $this->operator_m->operators()];
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
			$this->_module 	= 'backend/v_operator';
			
			$this->js 		= 'operator';

			$this->_data 	= array(
				'title' 	=> $this->app->site_name . ' - Operator',
				'users'		=> $this->operator_m->users(),
				'counters'	=> $this->operator_m->counters(),
				'btn_tambah'=> $this->app_m->getContentMenu('tambah-operator')
			);

			$this->load_view();
		}
	}

	public function tambah()
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules('counter_id', 'ID Loket', 'required|exact_length[13]|alpha_numeric');
		$this->form_validation->set_rules('user_id', 'ID Petugas', 'required|exact_length[13]|alpha_numeric');

		if ($this->form_validation->run() == TRUE) 
		{
			if($this->operator_m->cekOperator($post) == 0)
			{
		        $op_id 	= uniqidReal();
				$status = $this->operator_m->tambah($op_id, $post);
				$msg 	= ($status === 1) ? 'Operator ditambahkan.' : 'Gagal menambahkan operator.';
			}
			else
			{
				$msg = 'Petugas telah ditambahkan ke loket.';
			}
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

		$this->form_validation->set_rules('counter_id', 'ID Loket', 'required|exact_length[13]|alpha_numeric');
		$this->form_validation->set_rules('user_id', 'ID Petugas', 'required|exact_length[13]|alpha_numeric');
		$this->form_validation->set_rules('operator_id', 'ID Data', 'required|exact_length[13]|alpha_numeric');


		if ($this->form_validation->run() == TRUE) 
		{
			if($this->operator_m->cekOperator($post) == 0)
			{
				$status = $this->operator_m->ubah($post);
				$msg 	= ($status === 1) ? 'Operator diubah.' : 'Gagal mengubah operator.';
			}
			else
			{
				$msg = 'Petugas telah ditambahkan ke loket.';
			}
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
		$operator_id 	= $this->input->post('operator_id', TRUE);

		$this->form_validation->set_rules('operator_id', 'ID Data', 'required|alpha_numeric|exact_length[13]');
		if ($this->form_validation->run() == TRUE) 
		{
			$status = $this->operator_m->hapus($operator_id);
			$msg = ($status === 1) ? 'Operator dihapus.' : 'Operator gagal dihapus.';
		} 
		else 
		{
			$msg = validation_errors();
		}

		$result = array('result' => $status, 'msg' => $msg, 'token' => $this->security->get_csrf_hash());
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}