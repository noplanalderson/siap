<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atm extends SIAP_Frontend {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('home_m');
		$this->load->model('transaksi_m');
	}

	public function index()
	{
		if(empty($this->input->get('id', TRUE)))
		{
			if($this->input->is_ajax_request() === true)
			{
				if(!empty($this->input->post('counter_id', TRUE)))
				{
					$this->form_validation->set_rules('counter_id', 'ID Loket', 'required|exact_length[13]|alpha_numeric');
					if ($this->form_validation->run() == TRUE) 
					{
						$status = 1;
						$data 	= $this->transaksi_m->insertTransaksi($this->input->post('counter_id', TRUE));
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
				$this->css_plugin = array(
					'fontawesome/css/all.min',
					'sweetalert2/dist/sweetalert2.min'
				);

				$this->js_plugin = 'sweetalert2/dist/sweetalert2.min';

				$this->_module 	= 'frontend/atm';
				
				$this->css = 'swal';

				$this->js = 'atm';

				$this->_data 	= array(
					'title' 	=> $this->app->site_name,
					'running_text' => $this->home_m->runningText(),
					'loket'		=> $this->home_m->getLoket()
				);

				$this->load_view();
			}
		}
		else
		{
			$this->_partial = array(
				'frontend/head',
				'frontend/body',
				'frontend/script'
			);

			$counter_id = $this->input->get('id', TRUE);
			$counter_id = ((bool)preg_match('/[a-zA-Z0-9]+$/', $counter_id) === true) ? $counter_id : '';

			$this->_module 	= 'frontend/atm_print';

			$this->js 		= 'print';

			$this->_data 	= array(
				'title' 	=> $this->app->site_name,
				'antrian' 	=> $this->home_m->nomorAntrian($counter_id),
				'loket'		=> $this->home_m->getLoketByID($counter_id)
			);

			$this->load_view();
		}
	}

}

/* End of file atm.php */
/* Location: ./application/controllers/atm.php */