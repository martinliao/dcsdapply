<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
if(empty($_SESSION['accountuuid'])){
    die('請勿非法登入');
} else {
    $db_ip = "172.25.154.75";
    $db_username = "nelearn";
    $db_password = "L@admin01!";
    $db_name2 = "moodle";

    $link2 = new mysqli($db_ip, $db_username, $db_password, $db_name2); //moodle
    if (!$link2) {
        die('connect error');
    }

    mysqli_set_charset($link2, "utf8");

    $sql = sprintf("select count(1) cnt from mdl_fet_pid a join mdl_role_assignments b on a.uid = b.userid where a.idno = '%s' and roleid in (1,11)",$_SESSION['userData']['Usrid']);

    $result = mysqli_query($link2, $sql);
    $row = $result->fetch_object();

    mysqli_close($link2);

    if($row->cnt == '0'){
        die('您無此權限');
    } else {
        $_SESSION['KCFINDER']['disabled'] = false;
    }
}

class Instant_message extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this ->load-> model('instant_message_model');
    }    
    
    public function index() { 
        $data = $this->instant_message_model->get_message($_POST);
        $data_list['message'] = $data;
        if(!empty($_POST['search'])){
            $data_list['search'] = $_POST['search'];
        } else {
            $data_list['search'] = '';
        }
    
        $info['mode'] = '1';        

        $this->load->view('im/header',$info);
        $this->load->view('im/Instant_message_history',$data_list);
        $this->load->view('im/footer');
    }
    
    public function send() {
        $edit = $this->input->post('act',TRUE);
        if($edit == 'send'){
            $this->instant_message_model->send_message($_POST);
            echo "<script>
                    alert('寄送完成');
                    location.href='http://elearning.taipei/eda/manage/Instant_message/send/';
                </script>";
        }

        $info['mode'] = '2';

        $this->load->view('im/header',$info);
        $this->load->view('im/Instant_message_send');
        $this->load->view('im/footer');
    }

    public function view() { 
        $id = $this->uri->segment(3);
        $idno = $this->uri->segment(4);

        $data = $this->instant_message_model->get_message_by_id($id,$idno);
        $prev = $this->instant_message_model->get_prev($id,$idno);
        $next = $this->instant_message_model->get_next($id,$idno);
        $first = $this->instant_message_model->get_first($id,$idno);
        $final = $this->instant_message_model->get_final($id,$idno);

        $data_list['message'] = $data;

        if(!empty($prev[0]->prev_id)){
            $data_list['prev'] = $prev[0]->prev_id;
        } else {
            $data_list['prev'] = '-1';
        } 
        
        if(!empty($next[0]->next_id)){
            $data_list['next'] = $next[0]->next_id;
        } else {
            $data_list['next'] = '-1';
        } 
       
        if(!empty($idno)){
            $data_list['search'] = $idno; 
        }

        $data_list['first'] = $first[0]->first_id;
        $data_list['final'] = $final[0]->final_id;

        $info['mode'] = '1'; 

        $this->load->view('im/header',$info);
        $this->load->view('im/send_view',$data_list);
        $this->load->view('im/footer');
    }
}
