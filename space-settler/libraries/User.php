<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
				'id'			=> $user->id,
				'username'		=> $user->username,
				'email'			=> $user->email,
				'hibernating'	=> $user->hibernating,
				'skin'			=> $user->skin,
				'logged_in'		=> TRUE
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
		$CI->load->library('email');

		if( ! valid_email($email))
			$this->register_errors	.= lang('login.email_not_valid').'<br />';

		if($this->exists_email($email))
			$this->register_errors	.= lang('login.email_exists').'<br />';

		if( ! is_alnum($username))
			$this->register_errors	.= lang('login.user_not_alnum').'<br />';

		if($this->exists_user($username))
			$this->register_errors	.= lang('login.user_exists').'<br />';

		$planet		= $this->_select_body();
		if( ! $planet)
			$this->register_errors	.= lang('login.no_planet').'<br />';

		if($this->register_errors)
			return FALSE;

		$CI->load->helper('string');

		$password	= random_string('alnum', 8);
		$IP			= ip2int($CI->input->ip_address());
		$code		= random_string('alnum', 15);
		$time		= now();

		$data		= array(
					'username'		=> strtolower($username),
					'password'		=> sha1($password),
					'email'			=> $email,
					'reg_email'		=> $email,
					'validation'	=> $code,
					'name'			=> $username,
					'last_ip'		=> $IP,
					'reg_ip'		=> $IP,
					'register_time'	=> $time,
					'last_active'	=> $time
					);

		$CI->db->insert('users', $data);

		$CI->db->select_max('id');
		$query = $CI->db->get('users');
		foreach ($query->result() as $user) $user = $user->id;

		if($CI->db->update('bodies', array('owner' => $user), array('id' => $planet)))
		{
			$CI->email->from('space-settler@razican.com', 'Space Settler');
			$CI->email->reply_to('noreply@razican.com', 'Space Settler');
			$CI->email->to($email);
			$CI->email->subject(lang('login.reg_message'));
			$data		= array('%game_name%', '%password%', '%username%', '%validation_link%');
			$replace	= array($CI->config->item('game_name'), $password, $username, site_url('validation/'.$code));
			$CI->email->message(str_replace($data, $replace, lang('login.reg_email_message')));

			if( ! $CI->email->send())
			{
				$this->validate($code);
				log_message('error', 'Email could not be sended');
				$this->register_errors	.= str_replace('%password%', $password, lang('login.reg_email_send_error'));
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		return FALSE;
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
	 * Validate user's email address
	 *
	 * @access	public
	 * @return	bool
	 */
	public function validate($code)
	{
		$CI			=& get_instance();

		$CI->db->where('validation', $code);
		$CI->db->update('users', array('validation' => NULL));

		return ($CI->db->affected_rows() != 0);
	}

	/**
	 * Finish hibernations that have been active since more
	 * than the stablished time.
	 *
	 * @access	public
	 * @return	bool
	 */
	public function finish_hibernations()
	{
		$CI			=& get_instance();
		$time		= now();

		$CI->db->select('id, email');
		$CI->db->where('hibernating', TRUE);
		$CI->db->where('last_active <', $time-$CI->config->item('hib_inactive'));
		$query		= $CI->db->get('users');

		if ($query->num_rows() > 0)
		{
			$update	= array();
			$emails	= array();
			foreach ($query->result() as $user)
			{
				$emails[]	= $user->email;
				$update[]	= array(
							'id' => $user->id,
							'hibernating' => FALSE,
							'last_active' => $time
							);
			}
			$CI->db->update_batch('users', $update, 'id');

			$CI->email->clear();
			$CI->email->to($emails);
		    $CI->email->from('space-settler@razican.com', 'Space Settler');
			$CI->email->reply_to('noreply@razican.com', 'Space Settler');
		    $CI->email->subject(str_replace('%game_name%', $CI->config->item('game_name'), lang('cron.hibernation_title')));
			$CI->email->message(str_replace(array('%link%', '%days%'), array(site_url('/'), floor($CI->config->item('inactive')/86400)), lang('cron.hibernation_text')));
		    $CI->email->send();
		}
		log_message('debug', 'Hibarnations finished correctly');
		return TRUE;
	}

	/**
	 * This function will warn all the users that will be deleted
	 * in the next 24 hours
	 *
	 * @access	public
	 * @return	bool
	 */
	public function warn_inactives()
	{
		$CI			=& get_instance();
		$time		= now();

		// Users who need to activate their accounts //
		$CI->db->select('email, validation');
		$CI->db->where('`validation` IS NOT NULL');
		$CI->db->where('last_active <', $time - $CI->config->item('reg_inactive') + $CI->config->item('warn_inact'));
		$query		= $CI->db->get('users');

		if ($query->num_rows() > 0)
		{
			$emails	= array();

			foreach ($query->result() as $user)
			{
				$CI->email->clear();
				$CI->email->to($user->email);
			    $CI->email->from('space-settler@razican.com', 'Space Settler');
				$CI->email->reply_to('noreply@razican.com', 'Space Settler');
			    $CI->email->subject(str_replace('%game_name%', $CI->config->item('game_name'), lang('cron.warning_title')));
				$CI->email->message(str_replace(array('%link%', '%time%'), array(site_url('/register/validate/'.$user->validation), floor($CI->config->item('warn_inact')/3600)), lang('cron.warning_email_text')));
			    $CI->email->send();

			}
		}

		// Users which are inactives //
		$CI->db->select('email');
		$CI->db->where('hibernating', FALSE);
		$CI->db->where('last_active <', $time - $CI->config->item('inactive') + $CI->config->item('warn_inact'));
		$query		= $CI->db->get('users');
		if ($query->num_rows() > 0)
		{
			$emails	= array();

			foreach ($query->result() as $user) $emails[]	= $user->email;

			$CI->email->clear();
			$CI->email->to($emails);
		    $CI->email->from('space-settler@razican.com', 'Space Settler');
			$CI->email->reply_to('noreply@razican.com', 'Space Settler');
		    $CI->email->subject(str_replace('%game_name%', $CI->config->item('game_name'), lang('cron.warning_title')));
			$CI->email->message(str_replace(array('%link%', '%time%'), array(site_url('/'), floor($CI->config->item('warn_inact')/3600)), lang('cron.warning_text')));
		    $CI->email->send();
		}
		log_message('debug', 'Inactives warned correctly');
		return TRUE;
	}

	/**
	 * Deletes all the inactive users
	 *
	 * @access	public
	 * @return	bool
	 */
	public function delete_inactives()
	{
		$CI			=& get_instance();
		$time		= now();

		$CI->db->select('id, email');
		/* FALTAN LOS GRUPOS Y LA ADAPTACIÓN A CI 3
		$CI->db->where('validation !=', NULL);
		$CI->db->where('last_active <', $time-$CI->config->item('reg_inactive'));
		$CI->db->or_where('hibernating', FALSE);
		$CI->db->where('last_active <', $time-$CI->config->item('inactive'));*/
		$CI->db->where('(`validation` IS NOT NULL AND `last_active` < '.($time-$CI->config->item('reg_inactive')).') OR (`hibernating` = 0 AND `last_active` < '.($time-$CI->config->item('inactive')).')');
		$query		= $CI->db->get('users');

		if ($query->num_rows() > 0)
		{
			$users	= array();
			$emails	= array();

			foreach ($query->result() as $user)
			{
				$emails[]	= $user->email;
				$users[]	= $user->id;
			}
			$CI->db->where_in('owner', $users);
			$CI->db->update('bodies', array('owner' => NULL));

			$CI->email->clear();
			$CI->email->to($emails);
		    $CI->email->from('space-settler@razican.com', 'Space Settler');
			$CI->email->reply_to('noreply@razican.com', 'Space Settler');
		    $CI->email->subject(str_replace('%game_name%', $CI->config->item('game_name'), lang('cron.delete_title')));
			$CI->email->message(str_replace('%link%', site_url('/'), lang('cron.inactive_del_text')));
		    $CI->email->send();
		}
		log_message('debug', 'Inactives deleted correctly');
		return TRUE;
	}

	/**
	 * Count user's planets
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	public function count_planets($id = NULL)
	{
		return $this->_count_bodies($id);
	}

	/**
	 * Count user's mooons
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	public function count_moons($id = NULL)
	{
		return $this->_count_bodies($id, 1);
	}

	/**
	 * Count user's bodies
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 * @return	bool
	 */
	private function _count_bodies($id, $type = 0)
	{
		$CI			=& get_instance();
		$id			= is_null($id) ? $CI->session->userdata('id') : $id;

		$CI->db->where('owner', $id);
		$CI->db->where('type', $type);
		$CI->db->from('bodies');

		return $CI->db->count_all_results();
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

		if($query->num_rows()) foreach($query->result() as $body) $bodies[] = $body->id;

		$body			= isset($bodies) ? $bodies[mt_rand(0, count($bodies))] : FALSE;

		return $body;
	}
}