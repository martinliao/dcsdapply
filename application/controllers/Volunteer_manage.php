<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Volunteer_manage extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->model('volunteer_manage_model');
    }    
    
    public function index() { 
        $this->load->view('volunteer_manage/header');
        $this->load->view('volunteer_manage/index');
        $this->load->view('volunteer_manage/footer');
    }

    public function volunteer_category_manage(){

        $data['list'] = $this->volunteer_manage_model->get_volunteer_category_detail();

        $this->load->view('volunteer_manage/header');
        $this->load->view('volunteer_manage/volunteer_category_manage',$data);
        $this->load->view('volunteer_manage/footer');
    }

    public function volunteer_category_edit(){
        $id = $this->uri->segment(3);
        $data = array();

        if(!empty($_POST)){
            if($_POST['id'] > 0){
                $result = $this->volunteer_manage_model->upd_volunteer_category_detail($_POST);
            } else {
                $result = $this->volunteer_manage_model->add_volunteer_category_detail($_POST);
            }

            if($result){
                $url = '"'.base_url().'volunteer_manage/volunteer_category_manage'.'"';
                echo "<script>
                    alert('儲存成功');
                    location.href = $url;
                </script>";
            }
            
        }

        if($id > 0){
            $data['detail'] = $this->volunteer_manage_model->get_volunteer_category_detail(intval($id));
            if(empty($data['detail'])){
                redirect(base_url().'volunteer_manage/volunteer_category_manage');
            }
        }

        $data['id'] = $id;
        $this->load->view('volunteer_manage/header');
        $this->load->view('volunteer_manage/volunteer_category_edit',$data);
        $this->load->view('volunteer_manage/footer');
    }

    public function volunteer_category_del(){
        $id = $this->uri->segment(3);

        if($id > 0){
            $result = $this->volunteer_manage_model->del_volunteer_category_detail($id);

            if($result){
                $url = '"'.base_url().'volunteer_manage/volunteer_category_manage'.'"';
                echo "<script>
                    alert('刪除成功');
                    location.href = $url;
                </script>";
            }
        } else {
            $url = '"'.base_url().'volunteer_manage/volunteer_category_manage'.'"';
            echo "<script>
                alert('刪除成功');
                location.href = $url;
            </script>";
        }
    }
    
}
