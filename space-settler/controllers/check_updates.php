<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Check_updates extends CI_Controller {

	public function index()
	{
		$this->load->library('update');
		echo 'PHP : '.($this->update->check_php() ? 'OK' : 'Desactualizado').' ['.phpversion().']<br />';
		echo 'CodeIgniter : '.($this->update->check_codeigniter() ? 'OK' : 'Desactualizado').' ['.CI_VERSION.']<br />';
	}
}

/* End of file check_updates.php */
/* Location: ./application/controllers/check_updates.php */