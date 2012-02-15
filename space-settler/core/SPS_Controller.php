<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SPS_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		if( ! $this->input->is_cli_request())
		{
			$this->output->enable_profiler($this->config->item('debug'));

			if ($this->session->userdata('logged_in') && ( ! $this->session->userdata('hibernating')))
			{
				$this->db->where('id', $this->session->userdata('id'));
				$this->db->set('last_ip', ip2int($this->input->ip_address()));
				$this->db->set('last_active', now());
				$this->db->update('users');
			}
		}
	}
}