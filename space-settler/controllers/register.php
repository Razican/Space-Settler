<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends SPS_Controller {

	public function index($referrer = NULL)
	{
		if (is_null($referrer) && $this->uri->segment(2))
			redirect('register');

		if ( ! $this->session->userdata('logged_in'))
		{
			$this->lang->load('login');

			if ($this->input->server('REQUEST_METHOD') === 'POST')
			{
				if (( ! $this->input->post('username')) OR ( ! $this->input->post('email')))
				{
					message(lang('login.reg_incomplete'), 'register'. ($referrer ? '/referrer/'.$referrer : ''));
				}
				elseif ($this->user->register($this->input->post('username'),
						$this->input->post('email'),
						$referrer))
				{
					message(lang('login.reg_correct'));
				}
				else
				{
					message($this->user->register_errors, 'register'. ($referrer ? '/referrer/'.$referrer : ''));
				}
			}
			else
			{
				$data['license']	= $this->load->view('license', '', TRUE);
				$data['menu']		= $this->load->view('public/menu', '', TRUE);
				$data['referrer']	= $referrer;
				$this->load->view('public/register', $data);
			}
		}
		else
		{
			redirect('/');
		}
	}

	public function referrer($referrer)
	{
		$this->index($referrer);
	}

	public function validate($code)
	{
		if (strlen($code) != 15)
			redirect('/');

		if($this->uri->segment(3))
			redirect('validate/'.$code);

		$this->lang->load('login');
		$this->load->library('user');

		if ($this->user->validate($code))
		{
			message(lang('login.val_complete'));
		}
		else
		{
			message(lang('login.val_no_complete'));
		}
	}
}


/* End of file register.php */
/* Location: ./application/controllers/register.php */