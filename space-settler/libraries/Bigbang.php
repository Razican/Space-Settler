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
	 * @param	int
	 * @param	int
	 */
	public function create_planet($position, $star_id)
	{
		$CI			=& get_instance();

		$distance	= $this->_distance($position, $star_id);
		$radius		= $this->_radius($position, $star_id);
		$mass		= $this->_mass($radius, $star_id);
		$habitable	= $this->_is_habitable($distance, $radius, $mass, $star_id);
		$water		= $habitable ? mt_rand(100,10000) : 0;

		if($radius && $mass && $distance)
		{
			$this->planets[] = array('star' => $star_id+$this->current_stars+1, 'position' => $position, 'mass' => $mass, 'radius' => $radius, 'distance' => $distance, 'habitable' => $habitable, 'water' => $water);
			$this->create_moons($star_id);
			$this->last_planet++;
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Create moons for a planet
	 *
	 * @access	public
	 * @param	int
	 */
	public function create_moons($star)
	{
		$CI				=& get_instance();

		$planet_id		= $this->last_planet;
		$planet			= $this->planets[$planet_id];
		$double_planet	= $planet['mass'] < 100 ? mt_rand(0,1) : 0;
		$moon_num		= round(pow($planet['mass'], 0.34));
		$min_moons		= $moon_num > 20 ? $moon_num - 20 : 0;
		$max_moons		= 3+$moon_num;
		$moon_num		= mt_rand($min_moons, $max_moons);
		$max_mass		= $planet['mass'] > 25000 ? 50 : $planet['mass']/5;
		$star_distance	= $planet['distance'];
		$max_distance	= 10000;

		//Falta el doble planeta

		for($i=0; $i<$moon_num; $i++)
		{
			$radius		= mt_rand(10000, 3000000);
			$density	= mt_rand(150000, 700000);
			$mass		= round(volume($radius)*$density);
			$mass		= $mass > $max_mass ? mt_rand($max_mass*0.95, $max_mass) : $mass;
			$mass		= round($mass/$CI->config->item('earth_mass')*1E+17); //masas terrestres MAL
			$distance	= ($i+1)*($max_distance-100)/$moon_num+100;
			$distance	= mt_rand(round($distance*0.95), round($distance*1.05));
			$habitable	= $this->_is_habitable($star_distance, $radius, $mass, $star);
			$water		= $habitable ? mt_rand(100,10000) : 0;
			$planet		= $planet_id+1+$this->current_bodies;

			//if($radius && $mass && $distance && $planet)
				$this->moons[] = array('star' => $star+$this->current_stars+1, 'position' => $i+1, 'type' => 1, 'planet' => $planet, 'mass' => $mass, 'radius' => $radius, 'distance' => $distance, 'habitable' => $habitable, 'water' => $water);
		}
	}
	/**
	 * Create a star
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 */
	public function create_star($system)
	{
		$CI		=& get_instance();
		if ( ! $this->galaxy)
		{
			$CI->db->select_max('galaxy');
			$CI->db->select('galaxy');
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

		$luminosity				= round(pow($radius/10000, 2)*$CI->config->item('Boltzman_constant')*pow($temperature, 4)*1E+12);

		if($mass && $radius && $temperature && $luminosity)
		{
			$this->stars[]		= array('galaxy' => $galaxy, 'system' => $system, 'type' => $type, 'mass' => $mass, 'radius' => $radius, 'luminosity' => $luminosity, 'temperature' => $temperature);
			$this->stars_p[]	= array();
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Calculate a planet's distance to sun based on its position,
	 * using Titius-Bode Law.
	 *
	 * @access	private
	 * @param	int
	 * @param	int
	 */
	private function _distance($position, $star_id)
	{
		if( ! isset($this->stars_p[$star_id]['m']))
		{
			$this->stars_p[$star_id]['m']	= mt_rand(35E+3, 6E+5)/1E+6;
			$n		= 25*log($this->stars_p[$star_id]['m']/12+1)+0.4;//MAL
			$this->stars_p[$star_id]['n']	= mt_rand(round($n*999E+3), round($n*1001E+3))/1E+6;
		}
		$m			= $this->stars_p[$star_id]['m'];
		$n			= $this->stars_p[$star_id]['n'];

		$distance	= exp(($m*$position - $n))*100;
		return mt_rand(round($distance*0.9), round($distance*1.1));
	}

	/**
	 * Return the size of a future planet based on its position and star
	 *
	 * @access	private
	 * @param	int
	 * @param	int
	 * @return	int
	 */
	private function _radius($position, $star_id)
	{
		$CI											=& get_instance();
		$probability								= mt_rand(1, 100);
		$this->stars_p[$star_id]['max_radius']		= isset($this->stars_p[$star_id]['max_radius']) ? $this->stars_p[$star_id]['max_radius'] : $this->stars[$star_id]['radius']*$CI->config->item('sun_radius')/5000;
		$max_radius									= $this->stars_p[$star_id]['max_radius'];

		if($position < 5)
		{
			if($probability <= 10) $radius		= mt_rand(375E+3, 1875E+3);
			elseif($probability <= 40) $radius	= mt_rand(1875E+3, 375E+4);
			elseif($probability <= 70) $radius	= mt_rand(375E+4, 5625E+3);
			elseif($probability <= 85) $radius	= mt_rand(5625E+3, 1125E+4);
			elseif($probability <= 95) $radius	= mt_rand(1125E+4, 25E+6);
			else $radius						= mt_rand(25E+6, 85E+6);
		} elseif($position < 10)
		{
			if($probability <= 5) $radius		= mt_rand(375E+3, 1875E+3);
			elseif($probability <= 30) $radius	= mt_rand(1875E+3, 375E+4);
			elseif($probability <= 50) $radius	= mt_rand(375E+4, 5625E+3);
			elseif($probability <= 65) $radius	= mt_rand(5625E+3, 1125E+4);
			elseif($probability <= 95) $radius	= mt_rand(1125E+4, 25E+6);
			else $radius						= mt_rand(25E+6, 85E+6);
		} else {
			if($probability <= 50) $radius		= mt_rand(375E+3, 1875E+3);
			elseif($probability <= 80) $radius	= mt_rand(1875E+3, 375E+4);
			elseif($probability <= 95) $radius	= mt_rand(375E+4, 5625E+3);
			elseif($probability <= 99) $radius	= mt_rand(1125E+4, 25E+6);
			else $radius						= mt_rand(25E+6, 85E+6);
		}

		return $radius;// > $max_radius ? mt_rand($max_radius*0.95, $max_radius) : $radius;
	}

	/**
	 * Decide whether a planet is habitable or not
	 *
	 * @access	private
	 * @param	int
	 * @param	int
	 * @param	int
	 * @param	int
	 */
	private function _is_habitable($distance, $radius, $mass, $star_id)
	{
		$CI					=& get_instance();
		$habitable_zone		= sqrt($this->stars[$star_id]['luminosity']*1E-12)*100;
		$habitable_zone_min	= round($habitable_zone*0.95);
		$habitable_zone_max	= round($habitable_zone*1.05);
		$gravity			= $CI->config->item('G')*$mass*$CI->config->item('earth_mass')/pow($radius, 2)/10000;
		$density			= $mass*$CI->config->item('earth_mass')/(volume($radius)*100);

		if(	($distance	< $habitable_zone_min) OR
			($distance	> $habitable_zone_max) OR
			($gravity	< 3) OR ($gravity > 15) OR
			($density	< 1500)) return 0;

		return 1;
	}

	/**
	 * Return the mass of a planet based on
	 *
	 * @access	private
	 * @param	int
	 * @param	int
	 * @param	int
	 * @param	int
	 */
	private function _mass($radius, $star_id)
	{
		$CI		=& get_instance();

		$this->stars_p[$star_id]['max_mass']	= isset($this->stars_p[$star_id]['max_mass']) ? $this->stars_p[$star_id]['max_mass'] : round($this->stars[$star_id]['mass']*$CI->config->item('sun_mass')/(50000*$CI->config->item('earth_mass')));
		$this->stars_p[$star_id]['max_mass']	= $this->stars_p[$star_id]['max_mass'] > 60000000 ? 60000000 : $this->stars_p[$star_id]['max_mass'];
		$max_mass = $this->stars_p[$star_id]['max_mass'];

		if($radius < 1E+6)		$density	= mt_rand(15000000, 30000000);
		elseif($radius < 16E+6) $density	= mt_rand(30000000, 150000000);
		elseif($radius < 65E+6) $density	= mt_rand(15000000, 30000000);
		else					$density	= mt_rand(1500000, 15000000);

		$mass	= round(volume($radius)*$density/$CI->config->item('earth_mass'));
		$mass	= $mass > $max_mass ? mt_rand(round($max_mass*0.95), $max_mass) : $mass;

		return $mass;
	}
}

/* End of file Bigbang.php */
/* Location: ./space_settler/libraries/Bigbang.php */