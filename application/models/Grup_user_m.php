<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grup_user_m extends CI_Model {

	public function getFeatures($mode = null)
	{
		$this->db->select('grup_fitur, mode');
		if($mode === 'r') {
			$this->db->where('mode', 'r');
		}
		$this->db->group_by('grup_fitur');
		$this->db->group_by('mode');
		return $this->db->get('tb_menu')->result_array();
	}	

	private function __randomColor()
	{
		$color = array(
			'btn-primary',
			'btn-danger',
			'btn-success',
			'btn-warning',
			'btn-info',
			'btn-secondary',
			'btn-light'
		);
		return $color;
	}

	public function getFeaturesByGroupID($group_id, $comma = false)
	{
		$this->db->select('a.grup_fitur, a.mode');
		$this->db->join('tb_roles b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->where('b.group_id', $group_id);
		$this->db->group_by('a.grup_fitur');
		$this->db->group_by('a.mode');
		$this->db->order_by('a.grup_fitur', 'asc');
		$result = $this->db->get('tb_menu a')->result();

		$priv = [];

		if(!$comma)
		{
			if(count($result) > 0)
			{
				foreach ($result as $value) {
					$colors = $this->__randomColor();
					shuffle($colors);

					$priv[] = '<span class="badge badge-pill '.$colors[0].' mr-1 mb-3">'.$value->grup_fitur.' ('. $value->mode.')</span>';
				}

				return implode(' ', $priv);
			}
		}
		else
		{
			if(count($result) > 0)
			{
				foreach ($result as $value) {
					$priv[] = $value->grup_fitur.'_'.$value->mode;
				}

				return implode(',', $priv);
			}
		}
	}

	public function grup($id = null)
	{
		if(!empty($id)) {
			$this->db->where('group_id', $id);
			$user_group =  $this->db->get('tb_user_group')->row_array();

			return array_merge($user_group, ['features' => $this->getFeaturesByGroupID($user_group['group_id'], true)]);
		}
		else
		{
			return $this->db->get('tb_user_group')->result();
		}
	}

	public function getIndexMenu($group_id, $index_menu)
	{
		$this->db->select('a.label_menu, a.slug_menu');
		$this->db->join('tb_roles b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->where('b.group_id', $group_id);
		$this->db->where('a.tipe_menu != ', 'button');
		$this->db->order_by('label_menu', 'asc');
		$result = $this->db->get('tb_menu a')->result();

		foreach ($result as $index)
		{
			$options[] = '<option value="'.$index->slug_menu.'" '.(($index_menu === $index->slug_menu) ? 'selected=""' : "").'>'.$index->label_menu.'</option>';
		}

		return implode("\n",$options);
	}

	private function __tambahFitur($id, $feature)
	{
		$feature = explode('_', $feature);

		$this->db->select('menu_id');
		$this->db->where('grup_fitur', $feature[0]);
		$this->db->where('mode', $feature[1]);
		$result = $this->db->get('tb_menu')->result_array();

		$object = [];
		foreach ($result as $res) {
			
			$object[] = array('group_id' => $id, 'menu_id' => $res['menu_id']);
		}

		return $this->db->insert_batch('tb_roles', $object) ? true : false;
	}

	public function tambah($post)
	{
		$insert = $this->db->insert('tb_user_group', [
			'group_name' => strtolower($post['group_name']),
			'mode' => $post['mode']
		]);

		$group_id = $this->db->insert_id();

		if($insert)
		{
			for ($i = 0; $i < count($post['fitur']); $i++)
			{
				$this->__tambahFitur($group_id, $post['fitur'][$i]);
			}

			return 1;
		}
		else
		{
			return 0;
		}
	}

	public function ubah($post)
	{
		$this->db->where('group_id', $post['group_id']);
		$this->db->delete('tb_roles');

		$delete = ($this->db->affected_rows() > 0) ? true : false;

		if($delete) {
			$this->db->where('group_id', $post['group_id']);
			$update = $this->db->update('tb_user_group', array('group_name' => $post['group_name']));
			if($update) {

				for ($i = 0; $i < count($post['fitur']); $i++)
				{
					$this->__tambahFitur($post['group_id'], $post['fitur'][$i]);
				}

				return 1;
			}
		}
		else
		{
			return 0;
		}
	}

	public function checkGroup($post)
	{
		$this->db->select('group_name');
		$this->db->where('group_name', strtolower($post['group_name']));
		$this->db->where('group_id !=', $post['group_id']);
		return $this->db->get('tb_user_group')->num_rows();
	}

	public function hapus($group_id)
	{
		$this->db->where('group_id', $group_id);
		$this->db->delete('tb_user_group');
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function updateIndex($post)
	{
		$this->db->where('group_id', $post['group_id']);
		$this->db->update('tb_user_group', ['index_menu' => $post['index_menu']]);
		return ($this->db->affected_rows() > 0) ? true : false;
	}
}

/* End of file grup_user_m.php */
/* Location: ./application/models/grup_user_m.php */