<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends SIAP_Backend {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();

		$this->load->model('dashboard_m');
	}

	public function index()
	{
		$this->js_plugin = array(
			'chart.js/Chart.min'
		);

		$this->_module 	= 'backend/v_dashboard';
		
		$this->js 		= 'dashboard';

		$this->_data 	= array(
			'title' 	=> $this->app->site_name . ' - Dashboard',
		);

		$this->load_view();
	}

	public function stats()
	{
		$data = array(
			'jumlah_petugas' 	=> $this->dashboard_m->total_petugas(),
			'jumlah_loket' 		=> $this->dashboard_m->total_loket(),
			'jumlah_pengunjung'	=> $this->dashboard_m->pengunjung_hari_ini(),
			'pengunjung_ytd'	=> $this->dashboard_m->pengunjung_ytd(),
			'jumlah_slide'		=> $this->dashboard_m->slides()
		);

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
}