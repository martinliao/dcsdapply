<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service_history extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->database('phy');
        $this->load->model('Calendar_model');

        // 這邊之後請改抓SESSION
        session_start();
        $_SESSION['userID'] = isset($_SESSION['userID'])?$_SESSION['userID']:1;

        $userID = $_SESSION['userID'];
        $user = $this->db->where('id',$userID)
                         ->get('users')
                         ->row();
        $this->user = $user;

    }    
    
    public function index($default_month_date=null) { 
        $default_month_date = isset($default_month_date)?date('Y-m-d',$default_month_date):date('Y-m-d',strtotime(date('Y-m-01').'+1 month'));
        $week_list = $this->Calendar_model->get_week_list($default_month_date);

        $vc_list = $this->Calendar_model->get_vc_list();


        $start = current($week_list);
        $end = end($week_list);
        $calendar_list = $this->Calendar_model->get_calendar_list($start,$end,$this->user->long_range);
        $apply_data = $this->Calendar_model->get_all_apply_data($start,$end);

        reset($week_list);
        // seeData($apply_data,1);
        // seeData($calendar_list);
        $v_list = $this->db->get('volunteer_category')->result();
        $v_list = $v_list?$v_list:array();


        $data['userID'] = $this->user->id;
        $data['week_list'] = $week_list;
        $data['vc_list'] = $vc_list;
        $data['v_list'] = $v_list;

        $data['calendar_list'] = $calendar_list;
        $data['apply_data'] = $apply_data;
        
        $this->load->view('volunteer_manage/header',array('active'=>'service_history'));
        $this->load->view('service_history/service_history_index',$data);
        $this->load->view('volunteer_manage/footer');
    }


    public function search(){
        $table = $this->_build_table();
        if(!$table)
            die('此區間內無服務資料');

        echo $table;
    }

    public function download() {
        $table = $this->_build_table();
        if(!$table)
            die('此區間內無服務資料');
        
        $this->load->view('service_history/doc',array('table'=>$table));
    }

    private function _build_table(){
        $user = $this->user;
        $userID = $user->id;
        $userName = $user->name;
        $year = $this->input->post('year');

        $start = $year.'-'.$this->input->post('month_start').'-01';
        $end = date('Y-m-d',strtotime($year.'-'.$this->input->post('month_end').'-01 +1 month -1 day'));
        $apply_data = $this->Calendar_model->get_all_apply_data($start,$end,$userID);

        $v3 = $this->db->where('id',3)->get('volunteer_category')->row();
        // seeData($apply_data);
        // seeData($_POST);
        $vList = array_keys($_POST['vID']);
        if(empty($apply_data))
            return false;

        $all_sum_hours = 0;
        $sum_service_person = 0;
        $apply_data_group = array();
        foreach ($apply_data as $each)
        {
            $each = $each[$userID];
            // 如果不是正取就別看了
            if(!$each->got_it)
                continue;
            // 如果不是要查的志工
            if(!in_array($each->vID, $vList))
                continue;


            $m = (int)date('m',strtotime($each->date));

            if(!isset($apply_data_group[$m][$each->vID]))
            {
                $apply_data_group[$m][$each->vID] = new stdClass();
                $apply_data_group[$m][$each->vID]->vName = $each->vName;
                $apply_data_group[$m][$each->vID]->content = $each->content;
                $apply_data_group[$m][$each->vID]->userName = $each->userName;
                $apply_data_group[$m][$each->vID]->person = $each->person;
                $apply_data_group[$m][$each->vID]->sum_hours = 0;
            }

            $apply_data_group[$m][$each->vID]->sum_hours+=$each->hours;
            $apply_data_group[$m][$each->vID]->person+=$each->person;
            $sum_service_person+=$each->person;

            // seeData($each);

        }
        $table_data = '';
        $seal_path = $_SERVER['DOCUMENT_ROOT'].'/eda/seal.png';
        $type = pathinfo($seal_path, PATHINFO_EXTENSION);
        $data = file_get_contents($seal_path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        foreach ($apply_data_group as $month => $month_data)
        {
            foreach ($month_data as $vID => $each)
            {
                $all_sum_hours+=$each->sum_hours;
                $month_base = $year.'-'.$month.'-1';
                $month_str_start = date('Ymd',strtotime($month_base));
                $month_str_end = date('Ymd',strtotime($month_base.' +1 month -1 day'));

                $month_str = $month_str_start.'-'.$month_str_end;

                $table_data.='
                    <tr>
                        <td>綜合服務</td>
                        <td>'.$each->content.'</td>
                        <td>'.$month_str.'</td>
                        <td>'.$each->sum_hours.'小時0分鐘</td>
                        <td>臺北市政府公務人員訓練處_志工隊</td>
                        <td width="120px"><img id="AAAA'.$vID.'" src="'.$base64.'"></td>
                        <td>'.$each->vName.'志工</td>
                    </tr>
                ';
            }
        }

        $table = '<table border="1">';
        $table.= '
            <tr>
                <td>服務項目</td>
                <td>服務內容</td>
                <td>服務日期</td>
                <td>時數</td>
                <td>服務單位</td>
                <td>職章</td>
                <td>備註</td>
            </tr>
            <tr>
                <td colspan="7">
                    【'.$user->name.'】 '.$user->idNo.'<br>
                    總服務：'.$all_sum_hours.'小時0分鐘　總服務：'.$sum_service_person.'人次'.(in_array('3', $vList) && $v3?'　　(備註：'.$v3->special_note.')':null).'
                </td>
            </tr>
        ';
        $table.= $table_data;
        $table.= '</table>';

        return $table;
    }

    public function apply(){
        if(isAjax() || isPost())
        {
            $userID = $this->user->id;
            $calendarID = $this->input->post('calendarID');

            json_response($this->Calendar_model->apply($userID,$calendarID));
        }
        else
        {
            die('error');
        }
    }

    public function cancel(){
        if(isAjax() || isPost())
        {
            $userID = $this->user->id;
            $applyID = $this->input->post('applyID');

            json_response($this->Calendar_model->cancel($userID,$applyID));
        }
        else
        {
            die('error');
        }
    }    
}
