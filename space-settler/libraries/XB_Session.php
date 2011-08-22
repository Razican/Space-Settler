<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * XB_Session Class
 *
 * @subpackage	Libraries
 * @author		Razican
 * @category	Libraries
 * @link		http://www.razican.com/
 */

class XB_Session extends CI_Session {

  function __construct()
  {
    parent::__construct();

    $this->now = time();
  }

  	/**
	 * Write the session cookie
	 *
	 * @access	public
	 * @return	void
	 */
	function _set_cookie($cookie_data = NULL)
	{
		if (is_null($cookie_data))
		{
			$cookie_data	= $this->userdata;
		}

		$cookie_data = $this->_serialize($cookie_data);

		if ($this->sess_encrypt_cookie == TRUE)
		{
			$cookie_data	= $this->CI->encrypt->encode($cookie_data);
		}
		else
		{
			$cookie_data	= $cookie_data.md5($cookie_data.$this->encryption_key);
		}

		$expire				= (config_item('sess_expire_on_close') === TRUE) ? 0 : $this->sess_expiration + time();
		$secure_cookie		= (config_item('cookie_secure') === TRUE) ? 1 : 0;

		setcookie(
					$this->sess_cookie_name,
					$cookie_data,
					$expire,
					$this->cookie_path,
					$this->cookie_domain,
					0,
					$secure_cookie
				);
	}
}


/* End of file XB_Session.php */
/* Location: ./application/libraries/XB_Session.php */