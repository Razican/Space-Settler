<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Get_distance extends CI_Controller {

	public function index($sun_mass, $planet_mass, $semimajor_axis, $eccentricity, $time)
	{
		$this->config->load('physics');

		$sun_mass		= $sun_mass*$this->config->item('sun_mass');
		$planet_mass	= $planet_mass*$this->config->item('earth_mass');
		$a				= $semimajor_axis*$this->config->item('AU');

		$period			= 2*M_PI*sqrt(pow($a, 3)/($this->config->item('G')*($sun_mass+$planet_mass)));

		$M				= 2*M_PI*($time % $period)/$period;

		$E0				= $M;
		$E1				= $M+$eccentricity*sin($E0);

		while(abs($E1-$E0 > 0.0001))
		{
			$E0			= $E1;
			$E1			= $M+$eccentricity*sin($E0);
		}

		$zeta			= 2*atan(sqrt((1+$eccentricity)/(1-$eccentricity))*tan($E1/2));
		$distance		= $a*(1-pow($eccentricity, 2))/(1+$eccentricity*cos($zeta));

		echo $distance/$this->config->item('AU');
	}
}


/* End of file get_distance.php */
/* Location: ./application/controllers/get_distance.php */