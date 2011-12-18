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
	var $stars		= array();
	var $planets	= array();

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

		$distance	= _distance($position, $star_id);
		$radius		= _radius($position, $star_id);
		$mass		= _mass($radius, $position, $star_id);
		$habitable	= _is_habitable($distance, $radius, $mass, $star_id);

		if($diameter && $mass && $distance)
		{
			$planet	= array('system' => $star_id, 'position' => $position, 'mass' => $mass, 'radius' => $radius, 'distance' => $distance, 'habitable' => $habitable);
			$this->planets[] = $planet;
			return $CI->db->insert('bodies', $planet);
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
		$CI->load->config('phisics');

		$type	= substr($CI->config->item('star_types'), mt_rand(0, 6), 1);

		switch($type)
		{
			case 'O':
				$mass			= mt_rand(3600, 10000);
				$temperature	= mt_rand(2800000, 5000000);
				$radius			= mt_rand(900, 2500);
			break;
			case 'B':
				$mass			= mt_rand(650, 3600);
				$temperature	= mt_rand(960000, 2800000);
				$radius			= mt_rand(490, 1000);
			break;
			case 'A':
				$mass			= mt_rand(240, 650);
				$temperature	= mt_rand(710000, 960000);
				$diameter		= mt_rand(150, 490);
			break;
			case 'F':
				$mass			= mt_rand(140, 240);
				$temperature	= mt_rand(570000, 710000);
				$radius			= mt_rand(120, 150);
			break;
			case 'G':
				$mass			= mt_rand(95, 140);
				$temperature	= mt_rand(460000, 570000);
				$radius			= mt_rand(100, 120);
			break;
			case 'K':
				$mass			= mt_rand(55, 95);
				$temperature	= mt_rand(320000, 460000);
				$radius			= mt_rand(65, 100);
			break;
			case 'M':
				$mass			= mt_rand(16, 55);
				$temperature	= mt_rand(1700, 3200);
				$radius			= mt_rand(24, 65);
		}

		$luminosity		= round(($radius/100, 2)*$CI->config->item('Stephan-Boltzman')*pow($temperature/100, 4)*100);

		if($mass && $radius && $temperature && $luminosity)
		{
			$star			= array('galaxy' => $galaxy, 'system' => $system, 'mass' => $mass, 'radius' => $radius, 'luminosity' => $luminosity, 'temperature' => $temperature);
			$this->stars[]	= $star;
			return $CI->db->insert('stars', $star);
		}
		return FALSE;
	}

	/**
	 * Calculate a planet's distance to sun based on its position,
	 * using Titius-Bode Law.
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 */
	private function _distance($position, $star_id)
	{
		if( ! isset($this->stars[$star_id]['m']))
		{
			$this->stars[$star_id]['m']	= mt_rand(35000, 650000)/1000000;
			$n = 13.9-25.25*log($this->stars[$star_id]['m']+1)
			$this->stars[$star_id]['n']	= mt_rand(round($n*999000), round(n)*1001000)/1000000;
		}
		$m	= $this->stars[$star_id]['m'];
		$n	= $this->stars[$star_id]['n'];

		$dist_value	= exp(($m*$position - $n))*100;
		$distance	= mt_rand(round($dist_value*0.9), round($dist_value*1.1));
	}

	/**
	 * Return the size of a future planet based on its position and star
	 *
	 * @access	private
	 * @param	array
	 * @return	array
	 */
	private function _size($position)
	{
		$probability		= mt_rand(1, 100);
		$max_size			= _max_size($position);

		switch($position['planet'])
		{
			case 1:
				if($probability <= 10) $size['fields'] = mt_rand(10, 50);
				elseif($probability <= 25) $size['fields'] = mt_rand(50, 100);
				elseif($probability <= 28) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 30) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 3250);
			break;
			case 2:
				if($probability <= 5) $size['fields'] = mt_rand(10, 50);
				elseif($probability <= 30) $size['fields'] = mt_rand(50, 100);
				elseif($probability <= 40) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 55) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 2100);
			break;
			case 3:
				if($probability <= 1) $size['fields'] = mt_rand(10, 50);
				elseif($probability <= 31) $size['fields'] = mt_rand(50, 100);
				elseif($probability <= 50) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 65) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 2000);
			break;
			case 4:
				if($probability <= 10) $size['fields'] = mt_rand(10, 50);
				elseif($probability <= 35) $size['fields'] = mt_rand(50, 100);
				elseif($probability <= 65) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 75) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 2250);
			break;
			case 5:
				if($probability <= 2) $size['fields'] = mt_rand(10, 50);
				elseif($probability <= 5) $size['fields'] = mt_rand(50, 100);
				elseif($probability <= 25) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 50) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 1750);
			break;
			case 6:
				if($probability <= 5) $size['fields'] = mt_rand(10, 50);
				elseif($probability <= 15) $size['fields'] = mt_rand(50, 100);
				elseif($probability <= 25) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 45) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 2000);
			break;
			case 7:
				if($probability <= 10) $size['fields'] = mt_rand(10, 50);
				elseif($probability <= 30) $size['fields'] = mt_rand(50, 100);
				elseif($probability <= 40) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 60) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 1500);
			break;
			case 8:
				if($probability <= 20) $size['fields'] = mt_rand(10, 50);
				elseif($probability <= 45) $size['fields'] = mt_rand(50, 100);
				elseif($probability <= 55) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 70) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 1000);
			break;
			case 9:
				if($probability <= 30) $size['fields'] = mt_rand(10, 50);
				elseif($probability <= 55) $size['fields'] = mt_rand(50, 100);
				elseif($probability <= 70) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 80) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 600);
			break;
			case 10:
				if($probability <= 40) $size['fields'] = mt_rand(10, 50);
				elseif($probability <= 70) $size['fields'] = mt_rand(50, 100);
				elseif($probability <= 80) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 85) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 500);
			break;
			case 11:
				if($probability <= 40) $size['fields'] = mt_rand(10, 50);
				elseif($probability <= 83) $size['fields'] = mt_rand(50, 100);
				elseif($probability <= 88) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 90) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 500);
			break;
			case 12:
				if($probability <= 60) $size['fields'] = mt_rand(10, 50);
				elseif($probability <= 90) $size['fields'] = mt_rand(50, 100);
				elseif($probability <= 93) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 95) $size['fields'] = mt_rand(150, 250);
				else $size['fields'] = mt_rand(250, 400);
			break;
			case 13:
				if($probability <= 65) $size['fields'] = mt_rand(10, 50);
				elseif($probability <= 95) $size['fields'] = mt_rand(50, 100);
				elseif($probability <= 97) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 98) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 500);
			break;
			case 14:
				if($probability <= 70) $size['fields'] = mt_rand(10, 50);
				elseif($probability <= 97) $size['fields'] = mt_rand(50, 100);
				elseif($probability <= 98) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 99) $size['fields'] = mt_rand(150, 250);
				else $size['fields'] = mt_rand(250, 400);
			break;
			case 15:
				if($probability <= 75) $size['fields'] = mt_rand(10, 50);
				elseif($probability <= 95) $size['fields'] = mt_rand(50, 100);
				elseif($probability <= 96) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 97) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 400);
			break;
			case 16:
				if($probability <= 80) $size['fields'] = mt_rand(10, 50);
				elseif($probability <= 93) $size['fields'] = mt_rand(50, 100);
				elseif($probability <= 94) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 95) $size['fields'] = mt_rand(150, 250);
				else $size['fields'] = mt_rand(250, 400);
			break;
			case 17:
				if($probability <= 83) $size['fields'] = mt_rand(10, 40);
				elseif($probability <= 93) $size['fields'] = mt_rand(40, 100);
				elseif($probability <= 94) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 95) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 500);
			break;
			case 18:
				if($probability <= 90) $size['fields'] = mt_rand(10, 40);
				elseif($probability <= 94) $size['fields'] = mt_rand(40, 100);
				elseif($probability <= 95) $size['fields'] = mt_rand(100, 150);
				elseif($probability <= 96) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 1500);
			break;
			case 19:
				if($probability <= 92) $size['fields'] = mt_rand(10, 30);
				elseif($probability <= 95) $size['fields'] = mt_rand(30, 90);
				elseif($probability <= 96) $size['fields'] = mt_rand(90, 150);
				elseif($probability <= 97) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 750);
			break;
			case 20:
				if($probability <= 94) $size['fields'] = mt_rand(10, 30);
				elseif($probability <= 96) $size['fields'] = mt_rand(30, 90);
				elseif($probability <= 97) $size['fields'] = mt_rand(90, 150);
				elseif($probability <= 98) $size['fields'] = mt_rand(150, 300);
				else $size['fields'] = mt_rand(300, 750);
			break;
		}

		$size['fields']		= $size['fields'] > $max_size ? ceil($max_size*mt_rand(98, 100)/100) : $size['fields'];
		$size['diameter']	= mt_rand(($size['fields']-1)*75, ($size['fields']+1)*75);

		return $size;
	}
}