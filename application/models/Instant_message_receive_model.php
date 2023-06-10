<?php

class Instant_message_receive_model extends MY_Model{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}
	
	function get_name($idno)
	{
		$sql = sprintf("SELECT b.firstname FROM mdl_fet_pid a join mdl_user b on a.uid = b.id WHERE idno = '%s'",addslashes(strtoupper($idno)));
		$query = $this->db->query($sql);
		$name = $query->result();

		if(!empty($name)){
			return $name[0]->firstname;
		} else {
			return false;
		}
		
	}

	function get_message($idno,$status)
	{
		$uid = $this->get_uid(strtoupper($idno));

		if($status == '1'){
			$sql = sprintf("SELECT * FROM mdl_fet_instant_message_readed a JOIN mdl_fet_instant_message b on a.mid = b.id WHERE a.uid = '%s' ORDER BY b.send_time DESC",addslashes($uid[0]->uid));
		} elseif($status == '0') {
			$sql = sprintf("SELECT
								*
							FROM
								mdl_fet_instant_message a
							WHERE
								(
									a.recipient_id = '%s'
									OR a.recipient_id = 'all'
								)
							AND a.id NOT IN (
								SELECT
									mid
								FROM
									mdl_fet_instant_message_readed
								WHERE
									uid = '%s'
							)
							ORDER BY
								send_time DESC",
							addslashes($uid[0]->uid),
							addslashes($uid[0]->uid)
						);
		}

		$query = $this->db->query($sql);

		return $query->result();
	}

	function get_count($idno)
	{
		$uid = $this->get_uid(strtoupper($idno));

		$sql = sprintf("SELECT
							count(1) cnt
						FROM
							mdl_fet_instant_message a
						WHERE
							(
								a.recipient_id = '%s'
								OR a.recipient_id = 'all'
							)
						AND a.id NOT IN (
							SELECT
								mid
							FROM
								mdl_fet_instant_message_readed
							WHERE
								uid = '%s'
						)
						ORDER BY
							send_time DESC",
							addslashes($uid[0]->uid),
							addslashes($uid[0]->uid)
						);
		$query = $this->db->query($sql);

		return $query->result();
	}

	function get_message_by_id($id,$idno)
	{
		$uid = $this->get_uid(strtoupper($idno));

		$sql = sprintf("SELECT * FROM mdl_fet_instant_message WHERE (recipient_id = '%s' or recipient_id = 'all') and id = '%s'",
			addslashes($uid[0]->uid),
			addslashes($id)
		);
		$query = $this->db->query($sql);
		
		return $query->result();
	}

	function get_prev($id,$status,$idno)
	{
		$uid = $this->get_uid(strtoupper($idno));

		if($status == '1'){
			$sql = sprintf("SELECT min(mid) prev_id FROM mdl_fet_instant_message_readed WHERE uid = '%s' AND mid > '%s'",
				addslashes($uid[0]->uid),
				addslashes($id)
			);
		} elseif($status == '0') {
			$sql = sprintf("SELECT
								min(a.id) prev_id
							FROM
								mdl_fet_instant_message a
							WHERE
								(
									a.recipient_id = '%s'
									OR a.recipient_id = 'all'
								)
							AND a.id NOT IN (
								SELECT
									mid
								FROM
									mdl_fet_instant_message_readed
								WHERE
									uid = '%s'
							) 
							AND a.id > '%s'
							ORDER BY
								send_time DESC",
								addslashes($uid[0]->uid),
								addslashes($uid[0]->uid,$id)
							);

		}

		$query = $this->db->query($sql);

		return $query->result();

	}

	function get_next($id,$status,$idno)
	{
		$uid = $this->get_uid(strtoupper($idno));

		if($status == '1'){
			$sql = sprintf("SELECT max(mid) next_id FROM mdl_fet_instant_message_readed WHERE uid = '%s' AND mid < '%s'",
				addslashes($uid[0]->uid),
				addslashes($id)
			);
		} elseif($status == '0') {
			$sql = sprintf("SELECT
								max(a.id) next_id
							FROM
								mdl_fet_instant_message a
							WHERE
								(
									a.recipient_id = '%s'
									OR a.recipient_id = 'all'
								)
							AND a.id NOT IN (
								SELECT
									mid
								FROM
									mdl_fet_instant_message_readed
								WHERE
									uid = '%s'
							) 
							AND a.id < '%s'
							ORDER BY
								send_time DESC",
							addslashes($uid[0]->uid),
							addslashes($uid[0]->uid),
							addslashes($id)
						);
		}
		
		$query = $this->db->query($sql);

		return $query->result();

	}

	function get_first($id,$status,$idno)
	{
		$uid = $this->get_uid(strtoupper($idno));

		if($status == '1'){
			$sql = sprintf("SELECT max(mid) first_id FROM mdl_fet_instant_message_readed WHERE uid = '%s'",addslashes($uid[0]->uid));
		} elseif($status == '0') {
			$sql = sprintf("SELECT
								max(a.id) first_id
							FROM
								mdl_fet_instant_message a
							WHERE
								(
									a.recipient_id = '%s'
									OR a.recipient_id = 'all'
								)
							AND a.id NOT IN (
								SELECT
									mid
								FROM
									mdl_fet_instant_message_readed
								WHERE
									uid = '%s'
							)",
							addslashes($uid[0]->uid),
							addslashes($uid[0]->uid)
						);

		}

		$query = $this->db->query($sql);

		return $query->result();

	}

	function get_final($id,$status,$idno)
	{
		$uid = $this->get_uid(strtoupper($idno));

		if($status == '1'){
			$sql = sprintf("SELECT min(mid) final_id FROM mdl_fet_instant_message_readed WHERE uid = '%s'",addslashes($uid[0]->uid));
		} elseif($status == '0') {
			$sql = sprintf("SELECT
								min(a.id) final_id
							FROM
								mdl_fet_instant_message a
							WHERE
								(
									a.recipient_id = '%s'
									OR a.recipient_id = 'all'
								)
							AND a.id NOT IN (
								SELECT
									mid
								FROM
									mdl_fet_instant_message_readed
								WHERE
									uid = '%s'
							)",
							addslashes($uid[0]->uid),
							addslashes($uid[0]->uid)
						);

		}

		$query = $this->db->query($sql);

		return $query->result();

	}

	function get_uid($idno){
		$sql = sprintf("SELECT uid FROM mdl_fet_pid WHERE idno = '%s'",addslashes(strtoupper($idno)));
		$query = $this->db->query($sql);
		$uid = $query->result();

		return $uid;
	}

	function update_status($id,$idno){
		$uid = $this->get_uid(strtoupper($idno));

		$sql = sprintf("INSERT INTO mdl_fet_instant_message_readed(mid,uid) VALUES('%s','%s')",
			addslashes($id),
			addslashes($uid[0]->uid)
		);
		$this->db->query($sql);
	}

}
