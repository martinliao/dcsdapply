<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->database('phy');

        $this->load->model('volunteer_select_model');
        $this->load->model('volunteer_manage_model');

        session_start();
    }    
    
    
    public function checkout_to_user($mID='' , $user_id='')
    {
        // 確認身份 ?
        $tmp = $this->db->where('id',$user_id)->get('users') ;
        if ( $tmp ) {
            // 轉換
            $tmp = $tmp->first_row() ;
            // 存 session
            $_SESSION['userID']     = $user_id      ;
            $_SESSION['role_id']    = 20            ;
            $_SESSION['userName']   = $tmp->name    ;

            // 返回
            $_SESSION['back_mID']   = $mID      ;

        } else {
            // 錯誤
            // 不做任何事情
        }

        header("Location:https://elearning.taipei/eda/apply/volunteer_apply") ;
        exit() ;
    }



    public function back_to_close()
    {
        // 返回
        $_SESSION['userID']     = $_SESSION['back_mID'] ;
        $_SESSION['role_id']    = 19                    ;

        // 刪除
        unset($_SESSION['userName'] ) ;
        unset($_SESSION['back_mID'] ) ;

        // 套轉
        header("Location:https://elearning.taipei/eda/manage/volunteer_manage/scheduling_setup") ;
        exit() ;
    }




}
