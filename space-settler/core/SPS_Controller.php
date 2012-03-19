<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SPS_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->view_path(FCPATH.'skins/'.skin().'/views/');

		if( ! $this->input->is_cli_request())
		{
			$this->output->enable_profiler($this->config->item('debug'));

			if ($this->session->userdata('logged_in'))
			{
				$this->db->where('id', $this->session->userdata('id'));
				if ( ! $this->session->userdata('hibernating')) $this->db->set('last_active', now());
				$this->db->set('last_ip', ip2int($this->input->ip_address()));
				$this->db->update('users');
			}
		}
	}
}