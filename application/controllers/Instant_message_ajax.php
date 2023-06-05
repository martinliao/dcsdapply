<?php

class Instant_message_ajax extends CI_Controller {

	function Instant_message_ajax() {
		parent::__construct();
	}


	function get_name()
	{
		$idno = $this->input->post('idno',TRUE);
		$this->load->model('Instant_message_model');
		$data = $this->Instant_message_model->get_name(strtoupper($idno));
		if(!empty($data))
		{	
			print($data);
		}
		else
		{
			echo "0";
		}

	}

	function index(){

		echo "Instant_message";
	}
}

/* End of file home.php */
/* Location: ./system/application/controllers/home.php */
