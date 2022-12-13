<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_m extends CI_Model {

	public function getMainMenu()
	{
		$this->db->select('a.menu_id, a.label_menu, a.slug_menu, a.icon_menu, a.grup_fitur');
		$this->db->join('tb_roles b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->where('a.tipe_menu', 'mainmenu');
		$this->db->where('b.group_id', $this->session->userdata('gid'));
		$this->db->order_by('a.menu_sequence', 'asc');
		return $this->db->get('tb_menu a')->result();
	}

	public function getSubMenu($grup_fitur)
	{
		$this->db->select('a.label_menu, a.slug_menu, a.icon_menu, a.grup_fitur');
		$this->db->join('tb_roles b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->where('a.tipe_menu', 'submenu');
		$this->db->where('a.grup_fitur', $grup_fitur);
		$this->db->where('b.group_id', $this->session->userdata('gid'));
		$this->db->order_by('a.menu_sequence', 'asc');
		return $this->db->get('tb_menu a')->result();
	}

	public function getContentMenu($link)
	{
		$this->db->select('a.label_menu, a.slug_menu, a.icon_menu');
		$this->db->join('tb_roles b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->where('a.tipe_menu', 'button');
		$this->db->where('b.group_id', $this->session->userdata('gid'));
		$this->db->where('a.slug_menu', $link);
		$this->db->order_by('a.menu_sequence', 'asc');
		return $this->db->get('tb_menu a')->row();
	}

	public function allMenu()
	{
		$this->db->select('a.slug_menu');
		$this->db->join('tb_roles b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->where('b.group_id', $this->session->userdata('gid'));
		return $this->db->get('tb_menu a')->result_array();
	}

	public function getUserProfile()
	{
		$this->db->select("a.employee_name, a.username, a.last_login, a.last_ip, a.user_picture,
						   b.group_name, b.index_menu");
		$this->db->join('tb_user_group b', 'a.group_id = b.group_id', 'inner');
		$this->db->where('a.user_id', $this->session->userdata('uid'));
		return $this->db->get('tb_user a')->row();
	}

	public function checkRole($menu, $gid)
	{
		$this->db->select('a.role_id');
		$this->db->join('tb_menu b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->where('a.group_id', $gid);
		$this->db->where('b.slug_menu', $menu);
		return $this->db->get('tb_roles a')->num_rows();
	}
	
	public function getAppSetting()
	{
		return $this->db->get('tb_web_setting', 1)->row();
	}
	
	public function updateSettings($post)
	{
		return $this->db->update('tb_web_setting', $post) ? 1 : 0;
	}

	public function uploadImage($index, $image)
	{
		return $this->db->update('tb_web_setting', [$index => $image]) ? true : false;
	}

	public function publicMainMenu()
	{
		$this->db->select('id_nav, label, tautan, tautan_external, urutan, tab_baru');
		$this->db->where('posisi', 'mainmenu');
		$this->db->order_by('urutan', 'asc');
		return $this->db->get('tb_navigasi')->result();
	}

	public function publicSubmenu($id_nav)
	{
		$this->db->select('label, tautan, tautan_external, urutan, tab_baru');
		$this->db->where('posisi', 'submenu');
		$this->db->where('parent', $id_nav);
		$this->db->order_by('urutan', 'asc');
		return $this->db->get('tb_navigasi')->result();
	}

	public function getSlides()
	{
		$this->db->select('id_slide, slide_file, alt_text');
		$this->db->order_by('id_slide', 'asc');
		return $this->db->get('tb_slide', 5)->result();
	}
}