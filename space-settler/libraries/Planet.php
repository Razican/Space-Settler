<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Planet Class
 *
 * @subpackage	Libraries
 * @author		Razican
 * @category	Libraries
 * @link		http://www.razican.com/
 */

class Planet
{
	/**
	 * Create a planet
	 *
	 * @access	public
	 * @param	array
	 */
	public function create($position = NULL)
	{
		$CI	=& get_instance();

		$position	= $position ? $position : _select_position();
		$size		= $position ? _size($position) : round((mt_rand(95, 105) * $CI->config->item('start_field_max'))/100);

		return FALSE;
	}

	/**
	 * Create a moon
	 *
	 * @access	public
	 * @param
	 */
	public function create_moon()
	{
		return FALSE;
	}

	/**
	 * Return the size of a future planet based on its position
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

	/**
	 * Returns if a star is valid
	 *
	 * @access	private
	 * @param	array
	 * @return	boolean
	 */
	private function _habitable_stars($star)
	{
		$relation		= $star['luminosity'] / $star['diameter'];

		$is_habitable	= (($star['diameter'] >= 0.02) &&
							($star['diameter'] <= 50) &&
							($star['luminosity'] >= 0.02) &&
							($star['luminosity'] <= 50) &&
							($relation <= 10) && ($relation >= 0.1);
		return  $is_habitable;
	}

	/**
	 * Returns the minimum position for an habitable planet
	 *
	 * @access	private
	 * @param	integer
	 * @return	integer
	 */
	private function _minimum_habitable_position($magnitude)
	{
		if($magnitude <= 0.2) return 1;
		elseif($magnitude <= 10) return 2;
		elseif($magnitude <= 50) return 3;
		elseif($magnitude <= 250) return 4;
		elseif($magnitude <= 500) return 5;
		elseif($magnitude <= 750) return 6;
		elseif($magnitude <= 1000) return 7;
		elseif($magnitude <= 1500) return 8;
		elseif($magnitude <= 2000) return 9;
		else return 10;
	}

	/**
	 * Returns the maximum position for an habitable planet
	 *
	 * @access	private
	 * @param	integer
	 * @return	integer
	 */
	private function _maximum_habitable_position($magnitude)
	{
		if($magnitude <= 0.01) return 1;
		elseif($magnitude <= 0.1) return 2;
		elseif($magnitude <= 0.25) return 3;
		elseif($magnitude <= 2) return 4;
		elseif($magnitude <= 25) return 5;
		elseif($magnitude <= 100) return 6;
		elseif($magnitude <= 250) return 7;
		elseif($magnitude <= 500) return 8;
		elseif($magnitude <= 1000) return 9;
		elseif($magnitude <= 1500) return 10;
		elseif($magnitude <= 2000) return 11;
		else return 12;
	}

	/**
	 * Returns wether a planet is gaseous or not
	 *
	 * @access	private
	 * @param	array
	 * @return	boolean
	 */
	private function _is_gaseous_planet($planet)
	{
		return ($planet['fields'] > 500);
	}


	/**
	 * Return the perfect planet for a new user
	 *
	 * @access	private
	 * @return	array
	 */
	private function _select_position()
	{
		$CI			=& get_instance();

		$CI->config->load('stars');
		$stars		= array_filter($CI->config->item('stars'), '_habitable_stars');

		$CI->db->select('id, galaxy, system, planet, distance, diameter');
		$CI->db->where_in('star', array_keys($stars));
		$query	= $CI->db->get('planets');

		foreach($query->result() as $planet)
		{
			$stars[$planet->star]['planets'][$planet->id]	= $planet;
		}

		foreach($stars as $id => $star)
		{
			$magnitude				= $star['diameter'] * $star['luminosity'];

			$min_position			= _min_habitable_position($magnitude);
			$max_position			= _max_habitable_position($magnitude);

			$total_habit_planets	= 1 + $max_position - $min_position;

			$habitable_planets		= array();
			for($i = $min_position; $i<= $max_position; $i++){ $habitable_planets[$i] = $i; }

			$habitable_planets		= array_filter($habitable_planets, '_is_position_habitable');

			$star['density']		= ($total_habit_planets - count($habitable_planets)) / $total_habit_planets;
		}


		$galaxies			= array_filter($galaxy, '_is_good_galaxy');
		$position['galaxy']	= empty($galaxies) ? array_rand(array_keys(array_filter($galaxy, '_is_empty_galaxy'))) : array_rand(array_keys($galaxies));



		return FALSE;
	}

	/**
	 * Return maximum planet size based on its star
	 *
	 * @access	private
	 * @param	array
	 * @return	int
	 */
	private function _max_size($position)
	{
		$CI		=& get_instance();

		$CI->config->load('stars');

		foreach($CI->config->item('stars') as $star)
			if(($star['galaxy'] == $position['galaxy']) && ($star['system'] == $position['system'])) break;

		return ceil(pow($star['diameter'], 1/6)*2000);

	}
}