<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_seo extends APP_Backend {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();
	}

	public function index()
	{
		if($this->input->is_ajax_request())
		{	
			$status = 0;
			$seo 	= $this->input->post(null, TRUE);

			$this->form_validation->set_rules($this->_rules());

			if ($this->form_validation->run() == TRUE) {

				$status = $this->app_m->updateSeoSettings($seo);
				$msg 	= ($status === 1) ? 'Pengaturan berhasil diubah.' : 'Gagal mengubah pengaturan.';

				if($status === 1) $this->cache->delete('seo_setting');
			} 
			else 
			{
				$msg = validation_errors();
			}

			$token 	= $this->security->get_csrf_hash();
			$result = array('result' => $status, 'msg' => $msg, 'token' => $token);
			$this->output->set_content_type('application/json')->set_output(json_encode($result)); 
		}
		else
		{
			$this->js_plugin = array(
				'tags/jquery.tagsinput.min'
			);

			$this->_module 	= 'backend/v_seo_setting';
			
			$this->js 		= 'pengaturan_seo';

			$this->_data 	= array(
				'title' 		=> $this->app->site_name . ' - Pengaturan SEO'
			);

			$this->load_view();
		}
	}

	function valid_json($str)
	{
		$json = json_decode($str);

		if($json !== false && $str != $json)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('valid_json', 'Format JSON tidak valid.');
			return false;
		}
	}

	private function _rules()
	{
		$rules = array(
			array(
				'field' => 'meta_description',
				'label' => 'Meta Description',
				'rules'	=> 'trim|required|regex_match[/[a-zA-Z0-9 @&#\/\-_.,]+$/]|min_length[3]|max_length[500]',
				'errors'=> [
					'regex_match' => '{field} hanya boleh mengandung karakter [a-zA-Z0-9 @&#/-_.,]'
				]
			),
			array(
				'field' => 'meta_keywords',
				'label' => 'Meta Keywords',
				'rules'	=> 'trim|regex_match[/[a-zA-Z0-9 @&#\/\-_.,]+$/]|min_length[3]|max_length[255]',
				'errors'=> [
					'regex_match' => '{field} hanya boleh mengandung karakter [a-zA-Z0-9 @&#/-_.,]'
				]
			),
			array(
				'field' => 'schema_org',
				'label' => 'Schema.org',
				'rules'	=> 'required|callback_valid_json'
			),
			array(
				'field' => 'meta_author',
				'label' => 'Meta Author',
				'rules' => 'trim|required|min_length[5]|max_length[100]|regex_match[/[a-zA-Z0-9 \-_.,]+$/]',
				'errors'=> array(
					'regex_match'=> '{field} hanya  boleh mengandung alfanumerik, spasi, dan dash'
				)
			),
			array(
				'field' => 'meta_subject',
				'label' => 'Meta Subject',
				'rules'	=> 'trim|required|regex_match[/[a-zA-Z0-9 @&#\/\-_.,]+$/]|min_length[3]|max_length[500]',
				'errors'=> [
					'regex_match' => '{field} hanya boleh mengandung karakter [a-zA-Z0-9 @&#/-_.,]'
				]
			)
		);

		return $rules;
	}
}

/* End of file Pengaturan_seo.php */
/* Location: .//C/xampp/htdocs/healmeid/app/controllers/backend/Pengaturan_seo.php */