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
			$this->position			= $args[2]+1;
			$this->planet			= NULL;
			$this->_orbit($args[3]);
			$this->_rotation();
			$this->_type();
			$this->_atmosphere();
			$this->_properties();
			$this->_rotation();
			$this->_albedo();
			$this->_temperature();
			$this->_ground();
		//	$this->_is_habitable();

		//	$this->_titius_bode();
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
		$this->orbit['apa']		= $this->orbit['sma']*(1+$this->orbit['ecc']);
		$this->orbit['pea']		= $this->orbit['sma']*(1-$this->orbit['ecc']);
	}

	private function _type()
	{
		$this->type = mt_rand(0,1);
	}

	private function _atmosphere()
	{
		$this->atmosphere = array();
		if ( ! $this->type)
		{
				$this->atmosphere['pressure']		= mt_rand(0, 1) ? mt_rand(0, 100) : mt_rand(0, 1000000);
				$this->atmosphere['composition']	= array();
				$total = 0;
				if (mt_rand(0,1))
				{
					$this->atmosphere['composition']['CO2'] = mt_rand(7500, 9900)/100;
					$total += $this->atmosphere['composition']['CO2'];
					$this->atmosphere['composition']['N2'] = mt_rand(0, (100-$total)*100)/100;
					$total += $this->atmosphere['composition']['N2'];
					$this->atmosphere['composition']['O2'] = mt_rand(0, (100-$total)*100)/100;
					$total += $this->atmosphere['composition']['O2'];
				}
				else
				{
					$this->atmosphere['composition']['N2'] = mt_rand(5000, 9500)/100;
					$total += $this->atmosphere['composition']['N2'];
					if (mt_rand(0,1))
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
				$this->_greenhouse();
		}
		else
		{
			$this->atmosphere = NULL;
		}
	}

	private function _greenhouse()
	{
		if ( ! $this->type)
		{
			$this->atmosphere['greenhouse']	= $this->atmosphere['composition']['CO2']*$this->atmosphere['pressure']/35;
			if ($this->atmosphere['greenhouse'] > 1) $this->atmosphere['greenhouse'] = pow($this->atmosphere['greenhouse'], 0.637);
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

		if ($this->orbit['sma'] > $tidal_lock)
		{
			$this->rotation['axTilt']	= (mt_rand(0, 1) ? mt_rand(2000, 3000) : mt_rand(0, 18000))/100;

			if ($this->rotation['axTilt'] >= 90)
			{
				$this->rotation['period']	= mt_rand(50000, 25000000);
			}
			else
			{
				$this->rotation['period']	= mt_rand(18000, 180000);
			}
		}
		elseif ($this->orbit['sma'] > $tidal_lock/2)
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
				$day	= $this->rotation['period']/(1-$this->rotation['period']/$this->orbit['period']);
			}
			elseif ($this->rotation['period'] < 0)
			{
				$day	= $this->rotation['period']/(1+$this->rotation['period']/$this->orbit['period']);
			}
			else
			{
				$day	= 0;
			}
		}

		$this->rotation['day']	= $day;
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
		if ( ! $this->type)
		{
			$CI		=& get_instance();

			$l		= $this->star->luminosity*$CI->config->item('sun_luminosity');
			$this->temperature['eff']	= pow(($l*(1-$this->albedo))/(16*M_PI*$CI->config->item('Boltzman_constant')*pow($this->orbit['apa']*$CI->config->item('AU'), 2)),1/4);

			//ERROR: En planetas muy cercanos a estrellas muy calientes, la temperatura se voltea al negativo en 32 bits
			//Se debe hacer que la temperatura media no pueda superar los 3.000K, más o menos, así que en casos de muy, muy
			//alta temperatura, se destruye la atmósfera, y se crea un super planeta caliente.
			if ($this->atmosphere['greenhouse'] <= 1)
			{
				$this->temperature['avg']	= $this->temperature['eff']+$this->atmosphere['greenhouse']*20+mt_rand(0, 15)*$this->atmosphere['greenhouse'];
			}
			else
			{
				$this->temperature['avg']	= $this->temperature['eff']+pow($this->atmosphere['greenhouse'], 1.225)+25+mt_rand(0, 10);
			}

			if ($this->rotation['axTilt'] < 10 OR $this->rotation['axTilt'] > 170)
			{
				//TODO Todavía esta fórmula no es realista

		//		$change	= $this->temperature['avg']*$this->rotation['day']/$this->atmosphere['greenhouse'];

		//		$this->temperature['min']	= $this->temperature['avg']-mt_rand(round($change*0.8*10), round($change*1.2*10))/10;
		//		$this->temperature['max']	= $this->temperature['avg']+mt_rand(round($change*0.8*10), round($change*1.2*10))/10;

				//Solo se tiene en cuenta la duración del día y el efecto invernadero
				//Como en Venus o Mercurio
			}
			elseif ($this->rotation['axTilt'] > 50 && $this->rotation['axTilt'] < 130)
			{
				//Se considera un planeta acoplado
				//Como Mercurio, pero más exagerado, o como Venus pero más exagerado
				//También hay que tener en cuenta la duración del día
			}
			else
			{
				//Estaciones, etc, como en la Tierra o Marte
				//Pero hay que tener en cuenta la duración del día
			}
			/*
			 * Si la inclinación es pequeña solo se tiene en cuenta la duración del día (-10º) Si es grande (+10º)
			 * se tiene en cuenta también las estaciones y los polos. Si es muy grande (+50º) se
			 * considera como si fuera un planeta acoplado.
			 *
			 * El efecto invernadero se aplica a las temperaturas máximas, pero a las mínimas solo si
			 * el planeta no se considera acoplado.
			 *
			 * Aquí hay problemas a la hora de hacer el cálculo realista, ya que no hay suficientes datos de planetas
			 * rocosos.
			 */
		}
	}

	private function _ground()
	{
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
	}
}


/* End of file planet.php */
/* Location: ./space_settler/entities/bodies/planet.php */