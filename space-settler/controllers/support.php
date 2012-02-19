<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends SPS_Controller {

	public function index()
	{
		if( ! $this->session->userdata('logged_in')) redirect('/');
		if($this->uri->segment(2)) redirect('support');

		$this->show($this->session->userdata('id'));
	}

	public function show($id = NULL)
	{
		if( ! $this->session->userdata('logged_in')) redirect('/');
		define('INGAME', TRUE);

		$this->load->model('support_m');
		$this->lang->load('menu');
		$this->lang->load('support');

		$data['menu']		= $this->load->view('ingame/menu', '', TRUE);
		$data['tickets']	= $this->support_m->load_all_tickets($id);

		$this->load->view('ingame/support/table', $data);
	}

	public function new_ticket()
	{
		if( ! $this->session->userdata('logged_in')) redirect('/');
		define('INGAME', TRUE);

		$this->lang->load('support');

		if($this->input->server('REQUEST_METHOD') === 'POST')
		{
			if( ! $this->input->post('type') OR
				! $this->input->post('title') OR
				! $this->input->post('text'))
			{
				message(lang('support.no_data'), 'support/new_ticket', TRUE);
			}
			else if ($this->input->post('type') > 3 OR $this->input->post('type') < 1)
			{
				log_message('error', 'User with ID '.$this->session->userdata('id').
							' and IP '.$this->input->ip_address().' has tried to send an invalid type at support/new_ticket.');
				message(lang('overal.hacking_attempt'), 'support/new_ticket', TRUE);
			}
			else
			{
				$this->load->model('support_m');

				$new_ticket = $this->support_m->new_ticket(	$this->input->post('type'),
															$this->input->post('title'),
															$this->input->post('text'));

				if($new_ticket)
					message(lang('support.new_success'), 'support', TRUE);
				else
					message(lang('support.new_error'), 'support', TRUE);
			}
		}
		else
		{
			$this->lang->load('menu');

			$data['menu']		= $this->load->view('ingame/menu', '', TRUE);

			$data['title']		= array(
								'name'		=> 'title',
								'id'		=> 'form_title',
								'maxlength'	=> '50',
								'size'		=> '50'
								);

			$data['type']		= array(
								'1'			=> lang('support.type_1'),
								'2'			=> lang('support.type_2'),
								'3'			=> lang('support.type_3')
								);

			$data['text']		= array(
								'name'		=> 'text',
								'id'		=> 'form_text',
								'rows'		=> '10',
								'cols'		=> '75'
								);

			$this->load->view('ingame/support/form', $data);
		}
	}

	public function ticket($id = NULL)
	{
		if( ! $this->session->userdata('logged_in')) redirect('/');
		if(is_null($id)) redirect('support');
		define('INGAME', TRUE);

		$this->load->model('support_m');
		$this->lang->load('menu');
		$this->lang->load('support');

		$data['menu']		= $this->load->view('ingame/menu', '', TRUE);
		$data['ticket']		= $this->support_m->load_ticket($id);

		$this->load->view('ingame/support/ticket', $data);
	}
}


/* End of file support.php */
/* Location: ./space_settler/controllers/support.php */