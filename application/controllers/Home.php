<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends SIAP_Frontend {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('home_m');
	}

	public function index()
	{
		$this->_module 	= 'frontend/home';
		
		$this->js = 'home';

		$this->_data 	= array(
			'title' 	=> $this->app->site_name,
			'slides'	=> $this->home_m->getSlides(),
			'running_text' => $this->home_m->runningText(),
			'loket'		=> $this->home_m->getLoket()
		);

		$this->load_view();
	}

	public function stats()
	{
		$data = $this->home_m->stats();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
}