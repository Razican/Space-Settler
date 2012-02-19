<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Support_m extends CI_Model {

	/**
	 * Load support tickets
	 *
	 * @access	public
	 * @param	int
	 * @return	object|boolean
	 */
	public function load_all_tickets($id = NULL)
	{

		if($id) $this->db->where('id', $id);
		$query	= $this->db->get('support');

		if($query->num_rows() > 0)
		{
			$tickets	= array();
			$users		= array();

			foreach ($query->result() as $ticket)
			{
				$users[$ticket->user_id]	= $ticket->user_id;
				$ticket->status				= lang('support.status_'.$ticket->status);
				$ticket->type				= lang('support.type_'.$ticket->type);
				$ticket->replies			= count(unserialize($ticket->text))-1;
				$tickets[]					= $ticket;
			}

			$this->db->where_in('id', $users);
			$this->db->select('id, name');
			$query	= $this->db->get('users');

			$users	= array();

			if($query->num_rows() > 0)
				foreach($query->result() as $user)
					$users[$user->id]	= $user->name;

			foreach($tickets as $key => $ticket)
			{
				$ticket->user	= isset($users[$ticket->user_id]) ? $users[$ticket->user_id] : 'N/A';
				$tickets[$key]	= $ticket;
			}

			return $tickets;
		}

		return FALSE;
	}

	/**
	 * Create a new support ticket
	 *
	 * @access	public
	 * @param	int
	 * @param	string
	 * @param	string
	 * @return	boolean
	 */
	public function new_ticket($type, $title, $text)
	{
		settype($type, 'integer');

		$text	= serialize(array(array(
					'user_id'	=> $this->session->userdata('id'),
					'text'		=> $text
				)));

		$data	= array(
			'user_id'	=> $this->session->userdata('id'),
			'type'		=> $type,
			'title'		=> $title,
			'text'		=> $text
		);

		return $this->db->insert('support', $data);
	}
}


/* End of file support_m.php */
/* Location: ./space_settler/model/support_m.php */