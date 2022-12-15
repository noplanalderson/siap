<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_m extends CI_Model {

	public function lastQueue($counter_id)
	{
		$this->db->select('transaction_id, queue_num');
		$this->db->where('counter_id', $counter_id);
		$this->db->where("date_format(date, '%Y%m%d') =", date('Ymd'));
		$this->db->where('status', 'queue');
		$this->db->order_by('queue_num', 'asc');
		return $this->db->get('tb_transaction', 1)->row_array();
	}

	public function nextQueue($counter_id)
	{
		$this->db->where('counter_id', $counter_id);
		$this->db->where("date_format(date, '%Y%m%d') =", date('Ymd'));
		return $this->db->get('tb_transaction')->num_rows() + 1;
	}

	public function updateTransaksi($counter_id, $transaction_id)
	{
		$this->db->where('transaction_id', $transaction_id);
		$update = $this->db->update('tb_transaction', [
			'employee_name' => $this->user->employee_name,
			'status' => 'done'
		]) ? true : false;

		return ($update === true) ? $this->lastQueue($counter_id) : 0;
	}

	public function insertTransaksi($counter_id)
	{
		$insert = $this->db->insert('tb_transaction', [
			'transaction_id' => uniqidReal(),
			'queue_num' => $this->nextQueue($counter_id),
			'counter_id' => $counter_id,
			'date' => date('Y-m-d h:i:s'),
			'status' => 'queue'
		]) ? true : false;

		return ($insert === true) ? $this->nextQueue($counter_id) : 0;
	}

	public function daftarTransaksi($loket, $start, $end)
	{
		$this->db->select('a.*, b.counter_name');
		$this->db->join('tb_counter b', 'a.counter_id = b.counter_id', 'inner');
		if($loket !== 'all') {
			$this->db->where('a.counter_id', $loket);
		}
		$this->db->where("date_format(a.date, '%Y-%m-%d') BETWEEN '".$start."' AND '".$end."'");
		return $this->db->get('tb_transaction a')->result_array();
	}
}

/* End of file transaksi_m.php */
/* Location: ./application/models/transaksi_m.php */