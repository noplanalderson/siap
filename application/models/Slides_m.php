<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slides_m extends CI_Model {

	public function slide($id)
	{
		$this->db->where('slide_id', $id);
		return $this->db->get('tb_slide')->row_array();
	}

	public function slides()
	{
		$this->db->order_by('upload_date', 'desc');
		return $this->db->get('tb_slide')->result_array();
	}

	public function tambah($id, $post, $gambar)
	{
		return $this->db->insert('tb_slide', [
			'slide_id' => $id,
			'image' => $gambar['file_name'],
			'upload_by' => $this->user->employee_name,
			'slide_title' => $post['slide_title'],
			'slide_description' => $post['slide_description'],
			'status' => (isset($post['status']) ? 'show' : 'hide')
		]) ? 1 : 0;
	}

	public function ubah($post, $gambar)
	{
		$this->db->where('slide_id', $post['slide_id']);
		$this->db->update('tb_slide', [
			'image' => $gambar,
			'upload_by' => $this->user->employee_name,
			'slide_title' => $post['slide_title'],
			'slide_description' => $post['slide_description'],
			'status' => (isset($post['status']) ? 'show' : 'hide')
		]);
		return ($this->db->affected_rows() > 0) ? 1 : 0;
	}

	public function hapus($id, $file)
	{
		$this->db->where('slide_id', $id);
		$this->db->delete('tb_slide');

		return ($this->db->affected_rows() > 0) ? 1 : 0;
	}
}

/* End of file slide_m.php */
/* Location: ./application/models/slide_m.php */