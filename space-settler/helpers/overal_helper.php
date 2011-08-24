<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function update_config( $config_name, $config_value )
{
/*	global $game_config;
	doquery("UPDATE {{table}} SET `config_value` = '".$config_value."' WHERE `config_name` = '".$config_name."';",'config');*/
}

function message ($message, $dest = '/', $topnav = FALSE, $menu = FALSE)
{
	$CI					=& get_instance();

	$data['head']		= $CI->load->view('head', '', TRUE);
	$data['footer']		= $CI->load->view('footer', '', TRUE);
	$data['message']	= $message;
	$data['dest']		= anchor($dest, lang('overal.go_back'), 'title="'.lang('overal.go_back').'"');

	$CI->load->view('message', $data);
}

function skin()
{
	$CI		=& get_instance();

	$skin	=  $CI->config->item('skin');
	$skin	= ( ! empty($skin)) ? $skin : 'default';

	return $skin;
}

/* End of file overal_helper.php */
/* Location: ./application/helpers/overal_helper.php */