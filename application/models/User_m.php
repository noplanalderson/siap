<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_m extends CI_Model {

	public function user($id)
	{
		$this->db->select('group_id, employee_name, username, status');
		$this->db->where('user_id', $id);
		return $this->db->get('tb_user', 1)->row_array();
	}

	public function daftarUser()
	{
		$this->db->select('a.user_id, a.username, a.employee_name, a.status, a.user_picture, 
						   b.group_name, b.mode');
		$this->db->join('tb_user_group b', 'a.group_id = b.group_id', 'inner');
		$this->db->order_by('a.employee_name', 'asc');
		return $this->db->get('tb_user a')->result_array();
	}

	public function userGroup()
	{
		$this->db->select('group_id, group_name, mode');
		$this->db->order_by('group_name', 'asc');
		return $this->db->get('tb_user_group')->result();
	}

	public function tambah($post, $id, $foto)
	{
		return $this->db->insert('tb_user', [
			'user_id' => $id,
			'employee_name' => ucwords($post['employee_name']),
			'username' => strtolower($post['username']),
			'password' => passwordHash($post['user_password'], [
				'memory_cost' => 2048, 
				'time_cost' => 8, 
				'threads' => 4
			]),
			'status' => (isset($post['status']) ? 'active' : 'inactive'),
			'group_id' => $post['group_id'],
			'user_picture' => $foto 
		]) ? 1 : 0;
	}

	public function cekUsername($post)
	{
		$this->db->select('user_id');
		$this->db->where('username', strtolower($post['username']));
		$this->db->where('user_id != ', $post['user_id']);
		return $this->db->get('tb_user')->num_rows();
	}

	public function ubah($post, $foto)
	{
		$this->db->where('user_id', $post['user_id']);
		$this->db->update('tb_user', [
			'employee_name' => ucwords($post['employee_name']),
			'username' => strtolower($post['username']),
			'password' => passwordHash($post['user_password'], [
				'memory_cost' => 2048, 
				'time_cost' => 8, 
				'threads' => 4
			]),
			'status' => (isset($post['status']) ? 'active' : 'inactive'),
			'group_id' => $post['group_id'],
			'user_picture' => $foto
		]);

		return ($this->db->affected_rows() > 0) ? 1 : 0;
	}

	public function hapus($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('user_id !=', $this->session->userdata('uid'));
		$this->db->delete('tb_user');
		return ($this->db->affected_rows() > 0) ? 1 : 0;
	}
}