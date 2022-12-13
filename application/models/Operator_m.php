<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operator_m extends CI_Model {

	public function users()
	{
		$this->db->select('user_id, employee_name');
		$this->db->order_by('employee_name', 'asc');
		return $this->db->get('tb_user')->result();
	}

	public function counters()
	{
		$this->db->select('counter_id, counter_name');
		$this->db->order_by('counter_name', 'asc');
		return $this->db->get('tb_counter')->result();
	}

	public function operator($id)
	{
		$this->db->where('operator_id', $id);
		return $this->db->get('tb_operator')->row_array();
	}

	public function cekOperator($post)
	{
		$this->db->where('user_id', $post['user_id']);
		$this->db->where('counter_id', $post['counter_id']);
		return $this->db->get('tb_operator')->num_rows();
	}
	
	public function operators()
	{
		$this->db->select('a.operator_id, b.employee_name, c.counter_name');
		$this->db->join('tb_user b', 'a.user_id = b.user_id', 'inner');
		$this->db->join('tb_counter c', 'a.counter_id = c.counter_id', 'inner');
		$this->db->order_by('c.counter_name', 'asc');
		return $this->db->get('tb_operator a')->result_array();
	}

	public function tambah($id, $post)
	{
		return $this->db->insert('tb_operator', [
			'operator_id' => $id,
			'user_id' => $post['user_id'],
			'counter_id' => $post['counter_id']
		]) ? 1 : 0;
	}

	public function ubah($post)
	{
		$this->db->where('operator_id', $post['operator_id']);
		$this->db->update('tb_operator', [
			'user_id' => $post['user_id'],
			'counter_id' => $post['counter_id']
		]);
		return ($this->db->affected_rows() > 0) ? 1 : 0;
	}

	public function hapus($id)
	{
		$this->db->where('operator_id', $id);
		$this->db->delete('tb_operator');

		return ($this->db->affected_rows() > 0) ? 1 : 0;
	}
}

/* End of file operator_m.php */
/* Location: ./application/models/operator_m.php */