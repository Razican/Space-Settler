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
	/*	Código
	 	$CI							=& get_instance();

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
	 * Register user
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function register($username, $email, $referrer)
	{
		$this->register_errors	= '';
		$CI						=& get_instance();

		$CI->load->helper('email');

		if( ! valid_email($email))
			$this->register_errors	.= lang('login.mail_not_valid').'<br />';

		if($this->exists_email($email))
			$this->register_errors	.= lang('login.mail_exists').'<br />';

		if( ! is_alnum($username))
			$this->register_errors	.= lang('login.user_not_alnum').'<br />';

		if($this->exists_user($username))
			$this->register_errors	.= lang('login.user_exists').'<br />';

		if($this->register_errors)
			return FALSE;

		$CI->load->helper('string');

		$password	= random_string('alnum', 8);
		$IP			= ip2int($CI->input->ip_address());
		$time		= now();
		$planet		= $this->_select_body();


		$data		= array(
					'username'		=> strtolower($username),
					'password'		=> sha1($password),
					'email'			=> $email,
					'reg_email'		=> $email,
					'name'			=> $username,
					'last_ip'		=> $IP,
					'reg_ip'		=> $IP,
					'register_time'	=> $time,
					'online_time'	=> $time
					);

		$CI->db->insert('users', $data);

		$CI->db->select_max('id');
		$query = $CI->db->get('users');
		foreach ($query->result() as $user) $user = $user->id;

		return $CI->db->update('bodies', array('owner' => $user), array('id' => $planet));
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

		return $CI->db->update('users', array('password' => $password));
	}

	/**
	 * Check if it's banned
	 *
	 * @access	public
	 * @return	bool
	 */
	public function is_banned()
	{
		return (($this->ban_finish != 0) && ($this->ban_finish > now()));
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
		return $this->_exists($email, 'email', 'users');
	}

	/**
	 * Check if an username exists
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function exists_user($username)
	{
		return $this->_exists(strtolower($username), 'username', 'users');
	}

	/**
	 * Check the given data exists
	 *
	 * @access	private
	 * @param	string
	 * @return	bool
	 */
	private function _exists($string, $field, $table)
	{
		$CI	=& get_instance();

		$CI->db->where($field, $string);
		$CI->db->limit(1);

		return $CI->db->count_all_results($table) ? TRUE : FALSE;
	}

	/**
	 * Select new user's body
	 *
	 * @access	private
	 * @return	int
	 */
	private function _select_body()
	{
		$CI			=& get_instance();

		$CI->db->where('habitable', 1);
		$CI->db->where('owner', NULL);
		$CI->db->select('id');
		$query	= $CI->db->get('bodies');

		foreach($query->result() as $body) $bodies[] = $body->id;

		$body			= $bodies[mt_rand(0, count($bodies))];

		return $body;
	}
}