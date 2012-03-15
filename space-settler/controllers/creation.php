<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Creation extends SPS_Controller {

	public function index()
	{
		if($this->input->is_cli_request())
		{
			ini_set('memory_limit','10G');
			ini_set('max_execution_time', 3600);
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
	
			$this->benchmark->mark('Planets and Moons created_start');
	
			for($f=0; $f < $total_stars; $f++)
			{
				if(mt_rand(1,10) > 5)
				{
					$planets	= mt_rand(7, 10);
	
					for($g=0; $g < $planets; $g++)
					{
						$this->bigbang->create_planet($g+1, $f);
					}
				}
			}
			$this->benchmark->mark('Planets and Moons created_end');
	
			$stars		= number_format(count($this->bigbang->stars), 0, ',', '.');
			$planets	= number_format(count($this->bigbang->planets), 0, ',', '.');
			$moons		= number_format(count($this->bigbang->moons), 0, ',', '.');
	
			$this->benchmark->mark($stars.' Star insertion_start');
			$this->db->insert_batch('stars', $this->bigbang->stars) OR die('Error! no se han podido crear las estrellas');
			$this->benchmark->mark($stars.' Star insertion_end');
			$this->benchmark->mark($planets.' Planet insertion_start');
			$this->db->insert_batch('bodies', $this->bigbang->planets) OR die('Error! no se han podido crear los planetas');
			$this->benchmark->mark($planets.' Planet insertion_end');
			$this->benchmark->mark($moons.' Moon insertion_start');
			$this->db->insert_batch('bodies', $this->bigbang->moons) OR die('Error! no se han podido crear los satélites');
			$this->benchmark->mark($moons.' Moon insertion_end');
	
			echo 'Se ha creado el universo';
		}
		else
		{
			log_message('ERROR: El usuario con IP '.$this->input->ip_address().' ha intentado acceder a /creation desde el navegador.');
			redirect('/', 'location', 301);
		}
	}
}

/* End of file creation.php */
/* Location: ./space_settler/controllers/creation.php */