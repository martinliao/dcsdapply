<?php

class Teaching_model extends MY_Model{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default');
    }
    
    function insert_teaching($list){
        for($i=0;$i<count($list['teaching_name']);$i++){
            if(!empty($list['teaching_id'][$i]) && !empty($list['teaching_name'][$i])){
                $sql = sprintf("INSERT INTO mdl_fet_teaching_manage(teaching_id,teaching_name) VALUES('%s','%s')",$list['teaching_id'][$i],$list['teaching_name'][$i]);
            }
            $this->db->query($sql);
        }
        
        return true;    
    }

    function delete_teaching($id){
        $sql = sprintf("DELETE FROM mdl_fet_teaching_manage WHERE id = '%s'",$id);
        $this->db->query($sql);
        return true;    
    }

    function update_teaching($list){
        $sql = sprintf("UPDATE mdl_fet_teaching_manage SET teaching_id ='%s', teaching_name ='%s', teacher ='%s',  teaching_status_now ='%s', contractor_remark ='%s', teaching_year ='%s', project_year ='%s', project_type ='%s', project_teaching_serial ='%s', file_size ='%s', teaching_timelength ='%s', certhour ='%s', questions ='%s', gradepass ='%s', owner ='%s', manufacturers ='%s', cooperation_unit ='%s', project_name ='%s', project_description ='%s', contractor ='%s', manufacturers_phone ='%s', cooperation_phone ='%s', video ='%s', course_intro ='%s',course_target ='%s', course_outline ='%s', other ='%s', quiz ='%s', tag ='%s', delivery_date ='%s', complete_date ='%s', final_update_date ='%s',    authorization_status ='%s', authorization_sign_date1 ='%s', authorization_sign_date2 ='%s', agree_exchange ='%s', exchange_course_status ='%s',   forbid_authorization_descript ='%s', speech_date ='%s', speech_address ='%s', authorization_deadline ='%s', artificial_check ='%s', deformity_course_count = '%s', category = '%s' WHERE id = '%s'",$list['teaching_id'], $list['teaching_name'], $list['teacher_name'], $list['teaching_status_now'], $list['contractor_remark'],$list['teaching_year'], $list['project_year'], $list['project_type'], $list['project_teaching_serial'], $list['file_size'], $list['teaching_time'], $list['certhour'], $list['questions'],$list['gradepass'], $list['owner'], $list['manufacturers'], $list['cooperation_unit'], $list['project_name'], $list['project_description'], $list['contractor'],$list['manufacturers_phone'], $list['cooperation_phone'], $list['video'], $list['course_intro'], $list['course_target'], $list['course_outline'], $list['course_other'], $list['quiz_yorn'],$list['tag'], $list['delivery_date'], $list['complete_date'], $list['final_update_date'], $list['authorization'], $list['authorization_sign_date1'], $list['authorization_sign_date2'], $list['agree_exchange'],$list['exchange_course_status'], $list['forbid_authorization_descript'], $list['speech_date'], $list['speech_address'], $list['authorization_deadline'], $list['artificial_check'], $list['deformity_course_count'], $list['category'],$list['id']);
        
        $this->db->query($sql);
        return true;
    }

    function get_teaching()
    {
        $this->db->select('id,teaching_id,teaching_name');
        $this->db->order_by('id');
        $query = $this->db->get('mdl_fet_teaching_manage');
        
        return $query->result();
    }

    function get_teaching_detail($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get('mdl_fet_teaching_manage');
        
        return $query->result();
    }

    function get_category(){
        $this->db->select('id,name,depth,path');
        $this->db->order_by('sortorder');
        $query = $this->db->get('mdl_course_categories');
        
        return $query->result();
    }

    function get_category_detail($id){
        $this->db->select('name');
        $this->db->where('id',$id);
        $query = $this->db->get('mdl_course_categories');
        
        return $query->result();
    }

    function get_first_type()
    {
        $this->db->select('name');
        $this->db->where('depth','1');
        $this->db->order_by('id');
        $query = $this->db->get('mdl_course_categories');

        return $query->result();
    }

    function get_second_type()
    {
        $this->db->select('name');
        $this->db->where('depth','2');
        $this->db->order_by('id');
        $query = $this->db->get('mdl_course_categories');

        return $query->result();
    }

    function get_third_type()
    {
        $this->db->select('name');
        $this->db->where('depth','3');
        $this->db->order_by('id');
        $query = $this->db->get('mdl_course_categories');

        return $query->result();
    }

    function get_teaching_counter_from_course($teaching_id){
        $sql = sprintf("select count(1) cnt from mdl_fet_course_manage where teaching_1 = '%s' or teaching_2 = '%s' or teaching_3 = '%s' or teaching_4 = '%s' or teaching_5 = '%s' or teaching_6 = '%s' or teaching_7 = '%s' or teaching_8 = '%s' or teaching_9 = '%s' or teaching_10 = '%s' or teaching_11 = '%s' or teaching_12 = '%s' or teaching_13 = '%s' or teaching_14 = '%s' or teaching_15 = '%s' or teaching_16 = '%s'",$teaching_id,$teaching_id,$teaching_id,$teaching_id,$teaching_id,$teaching_id,$teaching_id,$teaching_id,$teaching_id,$teaching_id,$teaching_id,$teaching_id,$teaching_id,$teaching_id,$teaching_id,$teaching_id);

        $query = $this->db->query($sql);
        return $query->result();

    } 

        
}   