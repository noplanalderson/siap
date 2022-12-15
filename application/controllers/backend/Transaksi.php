<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends SIAP_Backend {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();
		$this->load->model('transaksi_m');
		$this->load->model('loket_m');
	}

	public function index()
	{
		if($this->input->is_ajax_request() == true)
		{	
			$start_date = $this->input->get('start_date', TRUE);
			$end_date 	= $this->input->get('end_date', TRUE);
			$loket 		= $this->input->get('loket', TRUE);

			$start 	= (validate_date($start_date) === true) ? $start_date : date('Y-m-d');
			$end 	= (validate_date($end_date) === true) ? $end_date : date('Y-m-d');
			$loket 	= ((bool)preg_match('/[a-zA-Z0-9]+$/', $loket) === true) ? $loket : 'all';  

			$result 	= ['data' => $this->transaksi_m->daftarTransaksi($loket, $start, $end)];
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		else
		{
			$this->css_plugin = 'datatables/datatables.min';

			$this->js_plugin = 'datatables/datatables.min';

			$this->_module 	= 'backend/v_transaksi';
			
			$this->js 		= 'transaksi';

			$this->_data 	= array(
				'title' 	=> $this->app->site_name . ' - Transaksi',
				'loket'		=> $this->loket_m->daftarLoket()
			);

			$this->load_view();
		}
	}


}

/* End of file transaksi.php */
/* Location: ./application/controllers/transaksi.php */