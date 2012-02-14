<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	public function index()
	{
		log_message('error', 'User with IP '.$this->input->server('REMOTE_ADDR').' has tried to access Cron controller.');
		redirect('/');
	}

	public function inactives()
	{
	/*	if( ! $this->input->is_cli_request())
		{
			log_message('error', 'User with IP '.$this->input->server('REMOTE_ADDR').' has tried to access Cron controller.');
			redirect('/');
		}*/

		$this->load->library('user');
		$this->user->finish_hibernations();
		$this->user->delete_inactives();
		//$this->user->warn_inactives();
	}
}


/* End of file cron.php */
/* Location: ./application/controllers/cron.php */