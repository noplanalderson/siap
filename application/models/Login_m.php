<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_m extends CI_Model {

	public function verify($user)
	{
		$this->db->select('a.user_id, a.password, a.username, b.mode, b.index_menu, b.group_id');
		$this->db->join('tb_user_group b', 'a.group_id = b.group_id', 'inner');
		$this->db->where('a.username', $user);
		$this->db->where('a.status', 'active');
		return $this->db->get('tb_user a');
	}

	public function update_login_data()
	{
		$this->db->where('user_id', $this->session->userdata('uid'));
		$this->db->update('tb_user', 
			array(
				'last_login' => date('Y-m-d H:i:s', $this->session->userdata('time')),
				'last_ip' => get_real_ip(),
			)
		);
	}
}