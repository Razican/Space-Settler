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
	private $stars		= array();
	private $belts		= array();
	private $planets	= array();
	private $moons		= array();

	public	$stats		= array();
	public	$records	= array();

	private $debug		= array();

	public function __construct()
	{
		$this->current_galaxies	= $this->_count_galaxies();
		$this->current_stars	= $this->_count_stars();
		$this->current_bodies	= $this->_count_bodies();

		$this->stats			= array('1_stars' => 0, '2_stars' => 0, '3_stars' => 0, '4_stars' =>0,
										'O_stars' => 0, 'B_stars' => 0, 'A_stars' => 0, 'F_stars' => 0, 'G_stars' => 0,
										'K_stars' => 0, 'M_stars' => 0, 'belts' => 0, 'planets' => 0, 'planets_0' => 0,
										'planets_1' => 0, 'hot_planets' => 0, 'hot_jupiters' => 0, 'earths' => 0, 'moons' => 0);

		$this->records			= array('max_star_mass' => array('id' => NULL, 'mass' => NULL), 'min_star_mass' => array('id' => NULL, 'mass' => NULL),
										'max_planet_mass' => array('id' => NULL, 'mass' => NULL), 'min_planet_mass' => array('id' => NULL, 'mass' => NULL),
										'max_planet_temp' => array('id' => NULL, 'temp' => NULL), 'min_planet_temp' => array('id' => NULL, 'temp' => NULL),
										);

		$this->debug			= array('maxmass_planets' => 0);

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

		for ($i = 1; $i <= $solar_systems; $i++)
		{
			/* Star Creation */
			$star			= new Star($this->current_stars, $this->current_galaxies);
			$this->stats[$star->type.'_stars']++;
			if (is_null($this->records['max_star_mass']['id']) OR $this->records['max_star_mass']['mass'] < $star->mass)
				$this->records['max_star_mass'] = array('id' => $star->id, 'mass' => $star->mass);
			if (is_null($this->records['min_star_mass']['id']) OR $this->records['min_star_mass']['mass'] > $star->mass)
				$this->records['min_star_mass'] = array('id' => $star->id, 'mass' => $star->mass);

			$this->stars[]	= $star;
			$this->current_stars++;

			/* Planets and asteroid belts creation */
			$star_bodies	= $star->bodies;
			$last_distance	= 0;
			for ($h = 1; $h <= $star_bodies; $h++)
			{
				if(mt_rand(1,10) === 1)
				{
					/* Asteroid Belt */
		//			$this->belts[]		= new Belt($star, $this->current_bodies(), $h);
		//			$this->stats['belts']++;
		//			$this->current_bodies++;
				}
				else
				{
					/* Planet */
					$planet				= new Planet($star, $this->current_bodies, $h, $last_distance);
					$this->planets[]	=& $planet;
					$this->stats['planets']++;
					$this->stats['planets_'.$planet->type]++;
					if ( ! $planet->type && $planet->radius > 6E+6 && $planet->radius < 65E+5
						&& $planet->mass > 25E+23 && $planet->mass < 1E+25)
						$this->stats['earths']++;
					if ( ! $planet->type && $planet->temperature['eff'] > 1000) $this->stats['hot_planets']++;
					if ($planet->type && $planet->temperature['eff'] > 1000) $this->stats['hot_jupiters']++;

					if (is_null($this->records['max_planet_mass']['id']) OR $this->records['max_planet_mass']['mass'] < $planet->mass)
						$this->records['max_planet_mass'] = array('id' => $planet->id, 'mass' => $planet->mass);
					if ($planet->mass !== 0 && (is_null($this->records['min_planet_mass']['id']) OR $this->records['min_planet_mass']['mass'] > $planet->mass))
						$this->records['min_planet_mass'] = array('id' => $planet->id, 'mass' => $planet->mass);
					if (( ! $planet->type) && (is_null($this->records['max_planet_temp']['id']) OR $this->records['max_planet_temp']['temp'] < $planet->temperature['max']))
						$this->records['max_planet_temp'] = array('id' => $planet->id, 'temp' => $planet->temperature['max']);
					if (( ! $planet->type) && (is_null($this->records['min_planet_temp']['id']) OR $this->records['min_planet_temp']['temp'] > $planet->temperature['min']))
						$this->records['min_planet_temp'] = array('id' => $planet->id, 'temp' => $planet->temperature['eff']);
					if ($planet->type && (is_null($this->records['max_planet_temp']['id']) OR $this->records['max_planet_temp']['temp'] < $planet->temperature['eff']))
						$this->records['max_planet_temp'] = array('id' => $planet->id, 'temp' => $planet->temperature['eff']);
					if ($planet->type && (is_null($this->records['min_planet_temp']['id']) OR $this->records['min_planet_temp']['temp'] > $planet->temperature['eff']))
						$this->records['min_planet_temp'] = array('id' => $planet->id, 'temp' => $planet->temperature['eff']);

					$this->current_bodies++;

		//			$planet_moons		= $planet->num_moons(TRUE);
		//			for ($g = 1; $g <= $planet_moons; $g++)
		//			{
		//				/* Moons */
		//				$this->moons[]		= new Moon($planet, $this->current_bodies(), $g);
		//				$this->stats['moons']++;
		//				$this->current_bodies++;
		//			}

					$last_distance = $planet->orbit['sma'];
		//			$planet->finish();
				}
			}
			//Create dwarf-planets (Kuiper's Belt)

			$star->finish();
		}
		$this->current_galaxies++;

		$CI->benchmark->mark('galaxy_end');

		return TRUE;
	}

	/**
	 * Save the new galaxy
	 *
	 * @access	public
	 * @return	boolean
	 */
	public function save_galaxy()
	{
		$CI		=& get_instance();

		/* Star Insertion */
		$CI->benchmark->mark('stars_start');
		$stars		= $CI->db->insert_batch('stars', $this->stars);
		$CI->benchmark->mark('stars_end');

		/* Planet Insertion */
	//	$planets	= $CI->db->insert_batch('bodies', $this->planets);

		/* Asteroid belt insertion */
	//	$belts		= $CI->db->insert_batch('bodies', $this->belts);

		/* Moon insertion */
	//	$moons		= $CI->db->insert_batch('bodies', $this->moons);

		return $stars;//($stars && $planets && $belts && $moons);
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
	 * Get the number bodies in the current universe
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