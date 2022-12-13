<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_m extends CI_Model {

	public function nextQueue($counter_id)
	{
		$this->db->where('counter_id', $counter_id);
		$this->db->where('date', date('Y-m-d'));
		return $this->db->get('tb_transaction')->num_rows() + 1;
	}

	public function updateTransaksi($counter_id)
	{
		$insert = $this->db->insert('tb_transaction', [
			'transaction_id' => uniqidReal(),
			'counter_id' => $counter_id,
			'employee_name' => $this->user->employee_name,
			'date' => date('Y-m-d')
		]) ? true : false;

		return ($insert === true) ? $this->nextQueue($counter_id) : 0;
	}

}

/* End of file transaksi_m.php */
/* Location: ./application/models/transaksi_m.php */