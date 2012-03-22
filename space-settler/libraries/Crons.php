<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Crons Class
 *
 * @subpackage	Libraries
 * @author		Razican
 * @category	Libraries
 * @link		http://www.razican.com/
 */

 class Crons
{

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
		$CI->db->select('email, validation, validated');
		$CI->db->where('validated', FALSE);
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

		// Users who are inactive //
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
		$CI->db->where('(`validated` = 0 && `last_active` < '.($time-$CI->config->item('reg_inactive')).') OR (`hibernating` = 0 AND `last_active` < '.($time-$CI->config->item('inactive')).') OR ( `validated` = 1 AND `last_active` < '.($time-$CI->config->item('email_inactive')).')');
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
	 * Warn users who have changed their emails but haven't validated it
	 *
	 * @access	public
	 * @return	bool
	 */
	public function warn_emails()
	{

		$CI			=& get_instance();
		$time		= now();

		// Users who need to activate their accounts //
		$CI->db->select('email, validation, validated');
		$CI->db->where('validated', TRUE);
		/* FALTA LA ADAPTACIÓN A CI 3 */
		$CI->db->where('`validation` IS NOT NULL');
		$CI->db->where('last_active <', $time - $CI->config->item('email_inactive') + $CI->config->item('warn_inact'));
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
		log_message('debug', 'Inactive emails warned correctly');
		return TRUE;
	}
}