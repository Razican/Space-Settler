<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Planet class
 *
 * @subpackage	Entities
 * @author		Razican
 * @category	Bodies
 * @link		http://www.razican.com/
 */
final class Planet extends Body {

	public $star;
	public $position;
	public $double_planet;
	public $atmosphere;
	public $albedo;
	public $habitable;
	public $constructions;
	public $ground;
	public $owner;
	public $gravity;
	public $rotation;
	public $is_roche_ok;

	public function __construct()
	{
		$args	= func_get_args();
		if (func_num_args() === 1)
		{
			//IF it's an integer
			//$this->_load($args[0]);
			//If it's an array or an object
			//Update current values
		}
		else
		{
			parent::__construct();

			$this->id				= $args[1]+1;
			$this->star				= &$args[0];
			$this->position			= $args[2];
			$this->double_planet	= FALSE;
			$this->owner			= NULL;
			$this->constructions	= array();
			$this->_orbit($args[3]);
			$this->_rotation();
			$this->_type();
			$this->_atmosphere();
			$this->_properties();

			$this->_roche_limit();

			if ($this->is_roche_ok)
			{
				$this->_rotation();
				$this->_albedo();
				$this->_temperature();
				$this->_ground();
				$this->_is_habitable();

			//	$this->_titius_bode();
			}
		}
	}

	/**
	 * Define planet's orbit
	 *
	 * @access	private
	 * @param	int			Las planet's distance to sun
	 * @return void
	 */
	private function _orbit($last_distance)
	{
		$CI				=& get_instance();
		$this->orbit	= array();

		$sma					= exp($this->star->tb['m']*$this->position - $this->star->tb['n'])*1000;
		$sma					= mt_rand(round($sma*0.9), round($sma*1.1))/1000;
		$this->orbit['sma']		= $sma < $last_distance*1.15 ? $last_distance*mt_rand(115, 125)/100 : $sma;
		$this->orbit['ecc']		= ($this->orbit['sma'] < ($this->star->mass/2) ? mt_rand(50, 250) : mt_rand(0, 100))/1000;
		$this->orbit['incl']	= round((mt_rand(0, 100)/10)*M_PI/180, 3);
		$this->orbit['lan']		= round((mt_rand(0, 3599)/10)*M_PI/180, 3);
		$this->orbit['ArgPe']	= round((mt_rand(0, 3599)/10)*M_PI/180, 3);
		$this->orbit['Ma0']		= round((mt_rand(0, 3599)/10)*M_PI/180, 3);

		//Extra
		$this->orbit['period']	= round(2*M_PI*sqrt(pow($this->orbit['sma']*config_item('au'), 3)/(config_item('G')*$this->star->mass*config_item('sun_mass'))));
		$this->orbit['apa']		= round($this->orbit['sma']*(1+$this->orbit['ecc']), 3);
		$this->orbit['pea']		= round($this->orbit['sma']*(1-$this->orbit['ecc']), 3);
	}

	private function _type()
	{
		if ($this->orbit['sma'] < sqrt($this->star->luminosity))
		{
			$this->type	= mt_rand(0, 1);
		}
		elseif ($this->star->luminosity > 5 && ($this->orbit['sma'] < sqrt($this->star->luminosity)*50))
		{
			$this->type	= mt_rand(0, 5) ? 1 : 0;
		}
		else
		{
			$this->type = ($this->orbit['sma'] < sqrt($this->star->luminosity)*200) ? mt_rand(0,1) : 0;
		}
	}

	private function _atmosphere()
	{
		$this->atmosphere = array();
		if ( ! $this->type)
		{
				$this->atmosphere['pressure']		= (mt_rand(0, 1) ? mt_rand(0, 10000) : mt_rand(0, 10000000))/100;
				$this->atmosphere['composition']	= array();
				$total = 0;

				if ($this->atmosphere['pressure'] > 0 && mt_rand(0,1))
				{
					$this->atmosphere['composition']['CO2'] = mt_rand(75000, 99000)/1000;
					$total += $this->atmosphere['composition']['CO2'];
					$this->atmosphere['composition']['N2'] = mt_rand(1, (100-$total)*1000-3)/1000;
					$total += $this->atmosphere['composition']['N2'];
					$this->atmosphere['composition']['O2'] = mt_rand(1, (100-$total)*1000-2)/1000;
					$total += $this->atmosphere['composition']['O2'];
				}
				elseif ($this->atmosphere['pressure'] > 0)
				{
					$this->atmosphere['composition']['N2'] = mt_rand(50000, 95000)/1000;
					$total += $this->atmosphere['composition']['N2'];
					if (mt_rand(0,1))
					{
						$this->atmosphere['composition']['CO2'] = mt_rand(400, (100-$total)*1000-3)/1000;
						$total += $this->atmosphere['composition']['CO2'];
						$this->atmosphere['composition']['O2'] = mt_rand(1, (100-$total)*1000-2)/1000;
						$total += $this->atmosphere['composition']['O2'];
					}
					else
					{
						$this->atmosphere['composition']['O2'] = mt_rand(400, (100-$total)*1000-3)/1000;
						$total += $this->atmosphere['composition']['O2'];
						$this->atmosphere['composition']['CO2'] = mt_rand(1, (100-$total)*1000-2)/1000;
						$total += $this->atmosphere['composition']['CO2'];
					}
				}

				$this->atmosphere['composition']['others'] = 100-$total;
				$this->_greenhouse();
		}
		else
		{
			$this->atmosphere = NULL;
		}
	}

	private function _greenhouse()
	{
		if ( ! $this->type && ! is_null($this->atmosphere) && round($this->atmosphere['pressure']) > 0)
		{
			$greenhouse						= 2.1E-4*pow($this->atmosphere['composition']['CO2'], 0.313)*pow(round($this->atmosphere['pressure']), 0.829)+1E-7*round($this->atmosphere['pressure'])+0.0033*$this->atmosphere['composition']['CO2'];
			$this->atmosphere['greenhouse']	= mt_rand(round($greenhouse*0.95*100), round($greenhouse*1.05*100))/100;
		}
		else
		{
			$this->atmosphere['greenhouse']	= 0;
		}
	}

	private function _properties()
	{
		switch ($this->type)
		{
			case 0:
				$this->radius	= mt_rand(2E+6,15E+6);

				if ($this->radius < 75E+5)
				{
					$density	= mt_rand(27E+2, 65E+2);
				}
				else
				{
					$density	= mt_rand(55E+2, 15E+3);
				}

				$mass			= (4*M_PI*pow($this->radius, 3)*$density)/3;
				$mass			= ($mass > 9E+25) ? mt_rand(5E+3, 9E+3)*1E+22 : $mass;

				$this->mass		= $mass;
			break;
			case 1:
				$this->radius	= mt_rand(2E+7,1.5E+8);
				$mass			= pow($this->radius/1E+3, 1.3)*1.445E+21-5E+26;
				$mass			= mt_rand(round(($mass/5)/1E+20), round(($mass*5)/1E+20))*1E+20;

				if ($mass > 1E+28 && mt_rand(0,3000))
				{
					$mass		= $mass/10;
				}

				$this->mass		= $mass;
			break;
		}

		$this->gravity	= gravity($this->mass, $this->radius);
		$this->_density();
	}

	private function _roche_limit()
	{
		if ( ! $this->type)
		{
			$d = $this->star->radius()*pow(2*$this->star->density/$this->density, 1/3);
			$d_au = $d/config_item('au');
			if ($this->orbit['pea'] <= $d_au)
			{
				$this->is_roche_ok = FALSE;
			}
			else
			{
				$this->is_roche_ok = TRUE;
			}
		}
		else
		{
			$d = 2.44*$this->star->radius()*pow($this->star->density/$this->density, 1/3);
			$d_au = $d/config_item('au');
			if ($this->orbit['pea'] <= $d_au)
			{
				$this->is_roche_ok = FALSE;
			}
			else
			{
				$this->is_roche_ok = TRUE;
			}
		}
	}

	private function _rotation()
	{
		$CI				=& get_instance();
		$this->rotation = array();
		$tidal_lock		= sqrt($this->star->mass/config_item('sun_mass'))/2;

		if ($this->orbit['sma'] > $tidal_lock)
		{
			$this->rotation['axTilt']	= (mt_rand(0, 1) ? mt_rand(2000, 3000) : mt_rand(0, 18000))/100;

			if ($this->rotation['axTilt'] >= 90)
			{
				$this->rotation['period']	= $this->orbit['period'] < 50000 ? -mt_rand(round($this->orbit['period']*0.8), $this->orbit['period']-1) : -mt_rand(50000, ($this->orbit['period'] < 25000000 ? $this->orbit['period']-1 : 25000000));
			}
			else
			{
				$this->rotation['period']	= $this->orbit['period'] < 18000 ? mt_rand(round($this->orbit['period']*0.8), $this->orbit['period']-1) : mt_rand(18000, ($this->orbit['period'] < 180000 ? $this->orbit['period']-1 : 180000));
			}
		}
		elseif ($this->orbit['sma'] > sqrt($tidal_lock)/3)
		{
			$this->rotation['axTilt']	= mt_rand(0, 100)/100;
			$this->rotation['period']	= $this->orbit['period']*mt_rand(3, 6)/2;
		}
		else
		{
			$this->rotation['axTilt']	= 0;
			$this->rotation['period']	= $this->orbit['period'];
		}

		if ($this->rotation['axTilt'] === 90)
		{
			$day	= $this->orbit['period'];
		}
		else
		{
			if ($this->rotation['period'] > 0)
			{
				if ($this->rotation['period'] === $this->orbit['period'])
				{
					$day = $this->rotation['period'];
				}
				else
				{
					$day	= $this->rotation['period']/(1-($this->rotation['period']/$this->orbit['period']));
				}
			}
			elseif ($this->rotation['period'] < 0)
			{
				$day	= abs($this->rotation['period'])/(1+(abs($this->rotation['period'])/$this->orbit['period']));
			}
			else
			{
				$day	= 0;
			}
		}

		$this->rotation['day']	= round($day);
	}

	private function _albedo($look_ground = FALSE)
	{
		if ($look_ground)
		{
			//recalcular
		}
		else
		{
			if ($this->type)
			{
				$this->albedo = mt_rand(4000, 6000)/10000;
			}
			elseif (is_null($this->atmosphere))
			{
				$this->albedo = mt_rand(0, 1000)/10000;
			}
			else
			{
				if ($this->atmosphere['pressure'] < 100)
				{
					$this->albedo = mt_rand(0, 1000)/10000;
				}
				elseif ($this->atmosphere['pressure'] < 750)
				{
					$this->albedo = mt_rand(1000, 2500)/10000;
				}
				elseif ($this->atmosphere['pressure'] < 2500)
				{
					$this->albedo = mt_rand(2000, 3500)/10000;
				}
				elseif ($this->atmosphere['pressure'] < 10000)
				{
					$this->albedo = mt_rand(3000, 5000)/10000;
				}
				elseif ($this->atmosphere['pressure'] < 100000)
				{
					$this->albedo = mt_rand(4500, 7500)/10000;
				}
				else
				{
					$this->albedo = mt_rand(6000, 9000)/10000;
				}
			}
		}
	}

	private function _temperature()
	{
		$l		= $this->star->luminosity*config_item('sun_luminosity');
		$this->temperature['eff']	= round(pow(($l*(1-$this->albedo))/(16*M_PI*config_item('Boltzman_constant')*pow($this->orbit['sma']*config_item('au'), 2)),0.25), 2);

		if ( ! $this->type)
		{
			if ($this->temperature['eff'] > 800)
			{
				$this->atmosphere = array('pressure' => 0, 'greenhouse' => 0);
			}

			if ($this->atmosphere['greenhouse'] <= 1)
			{
				$this->temperature['avg']	= round(($this->temperature['eff']+$this->atmosphere['greenhouse']*20+mt_rand(0, 15)*$this->atmosphere['greenhouse']), 2);
			}
			else
			{
				$this->temperature['avg']	= round(($this->temperature['eff']+pow($this->atmosphere['greenhouse'], 1.225)+25+mt_rand(0, 10)), 2);
			}

			//CUIDADO!!! hay que tener en cuenta la excentricidad!!!
			if ($this->rotation['axTilt'] < 10 OR $this->rotation['axTilt'] > 170)
			{
				$change	= round((($this->temperature['avg']*pow($this->rotation['day'], 0.8)*5/pow(1.01, $this->atmosphere['greenhouse']))/1E+6), 2);

				$this->temperature['min']	= $this->temperature['avg']-mt_rand(round($change*1.2*100), round($change*1.7*100))/100;
				$this->temperature['max']	= $this->temperature['avg']+mt_rand(round($change*0.05*100), round($change*0.2*100))/100;
			}
			elseif ($this->rotation['axTilt'] > 50 && $this->rotation['axTilt'] < 130)
			{
				$this->temperature['min']	= $this->temperature['avg'];
				$this->temperature['max']	= $this->temperature['avg'];
				//Se considera un planeta acoplado
				//Como Mercurio, pero más exagerado, o como Venus pero más exagerado
				//También hay que tener en cuenta la duración del día
			}
			else
			{
				$this->temperature['min']	= $this->temperature['avg'];
				$this->temperature['max']	= $this->temperature['avg'];
				//Estaciones, etc, como en la Tierra o Marte
				//Pero hay que tener en cuenta la duración del día
			}
			/*
			 * Si la inclinación es pequeña solo se tiene en cuenta la duración del día (-10º) Si es grande (+10º)
			 * se tiene en cuenta también las estaciones y los polos. Si es muy grande (+50º) se
			 * considera como si fuera un planeta acoplado.
			 *
			 * Aquí hay problemas a la hora de hacer el cálculo realista, ya que no hay suficientes datos de planetas
			 * rocosos.
			 */
		}
	}

	private function _ground()
	{
		$ground = array();

		if ( ! $this->type)
		{
			//Solo tendrán suelo los planetas rocosos.
		}
		/*
		 * -Primero se comprueba la temperatura superficial con el albedo aleatorio
		 * -Luego se calcula si hay agua líquida o sólida, y si es así, aumenta el albedo
		 * -Se recalcula el agua y el hielo
		 * -Se calcula el resto de materiales
		 */
		$this->ground = $ground;
	}

	private function _is_habitable()
	{
		$habitable = FALSE;

		if ( ! $this->type)
		{
			// Comprobar habitabilidad
		}

		$this->habitable = $habitable;
	}
}


/* End of file planet.php */
/* Location: ./space_settler/entities/bodies/planet.php */