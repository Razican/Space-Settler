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
	public	$stars		= array();
	private	$stars_p	= array();
	public	$planets	= array();

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

		if($radius && $mass && $distance)
		{
			$this->planets[] = array('system' => $star_id+1, 'position' => $position, 'mass' => $mass, 'radius' => $radius, 'distance' => $distance, 'habitable' => $habitable);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Create a star
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 */
	public function create_star($galaxy, $system)
	{
		$CI		=& get_instance();

		$type	= substr($CI->config->item('star_types'), mt_rand(0, 6), 1);

		switch($type)
		{
			case 'O':
				$mass			= mt_rand(3600, 5E+3);
				$temperature	= mt_rand(28E+5, 5E+6);
				$radius			= mt_rand(900, 2500);
			break;
			case 'B':
				$mass			= mt_rand(650, 3600);
				$temperature	= mt_rand(96E+4, 28E+5);
				$radius			= mt_rand(490, 1E+3);
			break;
			case 'A':
				$mass			= mt_rand(240, 650);
				$temperature	= mt_rand(71E+4, 96E+4);
				$radius			= mt_rand(150, 490);
			break;
			case 'F':
				$mass			= mt_rand(140, 240);
				$temperature	= mt_rand(57E+4, 71E+4);
				$radius			= mt_rand(120, 150);
			break;
			case 'G':
				$mass			= mt_rand(95, 140);
				$temperature	= mt_rand(46E+4, 57E+4);
				$radius			= mt_rand(100, 120);
			break;
			case 'K':
				$mass			= mt_rand(55, 95);
				$temperature	= mt_rand(32E+4, 46E+4);
				$radius			= mt_rand(65, 100);
			break;
			case 'M':
				$mass			= mt_rand(16, 55);
				$temperature	= mt_rand(1700, 3200);
				$radius			= mt_rand(24, 65);
		}

		$luminosity				= round(pow($radius/100, 2)*$CI->config->item('Boltzman_constant')*pow($temperature/100, 4)*1E+12);

		if($mass && $radius && $temperature && $luminosity)
		{
			$this->stars[]		= array('galaxy' => $galaxy, 'system' => $system, 'type' => $type, 'mass' => $mass, 'radius' => $radius, 'luminosity' => $luminosity, 'temperature' => $temperature);
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
	 * @return	array
	 */
	private function _radius($position, $star_id)
	{
		$CI											=& get_instance();
		$probability								= mt_rand(1, 100);
		$this->stars_p[$star_id]['max_radius']		= isset($this->stars_p[$star_id]['max_radius']) ? $this->stars_p[$star_id]['max_radius'] : $this->stars[$star_id]['radius']*$CI->config->item('sun_radius')/500;
		$max_radius									= $this->stars_p[$star_id]['max_radius'];

		switch($position)
		{
			case 1:
				if($probability <= 10) $radius		= mt_rand(375E+3, 1875E+3);
				elseif($probability <= 25) $radius	= mt_rand(1875E+3, 375E+4);
				elseif($probability <= 28) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 30) $radius	= mt_rand(5625E+3, 1125E+4);
				else $radius						= mt_rand(1125E+4, 121875E+3);
			break;
			case 2:
				if($probability <= 5) $radius		= mt_rand(375E+3, 1875E+3);
				elseif($probability <= 30) $radius	= mt_rand(1875E+3, 375E+4);
				elseif($probability <= 40) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 55) $radius	= mt_rand(5625E+3, 1125E+4);
				else $radius						= mt_rand(1125E+4, 7875E+4);
			break;
			case 3:
				if($probability <= 1) $radius		= mt_rand(375E+3, 1875E+3);
				elseif($probability <= 31) $radius	= mt_rand(1875E+3, 375E+4);
				elseif($probability <= 50) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 65) $radius	= mt_rand(5625E+3, 1125E+4);
				else $radius						= mt_rand(1125E+4, 75E+6);
			break;
			case 4:
				if($probability <= 10) $radius		= mt_rand(375E+3, 1875E+3);
				elseif($probability <= 35) $radius	= mt_rand(1875E+3, 375E+4);
				elseif($probability <= 65) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 75) $radius	= mt_rand(5625E+3, 1125E+4);
				else $radius						= mt_rand(1125E+4, 84375E+3);
			break;
			case 5:
				if($probability <= 2) $radius		= mt_rand(375E+3, 1875E+3);
				elseif($probability <= 5) $radius	= mt_rand(1875E+3, 375E+4);
				elseif($probability <= 25) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 50) $radius	= mt_rand(5625E+3, 1125E+4);
				else $radius						= mt_rand(1125E+4, 65625E+3);
			break;
			case 6:
				if($probability <= 5) $radius		= mt_rand(375E+3, 1875E+3);
				elseif($probability <= 15) $radius	= mt_rand(1875E+3, 375E+4);
				elseif($probability <= 25) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 45) $radius	= mt_rand(5625E+3, 1125E+4);
				else $radius						= mt_rand(1125E+4, 75E+6);
			break;
			case 7:
				if($probability <= 10) $radius		= mt_rand(375E+3, 1875E+3);
				elseif($probability <= 30) $radius	= mt_rand(1875E+3, 375E+4);
				elseif($probability <= 40) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 60) $radius	= mt_rand(5625E+3, 1125E+4);
				else $radius						= mt_rand(1125E+4, 5625E+4);
			break;
			case 8:
				if($probability <= 20) $radius		= mt_rand(375E+3, 1875E+3);
				elseif($probability <= 45) $radius	= mt_rand(1875E+3, 375E+4);
				elseif($probability <= 55) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 70) $radius	= mt_rand(5625E+3, 1125E+4);
				else $radius						= mt_rand(1125E+4, 375E+5);
			break;
			case 9:
				if($probability <= 30) $radius		= mt_rand(375E+3, 1875E+3);
				elseif($probability <= 55) $radius	= mt_rand(1875E+3, 375E+4);
				elseif($probability <= 70) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 80) $radius	= mt_rand(5625E+3, 1125E+4);
				else $radius						= mt_rand(1125E+4, 225E+5);
			break;
			case 10:
				if($probability <= 40) $radius		= mt_rand(375E+3, 1875E+3);
				elseif($probability <= 70) $radius	= mt_rand(1875E+3, 375E+4);
				elseif($probability <= 80) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 85) $radius	= mt_rand(5625E+3, 1125E+4);
				else $radius						= mt_rand(1125E+4, 1875E+4);
			break;
			case 11:
				if($probability <= 40) $radius		= mt_rand(375E+3, 1875E+3);
				elseif($probability <= 83) $radius	= mt_rand(1875E+3, 375E+4);
				elseif($probability <= 88) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 90) $radius	= mt_rand(5625E+3, 1125E+4);
				else $radius						= mt_rand(1125E+4, 1875E+4);
			break;
			case 12:
				if($probability <= 60) $radius		= mt_rand(375E+3, 1875E+3);
				elseif($probability <= 90) $radius	= mt_rand(1875E+3, 375E+4);
				elseif($probability <= 93) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 95) $radius	= mt_rand(5625E+3, 9375E+3);
				else $radius						= mt_rand(9375E+3, 15E+6);
			break;
			case 13:
				if($probability <= 65) $radius		= mt_rand(375E+3, 1875E+3);
				elseif($probability <= 95) $radius	= mt_rand(1875E+3, 375E+4);
				elseif($probability <= 97) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 98) $radius	= mt_rand(5625E+3, 1125E+4);
				else $radius						= mt_rand(1125E+4, 1875E+4);
			break;
			case 14:
				if($probability <= 70) $radius		= mt_rand(375E+3, 1875E+3);
				elseif($probability <= 97) $radius	= mt_rand(1875E+3, 375E+4);
				elseif($probability <= 98) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 99) $radius	= mt_rand(5625E+3, 9375E+3);
				else $radius						= mt_rand(9375E+3, 15E+6);
			break;
			case 15:
				if($probability <= 75) $radius		= mt_rand(375E+3, 1875E+3);
				elseif($probability <= 95) $radius	= mt_rand(1875E+3, 375E+4);
				elseif($probability <= 96) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 97) $radius	= mt_rand(5625E+3, 1125E+4);
				else $radius						= mt_rand(1125E+4, 15E+6);
			break;
			case 16:
				if($probability <= 80) $radius		= mt_rand(375E+3, 1875E+3);
				elseif($probability <= 93) $radius	= mt_rand(1875E+3, 375E+4);
				elseif($probability <= 94) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 95) $radius	= mt_rand(5625E+3, 9375E+3);
				else $radius						= mt_rand(9375E+3, 15E+6);
			break;
			case 17:
				if($probability <= 83) $radius		= mt_rand(375E+3, 15E+5);
				elseif($probability <= 93) $radius	= mt_rand(15E+5, 375E+4);
				elseif($probability <= 94) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 95) $radius	= mt_rand(5625E+3, 1125E+4);
				else $radius						= mt_rand(1125E+4, 1875E+4);
			break;
			case 18:
				if($probability <= 90) $radius		= mt_rand(375E+3, 15E+5);
				elseif($probability <= 94) $radius	= mt_rand(15E+5, 375E+4);
				elseif($probability <= 95) $radius	= mt_rand(375E+4, 5625E+3);
				elseif($probability <= 96) $radius	= mt_rand(5625E+3, 1125E+4);
				else $radius						= mt_rand(1125E+4, 1875E+4);
			break;
			case 19:
				if($probability <= 92) $radius		= mt_rand(375E+3, 1125E+3);
				elseif($probability <= 95) $radius	= mt_rand(1125E+3, 3375E+3);
				elseif($probability <= 96) $radius	= mt_rand(3375E+3, 525E+4);
				elseif($probability <= 97) $radius	= mt_rand(525E+4, 75E+5);
				else $radius						= mt_rand(75E+5, 1125E+4);
			break;
			case 20:
				if($probability <= 94) $radius		= mt_rand(375E+3, 1125E+3);
				elseif($probability <= 96) $radius	= mt_rand(1125E+3, 28125E+2);
				elseif($probability <= 97) $radius	= mt_rand(28125E+2, 45E+5);
				elseif($probability <= 98) $radius	= mt_rand(45E+5, 6E+6);
				else $radius						= mt_rand(6E+6, 75E+5);
			break;
		}
		return $radius > $max_radius ? round(mt_rand(round($max_radius*0.95), round($max_radius))/$CI->config->item('earth_radius')*100) : round($radius/$CI->config->item('earth_radius')*100);
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
		$habitable_zone		= sqrt($this->stars[$star_id]['luminosity']*1E-12)*100;
		$habitable_zone_min	= round($habitable_zone*0.95);
		$habitable_zone_max	= round($habitable_zone*1.05);

		if(($distance < $habitable_zone_min) OR ($distance > $habitable_zone_max)) return 0;

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
		$CI	=& get_instance();

		$radius									= $radius/100;
		$this->stars_p[$star_id]['max_mass']	= isset($this->stars_p[$star_id]['max_mass']) ? $this->stars_p[$star_id]['max_mass'] : $this->stars[$star_id]['mass']*$CI->config->item('sun_mass')/500;
		$max_mass = $this->stars_p[$star_id]['max_mass'];

		if($radius < 2.5) $density		= mt_rand(300000, 1500000);
		elseif($radius < 10) $density	= mt_rand(150000, 300000);
		else $density					= mt_rand(15000, 150000);

		$mass	= round(4*M_PI*pow($radius*$CI->config->item('earth_radius'), 3)*$density);
		$mass	= $mass > $max_mass ? mt_rand(round($max_mass*0.95), round($max_mass)) : $mass;

		return round($mass/$CI->config->item('earth_mass'));
	}
}

/* End of file Bigbang.php */
/* Location: ./space_settler/libraries/Bigbang.php */