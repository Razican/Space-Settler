<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Creation extends SPS_Controller {

	public function index()
	{
		if(TRUE)//$this->input->is_cli_request())
		{
			$this->config->load('physics');
			$this->load->library('bigbang');
			if($this->bigbang->create_galaxy(10))//mt_rand(95000, 105000)))
			{
				echo 'Galaxia creada'.PHP_EOL;
				echo 'Datos:'.PHP_EOL;
				echo 'Agujeros Negros: '.number_format($this->bigbang->stats['1_stars'], 0, ',', ' ').PHP_EOL;
				echo 'Estrellas de Neutrones: '.number_format($this->bigbang->stats['2_stars'], 0, ',', ' ').PHP_EOL;
				echo 'Estrellas de Quarks: '.number_format($this->bigbang->stats['3_stars'], 0, ',', ' ').PHP_EOL;
				echo 'Enanas Blancas: '.number_format($this->bigbang->stats['4_stars'], 0, ',', ' ').PHP_EOL;
				echo 'Estrellas:'.PHP_EOL;
				echo 'Tipo O: '.number_format($this->bigbang->stats['O_stars'], 0, ',', ' ').PHP_EOL;
				echo 'Tipo B: '.number_format($this->bigbang->stats['B_stars'], 0, ',', ' ').PHP_EOL;
				echo 'Tipo A: '.number_format($this->bigbang->stats['A_stars'], 0, ',', ' ').PHP_EOL;
				echo 'Tipo F: '.number_format($this->bigbang->stats['F_stars'], 0, ',', ' ').PHP_EOL;
				echo 'Tipo G: '.number_format($this->bigbang->stats['G_stars'], 0, ',', ' ').PHP_EOL;
				echo 'Tipo K: '.number_format($this->bigbang->stats['K_stars'], 0, ',', ' ').PHP_EOL;
				echo 'Tipo M: '.number_format($this->bigbang->stats['M_stars'], 0, ',', ' ').PHP_EOL;
			/*	echo 'Cinturones de asteroides: '.number_format($this->bigbang->stats['belts'], 0, ',', ' ').PHP_EOL;
				echo 'Planetas: '.number_format($this->bigbang->stats['planets'], 0, ',', ' ').PHP_EOL;
				echo 'Lunas: '.number_format($this->bigbang->stats['moons'], 0, ',', ' ').PHP_EOL;*/

				if( ! $this->bigbang->save_galaxy())
					echo 'Ocurrió un error al guardar la galaxia'.PHP_EOL;
				else
					echo 'Galaxia guardada'.PHP_EOL;
			}
			else
			{
				echo 'Ocurrio un error al crear la galaxia'.PHP_EOL;
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