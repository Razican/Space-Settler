<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SPS_Loader Class
 *
 * @subpackage	Libraries
 * @author		Razican
 * @category	Loader
 * @link		http://www.razican.com/
 */

class SPS_Loader extends CI_Loader {

	function view_path($path)
	{
		$this->_ci_view_paths[$path] = TRUE;
	}

	function view($view, $vars = array(), $return = FALSE)
	{
		$vars = $this->_ci_object_to_array($vars);

		if (file_exists(APPPATH.'views/overal/'.$view.'.php'))
		{
			$skin = '';
			foreach ($this->_ci_view_paths as $path => $bool)
			{
				if ($bool && file_exists($path.$view.'.php'))
				{
					$skin	= $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $vars, '_ci_return' => TRUE));
				}
			}

			$array = array('skin' => $skin);

			$page		= $this->_ci_load(array('_ci_view' => 'overal/'.$view, '_ci_vars' => $array, '_ci_return' => $return));
		}
		elseif ( ! $return)
		{
			$this->view('head');
			$page	= $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $vars, '_ci_return' => FALSE));
			$this->view('footer');
		}
		else
		{
			$page	= $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $vars, '_ci_return' => TRUE));
		}

		return $page;
	}
}


/* End of file SPS_Loader.php */
/* Location: ./application/core/SPS_Loader.php */