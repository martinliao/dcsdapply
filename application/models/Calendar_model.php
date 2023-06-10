<?php

use core_availability\result;

class Calendar_model extends MY_Model{
  
  public function __construct()
  {
    parent::__construct();
    $this->load->database('phy');
  }

    /**
     * 取得指定日期的週曆
     *
     * @param      string  $date  指定日期
     *
     * @return     array   The week list.
     */
    public function get_week_list($date){
        $week_index = array(
            'Sunday' =>0,
            'Monday' =>1,
            'Tuesday' =>2,
            'Wednesday' =>3,
            'Thursday' =>4,
            'Friday' =>5,
            'Saturday' =>6,
        );
        $date_index = $week_index[date('l',strtotime($date))];       

        $less = $date_index;
        $plus = (6-$date_index);

        $week_list = array();
        for ($unix_time=strtotime($date.' -'.$less.' day'); $unix_time <= strtotime($date.' +'.$plus.' day'); $unix_time+=60*60*24)
        { 
            $week_list[] = date('Y-m-d',$unix_time);
        }

        return $week_list;
    }

    
    public function get_week_list_new($date){
        $week_index = array(
            'Sunday' =>0,
            'Monday' =>1,
            'Tuesday' =>2,
            'Wednesday' =>3,
            'Thursday' =>4,
            'Friday' =>5,
            'Saturday' =>6,
        );
        $date_index = $week_index[date('l',strtotime($date))];       

        $less = $date_index;
        $plus = (6-$date_index);

        $week_list = array();
        for ($unix_time=strtotime($date.' -'.$less.' day'); $unix_time <= strtotime($date.' +'.$plus.' day'); $unix_time+=60*60*24)
        { 
            $key = date('w',$unix_time);
            $week_list[$key] = date('Y-m-d',$unix_time);
        }

        return $week_list;
    }

    function checkExist($date){
        $this->db->select('count(1) cnt');
        $this->db->where('date',$date);
        $this->db->where('status',1);
        $query = $this->db->get('volunteer_calendar');
        $result = $query->result_array();

        if($result[0]['cnt'] > 0){
            return true;
        }

        return false;
    }

    public function get_month_list($date=null){        
        $date = $date?date('Y-m-01',strtotime($date)):date('Y-m-01');        
        $month_start = $date;
        $month_end = date('Y-m-d',strtotime($date.'+ 1 month - 1 day'));

        $month_list = array();

        for ($unix_time=strtotime($month_start); $unix_time <= strtotime($month_end); $unix_time+=60*60*24)
        { 
            $month_list[] = date('Y-m-d',$unix_time);
        }

        return $month_list;
    }

    public function get_month_list_test($date=null){        
        $date = $date?date('Y-m-01',strtotime($date)):date('Y-m-01');        
        $month_start = $date;
        $month_end = date('Y-m-d',strtotime($date.'+ 3 month - 1 day'));

        $month_list = array();

        for ($unix_time=strtotime($month_start); $unix_time <= strtotime($month_end); $unix_time+=60*60*24)
        { 
            $month_list[] = date('Y-m-d',$unix_time);
        }

        return $month_list;
    }

    
    /**
     * 取得志工與教室
     *
     * @return     <type>  The volunteer list.
     */
    public function get_vc_list(){
        $volunteer_list = array();

        $select = array(
            'vc.id vcID',
            'vc.volunteerID vID',
            'vc.classroomID cID',
            'v.name volunteerName',
            'v.others',
            '(CASE WHEN v.others>0 THEN v.morning_start ELSE NULL END ) morning_start',
            '(CASE WHEN v.others>0 THEN v.morning_end ELSE NULL END ) morning_end',
            '(CASE WHEN v.others>0 THEN v.afternoon_start ELSE NULL END ) afternoon_start',
            '(CASE WHEN v.others>0 THEN v.afternoon_end ELSE NULL END ) afternoon_end',
            '(NULL) night_start',
            '(NULL) night_end',
            'v.sign_month',
            'classroom.name classroomName',
        );
        $volunteer_list = $this->db->select(implode(',',$select))
                                   ->from('volunteer_category v')
                                   ->join('volunteer_classroom vc','v.id = vc.volunteerID')
                                   ->join('classroom classroom','classroom.id = vc.classroomID')
                                   ->order_by('(CASE WHEN v.sort > 0 THEN 1 ELSE 0 END) DESC,v.sort asc,v.others ASC ,v.id,classroom.sort,classroom.name')
                                   ->get()
                                   ->result();
        $volunteer_list = $volunteer_list?$volunteer_list:array();

        $return= array();
        foreach($volunteer_list as $key => $each)
        {
            $return[$each->vID][$each->cID] = $each;            
        }

        return $return;
    }

    public function get_calendar_list($start,$end,$long_range,$not_show=0){
        $calendar_list = array();
        $long_range = $long_range?$long_range:null;

        $select = array(
            'calendar.id',
            'calendar.vcID',
            'vc.volunteerID',
            'vc.classroomID',
            'c.sname',
            'c.belongto',
            'calendar.date',
            'calendar.type',
            'calendar.start_time',
            'calendar.end_time',
            'calendar.status',
            'calendar.hours',
            'calendar.num_got_it',
            'calendar.num_waiting',
            'course.id courseID',
            'course.name courseName',
            '(CASE WHEN course.id IS NOT NULL THEN course.apply_start ELSE apply_setting.apply_start END) apply_start',
            '(CASE WHEN course.id IS NOT NULL THEN course.apply_end ELSE apply_setting.apply_end END) apply_end',
            'course.worker',
            'course.term',
            'course.long_range'  // 2019 05 07 鵬 加上 要得到是否為長期課的資訊
        );
        $this->db->select(implode(',',$select))
               ->from('volunteer_category v')
         ->join('volunteer_classroom vc','v.id = vc.volunteerID')
         ->join('classroom c','c.id = vc.classroomID')
         ->join('volunteer_calendar calendar','calendar.vcID = vc.id')

         // 僅班務志工要撈班期資訊
         ->join('course course','course.id = calendar.courseID AND v.others = 0 AND course.need != 0','left')
         ->join('volunteer_apply_setting apply_setting','apply_setting.year = YEAR(calendar.date) AND apply_setting.month = MONTH(calendar.date) AND v.id = apply_setting.volunteerID','left')
         ->where('calendar.date >=',$start)
         ->where('(v.others = 1  OR ( v.others = 0 AND course.id IS NOT NULL))')
         ->where('calendar.date <=',$end)
         ->order_by('calendar.type,calendar.id');

        if($long_range)
        {
        // $this->db->where('course.long_range',1);
        }
        else
        $this->db->where('(course.long_range = 0 OR course.long_range IS NULL)');

        if($not_show == '1'){
            $this->db->where('c.belongto != 68001 or c.belongto is null',null);
        }
                                    
        $calendar_list = $this->db->get() ;
        if ( $calendar_list ) {
            $calendar_list = $calendar_list->result();
        } else {
            $calendar_list = array() ;
        }

        $calendar_list = $calendar_list?$calendar_list:array();

        $return= array();
        foreach($calendar_list as $key => $each)
        {
            $return[$each->vcID][$each->date][$each->type] = $each;

        }
       
        foreach($return as $key => $each){
            foreach($each as $key2 => $value){
                if(count($value) == 2){
                    $value[1]->first = $this->check_first($value[1]->volunteerID, $value[1]->date);
                }
            }
        }
        
        return $return;

    }

    public function check_first($category, $course_date){
        $now = date('Y-m-d H:i:s');
        $this->db->select('count(1) cnt');
        $this->db->where('first', 1);
        $this->db->where('category', $category);
        $this->db->where('startTime <=', $now);
        $this->db->where('endTime >=', $now);
        $this->db->where('reg_startTime <=', $course_date);
        $this->db->where('reg_endTime >=', $course_date);

        $query = $this->db->get('volunteer_stage');
        $result = $query->result_array();

        if($result[0]['cnt'] > 0){
            return '1';
        }

        return '0';
    }

    public function get_all_apply_data($start,$end,$userID=null){

        $select = array(
            'calendar_apply.id',
            'calendar_apply.userID',
            'calendar_apply.calendarID',
            'calendar.vcID',
            'vc.volunteerID vID',
            'vc.classroomID cID',
            'v.name vName',
            'v.others',
            'v.content',
            'c.name cName',
            'calendar.date',
            'calendar.type',
            'calendar_apply.start_time',
            'calendar_apply.end_time',
            'calendar_apply.hours',
            'calendar_apply.got_it',
            'users.name userName',
            // '(
            //   CASE
            //   WHEN v.id IN (\'3\',\'4\') AND calendar.person > 0
            //        THEN calendar.person
            //   WHEN v.id = 1
            //        THEN (SELECT person FROM course WHERE course.id = calendar.id)
            //   WHEN v.id IN (\'2\',\'5\')
            //        THEN ROUND( ((SELECT sum_person FROM v_course_person_per_date_type WHERE v_course_person_per_date_type.date = calendar.date AND v_course_person_per_date_type.type = calendar.type) / v.person_division_by),\'0\') 
            //   ELSE 0 END
            // ) person'
        );
        $order_by = array(
            'v.sort asc',
            'calendar.vcID asc',
            'calendar.date asc',
            'calendar.type asc',
            'calendar_apply.got_it desc',
            'calendar_apply.id asc',
        );
        $apply_data = $this->db->select(implode(',',$select))
                               ->from('volunteer_calendar_apply calendar_apply')
                               ->join('users','calendar_apply.userID = users.id')
                               ->join('volunteer_calendar calendar','calendar.id = calendar_apply.calendarID')
                               ->join('volunteer_classroom vc','calendar.vcID = vc.id')
                               ->join('volunteer_category v','vc.volunteerID = v.id')
                               ->join('classroom c','vc.classroomID = c.id')
                               ->where('calendar.date >=',$start)
                               ->where('calendar.date <=',$end) 
                               ->order_by(implode(',',$order_by));
        if(isset($userID))
          $this->db->where('volunteer_calendar_apply.userID',$userID);

        $apply_data = $this->db->get() ;
        if ( $apply_data ) {
            $apply_data = $apply_data->result();
        } else {
            $apply_data = array() ;
        }

        $return = array();
        foreach ($apply_data as $each_apply)
        {
            $each_apply->userName_enc = $each_apply->userName;
            if(mb_strlen($each_apply->userName_enc,'UTF-8') > 2)
            {
                // 除了前後兩字外都屏蔽
                $each_apply->userName_enc = mb_substr(($each_apply->userName),0,1,'UTF-8').str_pad('',mb_strlen($each_apply->userName_enc,'UTF-8')-2,'O').mb_substr(($each_apply->userName),-1,1,'UTF-8');
            }
            elseif (mb_strlen($each_apply->userName_enc,'UTF-8') == 2)
            {
                $each_apply->userName_enc = mb_substr(($each_apply->userName),0,1,'UTF-8').'O';
            }

            // $return[$each_apply->vcID][$each_apply->date][$each_apply->type][$each_apply->userID] = $each_apply;
            $return[$each_apply->calendarID][$each_apply->userID] = $each_apply;
        }

        return $return;
    }

    // 16762

    public function apply($userID,$calendarID)
    {
        /**
         * 2021.07.23 開發
         * 限制報名人數
         * -------------------------------------------------------------------------------------------------------------------------------------
         */
        
        // 預設不是長期班
        $check_long_range = false ;

        // 讀取原本的數值
        $calendar_data = $this->db->where('volunteer_calendar.id',$calendarID)
                                  ->where('status',1)
                                  ->get('volunteer_calendar')
                                  ->row();
        // 讀取 courseID
        if ( isset($calendar_data->courseID) && $calendar_data->courseID!="" ) {
            // 找到課程
            $course =  $this->db->where('course.id',$calendar_data->courseID)
                                    ->get('course')
                                    ->row();
            // 確認報明時間
            if ( isset($course->id) ) {
                // 確認
                if ( $course->apply_start=='' or $course->apply_end=='' ) {
                    // 沒有報名時間
                    return array('success'=>false,'msg'=>'報名失敗:此項目沒有設定可報名時間，無法報名！');
                }
            }

            if ( isset($course->long_range) && $course->long_range=='1' ) {
                // 是長期班
                $check_long_range = true ;
            }
        }

        // 取得 volunteerID
        $volunteerData = $this->db->where('id',$calendar_data->vcID)
                                  ->get('volunteer_classroom')
                                  ->row();
                                  
        // 找到 & 不能是長期班！
        if ( isset($volunteerData->volunteerID) && $check_long_range==false ) {
            // 找到分類的
            $volunteerID = $volunteerData->volunteerID ;

            /**
             * 報名上限制
             * 2021.07.08 修改
             */
            $sql = "SELECT * FROM `volunteer_stage` 
                        WHERE `startTime` <= '".date('Y-m-d H:i:s')."' 
                          AND `endTime` >= '".date('Y-m-d H:i:s')."'
                          AND category = '".addslashes($volunteerID)."'
                        ORDER BY sum ASC limit 1
                        " ;
            $tmp = $this->db->query($sql)->result_array() ;
            // 確認資料
            if ( is_array($tmp) && count($tmp) > 0 ) {
                // tmp
                $tmp = $tmp[0] ;
                
                // 確認課程日期是不是在 reg_startTime & reg_endTime 之間
                $ccTime = strtotime( $calendar_data->date." ".$calendar_data->start_time ) ;
                $ssTime = strtotime( $tmp['reg_startTime'] ) ;
                $eeTime = strtotime( $tmp['reg_endTime'] ) ;

                if ( $ssTime <= $ccTime && $ccTime <= $eeTime ) {
                    // 選定的課程在中間
                    // -------------------------------------------------------
                    // 切割參數
                    $sss = explode( ' ' , $tmp['reg_startTime'] ) ;
                    $eee = explode( ' ' , $tmp['reg_endTime'] ) ;
                    // 所以要                    
                    // 找尋這個區間內的數量

                    //20211130 Roger 只有在班務的時候排除長期班的次數
                    if ($volunteerID == 1){
                        $long_range_where = "and course.long_range != '1'";
                    }else{
                        $long_range_where = "";
                    }
                    
                    $sql = "SELECT 
                                count(volunteer_calendar_apply.id) as count  
                            FROM `volunteer_calendar_apply` as volunteer_calendar_apply
                            LEFT JOIN `volunteer_calendar` as volunteer_calendar  on volunteer_calendar.id = volunteer_calendar_apply.calendarID
                            LEFT JOIN `course` as course  on volunteer_calendar.courseID = course.id
                            LEFT JOIN `volunteer_classroom` as volunteer_classroom on volunteer_classroom.id = volunteer_calendar.vcID
                            where volunteer_calendar.date >= '".addslashes($sss[0])."' 
                            and volunteer_calendar.start_time >= '".addslashes($sss[1])."' 
                            and volunteer_calendar.date <= '".addslashes($eee[0])."' 
                            and volunteer_calendar.end_time <= '".addslashes($eee[1])."' 
                            and volunteer_calendar_apply.userID = '".addslashes($userID)."'
                            and volunteer_classroom.volunteerID = '".addslashes($volunteerID)."'
                            ".$long_range_where."
                            and volunteer_calendar_apply.got_it in ('0','1')  " ;
                    
                              // print_r($sql); 
                    $data = $this->db->query($sql)->result_array() ;

                    if ( is_array($data) ) {
                        // data
                        $data = $data[0] ;
                        // 看看報名是不是已經超過?
                        if ( is_numeric($tmp['sum']) && $data['count'] >= $tmp['sum'] ) {
                            // 已經報名滿了限制
                            return array('success'=>false,'msg'=>'報名失敗:您目前報名的課程已經超過上限：'.$tmp['sum'].'！');
                        }
                    }
                }

            }

        }
        // print_r($calendar_data); die() ;
        /**
         * -------------------------------------------------------------------------------------------------------------------------------------
         */
        
        $canGo = true ;

        if ( $calendar_data->type=='2' ) {
            $type = '1' ;
        } else {
            $type = '2' ;
        }
        // 「同班務」不能跨教室上下午報名
        // 1.相同日期
        // 2.上午 -> 下午 , 下午 -> 上午
        // 3.相同班務
        // 4.不同教室 
        // 看是否有資料
        $sql = "SELECT * 
                FROM `volunteer_calendar` vc
                WHERE `date` = '".addslashes($calendar_data->date)."' 
                    AND `type` = '".addslashes($type)."' 
                    AND `courseID` = '".addslashes($calendar_data->courseID)."' 
                    AND `vcID` != '".addslashes($calendar_data->vcID)."' 
                    AND EXISTS (
                            SELECT * 
                            FROM volunteer_calendar 
                            WHERE `date` = vc.`date` 
                                AND `type` = (
                                    CASE vc.`type` 
                                        WHEN 1  THEN 2 
                                        ELSE 1 
                                    END
                                ) 
                                AND courseID = vc.courseID 
                                AND vcID = vc.vcID 
                        )" ; 
        $tmpList = $this->db->query($sql)->result_array() ;

        // 找到對應資料,確認是不是已經有報名
        // 如果有 tmp 內的資料就不可以報名
        foreach( $tmpList as $tmp ) {
            // SQL
            $sql = "SELECT * FROM `volunteer_calendar_apply` 
                      WHERE `calendarID` = '".addslashes($tmp['id'])."' 
                        AND userID = '".addslashes($userID)."' " ;
            $ccc = $this->db->query($sql)->result_array() ;

            if ( count($ccc) > 0 ) {
                // 已經報名上午班或是下午班級了
                $canGo = false ;
            }
        }
        if ( $canGo==false ) {
            // 已經有報名
            // 1.相同日期
            // 2.上午 -> 下午 , 下午 -> 上午
            // 3.相同班務
            // 4.不同教室 
            return array('success'=>false,'msg'=>'報名失敗:「同班務」不能跨教室上下午報名！');
        }


        $now = new DateTime();
        $now = $now->format('Y-m-d');
        $calendar_data = $this->db->select("vc.*")
                                  ->from('volunteer_calendar vc')
                                  ->join('volunteer_classroom cs', 'cs.id = vc.vcID')
                                  ->join('volunteer_apply_setting setting', 'setting.volunteerID = cs.volunteerID', 'left')
                                  ->where('status',1)
                                  ->where('vc.id',$calendarID)
                                  ->where("(
                                            (
                                            DATE_FORMAT(vc.date, '%Y%m') = CONCAT(setting.`year`, LPAD(setting.`month`, '2', '0')) AND
                                            setting.apply_start <= '{$now}' AND 
                                            setting.apply_end >= '{$now}'
                                            ) OR 
                                            cs.volunteerID = 1
                                           )")
                                  ->get()
                                  ->row();
        

        if(!$calendar_data)
            return array('success'=>false,'msg'=>'報名失敗:錯誤的報名資訊，或該時段不允許報名');





        $vcID = $calendar_data->vcID;
        $date =  strtotime($calendar_data->date);
        $type = $calendar_data->type;

        
        $search_range_base = date('Y-m-01',$date);
        $search_range_start = date('Y-m-d',strtotime($search_range_base.'-1 day'));
        $search_range_end = date('Y-m-d',strtotime($search_range_base.'+1 month'));
        $date = date('Y-m-d',$date);
        

        $volunteer = $this->db->select('v.*,vc.volunteerID vID,vc.classroomID cID')
                              ->from('volunteer_classroom vc')
                              ->join('volunteer_category v','v.id = vc.volunteerID')
                              ->where('vc.id',$vcID)
                              ->get()
                              ->row();

        // 1.檢查當日當時段自己是不是已經報過了
        $already_applied = $this->db->from('volunteer_calendar_apply')
                                    ->where('userID',$userID)
                                    ->where('calendarID',$calendarID)
                                    ->get()
                                    ->num_rows();
        if($already_applied)
            return array('success'=>false,'msg'=>'報名失敗:您已經報名過此時段');


        // 2.同日的同時段，是否已經報過了
        $the_same_type_applied = $this->db->from('volunteer_calendar_apply')
                                          ->where('userID',$userID)
                                          ->where('calendarID IN (SELECT id FROM volunteer_calendar WHERE date = \''.$date.'\' AND type = \''.$type.'\')')
                                          ->get()
                                          ->num_rows();
        
        if($the_same_type_applied>0)
            return array('success'=>false,'msg'=>'報名失敗:您已在該日的相同時段中報名了其他志工職缺');


        // 3.檢核該月份的該類志工可報次數是否仍小於限制
        $sign_month_count = $this->db->from('volunteer_calendar_apply')
                                     ->join('volunteer_calendar','volunteer_calendar.id = volunteer_calendar_apply.calendarID')
                                     ->where('userID',$userID)
                                     ->where('volunteer_calendar.vcID IN (SELECT id FROM volunteer_classroom WHERE volunteerID = \''.$volunteer->id.'\')')
                                     ->where('date >',$search_range_start)
                                     ->where('date <',$search_range_end)
                                     ->get()
                                     ->num_rows();

        if($sign_month_count>=$volunteer->sign_month)
        {
            $return = array('success'=>false,'msg'=>'報名失敗:已超過報名次數限制');
            return $return;
        }

        // 正取/備取
        $got_it = false;

        $already_applied_num = $this->db->from('volunteer_calendar_apply')
                                   ->join('volunteer_calendar','volunteer_calendar.id = volunteer_calendar_apply.calendarID')
                                   ->where('calendarID',$calendar_data->id)
                                   ->where('volunteer_calendar.date >',$search_range_start)
                                   ->where('volunteer_calendar.date <',$search_range_end)
                                   ->get()
                                   ->result();

        if(count($already_applied_num) >= $calendar_data->num_got_it+$calendar_data->num_waiting)
            return array('success'=>false,'msg'=>'報名失敗:此志工職缺已滿');

        $already_got_it_num = 0;
        foreach ($already_applied_num as  $each)
        {
            if($each->got_it)
                $already_got_it_num++;
        }


        $got_it = $calendar_data->num_got_it>$already_got_it_num;

        
        $insert = array(
            'userID'=>$userID,
            'calendarID'=>$calendar_data->id,
            'start_time'=>$calendar_data->start_time,
            'end_time'=>$calendar_data->end_time,
            'hours'=>$calendar_data->hours,
            'got_it'=>$got_it,
        );

        $this->db->insert('volunteer_calendar_apply',$insert);

        return array('success'=>true,'msg'=>'報名完成');
    }

    public function cancel($userID,$applyID){
        $exist = $this->db->select('calendarid')
                          ->from('volunteer_calendar_apply')
                          ->where('id',$applyID)
                          ->where('userID',$userID)
                          ->get()
                          ->result();

        $return = array('success'=>false,'msg'=>'取消失敗');
        if(!empty($exist))
        {
            if($this->db->delete('volunteer_calendar_apply',array('id'=>$applyID,'userID'=>$userID))){
              $return = array('success'=>true,'msg'=>'取消成功');

              $vid = $exist[0]->calendarid;

              $this->db->select('num_got_it');
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
              
              if($data1[0]->num_got_it == $data2[0]->cnt){
                return $return;
              } else {
                $this->db->select('id');
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
                    $this->db->update('volunteer_calendar_apply'); 
                  }
                }
              }
            }
        }

        return $return;

    }

    public function getUserApplyVolunteerCategory($uid, $start_date, $end_date, $category, $year, $helf){
        $subquery = sprintf('select * from self_evaluation where uid="%s" and year="%s" and helf="%s" and category="%s"', intval($uid), intval($year), intval($helf), intval($category));

        $this->db->select('volunteer_category.id category_id,volunteer_category.name,t.*');
        $this->db->from('volunteer_calendar_apply');
        $this->db->join('volunteer_calendar', 'volunteer_calendar_apply.calendarID = volunteer_calendar.id');
        $this->db->join('volunteer_classroom', 'volunteer_calendar.vcID = volunteer_classroom.id');
        $this->db->join('volunteer_category', 'volunteer_classroom.volunteerID = volunteer_category.id');
        $this->db->join('users', 'volunteer_calendar_apply.userID = users.id');
        $this->db->join('sign_log', "DATE_FORMAT( sign_log.sign_time, '%Y-%m-%d' ) = volunteer_calendar.date and users.idNo = sign_log.idno");
        $this->db->join("($subquery) t", 'volunteer_calendar_apply.userID = t.uid and volunteer_category.id = t.category', 'left');
        $this->db->where('volunteer_calendar_apply.userID', intval($uid));
        $this->db->where('volunteer_category.id', intval($category));
        $this->db->where('volunteer_calendar.date >=', $start_date);
        $this->db->where('volunteer_calendar.date <=', $end_date);

        $this->db->group_by('volunteer_category.id');

        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    public function getCategoryName($id){
        $this->db->select('name');
        $this->db->where('id', intval($id));

        $query = $this->db->get('volunteer_category');
        $result = $query->result_array();

        if(!empty($result)){
            return $result[0]['name'];
        }

        return '';
    }

    public function getTotalHours($uid, $start_date, $end_date, $category){
        $sql = sprintf("select
                            sum(hours) total
                        from
                            (
                            select
                                CASE
                                                        volunteer_classroom.volunteerID 
                                                    WHEN '1' THEN
                                                        volunteer_calendar.hours
                                    ELSE
                                                        CASE
                                                            volunteer_calendar.type 
                                                        WHEN '1' THEN
                                                            (
                                                                round(TIME_TO_SEC(TIMEDIFF(volunteer_category.morning_end, volunteer_category.morning_start))/ 3600)
                                                            )
                                        WHEN '2' THEN
                                                            (
                                                                round(TIME_TO_SEC(TIMEDIFF(volunteer_category.afternoon_end, volunteer_category.afternoon_start))/ 3600)
                                                            )
                                    END
                                END hours
                            from
                                volunteer_calendar_apply
                            join volunteer_calendar on
                                volunteer_calendar_apply.calendarID = volunteer_calendar.id
                            join volunteer_classroom on
                                volunteer_calendar.vcID = volunteer_classroom.id
                            join volunteer_category on
                                volunteer_classroom.volunteerID = volunteer_category.id
                            join users on
                                volunteer_calendar_apply.userID = users.id
                            join sign_log on
                                DATE_FORMAT( sign_log.sign_time, '%%Y-%%m-%%d' ) = volunteer_calendar.date
                                and users.idNo = sign_log.idno
                            where
                                volunteer_calendar_apply.userID = '%s'
                                AND volunteer_calendar_apply.got_it = 1 
                                and volunteer_category.id = '%s'
                                and volunteer_calendar.date >= '%s'
                                and volunteer_calendar.date <= '%s'
                            GROUP BY
                                sign_log.idno,
                                volunteer_calendar.date,
                                volunteer_calendar.type ) a", intval($uid), intval($category), addslashes($start_date), addslashes($end_date));

        $query = $this->db->query($sql);
        $result =$query->result_array();

        if($result[0]['total'] > 0){
            return $result[0]['total'];
        }

        return 0;
    }

    public function check_self_evaluation($year, $helf, $category, $uid){
        $this->db->select('count(1) cnt');
        $this->db->where('status', '0');
        $this->db->where('year', $year);
        $this->db->where('helf', $helf);
        $this->db->where('category', $category);
        $this->db->where('uid', $uid);
        
        $query = $this->db->get('self_evaluation');
        $result = $query->result_array();

        if($result[0]['cnt'] > 0){
            return true;
        }
        
        return false;
    }

    public function insert_self_evaluation($mode, $year, $helf, $category, $top_grade, $bottom_grade, $uid, $selfcommment){
        $this->db->set('status', $mode);
        $this->db->set('year', $year);
        $this->db->set('helf', $helf);
        $this->db->set('category', $category);
        $this->db->set('top_grade', $top_grade);
        $this->db->set('bottom_grade', $bottom_grade);
        $this->db->set('uid', $uid);
        $this->db->set('create_time', date('Y-m-d H:i:s'));
        $this->db->set('modify_time', date('Y-m-d H:i:s'));
        $this->db->set('selfcomment', $selfcommment);

        if( $this->db->insert('self_evaluation')){
            return true;
        }

        return false;
    }

    public function update_self_evaluation($mode, $year, $helf, $category, $top_grade, $bottom_grade, $uid, $selfcommment){
        $this->db->set('status', $mode);
        $this->db->set('top_grade', $top_grade);
        $this->db->set('bottom_grade', $bottom_grade);
        $this->db->set('modify_time', date('Y-m-d H:i:s'));
        $this->db->set('selfcomment', $selfcommment);

        $this->db->where('uid', $uid);
        $this->db->where('year', $year);
        $this->db->where('helf', $helf);
        $this->db->where('category', $category);
       
        if( $this->db->update('self_evaluation')){
            return true;
        }

        return false;
    }

    public function getEvaluationSetup(){
        $sql = sprintf("SELECT
                            evaluation_setup.category,
                            evaluation_setup.year,
                            evaluation_setup.helf
                        FROM
                            evaluation_setup
                        JOIN (
                            SELECT
                                max(id) id
                            FROM
                                evaluation_setup
                            GROUP BY
                                year,
		                        helf,
                                category) md
                        on
                            evaluation_setup.id = md.id
                        where
                            '%s' BETWEEN evaluation_setup.start_time and evaluation_setup.end_time
                        order by
                            evaluation_setup.year,
                            evaluation_setup.helf,
                            evaluation_setup.category", date('Y-m-d H:i:s'));

        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function getSelfEvaluation($uid, $year, $helf, $category){
        $this->db->select('*');
        $this->db->from('self_evaluation');
        $this->db->where('uid', intval($uid));
        $this->db->where('year', intval($year));
        $this->db->where('helf', intval($helf));
        $this->db->where('category', intval($category));
        
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    public function getSelfOutside($userID, $queryDate)
    {
        $this->db->select('vca.userID, vca.start_time, vca.end_time, vca.hours, c.name, c.sname')
            ->from('volunteer_calendar_apply vca')
            ->join('volunteer_calendar vc', 'vc.id=vca.calendarID')
            ->join('volunteer_classroom vc2', 'vc.vcID = vc2.id')
            ->join('classroom c', 'vc2.classroomID = c.id')
            ->where('vc.date', $queryDate)
            ->where('c.belongto', '68001')
            ->where('vca.userID', $userID);
        $query = $this->db->get(); 
        if ($query) 
        {
            return $query->result_array();
        }
        return [];
    }
}
