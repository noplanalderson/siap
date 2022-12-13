<?php
/**
 * SIAP (Sistem Informasi dan Antrian Pengunjung)
 * 
 * 
 * This class contains modules for easy configuration of each controller.
 * with this class, we can easily call views, scripts, javascript plugins, 
 * and css as needed and easily parse data from model to view.
 * 
 * In this class, application settings, logged in user profiles, and access control are managed 
 * so that there is no need to configure these things on each existing controller.
 * 
 *
 * @package SIAP
 * @author Muhammad Ridwan Na'im
 * @version 1.0.0
 * @since  2022
 * 
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class SIAP_Backend extends CI_Controller 
{
	/**
	 * Application Settings
	 * 
	 * @var array
	*/
	public $apps = array();

	/**
	 * List of Required Partial Views
	 * 
	 * @var array
	*/
	public $_partial = array(
		'backend/head',
		'backend/sidebar',
		'backend/navbar',
		'backend/body',
		'backend/footer',
		'backend/script'
	);

	/**
	 * List of Required Partial Script
	 * 
	 * @var string
	*/
	public $_script = '';

	/**
	 * List of Required view module
	 * 
	 * @var string
	*/
	public $_module = '';

	/**
	 * Data yang akan diparsing dari controller atau model ke view
	 * 
	 * @var array
	*/
	public $_data = array();

	/**
	 * Required CSS Files
	 * 
	 * @var mixed
	*/
	public $css = '';

	/**
	 * Required JS Files
	 * 
	 * @var mixed
	*/
	public $js = '';

	/**
	 * Required CSS Plugins
	 * 
	 * @var mixed
	*/
	public $css_plugin = '';

	/**
	 * Required JS Plugins
	 * 
	 * @var mixed
	*/
	public $js_plugin = '';

	/**
	 * Required External JS Plugin
	 * 
	 * @var mixed
	*/
	public $external_js = '';

	/**
	 * Required External CSS Plugins
	 * 
	 * @var mixed
	*/
	public $external_css = '';

	/**
	 * Partial View Directory Location
	 * which contains file such head, sidebar, navbar, footer, and global js script
	 * 
	 * @var string
	*/
	protected $dir_partial = '_partial';

	/**
	 * Directory Prefix of View Module
	 * 
	 * @var string
	*/
	protected $dir_module = ''; 
	
	/**
	 * Directory location of javascript php file
	 * for specific module
	 * 
	 * @var string
	*/ 
	protected $dir_script = '_script';

	/**
	 * Default or Index Page from Logged User Type
	 * @var string
	*/
	protected $index_menu = '';

	/**
	 * Logged User Data
	 * @var array
	*/
	public $user = array();

	/**
	 * Logged User Menus
	 * @var array
	*/
	public $menus = array();

	/**
	 * Logged User Hash
	 * @var string
	*/
	public $user_hash = '';

	/**
	 * Codeigniter Instance
	 * 
	 * @var object
	*/
	public $_CI;

	/**
	 * Here we begin
	 * Create Class Constructor
	 * 
	*/
	public function __construct()
	{
		parent::__construct();

		// Codeigniter Instance
		$this->_CI =& get_instance();

		// Load Database Library
		$this->_CI->load->database();

		// Load memcached driver
		$this->_CI->load->driver('cache', array('adapter' => 'file'));

		// Load Core Models
		$this->load->model('app_m');

		// Save Loaded App Configuration to cache
		$this->app 		= load_cache('web_setting', 'app_m', 'getAppSetting', NULL, 300);
		
		if(!empty($this->session->userdata('uid')) && !empty($this->session->userdata('gid'))) 
		{
			$this->user_hash 	= hash('sha256', $this->session->userdata('uid'));

			// Save Loaded Logged User Profile
			$this->user 		= load_cache('siap_user_'.$this->user_hash, 'app_m', 'getUserProfile', NULL, 300);
			
			// Save Loaded App Main Menu to cache
			$this->menus 		= load_cache('siap_menu_'.$this->user_hash, 'app_m', 'getMainMenu', NULL, 300);

			// Get User's Index Page
			$this->index_menu 	= empty($this->user) ? $this->index_menu : $this->user->index_menu;
		}
		
		// Save logged user to session
		$this->_access 		= array(
			'uid' => $this->session->userdata('uid'),
			'gid' => $this->session->userdata('gid'),
			'active_page' => $this->uri->segment(2),
			'index_page' => 'admin/'.$this->index_menu,
			'user_hash' => $this->user_hash
		);
		
		// Load Access Control Library
		$this->load->library('access_control');
		$this->access_control->initialize($this->_access);

		if(config_item('csp_header'))
		{
			$this->load->library('CSP_Header');
			$this->csp_header->generateCSP();
		}

		if(config_item('security_header'))
		{
			$this->load->library('Security_header');
			$this->security_header->generate();
		}
	}

	protected function _partial($data)
	{
		if(!empty($this->_partial) && is_array($this->_partial))
		{
			for ($i=0; $i < count($this->_partial); $i++) {
				$this->_CI->load->view($this->dir_partial . '/' . $this->_partial[$i], $data);
			}
		}
	}

	protected function _module()
	{
		if(!empty($this->_module)) {
			return $this->_CI->load->view($this->dir_module . $this->_module, $this->_data, TRUE);
		}
	}

	protected function _script()
	{
		if(!empty($this->_script)) {
			return $this->_CI->load->view($this->dir_script . '/' . $this->_script . '.php', $this->_data, TRUE);
		}
	}

	protected function load_view()
	{
		$data = array_merge(
			$this->_data,
			array(
				'content' => $this->_module(),
				'custom_js' => $this->_script()
			)
		);

		$this->_partial($data);
	}

	public function load_css()
	{
		if(is_array($this->css))
		{
			for ($i=0; $i < count($this->css); $i++) { 
				if(is_array($this->css[$i]))
				{
					$attr = array_key_exists('attr', $this->css[$i]) ? (is_array($this->css[$i]) ? 
							implode(' ', $this->css[$i]['attr']) : $this->css[$i]['attr']) : NULL;

					if(array_key_exists('file', 'css', $this->css[$i])) {
						echo css($this->css[$i]['file'], $attr)."\n";
					
					}
				}
				else
				{
					echo css($this->css[$i]['file'])."\n";
				}
			}
		}
		elseif(!is_array($this->css) && $this->css !== '')
		{
			echo css($this->css)."\n";
		}
	}

	public function load_js()
	{
		if(is_array($this->js))
		{
			for ($i=0; $i < count($this->js); $i++) { 

				if(is_array($this->js[$i]))
				{
					$attr = array_key_exists('attr', $this->js[$i]) ? (is_array($this->js[$i]) ? 
							implode(' ', $this->js[$i]['attr']) : $this->js[$i]['attr']) : NULL;

					if(array_key_exists('file', $this->js[$i]))
					{
						echo js($this->js[$i]['file'], 'js', $attr)."\n";
					}
				}
				else
				{
					echo js($this->js[$i])."\n";
				}
			}
		}
		elseif(!is_array($this->js) && $this->js !== '')
		{
			echo js($this->js)."\n";
		}
	}

	public function load_css_plugin()
	{
		if(is_array($this->css_plugin))
		{
			for ($i=0; $i < count($this->css_plugin); $i++) { 
				if(is_array($this->css_plugin[$i]))
				{
					$attr = array_key_exists('attr', $this->css_plugin[$i]) ? 
							(is_array($this->css_plugin[$i]) ? implode(' ', $this->css_plugin[$i]['attr']) : 
								$this->css_plugin[$i]['attr']) : NULL;


					if(array_key_exists('file', $this->css_plugin[$i]))
					{
						echo plugin($this->css_plugin[$i]['file'], 'css', $attr)."\n";
					}
				}
				else
				{
					echo plugin($this->css_plugin[$i], 'css')."\n";
				}
			}
		}
		elseif(!is_array($this->css_plugin) && $this->css_plugin !== '')
		{
			echo plugin($this->css_plugin, 'css')."\n";
		}
	}

	public function load_js_plugin()
	{
		if(is_array($this->js_plugin))
		{
			for ($i=0; $i < count($this->js_plugin); $i++) { 

				if(is_array($this->js_plugin[$i]))
				{
					$attr = array_key_exists('attr', $this->js_plugin[$i]) ? 
							(is_array($this->js_plugin[$i]) ? implode(' ', $this->js_plugin[$i]['attr']) : 
								$this->js_plugin[$i]['attr']) : NULL;

					if(array_key_exists('file', $this->js_plugin[$i]))
					{
						echo plugin($this->js_plugin[$i]['file'], 'js', $attr)."\n";
					}
				}
				else
				{
					echo plugin($this->js_plugin[$i], 'js')."\n";
				}
			}
		}
		elseif(!is_array($this->js_plugin) && $this->js_plugin !== '')
		{
			echo plugin($this->js_plugin, 'js')."\n";
		}
	}

	public function load_external_css()
	{
		if(is_array($this->external_css))
		{
			for ($i=0; $i < count($this->external_css); $i++) { 

				echo "<link rel='stylesheet' href='".$this->external_css[$i]."'>\n";
			}
		}
		elseif(!is_array($this->external_css) && $this->external_css !== '')
		{
			echo "<link rel='stylesheet' href='".$this->external_css."'>\n";
		}
	}

	public function load_external_js()
	{
		if(is_array($this->external_js))
		{
			for ($i=0; $i < count($this->external_js); $i++) { 

				echo "<script src='".$this->external_js[$i]."'></script>\n";
			}
		}
		elseif(!is_array($this->external_js) && $this->external_js !== '')
		{
			echo "<script src='".$this->external_js."'></script>\n";
		}
	}
}
