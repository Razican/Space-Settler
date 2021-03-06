<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends SPS_Controller {

	public function index()
	{
		if ($this->uri->segment(2))
			redirect('logout', 'location', 301);

		if ($this->session->userdata('logged_in'))
		{
			$this->user->logout();
		}
		else
		{
			log_message('error', 'User with IP '.$this->input->ip_address().' has tried to enter /logout without loggin in.');
		}

		redirect('/');
	}
}


/* End of file logout.php */
/* Location: ./space_settler/controllers/logout.php */