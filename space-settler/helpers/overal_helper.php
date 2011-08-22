<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function update_config( $config_name, $config_value )
{
/*	global $game_config;
	doquery("UPDATE {{table}} SET `config_value` = '".$config_value."' WHERE `config_name` = '".$config_name."';",'config');*/
}

function message ($mes, $dest = "", $time = "3", $topnav = false, $menu = true)
{
/*	$parse['mes']   = $mes;

	$page .= parsetemplate(gettemplate('message_body'), $parse);

	if (!defined('IN_ADMIN'))
	{
		display ($page, $topnav, (($dest != "") ? "<meta http-equiv=\"refresh\" content=\"$time;URL=$dest\">" : ""), false, $menu);
	}
	else
	{
		display ($page, $topnav, (($dest != "") ? "<meta http-equiv=\"refresh\" content=\"$time;URL=$dest\">" : ""), true, false);
	}*/
}

function skin()
{
	global $CI;

	$skin	=  $CI->config->item('skin');
	$skin	= ( ! empty($skin)) ? $skin : 'default';
	return $skin;
}

/* End of file overal_helper.php */
/* Location: ./application/helpers/overal_helper.php */
