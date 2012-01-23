<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reset_password extends CI_Controller {

	public function index()
	{
		$this->output->enable_profiler($this->config->item('debug'));

		if($this->uri->segment(2))
			redirect('reset_password');

		if( ! $this->session->userdata('logged_in'))
		{
			define('LOGIN', TRUE);
			$this->lang->load('login');

			if ($this->input->server('REQUEST_METHOD') === 'POST')
			{
				$this->load->helper('email');

				$email	= $this->input->post('email');
				if(valid_email($email))
				{
					if( ! $this->user->exists_email($email))
					{
						message(lang('login.email_not_exist'), 'reset_password');
					}
					else
					{
						$this->load->helper('string');
						$this->load->library('email');

						$password	= random_string('alnum', 8);

						$this->user->reset_password($email, $password);

						$this->email->from('space-settler@razican.com', 'Space Settler');
						$this->email->reply_to('noreply@razican.com', 'Space Settler');
						$this->email->to($email);
						$this->email->subject(lang('login.reset_email_title'));
						$this->email->message(lang('login.reset_email_text').$password);
						$this->email->send();

						message(lang('login.reset_email_sended'));
					}
				}
				else
				{
					message(lang('login.email_not_valid'), 'reset_password');
				}
			}
			else
			{
				$data['forum_url']	= $this->config->item('forum_url');
				$data['head']		= $this->load->view('head', '', TRUE);
				$data['footer']		= $this->load->view('footer', '', TRUE);

				$this->load->view('public/reset_password', $data);
			}
		}
		else
		{
			redirect('/');
		}
	}
}


/* End of file reset_password.php */
/* Location: ./application/controllers/reset_password.php */
