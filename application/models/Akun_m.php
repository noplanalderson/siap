<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun_m extends CI_Model {

	public function akun()
	{
		$this->db->where('user_id', $this->session->userdata('uid'));
		return $this->db->get('tb_user')->row_array();
	}

	public function updateAkun($post, $user_picture)
	{
		$this->db->where('user_id', $this->session->userdata('uid'));
		$this->db->update('tb_user', [
			'username' => strtolower($post['user_name']),
			'password' => passwordHash($post['user_password'], [
				'memory_cost' => 2048, 
				'time_cost' => 8, 
				'threads' => 4
			]),
			'user_picture' => $user_picture
		]);

		return ($this->db->affected_rows() > 0) ? 1 : 0;
	}

}

/* End of file akun_m.php */
/* Location: ./application/models/akun_m.php */