<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Planet class
 *
 * @subpackage	Entities
 * @author		Razican
 * @category	Bodies
 * @link		http://www.razican.com/
 */
final class Planet extends Body
{
	public $star;
	public $position;
	public $terrestrial;
	public $double_planet;
	public $atmosphere;
	public $albedo;
	public $habitable;
	public $constructions;
	public $ground;
	public $owner;
	public $gravity;
	public $rotation;

	public function __construct()
	{
		$args	= func_get_args();
		if(func_num_args() === 1)
		{
			//$this->_load($args[0]);
		}
		else
		{
			parent::__construct();

			$this->id				= $args[1]+1;
			$this->star				= &$args[0];
			$this->position			= $args[2]+1;
			$this->planet			= NULL;
			$this->_orbit($args[3]);
			$this->_rotation();
			$this->_type();
			$this->_atmosphere();
			$this->_properties();
		//	$this->_ground();
		//	$this->_albedo();
		//	$this->_temperature();
		//	$this->_luminosity();
		//	$this->is_habitable(TRUE);

		//	$this->_titius_bode();
		}
	}

	private function _orbit($last_distance)
	{
		$CI				=& get_instance();
		$this->orbit	= array();

		$sma					= exp($this->star->tb['m']*$this->position - $this->star->tb['n'])*100;
		$sma					= mt_rand(round($sma*0.9), round($sma*1.1))/100;
		$this->orbit['sma']		= $sma < $last_distance ? $last_distance+0.05 : $sma;
		$this->orbit['ecc']		= ($this->orbit['sma'] < ($this->star->mass/2) ? mt_rand(50, 250) : mt_rand(0, 100))/1000;
		$this->orbit['incl']	= (mt_rand(0, 100)/10)*M_PI/180;
		$this->orbit['lan']		= (mt_rand(0, 3599)/10)*M_PI/180;
		$this->orbit['ArgPe']	= (mt_rand(0, 3599)/10)*M_PI/180;
		$this->orbit['Ma0']		= (mt_rand(0, 3599)/10)*M_PI/180;

		/*Extra*/
		$this->orbit['period']	= 2*M_PI*sqrt(pow($this->orbit['sma'], 3)/($CI->config->item('G')*$this->star->mass));
	}

	private function _type()
	{
		$this->type = mt_rand(0,1);
	}

	private function _atmosphere()
	{
		$this->atmosphere = array();
		if( ! $this->type)
		{
				$this->atmosphere['pressure']		= (mt_rand(0, 1) ? mt_rand(0, 100) : mt_rand(0, 1000000))/1000;
				$this->atmosphere['composition']	= array();
				$total = 0;
				if(mt_rand(0,1))
				{
					$this->atmosphere['composition']['CO2'] = mt_rand(7500, 9900)/100;
					$total += $this->atmosphere['composition']['CO2'];
					$this->atmosphere['composition']['NO2'] = mt_rand(0, (100-$total)*100)/100;
					$total += $this->atmosphere['composition']['N2'];
					$this->atmosphere['composition']['O2'] = mt_rand(0, (100-$total)*100)/100;
					$total += $this->atmosphere['composition']['O2'];
				}
				else
				{
					$this->atmosphere['composition']['N2'] = mt_rand(5000, 9500)/100;
					$total += $this->atmosphere['composition']['N2'];
					if(mt_rand(0,1))
					{
						$this->atmosphere['composition']['CO2'] = mt_rand(400, (100-$total)*100)/100;
						$total += $this->atmosphere['composition']['CO2'];
						$this->atmosphere['composition']['O2'] = mt_rand(0, (100-$total)*100)/100;
						$total += $this->atmosphere['composition']['O2'];
					}
					else
					{
						$this->atmosphere['composition']['O2'] = mt_rand(400, (100-$total)*100)/100;
						$total += $this->atmosphere['composition']['O2'];
						$this->atmosphere['composition']['CO2'] = mt_rand(0, (100-$total)*100)/100;
						$total += $this->atmosphere['composition']['CO2'];
					}
				}

				$this->atmosphere['composition']['others'] = $total;
		}
		else
		{
			$this->atmosphere = NULL;
		}
	}

	private function _properties()
	{
		switch($this->type)
		{
			case 0:
				$this->radius	= mt_rand(2E+6,15E+6);

				if($this->radius < 75E+5)	$density	= mt_rand(27E+2, 65E+2);
				else						$density	= mt_rand(55E+2, 15E+3);

				$mass			= (4*M_PI*pow($this->radius, 3)*$density)/3;
				$mass			= ($mass > 9E+25) ? mt_rand(5E+3, 9E+3)*1E+22 : $mass;
				$this->mass		= $mass;
			break;
			case 1:
				$this->radius	= mt_rand(2E+6,125E+6);
				$mass			= pow($this->radius/1E+3, 1.6)*1.2E+19-0.5E+26;

				$this->mass		= mt_rand(round($mass/1.5), round($mass*1.5));
			break;
		}

		$this->gravity	= gravity($this->mass, $this->radius);
		$this->_density();
	}

	private function _rotation()
	{
		$CI				=& get_instance();
		$this->rotation = array();
		$tidal_lock		= sqrt($this->star->mass/$CI->config->item('sun_mass'))/2;

		if($this->orbit['sma'] > $tidal_lock)
		{
			$this->rotation['axTilt']	= (mt_rand(0, 1) ? mt_rand(2000, 3000) : mt_rand(0, 18000))/100;

			if($this->rotation['axTilt'] > 90)
				$this->rotation['period']	= -1*mt_rand(50000, 21000000);
			else if($this->rotation['period'] < 90)
				$this->rotation['period']	= mt_rand(18000, 180000);
			else
				$this->rotation['period']	= 0;
		}
		else if($this->orbit['sma'] > $tidal_lock/2)
		{
			$this->rotation['axTilt']	= mt_rand(0, 100)/100;
			$this->rotation['period']	= $this->orbit['period']*mt_rand(3, 6)/2;
		}
		else
		{
			$this->rotation['axTilt']	= 0;
			$this->rotation['period']	= $this->orbit['period'];
		}
	}

	private function _ground()
	{
		//Si hay agua líquida o sólida, un porcentaje, si no, no
	}
}


/* End of file planet.php */
/* Location: ./space_settler/entities/bodies/planet.php */