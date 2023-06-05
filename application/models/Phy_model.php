<?php

class Phy_model extends MY_Model{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database('phy');
	}
	
	function get_name($idno)
	{
		// $sql = "SELECT count(1) cnt FROM require";
		// $query = $this->db->query($sql);
		// $cnt = $query->result();

		// print_r($cnt);
		die('123');
		
	}

	

}
