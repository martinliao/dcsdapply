<?php

class Volunteer_manage_model extends MY_Model{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database('phy');
	}
	
	function get_volunteer_category_detail($id=0){
		if($id > 0){
			$this->db->where('id',$id);
		}
		
		$this->db->where('others',1);
		$query = $this->db->get('volunteer_category');

		return $query->result();
	}

	function add_volunteer_category_detail($data){
		unset($data['id']);
		$data['create_time'] = time();
		$data['update_time'] = null;

		if($this->db->insert('volunteer_category',$data)){
			return true;
		} 

		return false;
	}

	function upd_volunteer_category_detail($data){
		$id = $data['id'];
		unset($data['id']);
		$data['update_time'] = time();
		$this->db->where('id', $id);

		if($this->db->update('volunteer_category',$data)){
			return true;
		} 

		return false;
	}

	function del_volunteer_category_detail($id){
		if($this->db->delete('volunteer_category', array('id' => $id))){
			return true;
		} 

		return false;
	}

}
