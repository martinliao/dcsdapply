<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_profile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('user_profile_model');
    }

    public function index()
    {
        $data['page_name'] = 'index';
        $data['link_save'] = base_url('user_profile/edit');
        $data['form'] = $this->user_profile_model->getUserById('18');
        $this->load->view('volunteer_manage/header', array('active' => 'user_profile'));
        $this->load->view('user_profile/user_profile', $data);
        $this->load->view('volunteer_manage/footer');
    }

    public function edit()
    {
        $data['page_name'] = 'edit';
        $data['link_save'] = base_url('user_profile/edit');
        $data['form'] = $this->user_profile_model->getUserById('18');
        if ($_post = $this->input->post()) {
            $this->user_profile_model->updateUser(array_merge($data['form'], $_post));
            redirect(base_url("user_profile"));
        }
        $this->load->view('volunteer_manage/header', array('active' => 'user_profile'));
        $this->load->view('user_profile/user_profile', $data);
        $this->load->view('volunteer_manage/footer');
    }

    public function importdatabase()
	{
		$this->load->library('migration');
		if ($this->migration->latest() === FALSE) {
			echo $this->migration->error_string();
		}
		//$this->session->set_flashdata('success_msg', 'Database migrated successfully!');
		return redirect('/');
	}
}
