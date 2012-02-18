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

		$this->load->model('support_m');
		$this->lang->load('menu');
		$this->lang->load('support');

		$data['tickets']	= $this->support_m->load_tickets($id);
		$data['menu']		= $this->load->view('ingame/menu', '', TRUE);

		$this->load->view('ingame/support_table', $data);
	}
}


/* End of file support.php */
/* Location: ./space_settler/controllers/support.php */