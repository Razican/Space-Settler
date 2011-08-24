<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reset_password extends CI_Controller {

	public function index()
	{
		$this->output->enable_profiler($this->config->item('debug'));

		if($this->uri->segment(2))
		{
			redirect('reset_password');
		}

		if( ! $this->session->userdata('logged_in'))
		{
			define('LOGIN', TRUE);
			$this->lang->load('login');

			if ($this->input->server('REQUEST_METHOD') === 'POST')
			{
				$this->load->helper('email');

				if(valid_email($this->input->post('email')))
				{

				}
				else
				{
					message(lang('login.mail_not_valid'), 'reset_password');
				}

				//echo "POST";
				/*$this->db->where('');
				$query	= $this->db->get('users');*/
			}
			else
			{
				$data['version']	= $this->config->item('version');
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
