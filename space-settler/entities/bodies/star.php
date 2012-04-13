<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Star class
 *
 * @subpackage	Entities
 * @author		Razican
 * @category	Bodies
 * @link		http://www.razican.com/
 */
final class Star extends Body
{
	public $galaxy;
	public $luminosity;

	public function __construct()
	{
		$args	= func_num_args();
		if(func_num_args() === 1)
		{
			//$this->_load($args[0]);
		}
		else
		{
			parent::__construct();

			$this->id					= $args[0]+1;
			$this->_orbit();
			$this->_type();
			$this->_properties();
			$this->_density();
			$this->galaxy				= $args[1]+1;
			$this->_luminosity();

			$this->_titius_bode();
		}


	}

	private function _orbit()
	{
		$this->orbit		= mt_rand(20000, 30000);
	}

	private function _type()
	{
		$probability		= mt_rand(1, 10000000);

		if($probability <= 3333) $this->type = '1';
		else if($probability <= 6666) $this->type = '2';
		else if($probability === 6667) $this->type = '3';
		else if($probability <= 10000) $this->type = '4';
		else if($probability <= 10003) $this->type = 'O';
		else if($probability <= 23000) $this->type = 'B';
		else if($probability <= 83000) $this->type = 'A';
		else if($probability <= 383000) $this->type = 'F';
		else if($probability <= 1143000) $this->type = 'G';
		else if($probability <= 2353000) $this->type = 'K';
		else $this->type = 'M';
	}

	private function _properties()
	{
		$CI =& get_instance();
		switch($this->type)
		{
			case '1':
				$this->mass			= mt_rand(0,1) ? mt_rand(5E+2, 10E+2)/100 : mt_rand(3E+2, 20E+2);
				$this->temperature	= 0;
				$this->radius		= (2*$CI->config->item('G')*$this->mass*$CI->config->item('sun_mass'))/(pow($CI->config->item('c'), 2)); //CUIDADOOOO En m
			break;
			case '2':
				$this->mass			= mt_rand(138, 2E+2)/100;
				$this->temperature	= 0;
				$this->radius		= mt_rand(11000, 13000); //CUIDADOOOO EN m
			break;
			case '3':
				$this->mass			= mt_rand(15E+2, 90E+2)/100;
				$this->temperature	= 0;
				$this->radius		= mt_rand(11000, 13000); //CUIDADOOOO EN m
			break;
			case '4':
				$this->mass			= mt_rand(50, 800)/100;
				$this->temperature	= mt_rand(0,3) ? mt_rand(8E+3, 12E+3) : mt_rand(6E+3, 5E+4);
				$this->radius		= (3*$this->mass*$CI->config->item('sun_mass'))/(4E+9*M_PI); //CUIDADOOO en m
			break;
			case 'O':
				$this->mass			= mt_rand(15E+2, 90E+2)/100;
				$this->temperature	= mt_rand(3E+4, 56E+3);
				$this->radius		= mt_rand(660, 4000)/100;
			break;
			case 'B':
				$this->mass			= mt_rand(210, 16E+2)/100;
				$this->temperature	= mt_rand(1E+4, 3E+4);
				$this->radius		= mt_rand(180, 660)/100;
			break;
			case 'A':
				$this->mass			= mt_rand(140, 210)/100;
				$this->temperature	= mt_rand(7500, 1E+4);
				$this->radius		= mt_rand(140, 180)/100;
			break;
			case 'F':
				$this->mass			= mt_rand(104, 140)/100;
				$this->temperature	= mt_rand(6000, 7500);
				$this->radius		= mt_rand(115, 140)/100;
			break;
			case 'G':
				$this->mass			= mt_rand(80, 104)/100;
				$this->temperature	= mt_rand(5200, 6000);
				$this->radius		= mt_rand(96, 115)/100;
			break;
			case 'K':
				$this->mass			= mt_rand(45, 80)/100;
				$this->temperature	= mt_rand(3700, 5200);
				$this->radius		= mt_rand(70, 96)/100;
			break;
			case 'M':
				$this->mass			= mt_rand(8, 45)/100;
				$this->temperature	= mt_rand(2300, 3700);
				$this->radius		= mt_rand(8, 70)/100;
		}
	}

	private function _luminosity()
	{
		$CI					=& get_instance();
		$this->luminosity	= 4*M_PI*pow($this->_radius(), 2)*$CI->config->item('Boltzman_constant')*pow($this->temperature, 4)/$CI->config->item('sun_luminosity');
	}

	/**
	 * Return the volume of a star
	 *
	 * @return	float	Volume in m³
	 */
	public function volume()
	{
		$CI					=& get_instance();
		return 4/3*M_PI*pow($this->_radius(), 3);
	}

	/**
	 * Calculate the density of a star
	 */
	private function _density()
	{
		$CI					=& get_instance();
		$this->density		= $this->mass*$CI->config->item('sun_mass')/$this->volume();
	}

	/**
	 * Return the number of bodies of the star
	 */
	public function num_bodies($random = FALSE)
	{
		if($random)
		{
			switch($this->type)
			{
				case 'O': case '1': case '2': case '3':
					$bodies = 0;
				break;
				case '4':
					$bodies = mt_rand(0,2);
				break;
				case 'B':
					if($this->mass < 4) $bodies = mt_rand(0,1) ? mt_rand(1,2) : 0;
					else $bodies = 0;
				break;
				case 'A':
					$bodies = mt_rand(0,3) ? mt_rand(1,3) : 0;
				break;
				case 'F':
					$bodies = mt_rand(0,8) ? mt_rand(2,6) : mt_rand(0,1);
				break;
				case 'G':
					$bodies = mt_rand(0,20) ? mt_rand(5,12) : mt_rand(0,4);
				break;
				case 'K':
					$bodies = mt_rand(0,15) ? mt_rand(3,10) : mt_rand(0,2);
				break;
				case 'M':
					$bodies = mt_rand(0,15) ? mt_rand(2,8) : mt_rand(0,1);
				break;
			}
			$this->bodies = $bodies;
		}

		return $this->bodies;
	}

	public function finish()
	{
		unset($this->bodies);
	}

	private function _titius_bode()
	{
		//calculate params
	}

	private function _radius()
	{
		$CI =& get_instance();
		return ($this->type === '1' OR $this->type === '2' OR $this->type === '3' OR $this->type === '4') ? $this->radius : $this->radius*$CI->config->item('sun_radius');
	}
}


/* End of file star.php */
/* Location: ./space_settler/entities/bodies/star.php */