<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Volunteer_apply extends CI_Controller
{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->database('phy');
        $this->load->model('Calendar_model');

        // 這邊之後請改抓SESSION
        session_start();
        $_SESSION['userID'] = isset($_SESSION['userID']) ? $_SESSION['userID'] : 1;

        // demo
        // $_SESSION['userID'] = 14 ;
        // $_SESSION['role_id'] = 20 ;

        $userID = $_SESSION['userID'];
        if( strcmp(ENVIRONMENT, 'production') != 0 )
        {
            $userID = $this->config->item('eda_apply_testrun_id'); // e.g. 18, 107
        }
        $user = $this->db->where('id', $userID)
            ->get('users')
            ->row();
        $this->user = $user;
    }

    public function change_user($userID)
    {
        $user = $this->db->where('id', $userID)
            ->get('users')
            ->row();
        if ($user) {
            echo '您正在使用帳號：' . $user->name . '進行測試';
            $_SESSION['userID'] = $userID;
            // seeData($_SESSION);
            echo '<script>setTimeout(function(){ location.href="' . base_url('volunteer_apply') . '" }, 2000);</script>';
        }
    }

    public function index($date = null)
    {
        //     $date = time()-86400*date('w')+(date('w')>0?86400:-6*86400); 
        $this->publish($date);
        // $this->_show_list($date);
        // } else {
        //     $this->_show_list($date);
        // }
    }

    public function only_me($date = null)
    {

        //     $date = time()-86400*date('w')+(date('w')>0?86400:-6*86400); 
        $this->publish($date, 1);
        // } else {
        //     $this->_show_list($date,1);
        // }
    }

    public function publish($default_month_date = null, $onlyme = null)
    {
        $default_month_date = time() - 86400 * date('w') + (date('w') > 0 ? 86400 : -6 * 86400);
        $tmp_v_list = $this->db->get('volunteer_category')->result();
        $v_list = array();
        $v_list['all'] = 1;
        foreach ($tmp_v_list as $each) {
            $v_list[] = 'vID[' . $each->id . ']=1';
        }
        $vID_str = implode('&', $v_list);

        if ($onlyme) {
            $vID_str .= '&onlyme=1';
        }

        redirect(base_url('volunteer_apply/publish_detail/' . $default_month_date . '?default=1&' . $vID_str));
    }

    public function publish_detail($default_month_date = null)
    {
        $data['export_date'] = $default_month_date;
        // 用POST查詢的話，就算完後導轉
        if ($this->input->post()) {
            $default_month_date = ($this->input->post('year') + 1911) . '-' . $this->input->post('month_start') . '-01';
            $default_month_date = strtotime($default_month_date);

            $vID_str = $this->input->post('vID') ? $this->input->post('vID') : array();
            $tmp_str = array();

            foreach ($vID_str as $key => $value) {
                $tmp_str[] = 'vID[' . $key . ']=' . $value;
            }


            $vID_str = implode('&', $tmp_str);

            if ($this->input->post('not_show')) {
                $vID_str .= '&no_outside=1';
            }

            if ($this->input->post('onlyme')) {
                $vID_str .= '&onlyme=1';
            }

            // if($this->input->post('export')){
            //     $vID_str .= '&export=1';
            // }
            redirect(base_url('volunteer_apply/publish_detail/' . $default_month_date . '?' . $vID_str));
        }
        // 用GET接參數
        $vID_str = $this->input->get('vID') ? $this->input->get('vID') : array();
        $not_show = $this->input->get('no_outside') ? $this->input->get('no_outside') : 0;
        $default = $this->input->get('default');
        $export = $this->input->get('export');
        $tmp_str = array();

        foreach ($vID_str as $key => $value) {
            $tmp_str[] = 'vID[' . $key . ']=' . $value;
        }

        $vID_str = implode('&', $tmp_str);
        $vID_str .= '&no_outside=' . $not_show;
        $vID_arr = $this->input->get('vID') ? $this->input->get('vID') : array();

        $tmp_v_list = $this->db->where('show', 1)->get('volunteer_category')->result();  //20210827 Roger 加入show = 1，不列出會計與人事
        $v_list = array();
        $all_checked = true;
        foreach ($tmp_v_list as $each) {
            $v_list[$each->id]['name'] = $each->name;
            $v_list[$each->id]['checked'] = isset($vID_arr[$each->id]);
            $all_checked = $all_checked && $v_list[$each->id]['checked'];
        }


        if ($this->input->get('onlyme')) {
            $ONLY_ME = 1;
        } else {
            $ONLY_ME = 0;
        }

        // $default_month_date = null;

        if ($default) {
            $default_month_date = isset($default_month_date) ? date('Y-m-d', $default_month_date) : date('Y-m-d', strtotime(date('Y-m-01') . '+1 month'));
            $week_list = $this->Calendar_model->get_week_list_new($default_month_date);
        } else {
            $start_date = $default_month_date;
            $end_date = strtotime(date('Y-m-d', $default_month_date) . '+1 month -1 day');

            $week_list = array();
            $now_date = $start_date;
            while ($now_date <= $end_date) {
                $w = date('w', $now_date);

                // if($w != '0' && $w != '6'){
                $week_list[] = date('Y-m-d', $now_date);
                // }

                $now_date += 60 * 60 * 24;
            }
        }

        // Remove weekend
        $week_list_count = count($week_list);
        for ($i = 0; $i < $week_list_count; $i++) {
            $weekday = date('w', strtotime($week_list[$i]));
            if ($weekday == '0' || $weekday == '6') {
                $exist = $this->Calendar_model->checkExist($week_list[$i]);

                if (!$exist) {
                    unset($week_list[$i]);
                }
            }
        }

        $vc_list = $this->Calendar_model->get_vc_list();

        $start = current($week_list);
        $end = end($week_list);
        $calendar_list = $this->Calendar_model->get_calendar_list($start, $end, $this->user->long_range, $not_show);
        $apply_data = $this->Calendar_model->get_all_apply_data($start, $end);

        reset($week_list);
        // seeData($apply_data,1);
        // seeData($calendar_list);

        $note = $this->db->where('id', 1)->get('system_value')->row();
        $note = $note ? $note->value : '';

        $use_classroom = array();
        $outside = array();
        foreach ($calendar_list as $key => $value) {
            foreach ($value as $key2 => $value2) {
                foreach ($value2 as $key3 => $value3) {
                    if (!in_array($value3->classroomID, $use_classroom)) {
                        array_push($use_classroom, $value3->classroomID);
                    }
                    if ($value3->belongto == '68001') {
                        $outside_key = $value3->date . '-' . $value3->courseID;
                        array_push($outside, $outside_key);
                    }
                }
            }
        }

        foreach ($vc_list[1] as $key => $value) {
            if (!in_array($key, $use_classroom)) {
                //unset($vc_list[1][$key]);
            }
        }

        $data['outside'] = $outside;
        $data['userID'] = $this->user->id;
        $data['note'] = $note;
        $data['vID_str'] = $vID_str;
        $data['vID_arr'] = $vID_arr;
        $data['week_list'] = $week_list;
        $data['vc_list'] = $vc_list;
        $data['v_list'] = $v_list;
        $data['all_checked'] = $all_checked;
        $data['calendar_list'] = $calendar_list;
        $data['calendar_list_check'] = $calendar_list;
        $data['apply_data'] = $apply_data;
        $data['ONLY_ME'] = $ONLY_ME;
        $data['not_show'] = $not_show;
        $data['default'] = $default;


        // Announcement, 讀取公告內容
        // 課程變動內容
        $sql = "SELECT * FROM `user_msg` WHERE `user_id` = " . $_SESSION['userID'] . " AND `exptime` >= '" . date('Y-m-d H:i:s') . "' ";
        $msgList = $this->db->query($sql)->result();
        if (is_array($msgList)) {
            $data['msgList'] = $msgList;
        } else {
            $data['msgList'] = array();
        }


        if ($export) {

            $data['userID'] = $this->user->id;
            $this->load->view('volunteer_apply/publish_detail_export', $data);
            // exit;
        } else {
            $this->load->view('volunteer_manage/header', array('active' => 'volunteer_apply'));
            $this->load->view('volunteer_apply/volunteer_apply_index_new', $data);
        }

        $this->load->view('volunteer_manage/footer');
    }

    private function _show_list($default_month_date, $ONLY_ME = false)
    {
        $default_month_date = isset($default_month_date) ? date('Y-m-d', $default_month_date) : date('Y-m-d', strtotime(date('Y-m-01') . '+1 month'));
        $week_list = $this->Calendar_model->get_week_list($default_month_date);
        // seeData($week_list,1);

        $vc_list = $this->Calendar_model->get_vc_list();


        $start = current($week_list);
        $end = end($week_list);
        $calendar_list = $this->Calendar_model->get_calendar_list($start, $end, $this->user->long_range);
        $apply_data = $this->Calendar_model->get_all_apply_data($start, $end);

        reset($week_list);
        // seeData($apply_data,1);
        // seeData($calendar_list);

        $note = $this->db->where('id', 1)->get('system_value')->row();
        $note = $note ? $note->value : '';
        $data['note'] = $note;



        $data['userID'] = $this->user->id;
        $data['week_list'] = $week_list;
        $data['vc_list'] = $vc_list;
        $data['calendar_list'] = $calendar_list;
        $data['apply_data'] = $apply_data;
        $data['ONLY_ME'] = $ONLY_ME;

        $this->load->view('volunteer_manage/header', array('active' => 'volunteer_apply'));

        // } else {
        $this->load->view('volunteer_apply/volunteer_apply_index', $data);
        // }

        $this->load->view('volunteer_manage/footer');
    }

    public function range($start_date, $end_date)
    {
        // $default_month_date = isset($default_month_date)?date('Y-m-d',$default_month_date):date('Y-m-d',strtotime(date('Y-m-01').'+1 month'));
        // $week_list = $this->Calendar_model->get_week_list($default_month_date);
        $week_list = array();
        $now_date = $start_date;
        while ($now_date <= $end_date) {
            $week_list[] = date('Y-m-d', $now_date);
            $now_date += 60 * 60 * 24;
        }
        if (!$week_list) {
            echo '
                <script>
                    alert("錯誤的日期區間");
                    location.href="' . base_url('volunteer_apply') . '";
                </script>
            ';
            die();
        }


        $vc_list = $this->Calendar_model->get_vc_list();


        $start = current($week_list);
        $end = end($week_list);
        $calendar_list = $this->Calendar_model->get_calendar_list($start, $end, $this->user->long_range);
        $apply_data = $this->Calendar_model->get_all_apply_data($start, $end);

        reset($week_list);


        $note = $this->db->where('id', 1)->get('system_value')->row();
        $note = $note ? $note->value : '';
        $data['note'] = $note;


        $data['userID'] = $this->user->id;
        $data['week_list'] = $week_list;
        $data['vc_list'] = $vc_list;
        $data['calendar_list'] = $calendar_list;
        $data['apply_data'] = $apply_data;
        $data['ONLY_ME'] = false;

        $data['start_date'] = ROCdate('Y-m-d', $start_date);
        $data['end_date'] = ROCdate('Y-m-d', $end_date);

        $this->load->view('volunteer_manage/header', array('active' => 'volunteer_apply'));
        $this->load->view('volunteer_apply/volunteer_apply_index_range', $data);
        $this->load->view('volunteer_manage/footer');
    }


    public function download($ONLY_ME = false, $date = null)
    {
        $date = $date ? $date : date('Y-m-01');
        $date = date('Y-m-d', strtotime($date . '+1 month'));



        $month_list = $this->Calendar_model->get_month_list($date);

        $vc_list = $this->Calendar_model->get_vc_list();

        $start = current($month_list);
        $end = end($month_list);

        $calendar_list = $this->Calendar_model->get_calendar_list($start, $end, $this->user->long_range);
        $apply_data = $this->Calendar_model->get_all_apply_data($start, $end);

        reset($month_list);


        $data['userID'] = $this->user->id;
        $data['month_list'] = $month_list;
        $data['vc_list'] = $vc_list;
        $data['calendar_list'] = $calendar_list;
        $data['apply_data'] = $apply_data;
        $data['ONLY_ME'] = $ONLY_ME;


        $this->load->view('volunteer_apply/download', $data);
    }






    // 這個是用來塞測試資料的，沒事幹不要執行  上線後建議拔掉
    private function test()
    {
        $start_date = '2019-01-01';
        $end_date = '2019-01-31';
        for ($date = strtotime($start_date); $date <= strtotime($end_date); $date += (60 * 60 * 24)) {
            for ($vcID = 1; $vcID <= 11; $vcID++) {
                // 亂數決定要不要新增 (25%機率新增)
                if (rand(1, 100) % 4 == 0)
                    continue;

                // 亂數決定是不是長期班 (16%機率長期班)
                if (rand(1, 100) % 6 == 0)
                    $long_range = 1;
                else
                    $long_range = 0;

                $date_str = date('Y-m-d', $date);
                $course = array(
                    'name' => ($long_range ? '長期班' : '一般班') . '_' . $date_str . '_' . $vcID,
                    'long_range' => $long_range,
                );
                $this->db->insert('course', $course);

                $courseID = $this->db->insert_id();

                $insert[1] = array(
                    'vcID' => $vcID,
                    'date' => $date_str,
                    'type' => 1,
                    'start_time' => '08:30',
                    'end_time' => '12:30',
                    'hours' => $hours = rand(1, 5),
                    'num_got_it' => $hours,
                    'num_waiting' => 2 * $hours,
                    'courseID' => $courseID,
                );

                $insert[2] = array(
                    'vcID' => $vcID,
                    'date' => $date_str,
                    'type' => 2,
                    'start_time' => '13:30',
                    'end_time' => '17:30',
                    'hours' => $hours = rand(1, 5),
                    'num_got_it' => $hours,
                    'num_waiting' => 2 * $hours,
                    'courseID' => $courseID,
                );

                $insert[3] = array(
                    'vcID' => $vcID,
                    'date' => $date_str,
                    'type' => 3,
                    'start_time' => '18:00',
                    'end_time' => '20:30',
                    'hours' => $hours = rand(1, 5),
                    'num_got_it' => $hours,
                    'num_waiting' => 2 * $hours,
                    'courseID' => $courseID,
                );

                $true_insert = array();
                foreach ($insert as $key => $value) {
                    if (rand(0, 1))
                        $true_insert[] = $value;
                }

                if (empty($true_insert))
                    $true_insert[] = $insert[rand(1, 3)];

                foreach ($true_insert as $each) {
                    $this->db->insert('volunteer_calendar', $each);
                }
            }
        }
    }

    public function apply()
    {
        if (isAjax() || isPost()) {
            $userID = $this->user->id;
            $calendarID = $this->input->post('calendarID');

            json_response($this->Calendar_model->apply($userID, $calendarID));
        } else {
            die('error');
        }
    }

    public function apply_new()
    {
        if (isAjax() || isPost()) {
            $userID     = $this->user->id;
            $calendarID = $this->input->post('calendarID');
            $url        = $this->input->post('url');

            $calendarIDList = explode(',', $calendarID);
            $info = array();
            $info['msg'] = '';
            $calendarIDCount = count($calendarIDList);

            for ($i = 0; $i < $calendarIDCount; $i++) {
                $result = $this->Calendar_model->apply($userID, $calendarIDList[$i]);

                if ($calendarIDCount == 2) {
                    if ($i == 0) {
                        $info['msg'] .= '上午班：' . $result['msg'] . ' | ';
                        $info['url'] = $url . '/#t' . $calendarIDList[$i];
                    } else if ($i == 1) {
                        $info['msg'] .= '下午班：' . $result['msg'];
                    }
                } else {
                    $info['msg'] = $result['msg'];
                    $info['url'] = $url . '/#t' . $calendarIDList[$i];
                }
            }

            json_response($info);
        } else {
            die('error');
        }
    }

    public function cancel()
    {
        if (isAjax() || isPost()) {
            $userID = $this->user->id;
            $applyID = $this->input->post('applyID');

            json_response($this->Calendar_model->cancel($userID, $applyID));
        } else {
            die('error');
        }
    }






    public function sign_off()
    {
        $data = array();

        if (date('m') >= 1 && date('m') <= 3) {
            $season = date('Y') . '-1';
        } else if (date('m') >= 4 && date('m') <= 6) {
            $season = date('Y') . '-2';
        } else if (date('m') >= 7 && date('m') <= 9) {
            $season = date('Y') . '-3';
        } else if (date('m') >= 10 && date('m') <= 12) {
            $season = date('Y') . '-4';
        }

        $userID = $_SESSION['userID'];
        $tmp    = $this->db->where('user_id', $userID)
            ->where('season', $season)
            ->get('sign_off_area')
            ->row();
        if ($tmp) {
            // 看過了
            $data['show_msg'] = 'n';
        } else {
            // 沒看過要顯示
            $data['show_msg'] = 'y';
        }


        $signature = $this->db->where('user_id', $userID)
            ->get('user_signature')
            ->row();
        if ($signature) {
            // 有 signature
            $data['show_signature'] = 'y';
            $data['signature']      = $signature->signature;
        } else {
            // 沒 signature
            $data['show_signature'] = 'n';
            $data['signature']      = '';
        }

        $this->load->view('volunteer_manage/header', array('active' => 'sign_off'));
        $this->load->view('volunteer_apply/sign_off', $data);
        $this->load->view('volunteer_manage/footer');
    }



    public function save_sign_off()
    {

        if (date('m') >= 1 && date('m') <= 3) {
            $season = date('Y') . '-1';
        } else if (date('m') >= 4 && date('m') <= 6) {
            $season = date('Y') . '-2';
        } else if (date('m') >= 7 && date('m') <= 9) {
            $season = date('Y') . '-3';
        } else if (date('m') >= 10 && date('m') <= 12) {
            $season = date('Y') . '-4';
        }

        $userID = $_SESSION['userID'];
        $data = array(
            'season' => $season,
            'user_id' => $userID
        );
        $this->db->insert('sign_off_area', $data);

        // 回報
        echo json_encode(array('code' => '100'));
    }



    public function save_signature()
    {
        // signature
        $signature  = $this->input->post('signature');
        $userID     = $_SESSION['userID'];


        // 先刪除
        $this->db->where('user_id', $userID);
        $this->db->delete('user_signature');

        // 新增
        $data = array(
            'signature' => $signature,
            'user_id'   => $userID
        );
        $this->db->insert('user_signature', $data);

        // 回報
        echo json_encode(array('code' => '100'));
    }
}
