<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	public function _remap($referrer)
	{
		$this->output->enable_profiler($this->config->item('debug'));

		$referrer	= $referrer === 'index' ? NULL : $referrer;
		$this->session->set_flashdata('referrer', $referrer);

		if($this->uri->segment(3))
			redirect('register/'.$referrer);

		if( ! $this->session->userdata('logged_in'))
		{
			define('LOGIN', TRUE);
			$this->lang->load('login');

			if ($this->input->server('REQUEST_METHOD') === 'POST')
			{
				$referrer	= $this->session->flashdata('referrer');
				if(( ! $this->input->post('username')) OR ( ! $this->input->post('email')))
					message(lang('login.reg_incomplete'), 'register'. ($referrer ? '/'.$referrer : ''));
				elseif($this->user->register($this->input->post('username'), $this->input->post('email'), $referrer))
					message(lang('login.reg_correct'));
				else
					message($this->user->register_errors, 'register'. ($referrer ? '/'.$referrer : ''));
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
