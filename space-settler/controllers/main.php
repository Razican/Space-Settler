<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		$this->output->enable_profiler($this->config->item('debug'));

		if($this->uri->segment(1))
		{
			redirect('/');
		}

		if( ! $this->session->userdata('logged_in'))
		{
			define('LOGIN', TRUE);

			if ($this->input->server('REQUEST_METHOD') === 'POST')
			{
				//Log In
			}
			else
			{
				$this->lang->load('login');

				$data['version']	= $this->config->item('version');
				$data['forum_url']	= $this->config->item('forum_url');
				$data['game_name']	= $this->config->item('game_name');
				$data['head']		= $this->load->view('head', '', TRUE);
				$data['footer']		= $this->load->view('footer', '', TRUE);

				$this->load->view('public/login', $data);
			}
		}
		else
		{
			echo "Overview";
			//ShowOverviewPage
		}
	}
}


/* End of file main.php */
/* Location: ./application/controllers/main.php */
