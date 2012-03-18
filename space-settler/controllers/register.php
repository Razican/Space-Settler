<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends SPS_Controller {

	public function _remap($referrer)
	{
		$this->output->enable_profiler($this->config->item('debug'));

		$referrer	= $referrer === 'index' ? NULL : $referrer;
		$this->session->set_flashdata('referrer', $referrer);

		if($this->uri->segment(3))
			redirect('register/'.$referrer);

		if( ! $this->session->userdata('logged_in'))
		{
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
				$data['license']	= $this->load->view('license', '', TRUE);
				$data['menu']		= $this->load->view('public/menu', '', TRUE);
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