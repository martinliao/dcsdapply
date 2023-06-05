<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
if(empty($_SESSION['accountuuid'])){
    die('請勿非法登入');
}

class Instant_message_receive extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this ->load-> model('instant_message_receive_model');
    }    
    
    public function index() { 
        $data = $this->instant_message_receive_model->get_message($_SESSION['userData']['Usrid'],'0');
        $cnt = $this->instant_message_receive_model->get_count($_SESSION['userData']['Usrid']);
        $data_list['message'] = $data;
        $count['cnt'] = $cnt[0]->cnt;
        $data_list['title'] = '收件匣';

        $count['mode'] = '1';

        $this->load->view('im_receive/header',$count);
        $this->load->view('im_receive/Instant_message_history',$data_list);
        $this->load->view('im_receive/footer');
    }
    
    public function history() {
        $data = $this->instant_message_receive_model->get_message($_SESSION['userData']['Usrid'],'1');
        $cnt = $this->instant_message_receive_model->get_count($_SESSION['userData']['Usrid']);
        $data_list['message'] = $data;
        $data_list['history'] = '1';
        $count['cnt'] = $cnt[0]->cnt;
        $data_list['title'] = '歷史匣';

        $count['mode'] = '2';

        $this->load->view('im_receive/header',$count);
        $this->load->view('im_receive/Instant_message_history',$data_list);
        $this->load->view('im_receive/footer');
    }

    public function receive_view() { 
        $id = $this->uri->segment(3);

        $name = $this->instant_message_receive_model->get_name($_SESSION['userData']['Usrid']);
        $data = $this->instant_message_receive_model->get_message_by_id($id,$_SESSION['userData']['Usrid']);
        $prev = $this->instant_message_receive_model->get_prev($id,'0',$_SESSION['userData']['Usrid']);
        $next = $this->instant_message_receive_model->get_next($id,'0',$_SESSION['userData']['Usrid']);
        $first = $this->instant_message_receive_model->get_first($id,'0',$_SESSION['userData']['Usrid']);
        $final = $this->instant_message_receive_model->get_final($id,'0',$_SESSION['userData']['Usrid']);
        $this->instant_message_receive_model->update_status($id,$_SESSION['userData']['Usrid']);
        $cnt = $this->instant_message_receive_model->get_count($_SESSION['userData']['Usrid']);

        $data_list['message'] = $data;
        $data_list['name'] = $name;
        $count['cnt'] = $cnt[0]->cnt;

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

        $data_list['first'] = $first[0]->first_id;
        $data_list['final'] = $final[0]->final_id;

        $count['mode'] = '1';

        $this->load->view('im_receive/header',$count);
        $this->load->view('im_receive/receive_view',$data_list);
        $this->load->view('im_receive/footer');
    }

    public function history_view() { 
        $id = $this->uri->segment(3);

        $name = $this->instant_message_receive_model->get_name($_SESSION['userData']['Usrid']);
        $data = $this->instant_message_receive_model->get_message_by_id($id,$_SESSION['userData']['Usrid']);
        $prev = $this->instant_message_receive_model->get_prev($id,'1',$_SESSION['userData']['Usrid']);
        $next = $this->instant_message_receive_model->get_next($id,'1',$_SESSION['userData']['Usrid']);
        $first = $this->instant_message_receive_model->get_first($id,'1',$_SESSION['userData']['Usrid']);
        $final = $this->instant_message_receive_model->get_final($id,'1',$_SESSION['userData']['Usrid']);
        $cnt = $this->instant_message_receive_model->get_count($_SESSION['userData']['Usrid']);

        $data_list['message'] = $data;
        $data_list['name'] = $name;
        $count['cnt'] = $cnt[0]->cnt;

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
       

        $data_list['first'] = $first[0]->first_id;
        $data_list['final'] = $final[0]->final_id;

        $count['mode'] = '2';

        $this->load->view('im_receive/header',$count);
        $this->load->view('im_receive/history_view',$data_list);
        $this->load->view('im_receive/footer');
    }
}
