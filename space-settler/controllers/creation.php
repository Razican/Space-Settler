<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Creation extends SPS_Controller {

	public function index()
	{
		if ($this->input->is_cli_request())
		{
			ini_set('memory_limit','10G');
			ini_set('max_execution_time', 3600);

			$this->config->load('physics');
			$this->load->library('bigbang');

			$stars = mt_rand(95000, 105000);
			if ($this->bigbang->create_galaxy($stars))
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
				echo 'Cinturones de asteroides (sin crear): '.format_number($this->bigbang->stats['belts']).PHP_EOL;
				echo 'Planetas (sin guardar): '.format_number($this->bigbang->stats['planets']).PHP_EOL;
				echo '	De los cuales: '.PHP_EOL;
				echo '	Gaseosos: '.format_number($this->bigbang->stats['planets_1']).PHP_EOL;
				echo '		De los cuales, júpiteres calientes: '.format_number($this->bigbang->stats['hot_jupiters']).PHP_EOL;
				echo '	Rocosos: '.format_number($this->bigbang->stats['planets_0']).PHP_EOL;
				echo '		De los cuales, hipercalientes: '.format_number($this->bigbang->stats['hot_planets']).PHP_EOL;
				echo '		De los cuales, supertierras: '.format_number($this->bigbang->stats['earths']).PHP_EOL;
				echo 'Lunas (sin crear): '.format_number($this->bigbang->stats['moons']).PHP_EOL.PHP_EOL;
				echo 'Records:'.PHP_EOL;
				echo '	Estrella más masiva:'.PHP_EOL;
				echo '		ID-> '.format_number($this->bigbang->records['max_star_mass']['id']).PHP_EOL;
				echo '		Masa-> '.format_number($this->bigbang->records['max_star_mass']['mass'], 2).' masas solares'.PHP_EOL;
				echo '	Estrella menos masiva:'.PHP_EOL;
				echo '		ID-> '.format_number($this->bigbang->records['min_star_mass']['id']).PHP_EOL;
				echo '		Masa-> '.format_number($this->bigbang->records['min_star_mass']['mass'], 2).' masas solares'.PHP_EOL;
				echo '	Planeta más masivo:'.PHP_EOL;
				echo '		ID-> '.format_number($this->bigbang->records['max_planet_mass']['id']).PHP_EOL;
				echo '		Masa-> '.$this->bigbang->records['max_planet_mass']['mass'].' Kg'.PHP_EOL;
				echo '	Planeta menos masivo:'.PHP_EOL;
				echo '		ID-> '.format_number($this->bigbang->records['min_planet_mass']['id']).PHP_EOL;
				echo '		Masa-> '.$this->bigbang->records['min_planet_mass']['mass'].' Kg'.PHP_EOL;
				echo '	Planeta más caliente:'.PHP_EOL;
				echo '		ID-> '.format_number($this->bigbang->records['max_planet_temp']['id']).PHP_EOL;
				echo '		Temperatura-> '.format_number($this->bigbang->records['max_planet_temp']['temp'], 2).' ºK'.PHP_EOL;
				echo '	Planeta más frío:'.PHP_EOL;
				echo '		ID-> '.format_number($this->bigbang->records['min_planet_temp']['id']).PHP_EOL;
				echo '		Temperatura-> '.format_number($this->bigbang->records['min_planet_temp']['temp'], 2).' ºK'.PHP_EOL;

				echo PHP_EOL;

				if ( ! $this->bigbang->save_galaxy())
				{
					echo 'Ocurrió un error al guardar la galaxia'.PHP_EOL;
				}
				else
				{
					echo 'Galaxia guardada'.PHP_EOL;
				}
			}
			else
			{
				echo 'Ocurrio un error al crear la galaxia'.PHP_EOL;
			}

			if ($this->config->item('debug'))
			{
				echo 'Tiempo tardado en crear la galaxia: '.format_number($this->benchmark->elapsed_time('galaxy_start', 'galaxy_end'), 4).' segundos'.PHP_EOL;
				echo 'Tiempo tardado en guardar las '.format_number($stars).' estrellas: '.format_number($this->benchmark->elapsed_time('stars_start', 'stars_end'), 4).' segundos'.PHP_EOL;
			}

			if ( ! $this->bigbang->finish())
			{
				echo 'El Big Bang no ha podido acabarse con éxito'.PHP_EOL.PHP_EOL;
			}
			else
			{
				echo 'Big Bang acabado correctamente'.PHP_EOL.PHP_EOL;
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