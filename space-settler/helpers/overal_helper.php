<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function update_config( $config_name, $config_value )
{
/*	global $game_config;
	doquery("UPDATE {{table}} SET `config_value` = '".$config_value."' WHERE `config_name` = '".$config_name."';",'config');*/
}

/**
 * Show message
 *
 * @param	string
 * @param	string
 * @param	bool
 * @param	bool
 * @return	void
 */
function message($message, $dest = '/', $topnav = FALSE, $menu = FALSE)
{
	$CI					=& get_instance();

	$data['message']	= $message;
	$data['dest']		= anchor($dest, lang('overal.go_back'), 'title="'.lang('overal.go_back').'"');

	$CI->load->view('message', $data);
}

/**
 * Convert an IP address to an unsigned integer
 *
 * @param	string
 * @return	integer
 */
function ip2int($ip_address)
{
	return sprintf("%u", ip2long($ip_address));
}

/**
 * Return current skin
 *
 * @return	string
 */
function skin()
{
	$CI		=& get_instance();

	$skin	=  $CI->config->item('skin');
	$skin	= ( ! empty($skin)) ? $skin : 'default';

	return $skin;
}

/**
 * Check for alphanumeric string
 *
 * @param	string
 * @param	bool
 * @return	bool
 */
function is_alnum($string, $space = FALSE)
{
	$valid			= array('-', '_');

	if($space)
		$valid[]	= ' ';

	return ctype_alnum(str_replace($valid, '', $string));
}

/**
 * Return the volume of a body
 *
 * @param	int
 * @return	float	Volume in m³
 */
function volume($radius)
{
	return 4/3*M_PI*pow($radius, 3);
}

/**
 * Return the gravity sufffered of a body at a distance from the main body.
 *
 * @param	int		Mass in Kg
 * @param	int		Distance in metres
 * @return	float
 */
function gravity($mass, $distance)
{
	$CI =& get_instance();
	return $CI->config->item('G')*$mass/pow($distance, 2);
}

/**
 * Return the current languaje key
 *
 * @return	string
 */
function current_lang()
{
	$CI =& get_instance();
	require_once(APPPATH.'language/'.$CI->config->item('language').'/config.php');
	if( ! isset($key)) show_error('ERROR! language not configured correctly!');

	return $key;
}


/* End of file overal_helper.php */
/* Location: ./application/helpers/overal_helper.php */