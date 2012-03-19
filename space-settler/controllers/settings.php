<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends SPS_Controller {

	public function index()
	{
		if($this->uri->segment(2)) redirect('settings', 'location', 301);
		if( ! $this->session->userdata('logged_in')) redirect('/');

		define('INGAME', TRUE);
		$this->lang->load('menu');
		$this->lang->load('settings');

		$settings	= $this->user->get_settings();

		$data['skins']			= list_skins('name');
		$data['name']			= array(
									'name'		=> 'name',
									'id'		=> 'form_name',
									'value'		=> $settings->name,
									'maxlength'	=> '20',
									'size'		=> '50'
								);

		$data['pass']			= array(
									'name'		=> 'password',
									'id'		=> 'form_pass',
									'maxlength'	=> '50',
									'size'		=> '50'
								);

		$data['pass_conf']		= array(
									'name'		=> 'passconf',
									'id'		=> 'form_passconf',
									'maxlength'	=> '50',
									'size'		=> '50'
								);

		$data['email']			= array(
									'name'		=> 'email',
									'id'		=> 'form_email',
									'value'		=> $settings->email,
									'maxlength'	=> '50',
									'size'		=> '50'
								);

		$data['hibernating']	= array(
									'name'		=> 'hibernate',
									'id'		=> 'form_hibernate',
									'checked'	=> $settings->hibernating
								);

		$data['license']	= $this->load->view('license', '', TRUE);
		$data['topbar']		= $this->load->view('ingame/topbar', '', TRUE);
		$data['menu']		= $this->load->view('ingame/menu', '', TRUE);

		$this->load->view('ingame/settings', $data);
	}

	public function save()
	{
		if( ! $this->session->userdata('logged_in')) redirect('/');
		if($this->input->server('REQUEST_METHOD') != 'POST') redirect('settings');

		define('INGAME', TRUE);
		$this->lang->load('menu');
		$this->lang->load('settings');
		$this->load->helper('email');

		if(( ! $this->input->post('name')) OR ( ! $this->input->post('email')))
			message('settings.no_data', 'settings');
		else if(($this->input->post('password')) && ( ! $this->input->post('passconf')))
			message('settings.confirm_pass', 'settings');
		else if( ! valid_email($this->input->post('email')))
			message('settings.email_not_valid', 'settings');
		else if ($this->input->post('password') != $this->input->post('passconf'))
			message('settings.passconf_dif', 'settings');

		$save	= $this->user->save_config(	$this->input->post('name'),
											$this->input->post('email'),
											$this->input->post('password'),
											(bool) $this->input->post('hibernate'));

		if($save)	message(lang('settings.save_ok'), 'settings');
		else		message(lang('settings.save_error'), 'settings');
	}
}