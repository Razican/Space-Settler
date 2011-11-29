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
	 * Return the perfect planet for a new user
	 *
	 * @access	private
	 * @return	array
	 */
	private function _select_position()
	{
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