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
	 * @return	object
	 */
	public function create($position = NULL)
	{
		$CI	=& get_instance();

		$position	= $position ? $position : _select_position();
		$size		= $position ? _size($position['planet']) : round((mt_rand(90, 110) * $CI->config->item('start_field_max'))/100);

		return FALSE;
	}

	/**
	 * Return the size of a future planet based on its position
	 *
	 * @access	private
	 * @param	int
	 * @return	array
	 */
	private function _size($position)
	{
		return FALSE;
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
}