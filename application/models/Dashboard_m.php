<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_m extends CI_Model {

	public function total_petugas()
	{
		return $this->db->get('tb_user')->num_rows();
	}

	public function total_loket()
	{
		return $this->db->get('tb_counter')->num_rows();
	}

	public function pengunjung_hari_ini()
	{
		$this->db->where('date', date('Y-m-d'));
		return $this->db->get('tb_transaction')->num_rows();
	}

	public function slides()
	{
		return $this->db->get('tb_slide')->num_rows();
	}
	
	public function pengunjung_ytd()
	{
		$bulan = [];
		$jumlah = [];

		$this->db->select("COUNT(transaction_id) AS total, date_format(date, '%M %Y') AS bulan");
		$this->db->group_by("date_format(date, '%M %Y')");
		$this->db->order_by('date', 'asc');
		$visitor = $this->db->get('tb_transaction', 12)->result();

		foreach ($visitor as $value) {
			$bulan[] = $value->bulan;
			$jumlah[] = $value->total;
		}

		return array('labels' => $bulan, 'data' => ['jumlah' => $jumlah]);
	}
}

/* End of file dashboard_m.php */
/* Location: ./application/models/dashboard_m.php */