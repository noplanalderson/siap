<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_m extends CI_Model {

	public function getSlides()
	{
		$this->db->select('slide_id, slide_title, slide_description, image');
		$this->db->where('status', 'show');
		$this->db->order_by('upload_date', 'desc');
		return $this->db->get('tb_slide')->result();
	}

	public function runningText()
	{
		$this->db->select('text');
		$this->db->order_by('date_created', 'desc');
		return $this->db->get('tb_running_text')->result();
	}

	public function getLoket()
	{
		$this->db->select('counter_id, counter_name, status');
		return $this->db->get('tb_counter')->result();
	}

	public function nomorAntrian($counter_id)
	{
		$this->db->where('counter_id', $counter_id);
		$this->db->where("date_format(date, '%Y%m%d') =", date('Ymd'));
		return $this->db->get('tb_transaction')->num_rows();
	}

	public function getLoketByID($counter_id)
	{
		$this->db->where('counter_id', $counter_id);
		return $this->db->get('tb_counter')->row();
	}
}

/* End of file home_m.php */
/* Location: ./application/models/home_m.php */