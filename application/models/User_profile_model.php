<?php

class User_profile_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database('phy');
	}
	
	public function getUserById($id){
		$this->db->where('id',$id);
		$query = $this->db->get('users');
		if($query !== FALSE && $query->num_rows() > 0){
			//return $query->result_array();
			return $query->row(0, 'array');
		}
		return [];
	}

	public function updateUser($user){
    	if($this->db->replace('users', $user)){
    		return true;
    	}
    	return false;
    }
}