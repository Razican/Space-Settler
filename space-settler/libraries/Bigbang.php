<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Bigbang Class
 *
 * @subpackage	Libraries
 * @author		Razican
 * @category	Libraries
 * @link		http://www.razican.com/
 */

class Bigbang
{
	public	$current_stars;
	public	$current_bodies;
	public	$stars			= array();
	private	$stars_p		= array();
	public	$planets		= array();
	public	$moons			= array();
	private	$galaxy			= NULL;
	private	$last_planet	= 0;

	public function __construct()
	{
		$CI =& get_instance();
		$CI->config->load('physics');
	}

	/**
	 * Create a planet
	 *
	 * @access	public
	 * @param	int		$position
	 * @param	int		$star_id
	 * return	bool	Returns TRUE on success, False on failure
	 */
	public function create_planet($position, $star_id)
	{
		if(mt_rand(0,5))
		{
			$CI			=& get_instance();

			$distance	= $this->_distance($position, $star_id);
			$radius		= $this->_radius($distance, $star_id);

			$terrestrial	= ($radius < 14000000) || ($radius < 16000000 && mt_rand(0,1));

			$mass		= $this->_mass($radius, $terrestrial, $star_id);

			if($radius && $mass && $distance)
			{
				$mass		= round($mass/1E+19)*1E+19;
				$habitable	= $this->_is_habitable($distance, $radius, $mass, $terrestrial, $star_id);
				$water		= $habitable ? mt_rand(1,10000) : 0;
				$habitable	= $water > 1000 && $water < 9500;
				$density	= round($this->_density($radius, $mass)*100);
				$distance	= $distance*10000;
				$this->planets[] = array('star' => $star_id+$this->current_stars+1, 'position' => $position, 'terrestrial' => $terrestrial, 'double_planet' => FALSE, 'mass' => $mass/1E+19, 'radius' => $radius, 'density' => $density, 'distance' => $distance, 'habitable' => $habitable, 'water' => $water);
				$this->create_moons($star_id);
				$this->last_planet++;
				return TRUE;
			}
			log_message('error', 'No se ha creado el planeta.');
		}
		return FALSE;
	}

	/**
	 * Create moons for a planet
	 *
	 * @access	public
	 * @param	int		$star
	 * @return	void
	 */
	public function create_moons($star)
	{
		$CI					=& get_instance();

		$planet_id			= $this->last_planet;
		$planet_db			= $planet_id+1+$this->current_bodies;
		$planet				= $this->planets[$planet_id];
		$planet_mass		= $planet['mass']*1E+19;
		$star_mass			= $this->stars[$star]['mass']*$CI->config->item('sun_mass')/100;
		$planet_distance	= $planet['distance']/10000;
		$double_planet		= ($planet_mass < 5E+22 && $planet_distance > 30) ? (mt_rand(0,2) === 2) : FALSE;
		$max_distance		= round($planet_distance*$CI->config->item('AU')*pow($planet_mass/(3*$star_mass),1/3)/$planet['radius']*10000)/10000;
		$titius_m			= mt_rand(2500, 6000)/10000;
		$titius_n			= mt_rand(11E+4, 13E+4)/10000;

		if($double_planet)
		{
			$mass			= IS_64 ? mt_rand(round($planet_mass/1E+11), round($planet_mass/2E+10))*1E+10 : mt_rand(round($planet_mass/1E+21), round($planet_mass/2E+20))*1E+20;
			$density		= mt_rand(15E+4, 2E+5)/100;
			$distance		= round(mt_rand(15E+6, (25E+6 > $max_distance*$planet['radius'] ? round($max_distance*$planet['radius']) : 25E+6))/$planet['radius']*10000)/10000;

			if($mass && $density && $distance)
			{
				$radius		= round(pow(3*$mass/(4*M_PI*$density),1/3));
				$habitable	= $this->_is_habitable($planet_distance, $radius, $mass, TRUE, $star);
				$water		= $habitable ? mt_rand(1,10000) : 0;
				$habitable	= $water > 1000 && $water < 9500;

				$mass		= round($mass/1E+17)*1E+17;

				$this->moons[]	= array('star' => $star+$this->current_stars+1, 'position' => 1, 'type' => 1, 'terrestrial' => TRUE, 'double_planet' => TRUE, 'planet' => $planet_db, 'mass' => $mass/1E+17, 'radius' => $radius, 'density' => $density*100, 'distance' => $distance, 'habitable' => $habitable, 'water' => $water);
				$this->planets[$planet_id]['double_planet'] = TRUE;
			}
		}

		/*$max_moons			= round(pow($planet_mass/$CI->config->item('earth_mass'), 0.06))-25;
		$max_moons			= $max_moons < 0 ? 0 : $max_moons;
		$max_radius			= $planet['radius']/3.5 > 3000000 ? 3000000 : round($planet['radius']/3.5);
		$max_mass			= $planet_mass > (1E+2/3)*$CI->config->item('earth_mass') ? 1/30*$CI->config->item('earth_mass') : $planet_mass/1E+6;

		for($i=$double_planet; $i <= $max_moons; $i++)
		{
			if(mt_rand(0, $max_moons) > mt_rand(0, round($max_moons/2)))
			{
				if($i === $max_moons && $max_moons === 1)
					$distance	= mt_rand(2E+5, $max_distance*10000);
				else
					$distance	= round(exp(($titius_m*($i+1) - $titius_n))*10000);

				$distance	= mt_rand(round($distance*0.9), round($distance*1.1))/10000;

				if($distance > $max_distance) break;

				$radius		= mt_rand(10000, $max_radius);
				$density	= mt_rand(150000, 700000);
				$mass		= round(volume($radius)*$density/100);
				$mass		= $mass > $max_mass ? mt_rand(round($max_mass*0.95), round($max_mass)) : $mass;
				$mass		= round($mass/1E+17)*1E+17;

				if($radius && $mass && $distance && $planet)
				{
					$habitable	= $this->_is_habitable($planet_distance, $radius, $mass, $star);
					$water		= $habitable ? mt_rand(1,10000) : 0;
					$habitable	= $water > 1000 && $water < 9500;
					$density	= round($this->_density($radius, $mass*$CI->config->item('earth_mass')/1E+17));
					$this->moons[] = array('star' => $star+$this->current_stars+1, 'position' => $i+1, 'type' => 1, 'planet' => $planet, 'mass' => $mass, 'radius' => $radius, 'density' => $density, 'distance' => $distance, 'habitable' => $habitable, 'water' => $water, 'double_planet' => 0);
				}
			}
		}*/
	}
	/**
	 * Create a star
	 *
	 * @access	public
	 * @param	int		$system
	 * @return	bool	Returns TRUE on success, False on failure
	 */
	public function create_star($system)
	{
		$CI		=& get_instance();
		if ( ! $this->galaxy)
		{
			$CI->db->select_max('galaxy');
			$CI->db->limit(1);
			$query	= $CI->db->get('stars');
			if($query->num_rows() > 0)
				foreach($query->result() as $star) $this->galaxy = $star->galaxy ? $star->galaxy+1 : 1;
		}
		$galaxy = $this->galaxy;

		$type	= substr($CI->config->item('star_types'), mt_rand(0, 6), 1);

		switch($type)
		{
			case 'O':
				$mass			= mt_rand(36E+2, 65E+2);
				$temperature	= mt_rand(28000, 50000);
				$radius			= mt_rand(900, 2500);
			break;
			case 'B':
				$mass			= mt_rand(650, 36E+2);
				$temperature	= mt_rand(9600, 28000);
				$radius			= mt_rand(490, 1000);
			break;
			case 'A':
				$mass			= mt_rand(240, 650);
				$temperature	= mt_rand(7100, 9600);
				$radius			= mt_rand(150, 490);
			break;
			case 'F':
				$mass			= mt_rand(140, 240);
				$temperature	= mt_rand(5700, 7100);
				$radius			= mt_rand(120, 150);
			break;
			case 'G':
				$mass			= mt_rand(95, 140);
				$temperature	= mt_rand(4600, 5700);
				$radius			= mt_rand(100, 120);
			break;
			case 'K':
				$mass			= mt_rand(55, 95);
				$temperature	= mt_rand(3200, 4600);
				$radius			= mt_rand(65, 100);
			break;
			case 'M':
				$mass			= mt_rand(16, 55);
				$temperature	= mt_rand(1700, 3200);
				$radius			= mt_rand(24, 65);
		}

		$luminosity				= round(4*M_PI*pow($radius*$CI->config->item('sun_radius')/100, 2)*$CI->config->item('Boltzman_constant')*pow($temperature, 4)*1E+12/$CI->config->item('sun_luminosity'));

		if($mass && $radius && $temperature && $luminosity)
		{
			$this->stars[]		= array('galaxy' => $galaxy, 'system' => $system, 'type' => $type, 'mass' => $mass, 'radius' => $radius, 'luminosity' => $luminosity, 'temperature' => $temperature);
			$max_mass			= round($mass*$CI->config->item('sun_mass')/50000);
			$this->stars_p[]	= array('max_radius' => round($radius*$CI->config->item('sun_radius')/500), 'max_mass' => ($max_mass > 19E+27 ? 19E+27 : $max_mass));
			return TRUE;
		}
		log_message('error', 'No se ha creado la estrella.');
		return FALSE;
	}

	/**
	 * Calculate the density of an object based on its radius and mass
	 *
	 * @access	private
	 * @param	int		$radius	(m)
	 * @param	int		$mass	(Kg)
	 * @return	int		Density (Kg/m³)
	 */
	private function _density($radius, $mass)
	{
		return ($mass/volume($radius));
	}

	/**
	 * Calculate a planet's distance to sun based on its position,
	 * using Titius-Bode Law.
	 *
	 * @access	private
	 * @param	int		$position
	 * @param	int		$star_id
	 * @return	int		Distance (AU)
	 */
	private function _distance($position, $star_id)
	{
		if( ! isset($this->stars_p[$star_id]['m']))
		{
			$this->stars_p[$star_id]['m']		= mt_rand(15E+2, 95E+2)/1E+4;
			$this->stars_p[$star_id]['n']		= mt_rand(125E+2, 525E+2)/1E+4;
			if(exp(($this->stars_p[$star_id]['m']*10 - $this->stars_p[$star_id]['n']) > 1000))
				$this->stars_p[$star_id]['m']	= log(1000 + $this->stars_p[$star_id]['n'])/10;
		}
		$m			= $this->stars_p[$star_id]['m'];
		$n			= $this->stars_p[$star_id]['n'];

		$distance	= exp(($m*$position - $n))*10000;
		return mt_rand(round($distance*0.9), round($distance*1.1))/10000;
	}

	/**
	 * Return the size of a future planet based on its position and star
	 *
	 * @access	private
	 * @param	int		$distance	(AU)
	 * @param	int		$star_id
	 * @return	int		Radius		(m)
	 */
	private function _radius($distance, $star_id)
	{
		$CI											=& get_instance();
		$probability								= mt_rand(1, 100);
		$max_radius									= $this->stars_p[$star_id]['max_radius'];

		if($distance < 4)
		{
			if($probability <= 25) $radius		= mt_rand(4E+5, 1E+6);
			elseif($probability <= 90) $radius	= mt_rand(1E+6, 15E+6);
			else $radius						= mt_rand(15E+6, 125E+6);
		} elseif($distance < 35)
		{
			if($probability <= 20) $radius		= mt_rand(4E+5, 1E+6);
			elseif($probability <= 50) $radius	= mt_rand(1E+6, 15E+6);
			else $radius						= mt_rand(15E+6, 125E+6);
		} else {
			$radius								= mt_rand(4E+5, 15E+5);
		}

		return $radius > $max_radius ? mt_rand(round($max_radius*0.95), round($max_radius)) : $radius;
	}

	/**
	 * Decide whether a planet is habitable or not
	 *
	 * @access	private
	 * @param	int		$distance	(AU)
	 * @param	int		$radius		(m)
	 * @param	int		$mass		(Kg)
	 * @param	bool	$terrestrial
	 * @param	int		$star_id
	 * @return	bool	Whether the body is habitable or not
	 */
	private function _is_habitable($distance, $radius, $mass, $terrestrial, $star_id)
	{
		$CI					=& get_instance();

		$habitable_zone		= sqrt($this->stars[$star_id]['luminosity']/1E+12)*100;
		$habitable_zone_min	= round($habitable_zone*0.85);
		$habitable_zone_max	= round($habitable_zone*1.2);
		$gravity			= gravity($mass, $radius);
		$density			= $this->_density($radius, $mass);

		$habitable			= 	($terrestrial)						&&
								($distance	> $habitable_zone_min)	&&
								($distance	< $habitable_zone_max)	&&
								($gravity	> 2) && ($gravity < 20);

		return $habitable;
	}

	/**
	 * Return the mass of a planet based on
	 *
	 * @access	private
	 * @param	int		$radius (m)
	 * @param	bool	$terrestrial Whether the planet is terrestrial or not
	 * @param	int		$star_id
	 * @return	int		Mass	(Kg)
	 */
	private function _mass($radius, $terrestrial, $star_id)
	{
		$CI			=& get_instance();
		$max_mass	= $this->stars_p[$star_id]['max_mass'];

		if($terrestrial)
		{
			if($radius < 1250000)		$density	= mt_rand(15E+4, 275E+3);
			elseif($radius < 7500000)	$density	= mt_rand(27E+4, 65E+4);
			else						$density	= mt_rand(55E+4, 15E+5);
		} else							$density	= mt_rand(15E+3, 125E+4);

		$density	= $density/100;

		$mass		= round(volume($radius)*$density);
		if($mass > $max_mass)
			$mass	= IS_64 ? mt_rand(round($max_mass*0.95/1E+10), round($max_mass/1E+10))*1E+10 : mt_rand(round($max_mass*0.95)/1E+20, round($max_mass/1E+20))*1E+20;

		return $mass;
	}
}


/* End of file Bigbang.php */
/* Location: ./space_settler/libraries/Bigbang.php */