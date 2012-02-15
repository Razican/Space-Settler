<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends SPS_Controller {

	public function index()
	{
		log_message('error', 'User with IP '.$this->input->server('REMOTE_ADDR').' has tried to access Cron controller.');
		redirect('/');
	}

	public function inactives()
	{
		if( ! $this->input->is_cli_request())
		{
			log_message('error', 'User with IP '.$this->input->server('REMOTE_ADDR').' has tried to access Cron controller.');
			redirect('/');
		}

		$this->load->library(array('user', 'email'));
		$this->lang->load('cron');

		if($this->user->finish_hibernations()) echo 'Hibernations Finished'.PHP_EOL;
		if($this->user->delete_inactives()) echo 'Inactives deleted'.PHP_EOL;
		if($this->user->warn_inactives()) echo 'Inactives warned'.PHP_EOL;
	}
}


/* End of file cron.php */
/* Location: ./application/controllers/cron.php */