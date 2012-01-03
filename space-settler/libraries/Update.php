<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Update Class
 *
 * @subpackage	Libraries
 * @author		Razican
 * @category	Libraries
 * @link		http://www.razican.com/
 */
class Update
{
	/**
	 * Check if installed PHP version is the latest
	 *
	 * @access	public
	 * @return	bool
	 */
	public function check_php()
	{
		$latest_php	= unserialize(file_get_contents('http://www.php.net/releases/index.php?serialize=1&version=5&max=1'));
		foreach($latest_php as $latest_version => $array){break;}
		if (strnatcmp(phpversion(), $latest_version) >= 0) return TRUE;
		return FALSE;
	}

	/**
	 * Check if installed CodeIgniter version is the latest
	 *
	 * @access	public
	 * @return	bool
	 */
	public function check_codeigniter()
	{
		$latest_version	= file_get_contents('http://versions.ellislab.com/codeigniter_version.txt');
		if (strnatcmp(str_replace('-dev', '', CI_VERSION), $latest_version) >= 0) return TRUE;
		return FALSE;
	}


}

/* End of file Update.php */
/* Location: ./application/libraries/Update.php */