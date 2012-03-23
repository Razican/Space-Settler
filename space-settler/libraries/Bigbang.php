<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Bigbang Class
 *
 * @subpackage	Libraries
 * @author		Razican
 * @category	Libraries
 * @link		http://www.razican.com/
 */

class Bigbang
{
	private	$current_galaxies;
	private	$current_stars;
	private	$current_bodies;
	private $stars		= array();
	private $belts		= array();
	private $planets	= array();
	private $moons		= array();

	public	$stats		= array();

	public function __construct()
	{
		$this->current_galaxies	= $this->_count_galaxies();
		$this->current_stars	= $this->_count_stars();
		$this->current_bodies	= $this->_count_bodies();
		$this->stats			= array('stars' => 0, 'belts' => 0, 'planets' => 0, 'moons' => 0);

		require_once(APPATH.'entities/body.php');
		require_once(APPATH.'entities/bodies/star.php');
		require_once(APPATH.'entities/bodies/belt.php');
		require_once(APPATH.'entities/bodies/planet.php');
		require_once(APPATH.'entities/bodies/moon.php');
	}

	/**
	 * Create a new galaxy
	 *
	 * @access	public
	 * @param	int
	 * @return	boolean
	 */
	public function create_galaxy($stars)
	{
		for($i = 1; $i <= $stars; $i++)
		{
			/* Star Creation */
			$star			= new Star($this->current_stars, $this->current_galaxies);
			$this->stars[]	=& $star;
			$this->stats['stars']++;
			$this->current_stars++;

			/* Planets and asteroid belts creation */
			$star_bodies	= $star->num_bodies(TRUE);
			for($h = 1; $h <= $star_bodies; $h++)
			{
				if(mt_rand(1,10) === 1)
				{
					/* Asteroid Belt */
					$this->belts[]		= new Belt($star, $this->current_bodies(), $h);
					$this->stats['belts']++;
					$this->current_bodies++;
				}
				else
				{
					/* Planet */
					$planet				= new Planet($star, $this->current_bodies(), $h);
					$this->planets[]	=& $planet;
					$this->stats['planets']++;
					$this->current_bodies++;

					$planet_moons		= $planet->num_moons(TRUE);
					for($g = 1; $g <= $planet_moons; $g++)
					{
						/* Moons */
						$this->moons[]		= new Moon($planet, $this->current_bodies(), $g);
						$this->stats['moons']++;
						$this->current_bodies++;
					}

					$planet->finish();
				}
			}

			$star->finish();
		}
		$this->current_galaxies++;
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
		$stars		= $CI->db->insert_batch('stars', $this->stars);

		/* Planet Insertion */
		$planets	= $CI->db->insert_batch('bodies', $this->planets);

		/* Asteroid belt insertion */
		$belts		= $CI->db->insert_batch('bodies', $this->belts);

		/* Moon insertion */
		$moons		= $CI->db->insert_batch('bodies', $this->moons);

		return ($stars && $planets && $belts && $moons);
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

		foreach($query->result() as $total);

		return is_null($total) ? 0 : $total;
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
}


/* End of file Bigbang.php */
/* Location: ./space_settler/libraries/Bigbang.php */