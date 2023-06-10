<?php

class Course_model extends MY_Model{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}
	
	
	function get_course()
	{
		$this->db->where('id!=','1');
		$this->db->order_by('id');
		$query = $this->db->get('mdl_course');
		
		return $query->result();
	}
	
	function get_course_info($id)
	{
		$sql = sprintf("SELECT
					t.id,
					t.idnumber,
					t.fullname,
					t.third,
					t.second,
					t.first,
					f.course_target,
					f.course_introduce,
					f.course_outline,
					f.course_outher,
					f.course_teacher,
					f.course_info,
					f.course_remark,
					g.keyword,
					g.certhour,
					g.ecpa_typeid,
					g.edu_detailtypeid,
					g.edu_studydetailid,
					g.edu_typeid,
					g.edu_typesubid,
					g.env_funid,
					g.env_typeid,
					h.gradepass
				FROM
					(
						SELECT
							a.id,
							a.idnumber,
							a.fullname,
							b. NAME third,
							c. NAME second,
							d. NAME first
						FROM
							mdl_course a
						LEFT JOIN mdl_course_categories b ON a.category = b.id
						LEFT JOIN mdl_course_categories c ON c.id = b.parent
						LEFT JOIN mdl_course_categories d ON d.id = c.parent
						LEFT JOIN mdl_course_categories e ON d.id = d.parent
						ORDER BY
							a.id
					) t
				LEFT JOIN mdl_fet_course_info_test f ON t.id = f.courseid
				LEFT JOIN mdl_fet_course_data_test g ON t.id = g.courseid
				LEFT JOIN mdl_grade_items h ON t.id = h.courseid
				AND h.itemmodule = 'quiz'
				where t.id = %s
				GROUP BY
					t.id",addslashes($id));

		$query = $this->db->query($sql);
		return $query->result();
	}

	function get_course_manage($id){
		$sql = sprintf("select * from mdl_fet_course_manage where cid = '%s'",addslashes($id));
		$query = $this->db->query($sql);
		return $query->result();

	}

	function edit_course_info($list){
		$sql = sprintf("select count(1) cnt from mdl_fet_course_manage where cid = '%s'",addslashes($list['cid']));
		$query = $this->db->query($sql);
		$cnt =  $query->result();
		if($cnt[0]->cnt > 0){
			$sql = sprintf("update mdl_fet_course_manage set course_status= '%s', is_mobile= '%s', is_quiz= '%s', contractor_remark= '%s', browser= '%s', off_date= '%s',	on_date= '%s', teaching_materials_year= '%s', course_output_year= '%s',	course_length= '%s', priority_policy= '%s',	teaching_1= '%s', teaching_2= '%s',	teaching_3= '%s', teaching_4= '%s',	teaching_5= '%s', teaching_6= '%s',	teaching_7= '%s', teaching_8= '%s',	teaching_9= '%s', teaching_10= '%s',	teaching_11= '%s', teaching_12= '%s', teaching_13= '%s', teaching_14= '%s',	teaching_15= '%s',	teaching_16= '%s',	class_name_104= '%s', edu_courseid= '%s', artificial_check_status= '%s', deformity_teaching_id = '%s',guest_allow = '%s' where cid ='%s'",
				addslashes($list['course_status_now']),
				addslashes($list['mobile_allow']),
				addslashes($list['quiz']),
				addslashes($list['contractor_remark']),
				addslashes($list['browser']),
				addslashes($list['off_date']),
				addslashes($list['on_date']),
				addslashes($list['teaching_materials_year']),
				addslashes($list['course_output_year']),
				addslashes($list['course_length']),
				addslashes($list['priority_policy']),
				addslashes($list['teaching_1']),
				addslashes($list['teaching_2']),
				addslashes($list['teaching_3']),
				addslashes($list['teaching_4']),
				addslashes($list['teaching_5']),
				addslashes($list['teaching_6']),
				addslashes($list['teaching_7']),
				addslashes($list['teaching_8']),
				addslashes($list['teaching_9']),
				addslashes($list['teaching_10']),
				addslashes($list['teaching_11']),
				addslashes($list['teaching_12']),
				addslashes($list['teaching_13']),
				addslashes($list['teaching_14']),
				addslashes($list['teaching_15']),
				addslashes($list['teaching_16']),
				addslashes($list['class_name']),
				addslashes($list['edu_courseid']),
				addslashes($list['artificial_check_error']),
				addslashes($list['deformity_teaching_id']),
				addslashes($list['guest_allow']),
				addslashes($list['cid'])
			);
			$query = $this->db->query($sql);
		} else {
			$sql = sprintf("insert into mdl_fet_course_manage(cid,course_status,is_mobile,is_quiz,contractor_remark,browser,off_date,on_date,teaching_materials_year,course_output_year,course_length,priority_policy,teaching_1,teaching_2,teaching_3,teaching_4,teaching_5,teaching_6,teaching_7,teaching_8,teaching_9,teaching_10,teaching_11,teaching_12,teaching_13,teaching_14,teaching_15,teaching_16,class_name_104,edu_courseid,artificial_check_status,deformity_teaching_id,guest_allow) values('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
				addslashes($list['cid']),
				addslashes($list['course_status_now']),
				addslashes($list['mobile_allow']),
				addslashes($list['quiz']),
				addslashes($list['contractor_remark']),
				addslashes($list['browser']),
				addslashes($list['off_date']),
				addslashes($list['on_date']),
				addslashes($list['teaching_materials_year']),
				addslashes($list['course_output_year']),
				addslashes($list['course_length']),
				addslashes($list['priority_policy']),
				addslashes($list['teaching_1']),
				addslashes($list['teaching_2']),
				addslashes($list['teaching_3']),
				addslashes($list['teaching_4']),
				addslashes($list['teaching_5']),
				addslashes($list['teaching_6']),
				addslashes($list['teaching_7']),
				addslashes($list['teaching_8']),
				addslashes($list['teaching_9']),
				addslashes($list['teaching_10']),
				addslashes($list['teaching_11']),
				addslashes($list['teaching_12']),
				addslashes($list['teaching_13']),
				addslashes($list['teaching_14']),
				addslashes($list['teaching_15']),
				addslashes($list['teaching_16']),
				addslashes($list['class_name']),
				addslashes($list['edu_courseid']),
				addslashes($list['artificial_check_error']),
				addslashes($list['deformity_teaching_id']),
				addslashes($list['guest_allow'])
			);
			$query = $this->db->query($sql);
		}

		$sql = sprintf("update mdl_fet_course_info_test set course_target = '%s', course_info = '%s', course_introduce = '%s', course_outline = '%s', course_outher = '%s', course_teacher = '%s', course_remark = '%s' where courseid = '%s'",
			addslashes(htmlspecialchars($list['course_target'])),
			addslashes(htmlspecialchars($list['course_info'])),
			addslashes(htmlspecialchars($list['course_intro'])),
			addslashes(htmlspecialchars($list['course_outline'])),
			addslashes(htmlspecialchars($list['course_other'])),
			addslashes(htmlspecialchars($list['teacher'])),
			addslashes(htmlspecialchars($list['course_remark'])),
			addslashes($list['cid'])
		);
		$query = $this->db->query($sql);

		$sql = sprintf("update mdl_fet_course_data_test set keyword = '%s', edu_typeid = '%s', edu_detailtypeid = '%s', edu_typesubid = '%s', edu_studydetailid = '%s', env_funid = '%s', env_typeid = '%s', ecpa_typeid = '%s' where courseid = '%s' ",
			addslashes($list['keyword']),
			addslashes($list['edu_typeid']),
			addslashes($list['edu_detailtypeid']),
			addslashes($list['edu_typesubid']),
			addslashes($list['edu_typesubid']),
			addslashes($list['edu_studydetailid']),
			addslashes($list['env_funid']),
			addslashes($list['env_typeid']),
			addslashes($list['cid'])
		);
		$query = $this->db->query($sql);


		return true;
	}
}
