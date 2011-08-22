<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	public function index($referrer = NULL)
	{
		$this->output->enable_profiler($this->config->item('debug'));

		if($this->uri->segment(2))
		{
			redirect('/');
		}

		if( ! $this->session->userdata('logged_in'))
		{
			echo "Registro";
			//ShowRegistrationPage
		}
		else
		{
			redirect('/');
		}
	}
}


/* End of file register.php */
/* Location: ./application/controllers/register.php */
