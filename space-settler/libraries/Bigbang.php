<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Bigbang Class
 *
 * @subpackage	Libraries
 * @author		Razican
 * @category	Libraries
 * @link		http://www.razican.com/
 */
class Bigbang {

	private	$current_galaxies;
	private	$current_stars;
	private	$current_bodies;

	public	$stats		= array();
	public	$records	= array();

	public function __construct()
	{
		$this->current_galaxies	= $this->_count_galaxies();
		$this->current_stars	= $this->_count_stars();
		$this->current_bodies	= $this->_count_bodies();

		$this->stats			= array('1_stars' => 0, '2_stars' => 0, '3_stars' => 0, '4_stars' =>0,
										'O_stars' => 0, 'B_stars' => 0, 'A_stars' => 0, 'F_stars' => 0,
										'G_stars' => 0, 'K_stars' => 0, 'M_stars' => 0, 'belts' => 0,
										'planets' => 0, 'planets_0' => 0, 'planets_1' => 0, 'hot_jupiters' => 0,
										'earths' => 0, 'habitable' => 0, 'moons' => 0);

		$this->records			= array('min_sma' => 0, 'max_sma' => 0, 'min_period' => 0, 'max_period' => 0,
										'min_temperature' => 0, 'max_temperature' => 0);

		require_once(APPPATH.'entities/body.php');
		require_once(APPPATH.'entities/bodies/star.php');
		require_once(APPPATH.'entities/bodies/belt.php');
		require_once(APPPATH.'entities/bodies/planet.php');
		require_once(APPPATH.'entities/bodies/moon.php');
	}

	/**
	 * Create a new galaxy
	 *
	 * @access	public
	 * @param	int			Current solar systems
	 * @return	boolean
	 */
	public function create_galaxy($solar_systems)
	{
		$CI =& get_instance();
		$CI->benchmark->mark('galaxy_start');

		//Progress bar initialization
		$columns = 0;
		preg_match_all("/rows.([0-9]+);.columns.([0-9]+);/", strtolower(exec('stty -a |grep columns')), $output);
		if(sizeof($output) == 3)
		{
			$columns = $output[2][0];
		}
		if ($columns > 0)
		{
			echo str_pad("[" , $columns-7)."]   0% ";
			$pbl = 0;
			$pbp = 0;
		}

		for ($i = 1; $i <= $solar_systems; $i++)
		{
			/* Star Creation */
			$star			= new Star($this->current_stars, $this->current_galaxies);
			$this->stats[$star->type.'_stars']++;

			$this->stars[]	= $star;
			$this->current_stars++;

			/* Planets and asteroid belts creation */
			$star_bodies	= $star->bodies;
			$planets		= array();
			$last_distance	= 0;
			for ($h = 1; $h <= $star_bodies; $h++)
			{
				if( ! mt_rand(0,10))
				{
					/* Asteroid Belt */
		//			$this->belts[]		= new Belt($star, $this->current_bodies(), $h);
		//			$this->stats['belts']++;
		//			$this->current_bodies++;
				}
				else
				{
					/* Planet */
					$planet		= new Planet($star, $this->current_bodies, $h, $last_distance);

					if ($planet->is_roche_ok)
					{
						$planets[]	= $planet;
						$this->stats['planets']++;
						$this->stats['planets_'.$planet->type]++;
						if ( ! $planet->type && $planet->radius > 6E+6 && $planet->radius < 65E+5
							&& $planet->mass > 25E+23 && $planet->mass < 1E+25)
							$this->stats['earths']++;
						if ($planet->type && $planet->temperature['eff'] > 500) $this->stats['hot_jupiters']++;
						if ($planet->habitable) $this->stats['habitable']++;

						if ($this->records['min_sma'] === 0 OR $this->records['min_sma'] > $planet->orbit['sma'])
							$this->records['min_sma'] = $planet->orbit['sma'];
						if ($this->records['max_sma'] < $planet->orbit['sma'])
							$this->records['max_sma'] = $planet->orbit['sma'];
						if ($this->records['min_period'] === 0 OR $this->records['min_period'] > $planet->orbit['period']/3600)
							$this->records['min_period'] = $planet->orbit['period']/3600;
						if ($this->records['max_period'] < $planet->orbit['period']/31536000)
							$this->records['max_period'] = $planet->orbit['period']/31536000;
						if ( ! $planet->type && ($this->records['min_temperature'] === 0 OR $this->records['min_temperature'] > $planet->temperature['min']))
							$this->records['min_temperature'] = $planet->temperature['min'];
						if ( ! $planet->type && ($this->records['max_temperature'] < $planet->temperature['max']))
							$this->records['max_temperature'] = $planet->temperature['max'];

						$this->current_bodies++;

		//			$planet_moons		= $planet->num_moons(TRUE);
		//			for ($g = 1; $g <= $planet_moons; $g++)
		//			{
		//				/* Moons */
		//				$moon				= new Moon($planet, $this->current_bodies(), $g)
		//				$this->moons[]		= $moon;
		//				$this->stats['moons']++;
		//				if ($moon->habitable) $this->stats['habitable']++;

		//				$this->current_bodies++;
		//			}

						if ($planet->orbit['sma'] > 750)
						{
							log_message('info', print_r($star, TRUE));
						}

						$last_distance = $planet->orbit['sma'];
		//			$planet->finish();
					}
					else
					{
						//TODO Crear cinturón de asteroides
					}
				}
			}
			//Create dwarf-planets (Kuiper's Belt)

			$this->_insert($star, $planets);

			if ($columns > 0)
			{
				$pbp	= $i/$solar_systems;
				$npbl	= round($pbp*($columns-8));
				$npbp	= round($pbp*100);

				if ($pbl !== $npbl OR $pbp !== $npbl)
				{
					$pbl = $npbl;
					$pbp = $npbp;
					echo str_repeat(chr(8), $columns);
					echo str_pad("[".($pbl > 0 ? str_repeat("=", $pbl-1).">" : ""), $columns-7)."]".str_pad($pbp, 4, " ", STR_PAD_LEFT)."% ";
				}
			}
			else
			{
				echo 'Creadas '.format_number($i).' estrellas'."\r";
			}
		}
		$this->current_galaxies++;

		if ($columns > 0)
		{
			echo str_repeat(chr(8), $columns);
			echo "[".str_repeat("=", $columns-8)."] 100% ".PHP_EOL.PHP_EOL;
		}

		$CI->benchmark->mark('galaxy_end');

		return TRUE;
	}

	/**
	 * Get the number of galaxies for the current universe
	 *
	 * @access	private
	 * @return	int
	 */
	private function _count_galaxies()
	{
		$CI		=& get_instance();

		$CI->db->select_max('galaxy');
		$query	= $CI->db->get('stars');

		foreach ($query->result() as $total);

		return is_null($total->galaxy) ? 0 : $total->galaxy;
	}

	/**
	 * Get the number of stars of the current universe
	 *
	 * @access	private
	 * @return	int
	 */
	private function _count_stars()
	{
		$CI		=& get_instance();

		return $CI->db->count_all_results('stars');
	}

	/**
	 * Get the number bodies in the current universe
	 *
	 * @access	private
	 * @return	int
	 */
	private function _count_bodies()
	{
		$CI		=& get_instance();

		return $CI->db->count_all_results('bodies');
	}

	/**
	 * Insert a star into the database
	 *
	 * @access	private
	 * @return	bool
	 */
	private function _insert($star, $planets)
	{
		$CI	=& get_instance();
		unset($star->bodies);
		unset($star->tb);
		$star->luminosity	= round($star->luminosity*1E+12);

		if ($star->type === '1' OR $star->type === '2' OR $star->type === '3')
		{
			$star->radius = round($star->radius);
		}
		elseif($star->type === '4')
		{
			$star->radius = round($star->radius/1000);
		}
		else
		{
			$star->radius = $star->radius*100;
		}

		$star->mass			= $star->mass*100;
		$star->density		= round($star->density*10);

		/* Planet Insertion */
	//	$planets	= $CI->db->insert_batch('bodies', $this->planets);

		/* Asteroid belt insertion */
	//	$belts		= $CI->db->insert_batch('bodies', $this->belts);

		/* Moon insertion */
	//	$moons		= $CI->db->insert_batch('bodies', $this->moons);


		return $CI->db->insert('stars', $star);
	}

	/**
	 * Finish the Big Bang and create the config file
	 *
	 * @access	public
	 * @return	boolean
	 */
	public function finish()
	{
		if($this->current_galaxies === 1)
		{
			$CI =& get_instance();
			$CI->load->helper('file');

			$path		= APPPATH.'config/universe.php';

			$text		="<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n/*\n";
			$text		.= "|--------------------------------------------------------------------------\n";
			$text		.= "| Big Bang time\n";
			$text		.= "|--------------------------------------------------------------------------\n|\n";
			$text		.= "| It tells when occurred the Big Bang (When was the universe started)\n|\n*/\n";
			$text		.= "\$config['bigbang_time']	= ".now().";\n\n\n";
			$text		.= "/* End of file universe.php */\n";
			$text		.= "/* Location: ./application/config/universe.php */";

			return write_file($path, $text);
		}

		return TRUE;
	}
}


/* End of file Bigbang.php */
/* Location: ./space_settler/libraries/Bigbang.php */
