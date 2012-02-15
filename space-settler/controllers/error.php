<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Error extends SPS_Controller {

	public function _remap($error)
	{
		if($this->uri->segment(1) != 'error') redirect('error/'.$error);

		switch($error)
		{
			case '404':
				header('HTTP/1.1 404 Not Found');
				$this->load->view('404');
			break;
			default:
				redirect('error/404');
		}
	}
}

/* End of file creation.php */
/* Location: ./space_settler/controllers/creation.php */