<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_web extends APP_Backend {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();

		$this->load->library('upload');
	}

	public function index()
	{
		if($this->input->is_ajax_request())
		{
			$status  = 0;
			$setting = $this->input->post(null, TRUE);

			$this->form_validation->set_rules($this->_rules());

			if ($this->form_validation->run() == TRUE) {
				
				if(!empty($_FILES['site_logo']['name']))
				{
					$config = array(
						'upload_path' => FCPATH . '_/uploads/sites/',
						'file_ext_tolower' => true,
						'allowed_types' => 'jpeg|jpg|png',
						'max_size' => '1024',
						'detect_mime' => true,
						'file_name' => 'logo_v'.date('Ymdhis')
					);
					
					$this->upload->initialize($config);

					if ( ! $this->upload->do_upload('site_logo'))
					{
						$msg[] = $this->upload->display_errors();
					}
					else
					{
						$logo = $this->upload->data();
						$site_logo = $logo['file_name'];
					}
				}
				else
				{
					$site_logo = $this->app->site_logo;
				}

				if(!empty($_FILES['site_logo_alt']['name']))
				{
					$config = array(
						'upload_path' => FCPATH . '_/uploads/sites/',
						'file_ext_tolower' => true,
						'allowed_types' => 'jpeg|jpg|png',
						'max_size' => '1024',
						'detect_mime' => true,
						'file_name' => 'logo_alt_v'.date('Ymdhis')
					);
					
					$this->upload->initialize($config);

					if ( ! $this->upload->do_upload('site_logo_alt'))
					{
						$msg[] = $this->upload->display_errors();
					}
					else
					{
						$logo_alt = $this->upload->data();
						$site_logo_alt = $logo_alt['file_name'];
					}
				}
				else
				{
					$site_logo_alt = $this->app->site_logo_alt;
				}

				$settings = array_replace($setting, array('site_logo' => $site_logo, 'site_logo_alt' => $site_logo_alt));

				$status = $this->app_m->updateSettings($settings);
				$msg[] 	= ($status === 1) ? 'Pengaturan disimpan.' : 'Gagal menyimpan pengaturan.';

				if($status === 1) $this->cache->delete('web_setting');
			} 
			else 
			{
				$msg[] = validation_errors('<p>','</p>');
			}

			$token 	= $this->security->get_csrf_hash();
			$result = array('result' => $status, 'msg' => implode('',$msg), 'token' => $token);

			$this->output->set_content_type('application/json')->set_output(json_encode($result)); 
		}
		else
		{
			$this->_module 	= 'backend/v_web_setting';
			
			$this->js 		= 'pengaturan_web';

			$this->_data 	= array(
				'title' 		=> $this->app->site_name . ' - Pengaturan Web'
			);

			$this->load_view();
		}
	}

	private function _rules()
	{
		$rules = array(
			array(
				'field' => 'site_name',
				'label' => 'Nama Instansi',
				'rules' => 'trim|required|min_length[5]|max_length[255]|regex_match[/[a-zA-Z0-9 \-_.]+$/]',
				'errors'=> array(
					'regex_match'=> '{field} hanya  boleh mengandung alfanumerik, spasi, dan dash'
				)
			),
			array(
				'field' => 'site_tagline',
				'label' => 'Tagline',
				'rules' => 'trim|min_length[5]|max_length[255]|regex_match[/[a-zA-Z0-9 \-_,.]+$/]',
				'errors'=> array(
					'regex_match'=> '{field} hanya  boleh mengandung alfanumerik, spasi, dan dash'
				)
			),
			array(
				'field' => 'site_description',
				'label' => 'Deskripsi',
				'rules'	=> 'trim|regex_match[/[a-zA-Z0-9 @&#\/\-_.,\']+$/]|min_length[3]|max_length[500]',
				'errors'=> [
					'regex_match' => '{field} hanya boleh mengandung karakter [a-zA-Z0-9 @&#/-_.,\']'
				]
			),
			array(
				'field' => 'site_address',
				'label' => 'Alamat Instansi',
				'rules'	=> 'trim|required|regex_match[/[a-zA-Z0-9 @&#\/\-_.,]+$/]|min_length[3]|max_length[500]',
				'errors'=> [
					'regex_match' => '{field} hanya boleh mengandung karakter [a-zA-Z0-9 @&#\/\-_.,]',
				]
			),
			array(
				'field' => 'site_phone',
				'label' => 'No. Telepon',
				'rules'	=> 'phone_regex',
				'errors'=> [
					'phone_regex' => '{field} harus nomor telepon wilayah Indonesia.'
				]
			),
			array(
				'field' => 'site_email',
				'label' => 'Email',
				'rules'	=> 'trim|required|valid_email|max_length[100]'
			),
			array(
				'field' => 'site_instagram',
				'label' => 'Instagram',
				'rules'	=> 'trim|valid_url'
			),
			array(
				'field' => 'site_facebook',
				'label' => 'Facebook',
				'rules'	=> 'trim|valid_url'
			),
			array(
				'field' => 'site_twitter',
				'label' => 'Twitter',
				'rules'	=> 'trim|valid_url'
			),
			array(
				'field' => 'site_youtube',
				'label' => 'Youtube',
				'rules'	=> 'trim|valid_url'
			),
			array(
				'field' => 'site_tiktok',
				'label' => 'Tiktok',
				'rules'	=> 'trim|valid_url'
			)
		);

		return $rules;
	}
}