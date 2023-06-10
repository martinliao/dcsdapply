<?php

class Instant_message_model extends MY_Model{
	
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

	function get_message($list)
	{
		if(!empty($list)){
			$uid = $this->get_uid($list['search']);
			if(!empty($uid)){
				$this->db->where('recipient_id',$uid[0]->uid);
			} else {
				return;
			}
			
		}
		$this->db->order_by("send_time,id", "desc"); 
		$query = $this->db->get('mdl_fet_instant_message');
		
		return $query->result();
	}

	function get_message_by_id($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('mdl_fet_instant_message');
		
		return $query->result();
	}

	function get_prev($id,$idno)
	{
		$where = '';

		if(!empty($idno)){
			$uid = $this->get_uid(strtoupper($idno));
			$where .= sprintf("AND recipient_id = '%s'",addslashes($uid[0]->uid));
		}

		$sql = sprintf("SELECT min(id) prev_id FROM mdl_fet_instant_message WHERE id > '%s' %s",addslashes($id),$where);
		$query = $this->db->query($sql);

		return $query->result();

	}

	function get_next($id,$idno)
	{
		$where = '';

		if(!empty($idno)){
			$uid = $this->get_uid(strtoupper($idno));
			$where .= sprintf("AND recipient_id = '%s'",addslashes($uid[0]->uid));
		}

		$sql = sprintf("SELECT max(id) next_id FROM mdl_fet_instant_message WHERE id < '%s' %s",addslashes($id),$where);
		$query = $this->db->query($sql);

		return $query->result();

	}

	function get_first($id,$idno)
	{
		$where = '';

		if(!empty($idno)){
			$uid = $this->get_uid(strtoupper($idno));
			$where .= sprintf("AND recipient_id = '%s'",addslashes($uid[0]->uid));
		}

		$sql = sprintf("SELECT max(id) first_id FROM mdl_fet_instant_message WHERE 1=1 %s",$where);
		$query = $this->db->query($sql);

		return $query->result();

	}

	function get_final($id,$idno)
	{
		$where = '';

		if(!empty($idno)){
			$uid = $this->get_uid(strtoupper($idno));
			$where .= sprintf("AND recipient_id = '%s'",addslashes($uid[0]->uid));
		}

		$sql = sprintf("SELECT min(id) final_id FROM mdl_fet_instant_message WHERE 1=1 %s",$where);
		$query = $this->db->query($sql);

		return $query->result();

	}

	function send_message($list)
	{
		if($list['mode'] == 'specify'){
			$idno_list = explode(',', $list['cname']);

			for($i=0;$i<count($idno_list);$i++){
				$uid = $this->get_uid($idno_list[$i]);

				if($uid[0]->uid > 0){
					$firstname = $this->get_name($idno_list[$i]);
					$sql = sprintf("INSERT INTO mdl_fet_instant_message(title,content,sender_id,sender_name,recipient_id,recipient_name,status,send_time) VALUES('%s','%s','','','%s','%s','0',NOW())",
						addslashes($list['title']),
						addslashes(htmlspecialchars($list['content'])),
						addslashes($uid[0]->uid),
						addslashes($firstname)
					);
					$this->db->query($sql);
				}
			}
			
		} elseif($list['mode'] == 'all') {
			$sql = $sql = sprintf("INSERT INTO mdl_fet_instant_message(title,content,sender_id,sender_name,recipient_id,recipient_name,status,send_time) VALUES('%s','%s','','','all','','0',NOW())",
				addslashes($list['title']),
				addslashes(htmlspecialchars($list['content']))
			);

			$this->db->query($sql);
		}
			
	}

	function get_uid($idno){
		$sql = sprintf("SELECT uid FROM mdl_fet_pid WHERE idno = '%s'",addslashes(strtoupper($idno)));
		$query = $this->db->query($sql);
		$uid = $query->result();

		return $uid;
	}

}
