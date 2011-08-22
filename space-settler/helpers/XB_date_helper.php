<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Get "now" time
 *
 * Returns time() based on the configured timezone.
 *
 * @access	public
 * @return	integer
 */
if ( ! function_exists('now'))
{
	function now()
	{
		$CI			=& get_instance();

		$timezone	= new DateTimeZone($CI->config->item('timezone'));
		$now		= new DateTime('now', $timezone);
		$offset		= $timezone->getOffset($now);
		$time		= time() + $offset;

		return $time;
	}
}


/* End of file XB_date_helper.php */
/* Location: ./megapublik/helpers/XB_date_helper.php */
