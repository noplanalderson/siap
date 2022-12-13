<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Running_text_m extends CI_Model {

	public function text($id)
	{
		$this->db->where('text_id', $id);
		return $this->db->get('tb_running_text')->row_array();
	}

	public function texts()
	{
		$this->db->order_by('date_created', 'desc');
		return $this->db->get('tb_running_text')->result_array();
	}

	public function tambah($id, $post)
	{
		return $this->db->insert('tb_running_text', [
			'text_id' => $id,
			'created_by' => $this->user->employee_name,
			'text' => $post['text'],
			'status' => $post['status']
		]) ? 1 : 0;
	}

	public function ubah($post)
	{
		$this->db->where('text_id', $post['text_id']);
		$this->db->update('tb_running_text', [
			'created_by' => $this->user->employee_name,
			'text' => $post['text'],
			'status' => $post['status']
		]);
		return ($this->db->affected_rows() > 0) ? 1 : 0;
	}

	public function hapus($id)
	{
		$this->db->where('text_id', $id);
		$this->db->delete('tb_running_text');

		return ($this->db->affected_rows() > 0) ? 1 : 0;
	}
}