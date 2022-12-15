<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slide extends SIAP_Backend {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();

		$this->load->model('slides_m');
	}

	public function index()
	{
		if($this->input->is_ajax_request() == true)
		{
			if(!empty($this->input->post('slide_id', TRUE)))
			{
				$this->form_validation->set_rules('slide_id', 'ID Gambar', 'required|exact_length[13]|alpha_numeric');
				if ($this->form_validation->run() == TRUE) 
				{
					$status = 1;
					$data 	= $this->slides_m->slide($this->input->post('slide_id', TRUE));
					$msg  	= empty($data) ? 'Gambar tidak ditemukan.' : '';
				} 
				else 
				{
					$status = 0;
					$data 	= [];
					$msg  	= validation_errors();
				}

				$token 	= $this->security->get_csrf_hash();
				$result = array('result' => $status, 'token' => $token, 'msg' => $msg, 'slide' => $data);
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}
			else
			{
				$result = ['data' => $this->slides_m->slides()];
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
			$this->_module 	= 'backend/v_slides';
			
			$this->js 		= 'slides';

			$this->_data 	= array(
				'title' 	=> $this->app->site_name . ' - Slide',
				'btn_tambah'=> $this->app_m->getContentMenu('tambah-gambar')
			);

			$this->load_view();
		}
	}

	public function tambah()
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules('slide_description', 'Deskripsi', 'required|max_length[255]');

		if ($this->form_validation->run() == TRUE) 
		{
	        $slide_id = uniqidReal();

			$config = array(
				'upload_path' => FCPATH . '_/uploads/slides/',
				'file_ext_tolower' => true,
				'allowed_types' => 'jpeg|jpg|png',
				'max_size' => '5200',
				'remove_spaces' => true,
				'max_filename' => '250',
				'detect_mime' => true,
				'file_name' => 'slide-'. $slide_id
			);
			
			$this->load->library('upload');
			$this->upload->initialize($config);
			
			if ( ! $this->upload->do_upload('image'))
			{
				$msg = $this->upload->display_errors();
			}
			else
			{
				$gambar = $this->upload->data();

				$status = $this->slides_m->tambah($slide_id, $post, $gambar);
				$msg 	= ($status === 1) ? 'Gambar berhasil diunggah.' : 'Gagal mengunggah gambar.';
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

		$this->form_validation->set_rules('slide_id', 'ID Gambar', 'required|exact_length[13]|alpha_numeric');
		$this->form_validation->set_rules('slide_description', 'Deskripsi', 'required|max_length[255]');

		if ($this->form_validation->run() == TRUE) 
		{
			$config = array(
				'upload_path' => FCPATH . '_/uploads/slides/',
				'file_ext_tolower' => true,
				'allowed_types' => 'jpeg|jpg|png',
				'max_size' => '5200',
				'remove_spaces' => true,
				'max_filename' => '250',
				'detect_mime' => true,
				'file_name' => 'slide-'. $post['slide_id']
			);
			
			$this->load->library('upload');
			$this->upload->initialize($config);
			
			if ( ! $this->upload->do_upload('image'))
			{
				$msg = $this->upload->display_errors();
				$gambar = $post['old_image'];
			}
			else
			{
				$gambar = $this->upload->data();
				$gambar = $gambar['file_name'];
				@unlink(FCPATH . '_/uploads/sites/'.$post['old_image']);

			}
			$status = $this->slides_m->ubah($post, $gambar);
			$msg 	= ($status === 1) ? 'Gambar disimpan.' : 'Gagal menyimpan gambar.';
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
		$slide_id 	= $this->input->post('slide_id', TRUE);
		$file 		= $this->input->post('file', TRUE);

		$this->form_validation->set_rules('slide_id', 'ID Slide', 'required|alpha_numeric|exact_length[13]');
		if ($this->form_validation->run() == TRUE) 
		{
			$status = $this->slides_m->hapus($slide_id, $file);

			if($status === 1) {
				@unlink(FCPATH . '_/uploads/sites/'.$file);
				$msg = 'Gambar dihapus.';
			}
			else {
				$msg = 'Gambar gagal dihapus.';
			}
		} 
		else 
		{
			$msg = validation_errors();
		}

		$result = array('result' => $status, 'msg' => $msg, 'token' => $this->security->get_csrf_hash());
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}