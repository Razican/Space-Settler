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
			define('LOGIN', TRUE);
			$this->lang->load('login');

			if ($this->input->server('REQUEST_METHOD') === 'POST')
			{
				echo "No se que camarada";
			}
			else
			{
				$data['game_name']	= $this->config->item('game_name');
				$data['forum_url']	= $this->config->item('forum_url');
				$data['head']		= $this->load->view('head', '', TRUE);
				$data['footer']		= $this->load->view('footer', '', TRUE);

				$this->load->view('public/register', $data);
			}
		}
		else
		{
			redirect('/');
		}
	}
}


/* End of file register.php */
/* Location: ./application/controllers/register.php */
