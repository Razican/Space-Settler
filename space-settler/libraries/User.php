<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User Class
 *
 * @subpackage	Libraries
 * @author		Razican
 * @category	Libraries
 * @link		http://www.razican.com/
 */

class User
{
	/**
	 * Load user data
	 *
	 * @access	public
	 * @param	numeric
	 * @return	bool
	 */
	public function load_data($id)
	{
	/*	$CI							=& get_instance();

		$user_id					= $CI->session->userdata('user_id');
		$id							= is_null($id) ? $user_id : $id;
		if ( ! $id)
		{
			$this->logged_in		= FALSE;
			return FALSE;
		}
		else
		{
			$query					= $CI->db->get_where('users', array('id' => $id));

			if ($query->num_rows() === 1)
			{
				foreach ($query->result() as $user)
				{
					foreach ($user as $key => $value)
					{
						if ($current === TRUE)
						{
							$this->$key				= $value;
							if ($CI->session->userdata('logged_in'))
								$this->logged_in	= TRUE;
						}
						else
						{
							$this->$id->$key		= $value;
						}
					}
				}

				if ($current === TRUE)
				{
					if ($this->experience == 0)
					{
						$this->level	= 1;
					}
					else
					{
						$this->level	=& floor(log($this->experience/$CI->config->item('first_level'),$CI->config->item('exp_multiplier'))+2);
					}

					$this->money		= unserialize($this->money);

					foreach($this->money as $currency => $money){ $this->money[$currency]	= $money/100; }

					$this->country		= $this->current_country($this->location);
					$states				= $CI->config->item('states');
					$this->timezone		= $states[$this->location]['timezone'];
				}
				else
				{
					if ($this->experience == 0)
					{
						$this->$id->level	= 1;
					}
					else
					{
						$this->$id->level	=& floor(log($this->experience/$CI->config->item('first_level'),$CI->config->item('exp_multiplier'))+2);
					}

					$this->$id->money		= unserialize($this->money);

					foreach($this->$id->money as $currency => $money){ $this->$id->money[$currency]	= $money/100; }

					$this->$id->country		= $this->current_country($this->location);
					$states					= $CI->config->item('states');
					$this->$id->timezone	= $states[$this->location]['timezone'];
				}
			}
			else
			{
				log_message('error', 'Function load_data() in /megapublik/libraries/User.php has not received a valid id.');
				return FALSE;
			}
		}*/
	}

	/**
	 * Log in user
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function login($username, $password, $remember = FALSE)
	{
		$CI			=& get_instance();
		$username	= strtolower($username);

		$CI->db->where('username', $username);
		$CI->db->where('password', sha1($password));
		$CI->db->limit(1);
		$query		= $CI->db->get('users');

		if($query->num_rows() === 1)
		{
			if( ! $remember)
				$CI->config->set_item('sess_expire_on_close', TRUE);

			foreach($query->result() as $user){}

			$userdata	= array(
				'user_id'			=> $user->id,
				'current_planet'	=> $user->planet_id,
				'logged_in'			=> TRUE
				);

			$CI->session->set_userdata($userdata);

			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Log out user
	 *
	 * @access	public
	 * @return	void
	 */
	public function logout()
	{
		$CI	=& get_instance();
		$CI->session->sess_destroy();
	}

	/**
	 * Check if it's banned
	 *
	 * @access	public
	 * @return	bool
	 */
	public function is_banned()
	{
		return ($this->ban_finish != 0) && ($this->ban_finish > now()) ? TRUE : FALSE;
	}

	/**
	 * Check if an email exists
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function exists_email($email)
	{
		$CI	=& get_instance();

		$CI->db->where('email', $email);
		$CI->db->limit(1);

		return $CI->db->count_all_results('users') ? TRUE : FALSE;
	}

	/**
	 * Reset user's password
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function reset_password($email, $password)
	{
		$CI			=& get_instance();

		$password	= sha1($password);
		$CI->db->where('email', $email);

		return $CI->db->update('users', array('password' => $sha1_pass)) ? TRUE : FALSE;
	}
}