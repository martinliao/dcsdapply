<?php

class Volunteer_select_model extends MY_Model{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database('phy');
	}
	
	function get_course_detail($start_date,$end_date,$class_no,$class_name){
		$this->db->where('start_date >= ',$start_date);
		$this->db->where('start_date <= ',$end_date);

        if(!empty($class_no)){
            $this->db->where('class_no',$class_no);
        }

        if(!empty($class_name)){
            $this->db->like('name', $class_name); 
        }

		$query = $this->db->get('course');

		return $query->result();
	}

	function get_course_detail_by_id($id){
		$this->db->where('id',$id);

		$query = $this->db->get('course');

		return $query->result();
	}

	function get_course_date_list($cid){
		$this->db->select('date');
		$this->db->where('courseid',$cid);
		$this->db->where('status','1');
		$this->db->group_by("date"); 
		$query = $this->db->get('volunteer_calendar');

		return $query->result();
	}	

	function get_volunteer_calendar_detail_by_id($cid,$date,$type,$aid=''){
		$this->db->select('a.id,a.num_got_it,a.num_waiting,b.id as aid,b.got_it,b.start_time,b.end_time,c.name,c.email');
		$this->db->from('volunteer_calendar a');
		$this->db->join('volunteer_calendar_apply b','a.id = b.calendarid');
		$this->db->join('users c','c.id = b.userid');
		$this->db->where('a.courseid',$cid);
		$this->db->where('a.status','1');
		$this->db->where('a.type',$type);
		$this->db->where('a.date',$date);
		if(!empty($aid)){
			$this->db->where('b.id',$aid);
		}
		
		$query = $this->db->get();

		return $query->result();
	}

	function get_person_limit($cid,$date,$type){
		$this->db->select('id,num_got_it,num_waiting');
		$this->db->from('volunteer_calendar');
		$this->db->where('courseid',$cid);
		$this->db->where('status','1');
		$this->db->where('type',$type);
		$this->db->where('date',$date);

		$query = $this->db->get();

		return $query->result();
	}

	function upd_volunteer_calendar($vid,$num_got_it){
		$this->db->set('num_got_it', $num_got_it);
		$this->db->set('num_waiting', ($num_got_it*2));
		$this->db->where('id',$vid);
		$this->db->update('volunteer_calendar'); 

		return true;
	}

	function upd_volunteer_calendar_apply($aid,$cid,$date,$type){
		$this->db->select('got_it');
		$this->db->from('volunteer_calendar_apply');
		$this->db->where('id',$aid); 
		$query = $this->db->get();
		$check = $query->result();

		$mail = array();

		if($check[0]->got_it == '1'){
			return $mail;
		}

		$course = $this->get_course_detail_by_id($cid);
		$detail = $this->get_volunteer_calendar_detail_by_id($cid,$date,$type,$aid);

		$this->db->set('got_it', '1');
		$this->db->where('id',$aid); 

		if($this->db->update('volunteer_calendar_apply')){
			$this->db->set('category', '班務');
			$this->db->set('year', $course[0]->year);
			$this->db->set('class_no', $course[0]->class_no);
			$this->db->set('term', $course[0]->term);
			$this->db->set('course_name', $course[0]->name);
			$this->db->set('firstname', $detail[0]->name);
			$this->db->set('course_date', $date);

			if($type == '1'){
				$type_name = '早上';
			} else if($type == '2'){
				$type_name = '下午';
			} else if($type == '3') {
				$type_name = '晚上';
			}

			$this->db->set('type', $type_name);
			$this->db->set('action', '錄取');
			$this->db->set('modifytime',date('Y-m-d H:i:s'));

			$this->db->insert('log');

			$date = (date('Y',strtotime($date))-1911).'年'.date('m',strtotime($date)).'月'.date('d',strtotime($date)).'日';
			$title = '提醒晉升公訓處志工正取-'.$date.'(班務志工)'; 
			$body = 'Dear '.$detail[0]->name.' 先生/小姐您好:<br>
					感謝您支持:臺北市政府公務人員訓練處志工隊之志願服務，<br>
					有關您選填:'.$date.' '.$detail[0]->start_time.'~'.$detail[0]->end_time.'<br>
					班期名稱:'.$course[0]->name.'<br>
					原為候補第一順位，因正取人員取消，<br>
					<font color="red">已晉升為正取!</font>屆時請您如期支援該班期，特來信通知，萬分感謝!!';

			$mail = array(
						'title' => $title,
						'body' => $body,
						'email' => $detail[0]->email,
				);
		}

		return $mail;
	}

	function upd_volunteer_calendar_apply_others($aid,$vid,$date,$type){
		$this->db->select('got_it,userid,start_time,end_time');
		$this->db->from('volunteer_calendar_apply');
		$this->db->where('id',$aid); 
		$query = $this->db->get();
		$check = $query->result();

		$mail = array();
		if($check[0]->got_it == '1'){
			return $mail;
		}

		$this->db->set('got_it', '1');
		$this->db->where('id',$aid);

		if($this->db->update('volunteer_calendar_apply')){
			$this->db->select('name');
			$this->db->from('volunteer_category');
			$this->db->where('id',$vid);
			$result = $this->db->get();
			$category_name = $result->row();

			$this->db->select('name,email');
			$this->db->from('users');
			$this->db->where('id',$check[0]->userid);
			$result = $this->db->get();
			$firstname = $result->result();

			if($type == '1'){
				$type_name = '早上';
			} else if($type == '2'){
				$type_name = '下午';
			}

			$this->db->set('category', $category_name->name);
			$this->db->set('firstname', $firstname[0]->name);
			$this->db->set('course_date', date('Y-m-d',$date));
			$this->db->set('type', $type_name);
			$this->db->set('action', '錄取');
			$this->db->set('modifytime',date('Y-m-d H:i:s'));
			$this->db->insert('log');

			$date = (date('Y',$date)-1911).'年'.date('m',$date).'月'.date('d',$date).'日';
			$title = '提醒晉升公訓處志工正取-'.$date.'('.$category_name->name.'志工)'; 
			$body = 'Dear '.$firstname[0]->name.' 先生/小姐您好:<br>
					感謝您支持:臺北市政府公務人員訓練處志工隊之志願服務，<br>
					有關您選填:'.$date.' '.$check[0]->start_time.'~'.$check[0]->end_time.'<br>
					原為候補第一順位，因正取人員取消，<br>
					<font color="red">已晉升為正取!</font>屆時請您如期支援該班期，特來信通知，萬分感謝!!';

			$mail = array(
						'title' => $title,
						'body' => $body,
						'email' => $firstname[0]->email,
				);

		}

		return $mail;
	}

	function del_volunteer_calendar_apply($aid,$cid,$date,$type){
		$course = $this->get_course_detail_by_id($cid);
		$detail = $this->get_volunteer_calendar_detail_by_id($cid,$date,$type,$aid);

		$mail = array();
		if($this->db->delete('volunteer_calendar_apply', array('id' => $aid))){
			$this->db->set('category', '班務');
			$this->db->set('year', $course[0]->year);
			$this->db->set('class_no', $course[0]->class_no);
			$this->db->set('term', $course[0]->term);
			$this->db->set('course_name', $course[0]->name);
			$this->db->set('firstname', $detail[0]->name);
			$this->db->set('course_date', $date);

			if($type == '1'){
				$type_name = '早上';
			} else if($type == '2'){
				$type_name = '下午';
			} else if($type == '3') {
				$type_name = '晚上';
			}

			$this->db->set('type', $type_name);
			$this->db->set('action', '取消');
			$this->db->set('modifytime',date('Y-m-d H:i:s'));

			$this->db->insert('log');

			$date = (date('Y',strtotime($date))-1911).'年'.date('m',strtotime($date)).'月'.date('d',strtotime($date)).'日';
			$title = '提醒取消公訓處志工正取-'.$date.'(班務志工)'; 
			$body = 'Dear '.$detail[0]->name.' 先生/小姐您好:<br>
					感謝您支持:臺北市政府公務人員訓練處志工隊之志願服務，<br>
					有關您選填:'.$date.' '.$detail[0]->start_time.'~'.$detail[0]->end_time.'<br>
					班期名稱:'.$course[0]->name.'<br>
					原為正取人員，因上述志工管理者已為您取消報名，<br>
					故原定報名服務班次已取消!，特來信通知，萬分感謝!!';

			$mail = array(
						'title' => $title,
						'body' => $body,
						'email' => $detail[0]->email,
				);
		}

		return $mail;
	}

	function del_volunteer_calendar_apply_others($aid,$vid,$date,$type){
		$this->db->select('userid,start_time,end_time');
		$this->db->from('volunteer_calendar_apply');
		$this->db->where('id',$aid); 
		$query = $this->db->get();
		$check = $query->result();

		$mail = array();
		if($this->db->delete('volunteer_calendar_apply', array('id' => $aid))){
			$this->db->select('name');
			$this->db->from('volunteer_category');
			$this->db->where('id',$vid);
			$result = $this->db->get();
			$category_name = $result->row();

			$this->db->select('name,email');
			$this->db->from('users');
			$this->db->where('id',$check[0]->userid);
			$result = $this->db->get();
			$firstname = $result->result();

			if($type == '1'){
				$type_name = '早上';
			} else if($type == '2'){
				$type_name = '下午';
			}

			$this->db->set('category', $category_name->name);
			$this->db->set('firstname', $firstname[0]->name);
			$this->db->set('course_date', date('Y-m-d',$date));
			$this->db->set('type', $type_name);
			$this->db->set('action', '取消');
			$this->db->set('modifytime',date('Y-m-d H:i:s'));
			$this->db->insert('log');

			$date = (date('Y',$date)-1911).'年'.date('m',$date).'月'.date('d',$date).'日';
			$title = '提醒取消公訓處志工正取-'.$date.'('.$category_name->name.'志工)'; 
			$body = 'Dear '.$firstname[0]->name.' 先生/小姐您好:<br>
					感謝您支持:臺北市政府公務人員訓練處志工隊之志願服務，<br>
					有關您選填:'.$date.' '.$check[0]->start_time.'~'.$check[0]->end_time.'<br>
					原為正取人員，因上述志工管理者已為您取消報名，<br>
					故原定報名服務班次已取消!，特來信通知，萬分感謝!!';

			$mail = array(
						'title' => $title,
						'body' => $body,
						'email' => $firstname[0]->email,
				);
		}

		return $mail;
	}

	function makeup_volunteer_calendar_apply($vid){
		$this->db->select('num_got_it,courseid,date');
		$this->db->from('volunteer_calendar');
		$this->db->where('id',$vid);
		$query = $this->db->get();
		$data1 = $query->result();

		$this->db->select('count(1) cnt');
		$this->db->from('volunteer_calendar_apply');
		$this->db->where('calendarid',$vid);
		$this->db->where('got_it','1');
		$query2 = $this->db->get();
		$data2 = $query2->result();
		$mail = array();
		if($data1[0]->num_got_it == $data2[0]->cnt){
			return $mail;
		} else {
			$this->db->select('id,userid,start_time,end_time');
			$this->db->from('volunteer_calendar_apply');
			$this->db->where('calendarid',$vid);
			$this->db->where('got_it','0');
			$this->db->order_by('id','asc');
			$query3 = $this->db->get();
			$data3 = $query3->result();

			$k = $data1[0]->num_got_it - $data2[0]->cnt;

			for($i=0;$i<$k;$i++){
				if(isset($data3[$i]->id) && $data3[$i]->id > 0){
					$this->db->set('got_it', '1');
					$this->db->where('id',$data3[$i]->id);
					
					if($this->db->update('volunteer_calendar_apply')){
						$this->db->select('name,email');
						$this->db->from('users');
						$this->db->where('id',$data3[0]->userid);
						$result = $this->db->get();
						$firstname = $result->result();

						$course = $this->get_course_detail_by_id($data1[0]->courseid);

						$date = (date('Y',strtotime($data1[0]->date))-1911).'年'.date('m',strtotime($data1[0]->date)).'月'.date('d',strtotime($data1[0]->date)).'日';
						$title = '提醒晉升公訓處志工正取-'.$date.'(班務志工)'; 
						$body = 'Dear '.$firstname[0]->name.' 先生/小姐您好:<br>
								感謝您支持:臺北市政府公務人員訓練處志工隊之志願服務，<br>
								有關您選填:'.$date.' '.$data3[0]->start_time.'~'.$data3[0]->end_time.'<br>
								班期名稱:'.$course[0]->name.'<br>
								原為候補第一順位，因正取人員取消，<br>
								<font color="red">已晉升為正取!</font>屆時請您如期支援該班期，特來信通知，萬分感謝!!';

						$mail_tmp = array(
									'title' => $title,
									'body' => $body,
									'email' => $firstname[0]->email,
							);

						array_push($mail, $mail_tmp);
						unset($mail_tmp);
					}
				}
			}

			return $mail;
		}

	}

	function makeup_volunteer_calendar_apply_other($vid,$category_id){
		$this->db->select('num_got_it,date');
		$this->db->from('volunteer_calendar');
		$this->db->where('id',$vid);
		$query = $this->db->get();
		$data1 = $query->result();

		$this->db->select('count(1) cnt');
		$this->db->from('volunteer_calendar_apply');
		$this->db->where('calendarid',$vid);
		$this->db->where('got_it','1');
		$query2 = $this->db->get();
		$data2 = $query2->result();
		$mail = array();
		if($data1[0]->num_got_it == $data2[0]->cnt){
			return $mail;
		} else {
			$this->db->select('id,userid,start_time,end_time');
			$this->db->from('volunteer_calendar_apply');
			$this->db->where('calendarid',$vid);
			$this->db->where('got_it','0');
			$this->db->order_by('id','asc');
			$query3 = $this->db->get();
			$data3 = $query3->result();

			$k = $data1[0]->num_got_it - $data2[0]->cnt;

			for($i=0;$i<$k;$i++){
				if(isset($data3[$i]->id) && $data3[$i]->id > 0){
					$this->db->set('got_it', '1');
					$this->db->where('id',$data3[$i]->id);
					if($this->db->update('volunteer_calendar_apply')){
						$this->db->select('name');
						$this->db->from('volunteer_category');
						$this->db->where('id',$category_id);
						$result = $this->db->get();
						$category_name = $result->row();

						$this->db->select('name,email');
						$this->db->from('users');
						$this->db->where('id',$data3[0]->userid);
						$result = $this->db->get();
						$firstname = $result->result();

						$date = (date('Y',strtotime($data1[0]->date))-1911).'年'.date('m',strtotime($data1[0]->date)).'月'.date('d',strtotime($data1[0]->date)).'日';
						$title = '提醒晉升公訓處志工正取-'.$date.'('.$category_name->name.'志工)'; 
						$body = 'Dear '.$firstname[0]->name.' 先生/小姐您好:<br>
								感謝您支持:臺北市政府公務人員訓練處志工隊之志願服務，<br>
								有關您選填:'.$date.' '.$data3[0]->start_time.'~'.$data3[0]->end_time.'<br>
								原為候補第一順位，因正取人員取消，<br>
								<font color="red">已晉升為正取!</font>屆時請您如期支援該班期，特來信通知，萬分感謝!!';

						$mail_tmp = array(
									'title' => $title,
									'body' => $body,
									'email' => $firstname[0]->email,
							);

						array_push($mail, $mail_tmp);
						unset($mail_tmp);
					}
				}
			}

			return $mail;
		}

	}

	function get_log($start_date,$end_date){
		$this->db->where('course_date >= ',$start_date);
		$this->db->where('course_date < ',$end_date);
		$query = $this->db->get('log');
		
		return $query->result();
	}

	function get_volunteer_category($vcid){
		$volunteer_data = $this->db->where('id',$vcid)
                                   ->where('others',1)
                                   ->get('volunteer_category')
                                   ->row();

        return $volunteer_data;              
	}

	function get_card_log_detail($start_date,$end_date,$name,$category){
		$this->db->select('a.*,b.name');
		$this->db->from('card_log a');
		$this->db->join('volunteer_category b','a.category = b.id');
		$this->db->where('use_date >= ',$start_date);
		$this->db->where('use_date <= ',$end_date);

		if(!empty($name)){
			$this->db->where('firstname',$name);
		}

		if(!empty($category)){
			$all = false;
			$category_list = '';

			for($i=0;$i<count($category);$i++){
				if($category[$i] == 'all'){
					$all = true;
					break;
				} else {
					$category_list .= $category[$i].',';
				}
			}

			if(!$all){
				$category_list = substr($category_list, 0,-1);
				$this->db->where_in('a.category',$category_list);
			} 
		} 

		$this->db->order_by('a.machine_id','asc');
		$this->db->order_by('a.use_date','asc');
		$this->db->order_by('a.idno','asc');
		$this->db->order_by('a.pass_time','asc');
		$query = $this->db->get();

		return $query->result_array();
	}

	function get_sign_log_list($start_date,$end_date,$uid,$category){
		$where = '';
		if(!empty($start_date) && !empty($end_date)){
			$start_date = $start_date.' 00:00:00';
			$end_date = $end_date.' 23:59:59';

			$where .= sprintf(" AND sign_log.sign_time BETWEEN '%s' AND '%s' ",$start_date,$end_date);
		}

		if(intval($uid) > 0){
			$where .= sprintf(" AND users.id = '%s' ",trim($uid)); 
		}

		if(!empty($category)){
			$all = false;
			$category_list = '';

			for($i=0;$i<count($category);$i++){
				if($category[$i] == 'all'){
					$all = true;
					break;
				} else {
					$category_list .= $category[$i].',';
				}
			}

			if(!$all){
				$category_list = substr($category_list, 0,-1);
				$where .= sprintf(" AND volunteer_classroom.volunteerID in (%s) ",$category_list); 
			} 
		} 

		$sql = sprintf("SELECT
							sign_log.idno,
							sign_log.status,
							DATE_FORMAT( sign_log.sign_time, '%%Y-%%m-%%d' ) AS sign_date,
							DATE_FORMAT( sign_log.sign_time, '%%H:%%i:%%s' ) AS sign_time,
							users.`name`,
							users.`id` as uid,
							volunteer_classroom.volunteerID,
							volunteer_category.`name` AS category_name,
							volunteer_calendar.type,
							CASE
								volunteer_classroom.volunteerID 
							WHEN '1' THEN
								volunteer_calendar.hours 
							ELSE
								CASE
									volunteer_calendar.type 
								WHEN '1' THEN
									(
										round(TIME_TO_SEC(TIMEDIFF(volunteer_category.morning_end,volunteer_category.morning_start))/3600)
									)
								WHEN '2' THEN
									(
										round(TIME_TO_SEC(TIMEDIFF(volunteer_category.afternoon_end,volunteer_category.afternoon_start))/3600)
									)
								END 
							END hours
						FROM
							sign_log
							JOIN users ON sign_log.idno = users.idNo
							JOIN volunteer_calendar_apply ON users.id = volunteer_calendar_apply.userID
							JOIN volunteer_calendar ON volunteer_calendar_apply.calendarID = volunteer_calendar.id 
							AND DATE_FORMAT( sign_log.sign_time, '%%Y-%%m-%%d' ) = volunteer_calendar.date
							JOIN volunteer_classroom ON volunteer_calendar.vcID = volunteer_classroom.id
							JOIN volunteer_category ON volunteer_classroom.volunteerID = volunteer_category.id 
						WHERE
							users.role_id = 20 
							AND volunteer_calendar_apply.got_it = 1 
							%s
						GROUP BY
							sign_log.idno,
							sign_log.sign_time,
							volunteer_calendar.date,
							volunteer_calendar.type 
						ORDER BY
							sign_log.sign_time,
							sign_log.idno",$where);
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function add_card_log($id,$hour,$minute,$second){
		$this->db->where('id',$id);
		$query = $this->db->get('card_log');
		$result = $query->result();

		if(!empty($result)){
			if(intval($hour) < 10){
				$hour = '0'.$hour;
			}

			if(intval($minute) < 10){
				$minute = '0'.$minute;
			}

			if(intval($second) < 10){
				$second = '0'.$second;
			}

			$this->db->set('category',$result[0]->category);
			$this->db->set('type',$result[0]->type);
			$this->db->set('idno',$result[0]->idno);
			$this->db->set('use_date',$result[0]->use_date);
			$this->db->set('firstname',$result[0]->firstname);
			$this->db->set('machine_id',$result[0]->machine_id);
			$this->db->set('pass_time',$hour.$minute.$second);

			if($this->db->insert('card_log')){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function add_card_log_new($idno,$hour,$minute,$second,$sign_date){
		if(intval($hour) < 10){
			$hour = '0'.$hour;
		}

		if(intval($minute) < 10){
			$minute = '0'.$minute;
		}

		if(intval($second) < 10){
			$second = '0'.$second;
		}

		$sign_time = $sign_date.' '.$hour.':'.$minute.':'.$second;
		
		$this->db->set('idno',$idno);
		$this->db->set('sign_time',$sign_time);
		$this->db->set('status','Y');

		if($this->db->insert('sign_log')){
			return true;
		} else {
			return false;
		}
	}

	function get_person_limit_others($vid,$type,$date){
		$this->db->select('id');
		$this->db->from('volunteer_classroom');
		$this->db->where('volunteerID',$vid);
		$result = $this->db->get();
		$category_id = $result->row();

		$this->db->select('id,num_got_it,num_waiting');
		$this->db->from('volunteer_calendar');
		$this->db->where('vcID',$category_id->id);
		$this->db->where('status','1');
		$this->db->where('type',$type);
		$this->db->where('date',date('Y-m-d',$date));
		$query = $this->db->get();
	
		return $query->result();
	}

	function get_volunteer_calendar_others_detail($vid,$type,$date){
		$date = date('Y-m-d',$date);
		$sql = sprintf("SELECT
							a.id,
							a.num_got_it,
							a.num_waiting,
							d.`name`,
							c.got_it,
							c.id as aid
						FROM
							volunteer_calendar a
						JOIN volunteer_classroom b ON a.vcID = b.id
						JOIN volunteer_calendar_apply c ON c.calendarID = a.id
						JOIN users d ON c.userid = d.id
						WHERE
							a.type = '%s'
						AND a.date = '%s'
						AND b.volunteerID = '%s'",$type,$date,$vid);
		
		$query = $this->db->query($sql);
		
		return $query->result();
	}

	function upd_volunteer_calendar_batch($vcid,$first_day,$last_day,$day,$type,$num_got_it){
		$this->db->select('id');
		$this->db->from('volunteer_classroom');
		$this->db->where('volunteerID',$vcid);
		$result = $this->db->get();
		$category_id = $result->row();

		if($category_id->id > 0 && $category_id->id != '1'){
			$this->db->where('vcid',$category_id->id);
			$this->db->where('day',$day);
			$this->db->where('type',$type);
			$this->db->where('date >=',$first_day);
			$this->db->where('date <=',$last_day);
			$this->db->set('num_got_it',$num_got_it);
			$this->db->set('num_waiting',($num_got_it*2));
			$this->db->update('volunteer_calendar');

			return true;
		}
		
		return false;
	}

	public function getVolunteerList($key){
		$this->db->select('name');
		$this->db->like('name', $key, 'after');
		$query = $this->db->get('users');
		$data = $query->result_array();

		return $data;
	}

	public function getVolunteerIdno($uid){
		$this->db->select('idNo');
		$this->db->where('id',$uid);
		$query = $this->db->get('users');
		$data = $query->result_array();

		if(!empty($data)){
			return $data[0]['idNo'];
		}

		return '';
	}
}
