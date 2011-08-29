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

	$data['head']		= $CI->load->view('head', '', TRUE);
	$data['footer']		= $CI->load->view('footer', '', TRUE);
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


/* End of file overal_helper.php */
/* Location: ./application/helpers/overal_helper.php */