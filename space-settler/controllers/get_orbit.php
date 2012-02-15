<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Get_orbit extends SPS_Controller {

	public function index($major_mass, $orbiting_mass, $semimajor_axis, $eccentricity, $time)
	{
		$params	= array('major_mass'		=> $major_mass,
						'orbiting_mass'		=> $orbiting_mass,
						'semimajor_axis'	=> $semimajor_axis,
						'eccentricity'		=> $eccentricity,
						'time'				=> $time);
		$this->load->library('orbit', $params);

		echo 'Distancia al sol : '.$this->orbit->distance().' AU<br>';
		echo 'Velocidad orbital : '.$this->orbit->velocity().' m/s';
	}
}


/* End of file get_distance.php */
/* Location: ./application/controllers/get_distance.php */