<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Creation extends CI_Controller {

	public function index()
	{
		ini_set('memory_limit','10G');
		ini_set('max_execution_time', 900);
		$this->output->enable_profiler($this->config->item('debug'));
		$this->output->set_profiler_sections(array('queries' => FALSE));
		$this->load->library('bigbang');

		$total_stars	= mt_rand(95000, 105000);
		$this->bigbang->current_stars	= $this->db->count_all('stars');
		$this->bigbang->current_bodies	= $this->db->count_all('bodies');

		$this->benchmark->mark('Stars created_start');
		for($i=0; $i < $total_stars; $i++)
		{
			$this->bigbang->create_star($i+1);
		}
		$this->benchmark->mark('Stars created_end');

		$stars_planets	= mt_rand(9989, 10009);

		$this->benchmark->mark('Planets and Moons created_start');
		for($f=1; $f <= $stars_planets; $f++)
		{
			$planets	= mt_rand(10, 15);
			$system		= mt_rand(round($f*$total_stars/($stars_planets+1)-9), round($f*$total_stars/($stars_planets+1)));

			for($g=0; $g < $planets; $g++)
			{
				$this->bigbang->create_planet($g+1, $system);
			}
		}
		$this->benchmark->mark('Planets and Moons created_end');

		$this->benchmark->mark('Database insertion_start');
		$this->db->insert_batch('stars', $this->bigbang->stars) OR die('Error! no se han podido crear las estrellas');
		$this->db->insert_batch('bodies', $this->bigbang->planets) OR die('Error! no se han podido crear los planetas');
		$this->db->insert_batch('bodies', $this->bigbang->moons) OR die('Error! no se han podido crear los satélites');
		$this->benchmark->mark('Database insertion_end');

		echo 'Se ha creado el universo';
	}
}

/* End of file creation.php */
/* Location: ./space_settler/controllers/creation.php */
