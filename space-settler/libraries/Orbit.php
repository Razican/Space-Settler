<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orbit {

	public $major_mass;
	public $orbiting_mass;
	public $semimajor_axis;
	public $eccentricity;
	public $time;

	public function __construct($param)
	{
		$CI				=& get_instance();
		$CI->config->load('physics');

		$this->major_mass		= $param['major_mass'];
		$this->orbiting_mass	= $param['orbiting_mass'];
		$this->semimajor_axis	= $param['semimajor_axis'];
		$this->eccentricity		= $param['eccentricity'];
		$this->time				= $param['time'];
	}

	public function distance()
	{
		$major_mass		= $this->major_mass*config_item('sun_mass');
		$orbiting_mass	= $this->orbiting_mass*config_item('earth_mass');
		$a				= $this->semimajor_axis*config_item('au');

		$period			= 2*M_PI*sqrt(pow($a, 3)/(config_item('G')*($major_mass+$orbiting_mass)));

		$M				= 2*M_PI*($this->time % $period)/$period;

		$E0				= $M;
		$E1				= $M+$this->eccentricity*sin($E0);

		while (abs($E1-$E0 > 0.0001))
		{
			$E0			= $E1;
			$E1			= $M+$this->eccentricity*sin($E0);
		}

		$zeta			= 2*atan(sqrt((1+$this->eccentricity)/(1-$this->eccentricity))*tan($E1/2));
		$distance		= $a*(1-pow($this->eccentricity, 2))/(1+$this->eccentricity*cos($zeta));
		$this->distance	= $distance/config_item('au');

		return $this->distance;
	}

	public function velocity()
	{
		$major_mass		= $this->major_mass*config_item('sun_mass');
		$orbiting_mass	= $this->orbiting_mass*config_item('earth_mass');

		$this->velocity	= sqrt(2*config_item('G')*($major_mass+$orbiting_mass)*(1/$this->distance - 1/(2*$this->semimajor_axis)));

		return $this->velocity;
	}
}


/* End of file Orbit.php */
/* Location: ./application/libraries/Orbit.php */