<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Validate extends SPS_Controller {

	public function _remap($code)
	{
		$this->output->enable_profiler($this->config->item('debug'));

		$code	= $code === 'index' ? '' : $code;

		if(strlen($code) != 15) redirect('/');
		if($this->uri->segment(3)) redirect('validate/'.$code);

		$this->lang->load('login');
		$this->load->library('user');

		if($this->user->validate($code)) message(lang('login.val_complete'));
		else message(lang('login.val_no_complete'));
	}
}


/* End of file validate.php */
/* Location: ./application/controllers/validate.php */