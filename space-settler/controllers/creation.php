<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Creation extends SPS_Controller {

	public function index()
	{
		if($this->input->is_cli_request())
		{
			ini_set('memory_limit','10G');
			ini_set('max_execution_time', 3600);

			$this->config->load('physics');
			$this->load->library('bigbang');

			$stars = mt_rand(950, 1050);
			if($this->bigbang->create_galaxy($stars))
			{
				echo 'Galaxia creada'.PHP_EOL.PHP_EOL;
				echo 'Datos:'.PHP_EOL.PHP_EOL;
				echo 'Agujeros Negros: '.number_format($this->bigbang->stats['1_stars'], 0, ',', ' ').PHP_EOL;
				echo 'Estrellas de Neutrones: '.number_format($this->bigbang->stats['2_stars'], 0, ',', ' ').PHP_EOL;
				echo 'Estrellas de Quarks: '.number_format($this->bigbang->stats['3_stars'], 0, ',', ' ').PHP_EOL;
				echo 'Enanas Blancas: '.number_format($this->bigbang->stats['4_stars'], 0, ',', ' ').PHP_EOL.PHP_EOL;
				echo 'Estrellas:'.PHP_EOL.PHP_EOL;
				echo 'Tipo O: '.format_number($this->bigbang->stats['O_stars']).PHP_EOL;
				echo 'Tipo B: '.format_number($this->bigbang->stats['B_stars']).PHP_EOL;
				echo 'Tipo A: '.format_number($this->bigbang->stats['A_stars']).PHP_EOL;
				echo 'Tipo F: '.format_number($this->bigbang->stats['F_stars']).PHP_EOL;
				echo 'Tipo G: '.format_number($this->bigbang->stats['G_stars']).PHP_EOL;
				echo 'Tipo K: '.format_number($this->bigbang->stats['K_stars']).PHP_EOL;
				echo 'Tipo M: '.format_number($this->bigbang->stats['M_stars']).PHP_EOL.PHP_EOL;
			/*	echo 'Cinturones de asteroides: '.number_format($this->bigbang->stats['belts'], 0, ',', ' ').PHP_EOL;
				echo 'Planetas: '.number_format($this->bigbang->stats['planets'], 0, ',', ' ').PHP_EOL;
				echo 'Lunas: '.number_format($this->bigbang->stats['moons'], 0, ',', ' ').PHP_EOL;*/

				if( ! $this->bigbang->save_galaxy())
					echo 'Ocurrió un error al guardar la galaxia'.PHP_EOL.PHP_EOL;
				else
					echo 'Galaxia guardada'.PHP_EOL.PHP_EOL;
			}
			else
			{
				echo 'Ocurrio un error al crear la galaxia'.PHP_EOL;
			}

			if($this->config->item('debug'))
			{
				echo 'Tiempo tardado en crear la galaxia: '.format_number($this->benchmark->elapsed_time('galaxy_start', 'galaxy_end'), 4).' segundos'.PHP_EOL;
				echo 'Tiempo tardado en guardar las '.format_number($stars).' estrellas: '.format_number($this->benchmark->elapsed_time('stars_start', 'stars_end'), 4).' segundos'.PHP_EOL;
			}
		}
		else
		{
			log_message('error', 'User with IP '.$this->input->ip_address().' has tried to access /creation from the browser.');
			redirect('/', 'location', 301);
		}
	}
}


/* End of file creation.php */
/* Location: ./space_settler/controllers/creation.php */