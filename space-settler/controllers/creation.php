<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Creation extends SPS_Controller {

	public function index()
	{
		if($this->input->is_cli_request())
		{
			$this->load->library('bigbang');
			if($this->bigbang->create_galaxy(mt_rand(95000, 105000)))
			{
				echo 'Galaxia creada'.PHP_EOL;
				if( ! $this->bigbang->save_galaxy())
				{
					echo 'Ocurrió un error al guardar la galaxia'.PHP_EOL;
				}
				else
				{
					echo 'Galaxia guardada'.PHP_EOL;
					echo 'Datos:'.PHP_EOL;
					echo 'Estrellas: '.number_format($this->bigbang->stats['stars'], 0, ',', ' ').PHP_EOL;
					echo 'Cinturones de asteroides: '.number_format($this->bigbang->stats['belts'], 0, ',', ' ').PHP_EOL;
					echo 'Planetas: '.number_format($this->bigbang->stats['planets'], 0, ',', ' ').PHP_EOL;
					echo 'Lunas: '.number_format($this->bigbang->stats['moons'], 0, ',', ' ').PHP_EOL;
				}
			}
			else
			{
				echo 'Ocurrio un error al crear la galaxia'.PHP_EOL;
			}
		}
		else
		{
			log_message('erro', 'User with IP '.$this->input->ip_address().' has tried to access /creation from the browser.');
			redirect('/', 'location', 301);
		}
	}
}


/* End of file creation.php */
/* Location: ./space_settler/controllers/creation.php */