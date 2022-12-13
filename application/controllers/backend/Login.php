<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends SIAP_Backend {

	public function __construct()
	{
		parent::__construct();
			
		$this->access_control->is_login();

		$this->load->model('login_m');

		$this->_partial = array(
			'backend/head',
			'backend/body',
			'backend/script'
		);
	}

	public function index()
	{
		$this->css_plugin = 'fontawesome/css/custom.min';
		
		$this->_module 	= 'backend/v_login';
		
		$this->css 		= 'login';
		
		$this->js 		= 'login';

		$this->_data 	= array(
			'title' 	=> $this->app->site_name . ' - Masuk'
		);

		$this->load_view();
	}

	public function auth()
	{
		$status 		= 0;
		$user 			= [];

		$user_name 		= $this->input->post('user_name', TRUE);
		$user_password	= $this->input->post('user_password', TRUE);

		$form_rules = [
	        ['field' => 'user_name',
	         'label' => 'User Name',
	         'rules' => 'trim|required|regex_match[/^[a-zA-Z0-9@\-_.]+$/]',
	         'errors'=> array('required' => '{field} required', 
	                    'regex_match' => '{field} Hanya boleh mengandung alfanumerik dan [-_.]')
	        ],
	        ['field' => 'user_password',
	         'label' => 'Password',
	         'rules' => 'trim|required',
	         'errors'=> array('required' => '{field} required')
	        ]
	    ];

		$this->form_validation->set_rules($form_rules);

		if ($this->form_validation->run() == TRUE)
		{
			$userData =  $this->login_m->verify($user_name);

			if($userData->num_rows() == 1) 
			{
				$user = $userData->row_array();
				$next_page = $user['index_menu'];
		
				if(password_verify($user_password, $user['password']) == true)
				{
					$now = new DateTime();
					$now->setTimezone(new DateTimeZone('Asia/Jakarta'));

					$sessionLogin = array(  
						'uid' 	=> $user['user_id'],
						'gid' 	=> $user['group_id'],
						'time'	=> strtotime($now->format('Y-m-d H:i:s')),
						'index_menu' => $next_page
					);

					$this->session->set_userdata($sessionLogin);
					$status = 1;
					$msg 	= 'Login berhasil. Mohon tunggu... ';

					foreach ($this->app_m->allMenu() as $value) {
						$menu[] = $value['slug_menu'];
					}

					$menu = json_encode($menu);
				}
				else
				{
					$msg = 'Kata sandi salah!';
				}
			}
			else
			{
				$msg = 'Akun tidak ditemukan atau dinonaktifkan!';
			}
		}
		else
		{
			$msg = validation_errors();
		}

		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token, 'menu' => (empty($menu) ? '' : $menu), 'url' => empty($user) ? '' : $next_page);
		
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}