<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends SPS_Controller {

	public function index()
	{
		$this->output->enable_profiler($this->config->item('debug'));

		if($this->uri->segment(1)) redirect('/', 'location', 301);

		if( ! $this->session->userdata('logged_in'))
		{
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
				$data['copyright']	= $this->load->view('public/copyright', '', TRUE);
				$data['menu']		= $this->load->view('public/menu', '', TRUE);
				$this->load->view('public/login', $data);
			}
		}
		else
		{
			define('INGAME', TRUE);
			$this->lang->load('menu');
			$this->lang->load('overview');

			$data['menu']		= $this->load->view('ingame/menu', '', TRUE);
			$data['planets']	= $this->user->count_planets();
			$data['moons']		= $this->user->count_moons();

			$this->load->view('ingame/overview', $data);
		}
	}
}


/* End of file main.php */
/* Location: ./application/controllers/main.php */