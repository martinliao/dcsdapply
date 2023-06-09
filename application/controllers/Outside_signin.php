<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Outside_signin extends CI_Controller
{
    protected $testrunID;
    protected $testrunDate;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->database('phy');
        $this->load->model('Calendar_model');
        $this->load->model('Volunteer_select_model');
        // 這邊之後請改抓SESSION
        //session_start();
        //$_SESSION['userID'] = isset($_SESSION['userID']) ? $_SESSION['userID'] : 1;

        $this->userID = $_SESSION['userID'];
        if( strcmp(ENVIRONMENT, 'production') != 0 )
        {
            $this->userID = $this->config->item('eda_apply_testrun_id'); // e.g. 18, 107
            $this->testrunDate = $this->config->item('eda_apply_testrun_date'); // e.g. '2023-05-31'
        }
        $user = $this->db->where('id', $this->userID)
            ->get('users')
            ->row();
        $this->user = $user;
    }

    public function index()
    {
        $default_month_date = time() - 86400 * date('w') + (date('w') > 0 ? 86400 : -6 * 86400);
        $_form['name'] = $this->user->name;
        $_form['idNo'] = $this->user->idNo;
        $data['form'] = $_form;
        $_today =  ( strcmp(ENVIRONMENT, 'production') != 0 ) ? $this->testrunDate : date('Y-m-d', $default_month_date);
        $outsideEvent= $this->Calendar_model->getSelfOutside($this->user->id, $_today);
        if ($_post = $this->input->post()) {
            if ($_post['idNo'] == $this->user->idNo){
                $result = $this->Volunteer_select_model->add_card_log_new(
                    $this->user->idNo, 
                    date('H'), date('i'), date('s'),
                    $_today
                );
                if($result) {
                    $this->session->set_flashdata('success_msg', '刷到成功.');
                } else {
                    $this->session->set_flashdata('error_msg', '刷到失敗!');
                }
            } else {
                $this->session->set_flashdata('error_msg', '刷到失敗, 身份證號不符！');
            }
            //redirect(base_url('volunteer_apply'));
        }
        $data['hasOutside'] = sizeof($outsideEvent) > 0;
        $this->load->view('volunteer_manage/header', array('active' => 'volunteer_apply'));
        $this->load->view('outside_signin/outside_signin', $data);
        $this->load->view('volunteer_manage/footer');
    }
}
