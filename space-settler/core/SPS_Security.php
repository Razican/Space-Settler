<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SPS_Security Class
 *
 * @subpackage	Libraries
 * @author		Razican
 * @category	Security
 * @link		http://www.razican.com/
 */

class SPS_Security extends CI_Security {

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Verify Cross Site Request Forgery Protection
	 *
	 * @return	object
	 */
	public function csrf_verify()
	{
		if ( ! (php_sapi_name() === 'cli' OR defined('STDIN')))
		{
			// If it's not a POST request we will set the CSRF cookie
			if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST')
			{
				return $this->csrf_set_cookie();
			}

			// Check if URI has been whitelisted from CSRF checks
			if ($exclude_uris = config_item('csrf_exclude_uris'))
			{
				$uri = load_class('URI', 'core');
				if (in_array($uri->uri_string(), $exclude_uris))
				{
					return $this;
				}
			}

			// Do the tokens exist in both the _POST and _COOKIE arrays?
			if ( ! isset($_POST[$this->_csrf_token_name]) OR ! isset($_COOKIE[$this->_csrf_cookie_name])
				OR $_POST[$this->_csrf_token_name] !== $_COOKIE[$this->_csrf_cookie_name]) // Do the tokens match?
			{
				$this->csrf_show_error();
			}

			// We kill this since we're done and we don't want to polute the _POST array
			unset($_POST[$this->_csrf_token_name]);

			// Regenerate on every submission?
			if (config_item('csrf_regenerate'))
			{
				// Nothing should last forever
				unset($_COOKIE[$this->_csrf_cookie_name]);
				$this->_csrf_hash = '';
			}

			$this->_csrf_set_hash();
			$this->csrf_set_cookie();

			log_message('debug', 'CSRF token verified');
		}
		return $this;
	}
}


/* End of file SPS_Security.php */
/* Location: ./application/core/SPS_Security.php */