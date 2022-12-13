<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loket extends SIAP_Backend {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();

		$this->load->model('loket_m');
		$this->load->model('transaksi_m');
	}

	public function index()
	{
		if($this->input->is_ajax_request() == true)
		{
			if(!empty($this->input->post('counter_id', TRUE)))
			{
				$this->form_validation->set_rules('counter_id', 'ID Loket', 'required|exact_length[13]|alpha_numeric');
				if ($this->form_validation->run() == TRUE) 
				{
					$status = 1;
					$data 	= $this->loket_m->loket($this->input->post('counter_id', TRUE));
					$msg  	= empty($data) ? 'Loket tidak ditemukan.' : '';
				} 
				else 
				{
					$status = 0;
					$data 	= [];
					$msg  	= validation_errors();
				}

				$token 	= $this->security->get_csrf_hash();
				$result = array('result' => $status, 'token' => $token, 'msg' => $msg, 'loket' => $data);
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}
			else
			{
				$result = ['data' => $this->loket_m->daftarLoket()];
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
			$this->_module 	= 'backend/v_loket';
			
			$this->js 		= 'loket';

			$this->_data 	= array(
				'title' 	=> $this->app->site_name . ' - Loket',
				'btn_tambah'=> $this->app_m->getContentMenu('tambah-loket')
			);

			$this->load_view();
		}
	}

	public function tambah()
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules('counter_name', 'Nama Loket', 'required|max_length[150]|alpha_numeric_spaces|is_unique[tb_counter.counter_name]');

		if ($this->form_validation->run() == TRUE) 
		{
			$status = $this->loket_m->tambah($post);
			$msg 	= ($status === 1) ? 'Loket ditambahkan.' : 'Gagal menambahkan loket.';
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

		$this->form_validation->set_rules('counter_name', 'Nama Loket', 'required|max_length[150]|alpha_numeric_spaces');

		if ($this->form_validation->run() == TRUE) 
		{
			if($this->loket_m->cekLoket($post) === 0)
			{
				$status = $this->loket_m->ubah($post);
				$msg 	= ($status === 1) ? 'Loket diubah.' : 'Gagal mengubah loket.';
			}
			else
			{
				$msg = 'Loket sudah ada.';
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
		$counter_id = $this->input->post('counter_id', TRUE);

		$this->form_validation->set_rules('counter_id', 'ID Loket', 'required|alpha_numeric|exact_length[13]');
		if ($this->form_validation->run() == TRUE) 
		{
			$status = $this->loket_m->hapus($counter_id);
			$msg = ($status === 1) ? 'Loket dihapus.' : 'Loket gagal dihapus.';
		} 
		else 
		{
			$msg = validation_errors();
		}

		$result = array('result' => $status, 'msg' => $msg, 'token' => $this->security->get_csrf_hash());
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function masuk($id)
	{
		if($this->input->is_ajax_request() == true)
		{
			if(!empty($this->input->post('counter_id', TRUE)))
			{
				$this->form_validation->set_rules('counter_id', 'ID Loket', 'required|exact_length[13]|alpha_numeric');
				if ($this->form_validation->run() == TRUE) 
				{
					$status = 1;
					$data 	= $this->transaksi_m->updateTransaksi($this->input->post('counter_id', TRUE));
					$msg  	= ($data === 0) ? 'Gagal melakukan transaksi.' : '';
				} 
				else 
				{
					$status = 0;
					$data 	= [];
					$msg  	= validation_errors();
				}

				$token 	= $this->security->get_csrf_hash();
				$result = array('result' => $status, 'token' => $token, 'msg' => $msg, 'transaksi' => $data);
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}
		}
		else
		{
			$loket = $this->loket_m->loket($id);

			if(empty($loket)) show_404();

			$this->_module 	= 'backend/v_masuk_loket';
			
			$this->js 		= 'masuk_loket';

			$this->_data 	= array(
				'title' 	=> $this->app->site_name . ' - ' . $loket['counter_name'],
				'loket'		=> $loket,
				'next_queue'=> $this->transaksi_m->nextQueue($loket['counter_id'])	
			);

			$this->load_view();
		}
	}
}