<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		$this->output->enable_profiler($this->config->item('debug'));

		if($this->uri->segment(1))
			redirect('/');

		if( ! $this->session->userdata('logged_in'))
		{
			define('LOGIN', TRUE);
			$this->lang->load('login');

			if ($this->input->server('REQUEST_METHOD') === 'POST')
			{
				if($this->user->login($this->input->post('username'), $this->input->post('password'), $this->input->post('pass_conf'), $this->input->post('email')))
					redirect('/');
				else
					message(lang('login.error'));
			}
			else
			{
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
			$this->lang->load('ingame');

			$data['head']		= $this->load->view('head', '', TRUE);
			$data['footer']		= $this->load->view('footer', '', TRUE);
			$data['menu']		= $this->load->view('ingame/menu', '', TRUE);

			$this->load->view('ingame/overview', $data);
		}
	}
}


/* End of file main.php */
/* Location: ./application/controllers/main.php */
