<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loket_m extends CI_Model {

	public function loket($id)
	{
		$this->db->select('a.*');
		$this->db->join('tb_operator b', 'a.counter_id = b.counter_id', 'inner');
		$this->db->where('b.user_id', $this->session->userdata('uid'));
		$this->db->where('a.counter_id', $id);
		return $this->db->get('tb_counter a')->row_array();
	}

	public function daftarLoket()
	{
		$this->db->select('a.*');
		$this->db->join('tb_operator b', 'a.counter_id = b.counter_id', 'inner');
		$this->db->where('b.user_id', $this->session->userdata('uid'));
		return $this->db->get('tb_counter a')->result_array();
	}

	public function cekLoket($post)
	{
		$this->db->where('counter_name', $post['counter_name']);
		$this->db->where('counter_id != ', $post['counter_id']);
		return $this->db->get('tb_counter')->num_rows();
	}

	public function tambah($post)
	{
		return $this->db->insert('tb_counter', [
			'counter_id' => uniqidReal(),
			'counter_name' => $post['counter_name'],
			'created_by' => $this->user->employee_name,
			'status' => $post['status']
		]) ? 1 : 0;
	}

	public function ubah($post)
	{
		$this->db->where('counter_id', $post['counter_id']);
		$this->db->update('tb_counter', [
			'counter_name' => $post['counter_name'],
			'created_by' => $this->user->employee_name,
			'status' => $post['status']
		]);

		return ($this->db->affected_rows() > 0) ? 1 : 0;
	}

	public function hapus($id)
	{
		$this->db->where('counter_id', $id);
		$this->db->delete('tb_counter');

		return ($this->db->affected_rows() > 0) ? 1 : 0;
	}

	public function status($id, $status)
	{
		$this->db->where('counter_id', $id);
		return $this->db->update('tb_counter', ['status' => $status]) ? 1 : 0;

		// return ($this->db->affected_rows() > 0) ? 1 : 0;
	}
}

/* End of file loket_m.php */
/* Location: ./application/models/loket_m.php */