<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Star class
 *
 * @subpackage	Entities
 * @author		Razican
 * @category	Bodies
 * @link		http://www.razican.com/
 */
final class Star extends Body {

	public $galaxy;
	public $luminosity;

	public function __construct()
	{
		$args	= func_get_args();
		if (func_num_args() === 1)
		{
			//$this->_load($args[0]);
		}
		else
		{
			parent::__construct();

			$this->id				= $args[0]+1;
			$this->system			= $args[0];
			$this->_orbit();
			$this->_type();
			$this->_properties();
			$this->_density();
			$this->galaxy			= $args[1]+1;
			$this->_luminosity();

			$this->_num_bodies();
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

		if ($probability <= 3333) $this->type = '1';
		elseif($probability <= 6666) $this->type = '2';
		elseif($probability === 6667) $this->type = '3';
		elseif($probability <= 10000) $this->type = '4';
		elseif($probability <= 10003) $this->type = 'O';
		elseif($probability <= 23000) $this->type = 'B';
		elseif($probability <= 83000) $this->type = 'A';
		elseif($probability <= 383000) $this->type = 'F';
		elseif($probability <= 1143000) $this->type = 'G';
		elseif($probability <= 2353000) $this->type = 'K';
		else $this->type = 'M';
	}

	private function _properties()
	{
		switch ($this->type)
		{
			case '1':
				$this->mass			= mt_rand(0,1) ? mt_rand(5E+2, 10E+2)/100 : mt_rand(3E+2, 20E+2)/100;
				$this->temperature	= 0;
				$this->radius		= (2*config_item('G')*$this->mass*config_item('sun_mass'))/(pow(config_item('c'), 2));
			break;
			case '2':
				$this->mass			= mt_rand(138, 2E+2)/100;
				$this->temperature	= 0;
				$this->radius		= mt_rand(11000, 13000);
			break;
			case '3':
				$this->mass			= mt_rand(200, 300)/100;
				$this->temperature	= 0;
				$this->radius		= mt_rand(11000, 13000);
			break;
			case '4':
				$this->mass			= mt_rand(50, 800)/100;
				$this->temperature	= mt_rand(0,3) ? mt_rand(8E+3, 12E+3) : mt_rand(6E+3, 5E+4);
				$this->radius		= pow((3*$this->mass*config_item('sun_mass'))/(4E+9*M_PI), 1/3);
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
				$this->mass			= (mt_rand(0, 3) ? mt_rand(10, 25) : mt_rand(10, 45))/100;
				$this->temperature	= mt_rand(2500, 3700);
				$this->radius		= mt_rand($this->mass*100-5, mt_rand(0, 3) ? 50 : 70)/100;
		}
	}

	private function _luminosity()
	{
		$this->luminosity	= 4*M_PI*pow($this->radius(), 2)*config_item('Boltzman_constant')*pow($this->temperature, 4)/config_item('sun_luminosity');
	}

	/**
	 * Return the volume of a star
	 *
	 * @return	float	Volume in m³
	 */
	public function volume()
	{
		return 4/3*M_PI*pow($this->radius(), 3);
	}

	/**
	 * Calculate the density of a star
	 */
	protected function _density()
	{
		$this->density		= ($this->type === '1') ? 0 : $this->mass*config_item('sun_mass')/$this->volume();
	}

	/**
	 * Return the number of bodies of the star
	 */
	public function _num_bodies()
	{
		switch ($this->type)
		{
			case 'O': case '1': case '2': case '3':
				$bodies = 0;
			break;
			case '4':
				$bodies = ($this->luminosity < 300) ? mt_rand(0,2) : 0;
			break;
			case 'B':
				$bodies = ($this->luminosity < 300 && mt_rand(0,1)) ? mt_rand(1,2) : 0;
			break;
			case 'A':
				$bodies = mt_rand(0,3);
			break;
			case 'F':
				$bodies = mt_rand(0,8) ? mt_rand(2,8) : mt_rand(0,1);
			break;
			case 'G':
				$bodies = mt_rand(0,10) ? mt_rand(4,10) : mt_rand(0,3);
			break;
			case 'K':
				$bodies = mt_rand(0,15) ? mt_rand(4,10) : mt_rand(0,3);
			break;
			case 'M':
				$bodies = mt_rand(0,20) ? mt_rand(5,12) : mt_rand(0,4);
			break;
		}
		$this->bodies = $bodies;
	}

	private function _titius_bode()
	{
		if (isset($this->bodies) && $this->bodies > 0)
		{
			$this->tb = array();

			if ($this->luminosity < 0.01)
			{
				$m			= mt_rand(40, 100);
			}
			elseif ($this->luminosity < 0.1)
			{
				$m			= mt_rand(75, 250);
			}
			elseif ($this->luminosity < 0.5)
			{
				$m			= mt_rand(150, 1000);
			}
			elseif ($this->luminosity < 6)
			{
				$m			= mt_rand(0, round(10-$this->luminosity)) ? mt_rand(100, 1000) : mt_rand(250, 6000);
			}
			elseif ($this->luminosity < 10)
			{
				$m			= mt_rand(round($this->luminosity*1000), round($this->luminosity*3000));
			}
			elseif ($this->luminosity < 30)
			{
				$m			= mt_rand(round($this->luminosity*1000 > 30000 ? 30000 : $this->luminosity*1000), round($this->luminosity*1500 > 30000 ? 30000 : $this->luminosity*1500));
			}
			else
			{
				$m			= mt_rand(25000, 50000);
			}

			$this->tb['m']	= $m/10000;
			$n				= ($m > 350) ? sqrt($this->tb['m'])*1.7+0.165 : 0.017/$this->tb['m'];
			$this->tb['n']	= mt_rand(round($n*0.8*10000), round($n*1.2*10000))/10000;
		}
	}

	public function radius()
	{
		if (($this->type === '1') OR ($this->type === '2') OR ($this->type === '3') OR ($this->type === '4'))
		{
			$radius	= $this->radius;
		}
		else
		{
			$radius	= $this->radius*config_item('sun_radius');
		}
		return $radius;
	}
}


/* End of file star.php */
/* Location: ./space_settler/entities/bodies/star.php */