<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Get_orbit extends CI_Controller {

	public function index($sun_mass, $planet_mass, $semimajor_axis, $eccentricity, $time)
	{
		$params	= array('sun_mass'			=> $sun_mass,
						'planet_mass'		=> $planet_mass,
						'semimajor_axis'	=> $semimajor_axis,
						'eccentricity'		=> $eccentricity,
						'time'				=> $time);
		$this->load->library('orbit', $params);
	}
}


/* End of file get_distance.php */
/* Location: ./application/controllers/get_distance.php */