<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends SIAP_Backend {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->load->model('akun_m');
	}

	public function index()
	{
		if($this->input->is_ajax_request())
		{
			if(!empty($this->input->post(null, TRUE)))
			{
				$status = 0;
				$post = $this->input->post(null, TRUE);

				$this->form_validation->set_rules('user_name', 'Username', 'trim|required|max_length[50]|regex_match[/[a-z0-9_]+$/]', ['regex_match' => 'Karakter yang diizinkan hanya a-z0-9_']);
				$this->form_validation->set_rules('user_password', 'Password', 'trim|required|min_length[8]');

				if ($this->form_validation->run() == TRUE) 
				{
					$config = array(
						'upload_path' => FCPATH . '_/uploads/users/' . $this->session->userdata('uid'),
						'file_ext_tolower' => true,
						'allowed_types' => 'jpeg|jpg|png',
						'max_size' => '5200',
						'remove_spaces' => true,
						'max_filename' => '250',
						'detect_mime' => true,
						'file_name' => $this->user->employee_name.'-'.$this->session->userdata('uid').'-'.date('Ymdhis')
					);
					
					$this->load->library('upload');
					$this->upload->initialize($config);
					
					if ( ! $this->upload->do_upload('user_picture'))
					{
						$msg = $this->upload->display_errors();
						$user_picture = $this->user->user_picture;
					}
					else
					{
						$data = $this->upload->data();
						$user_picture = $data['file_name'];
					}

					$status = $this->akun_m->updateAkun($post, $user_picture);
					$msg 	= ($status === 1) ? 'Pengaturan akun disimpan.' : 'Gagal menyimpan pengaturan akun.';

					if($status === 1) $this->cache->delete('siap_user_'.$this->user_hash);
				} 
				else 
				{
					$msg = validation_errors();
				}

				$result = array('result' => $status, 'token' => $this->security->get_csrf_hash(), 'msg' => $msg);
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}
			else
			{
				$result = $this->akun_m->akun();
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}
		}
	}

}

/* End of file akun.php */
/* Location: ./application/controllers/akun.php */