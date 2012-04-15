<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Error extends SPS_Controller {

	public function error_404()
	{
		header('HTTP/1.1 404 Not Found');
		$this->load->view('404');
	}
}


/* End of file error.php */
/* Location: ./space_settler/controllers/error.php */