<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User hook
 *
 * @subpackage	Hooks
 * @author		Razican
 * @category	Hooks
 * @link		http://www.razican.com/
 */

function load_user()
{
	log_message('debug', 'User loading initialised.');
	$CI			=& get_instance();

	if($CI->session->userdata('logged_in'))
		$CI->user->load_data($CI->session->userdata('user_id'));
}


/* End of file User.php */
/* Location: ./application/hooks/User.php */