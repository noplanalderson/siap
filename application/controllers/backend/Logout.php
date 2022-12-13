<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends SIAP_Backend {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_m');
	}
	
	public function index()
	{
		$this->cache->delete('siap_user_'.$this->user_hash);
		$this->cache->delete('siap_menu_'.$this->user_hash);
		
		$this->login_m->update_login_data();
		
		$session = array('uid', 'gid', 'time', 'index_menu');
		$this->session->unset_userdata($session);
		redirect('portaladmin');
	}

}