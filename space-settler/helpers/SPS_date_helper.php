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

	$date	= str_replace("%WEEKDAY%",		lang('time.day_f_'.date("w", now())),	$format);
	$date	= str_replace("%WEEKDAY_S%",	lang('time.day_s_'.date("w", now())),	$date);
	$date	= str_replace("%DAY%",			date("d", now()),						$date);
	$date	= str_replace("%DAY-0%",		date("j", now()),						$date);
	$date	= str_replace("%MONTHNAME%",	lang('time.month_f_'.date("m", now())),	$date);
	$date	= str_replace("%MONTHNAME_S%",	lang('time.month_s_'.date("m", now())),	$date);
	$date	= str_replace("%MONTH%",		date("m", now()),						$date);
	$date	= str_replace("%MONTH-0%",		date("n",now()),						$date);
	$date	= str_replace("%YEAR%",			date("Y", now()),						$date);
	$date	= str_replace("%YEAR_S%",		substr(date("Y", now()), -2),			$date);
	$date	= str_replace("%HOUR%",			date("H", now()),						$date);
	$date	= str_replace("%MINUTE%",		date("i", now()),						$date);
	$date	= str_replace("%SECOND%",		date("s", now()),						$date);
	$date	= str_replace("%OF%",			lang('overal.of'),						$date);

	return $date;
}


/* End of file SPS_date_helper.php */
/* Location: ./sapce-settler/helpers/SPS_date_helper.php */