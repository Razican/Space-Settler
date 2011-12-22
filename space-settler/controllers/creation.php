<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Creation extends CI_Controller {

	public function create($galaxies, $stars, $planets)
	{
		ini_set('memory_limit','512M');
		$this->output->enable_profiler($this->config->item('debug'));
		$this->output->set_profiler_sections(array('queries' => FALSE));
		$this->load->library('bigbang');

		for($i=0; $i<$galaxies; $i++)
		{
			for($f=0; $f<$stars; $f++)
			{
				$this->bigbang->create_star($i+1, $f+1);
			}
		}
		$this->db->insert_batch('stars', $this->bigbang->stars) OR die('Error! no se han podido crear las estrellas');

		foreach($this->bigbang->stars as $id => $star)
		{
			$planet_num	= $planets > 12 ? mt_rand(12, ($planets>15 ? 15 : $planets)) : mt_rand($planets-1, $planets);

			for($g=0; $g<$planet_num; $g++)
			{
				$this->bigbang->create_planet($g+1, $id);
			}
		}
		$this->db->insert_batch('bodies', $this->bigbang->planets) OR die('Error! no se han podido crear los planetas');
	}
}

/* End of file creation.php */
/* Location: ./space_settler/controllers/creation.php */