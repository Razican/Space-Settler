<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Get "now" time
 *
 * Returns time() based on the configured timezone.
 *
 * @access	public
 * @return	integer
 */
function now()
{
	$CI			=& get_instance();

	$timezone	= new DateTimeZone($CI->config->item('timezone'));
	$now		= new DateTime('now', $timezone);
	$offset		= $timezone->getOffset($now);
	$time		= time() + $offset;

	return $time;
}

/**
 * Show date
 *
 * Shows date based on the format parameter
 *
 * @access	public
 * @param	string
 * @return	integer
 */
function show_date($format = NULL)
{
	$CI			=& get_instance();

	$format		= $format ? $format : $CI->config->item('date_format');
	$CI->lang->load('time');

	//return $date;
}


/* End of file SPS_date_helper.php */
/* Location: ./megapublik/helpers/SPS_date_helper.php */