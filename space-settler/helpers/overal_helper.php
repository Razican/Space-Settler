<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Show message
 *
 * @param	string
 * @param	string
 * @param	bool
 * @param	bool
 * @return	void
 */
function message($message, $dest = '/')
{
	$CI					=& get_instance();

	$data['topbar']		= '';
	$data['menu']		= '';
	$data['license']	= $CI->load->view('license', '', TRUE);
	if(defined('INGAME'))
	{
		$CI->lang->load('menu');
		$data['topbar']		= $CI->load->view('ingame/topbar', '', TRUE).'<div class="clear"></div>';
		$data['menu']		= $CI->load->view('ingame/menu', '', TRUE);
	}

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

	$skin	=  $CI->session->userdata('logged_in') ? $CI->session->userdata('skin') : $CI->config->item('skin');
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
	if( ! defined('LANG_KEY')) show_error('ERROR! language not configured correctly!');

	return LANG_KEY;
}

/**
 * It gets the name for a given user ID (Alias of $this->user->get_name())
 *
 * @param	int
 * @param	boolean
 * @return	string
 */
function get_name($id, $is_admin = FALSE)
{
	$CI =& get_instance();

	return $CI->user->get_name($id, $is_admin);
}

/**
 * It gets the name for a given user ID (Alias of $this->user->get_name())
 *
 * @param	int
 * @param	int
 * @return	string
 */
function format_number($number, $decimals = 0)
{
	$CI =& get_instance();

	require_once(APPPATH.'language/'.$CI->config->item('language').'/config.php');
	if( ! defined('LANG_DEC') OR ( ! defined('LANG_THO'))) show_error('ERROR! language not configured correctly!');

	return number_format($number, $decimals, LANG_DEC, LANG_THO);
}

/**
 * It lists all the installed skins
 *
 * @return	array
 */
function list_skins($config_item = NULL)
{
	$skins	= array();
	foreach(scandir(FCPATH.'skins') as $dir)
	{
		if( ! is_dir(FCPATH.'skins/'.$dir)) break;
		if($dir != '.' && $dir != '..')
		{
			require_once(FCPATH.'skins/'.$dir.'/config.php');
			if( ! isset($config)) show_error(lang('overal.config_error'));
			$skins[$dir] = is_null($config_item) ? $config : $config[$config_item];
		}
	}
	return $skins;
}


/* End of file overal_helper.php */
/* Location: ./application/helpers/overal_helper.php */