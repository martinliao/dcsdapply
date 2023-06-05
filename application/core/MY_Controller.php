<?php 
class MY_Controller extends CI_Controller 
{
	public function __construct()
    {
        parent::__construct();
    }

    public function init_view($view,$data)
    {
    	$this->load->view('design/header');
        $this->load->view($view,$data);
        $this->load->view('design/footer');
    }
}