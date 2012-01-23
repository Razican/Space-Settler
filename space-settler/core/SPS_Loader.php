<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * SPS_Loader Class
 *
 * @subpackage	Libraries
 * @author		Razican
 * @category	Loader
 * @link		http://www.razican.com/
 */

class SPS_Loader extends CI_Loader {

	function view($view, $vars = array(), $return = FALSE)
	{
		return $this->_ci_load(array('_ci_view' => skin().'/'.$view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
	}
}


/* End of file SPS_Loader.php */
/* Location: ./application/core/SPS_Loader.php */
