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
	public	$current_stars;
	public	$current_bodies;
	public	$stars			= array();
	private	$stars_p		= array();
	public	$planets		= array();
	public	$moons			= array();
	private	$galaxy			= NULL;
	private	$last_planet	= 0;

	public function __construct()
	{
		$CI =& get_instance();
		$CI->config->load('physics');
	}

	/**
	 * Create a planet
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 * return	bool
	 */
	public function create_planet($position, $star_id)
	{
		$CI			=& get_instance();

		$distance	= $this->_distance($position, $star_id);
		$radius		= $this->_radius($distance/10000, $star_id);
		$mass		= $this->_mass($radius, $star_id);

		if($radius && $mass && $distance)
		{
			$habitable	= $this->_is_habitable($distance, $radius, $mass*$CI->config->item('earth_mass')/10000, $star_id);
			$water		= $habitable ? mt_rand(1,10000) : 0;
			$habitable	= $water > 1000 && $water < 9500 ? 1 : 0;
			$density	= round($this->_density($radius, $mass*$CI->config->item('earth_mass')/10000));
			$this->planets[] = array('star' => $star_id+$this->current_stars+1, 'position' => $position, 'mass' => $mass, 'radius' => $radius, 'density' => $density, 'distance' => $distance, 'habitable' => $habitable, 'water' => $water, 'double_planet' => 0);
			$this->create_moons($star_id);
			$this->last_planet++;
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Create moons for a planet
	 *
	 * @access	public
	 * @param	int
	 * @return	void
	 */
	public function create_moons($star)
	{
		$CI				=& get_instance();

		$planet_id		= $this->last_planet;
		$planet			= $this->planets[$planet_id];
		$double_planet	= $planet['mass'] < 100 ? mt_rand(0,1) : 0;
		$moon_num		= round(pow($planet['mass'], 0.34));
		$min_moons		= $moon_num > 20 ? $moon_num - 20 : ($double_planet ? 1 : 0);
		$max_moons		= $double_planet ? 4+$moon_num : 2+$moon_num;
		$moon_num		= mt_rand($min_moons, $max_moons);
		$max_mass		= $planet['mass'] > (1E+5/3) ? 1/30 : $planet['mass']/1E+6; //masas terrestres
		$star_distance	= $planet['distance'];

		if($double_planet)
		{
			$radius		= mt_rand(round($planet['radius']*0.1), round($planet['radius']*0.5));
			$mass		= mt_rand(round($planet['mass']/10), round($planet['mass']/2)); //Masas terrestres/10.000
			$mass		= round($mass*1E+17);
			$distance	= (9900)/$moon_num+100;
			$distance	= mt_rand(round($distance*0.95), round($distance*1.05));

			if($radius && $mass && $distance && $planet)
			{
				$planet		= $planet_id+1+$this->current_bodies;
				$habitable	= $this->_is_habitable($star_distance, $radius, $mass, $star);
				$water		= $habitable ? mt_rand(1,10000) : 0;
				$habitable	= $water > 1000 && $water < 9500 ? 1 : 0;
				$density	= 0;//round($this->_density($radius, $mass*$CI->config->item('earth_mass')/1E+17));
				$this->moons[] = array('star' => $star+$this->current_stars+1, 'position' => 1, 'type' => 1, 'planet' => $planet, 'mass' => $mass, 'radius' => $radius, 'density' => $density, 'distance' => $distance, 'habitable' => $habitable, 'water' => $water, 'double_planet' => 1);
				$this->planets[$planet_id]['double_planet'] = 1;
			}
		}

		$planet		= $planet_id+1+$this->current_bodies;

		for($i=$double_planet; $i<$moon_num; $i++)
		{
			$radius		= mt_rand(10000, 3000000);
			$density	= mt_rand(150000, 700000);
			$mass		= round(volume($radius)*$density)/100;
			$mass		= $mass > $max_mass ? mt_rand(round($max_mass*0.95), round($max_mass)) : $mass;
			$mass		= round($mass/$CI->config->item('earth_mass')*1E+17);
			$distance	= ($i+1)*(9900)/$moon_num+100;
			$distance	= mt_rand(round($distance*0.95), round($distance*1.05));

			if($radius && $mass && $distance && $planet)
			{
				$habitable	= $this->_is_habitable($star_distance, $radius, $mass, $star);
				$water		= $habitable ? mt_rand(1,10000) : 0;
				$habitable	= $water > 1000 && $water < 9500 ? 1 : 0;
				$density	= 0;//round($this->_density($radius, $mass*$CI->config->item('earth_mass')/1E+17));
				$this->moons[] = array('star' => $star+$this->current_stars+1, 'position' => $i+1, 'type' => 1, 'planet' => $planet, 'mass' => $mass, 'radius' => $radius, 'density' => $density, 'distance' => $distance, 'habitable' => $habitable, 'water' => $water, 'double_planet' => 0);
			}
		}
	}
	/**
	 * Create a star
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	public function create_star($system)
	{
		$CI		=& get_instance();
		if ( ! $this->galaxy)
		{
			$CI->db->select_max('galaxy');
			$CI->db->select('galaxy');
			$CI->db->limit(1);
			$query	= $CI->db->get('stars');
			if($query->num_rows() > 0)
				foreach($query->result() as $star) $this->galaxy = $star->galaxy ? $star->galaxy+1 : 1;
		}
		$galaxy = $this->galaxy;

		$type	= substr($CI->config->item('star_types'), mt_rand(0, 6), 1);

		switch($type)
		{
			case 'O':
				$mass			= mt_rand(36E+2, 65E+2);
				$temperature	= mt_rand(28000, 50000);
				$radius			= mt_rand(900, 2500);
			break;
			case 'B':
				$mass			= mt_rand(650, 36E+2);
				$temperature	= mt_rand(9600, 28000);
				$radius			= mt_rand(490, 1000);
			break;
			case 'A':
				$mass			= mt_rand(240, 650);
				$temperature	= mt_rand(7100, 9600);
				$radius			= mt_rand(150, 490);
			break;
			case 'F':
				$mass			= mt_rand(140, 240);
				$temperature	= mt_rand(5700, 7100);
				$radius			= mt_rand(120, 150);
			break;
			case 'G':
				$mass			= mt_rand(95, 140);
				$temperature	= mt_rand(4600, 5700);
				$radius			= mt_rand(100, 120);
			break;
			case 'K':
				$mass			= mt_rand(55, 95);
				$temperature	= mt_rand(3200, 4600);
				$radius			= mt_rand(65, 100);
			break;
			case 'M':
				$mass			= mt_rand(16, 55);
				$temperature	= mt_rand(1700, 3200);
				$radius			= mt_rand(24, 65);
		}

		$luminosity				= round(pow($radius/10000, 2)*$CI->config->item('Boltzman_constant')*pow($temperature, 4)*1E+12);

		if($mass && $radius && $temperature && $luminosity)
		{
			$this->stars[]		= array('galaxy' => $galaxy, 'system' => $system, 'type' => $type, 'mass' => $mass, 'radius' => $radius, 'luminosity' => $luminosity, 'temperature' => $temperature);
			$this->stars_p[]	= array();
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Calculate the density of an object based on its radius and mass
	 *
	 * @access	private
	 * @param	int		Radius in metres
	 * @param	int		Mass in Kg
	 * @return	int		Density in Kg/m³
	 */
	private function _density($radius, $mass)
	{
		return ($mass/volume($radius));
	}

	/**
	 * Calculate a planet's distance to sun based on its position,
	 * using Titius-Bode Law.
	 *
	 * @access	private
	 * @param	int
	 * @param	int
	 * @return	int
	 */
	private function _distance($position, $star_id)
	{
		if( ! isset($this->stars_p[$star_id]['m']))
		{
			$this->stars_p[$star_id]['m']	= mt_rand(35E+3, 6E+5)/1E+6;
			$n		= 25*log($this->stars_p[$star_id]['m']/12+1)+0.4;
			$this->stars_p[$star_id]['n']	= mt_rand(round($n*999E+3), round($n*1001E+3))/1E+6;
		}
		$m			= $this->stars_p[$star_id]['m'];
		$n			= $this->stars_p[$star_id]['n'];

		$distance	= exp(($m*$position - $n))*100;
		return mt_rand(round($distance*0.9), round($distance*1.1));
	}

	/**
	 * Return the size of a future planet based on its position and star
	 *
	 * @access	private
	 * @param	int		distance in AU
	 * @param	int
	 * @return	int
	 */
	private function _radius($distance, $star_id)
	{
		$CI											=& get_instance();
		$probability								= mt_rand(1, 100);
		$max_radius									= $this->stars_p[$star_id]['max_radius'];

		if($distance < 35)
		{
			if($probability <= 30) $radius		= mt_rand(4E+5, 1E+6);
			elseif($probability <= 70) $radius	= mt_rand(1E+6, 15E+6);
			else $radius						= mt_rand(15E+6, 125E+6);
		} else {
			$radius								= mt_rand(4E+5, 15E+5);
		}

		return $radius > $max_radius ? mt_rand(round($max_radius*0.95), round($max_radius)) : $radius;
	}

	/**
	 * Decide whether a planet is habitable or not
	 *
	 * @access	private
	 * @param	int		Distance in AU
	 * @param	int		Radius in metres
	 * @param	int		Mass in Kg
	 * @param	int
	 * @return	int
	 */
	private function _is_habitable($distance, $radius, $mass, $star_id)
	{
		$CI					=& get_instance();

		$habitable_zone		= sqrt($this->stars[$star_id]['luminosity']*1E-12)*100;
		$habitable_zone_min	= round($habitable_zone*0.95);
		$habitable_zone_max	= round($habitable_zone*1.05);
		$gravity			= gravity($mass, $radius);
		$density			= $this->_density($radius, $mass);

		if(	($distance	< $habitable_zone_min) OR
			($distance	> $habitable_zone_max) OR
			($gravity	< 3) OR ($gravity > 15) OR
			($density	< 1500)) return 0;

		return 1;
	}

	/**
	 * Return the mass of a planet based on
	 *
	 * @access	private
	 * @param	int
	 * @param	int
	 * @return	int
	 */
	private function _mass($radius, $star_id)
	{
		$CI		=& get_instance();

		$this->stars_p[$star_id]['max_mass']	= isset($this->stars_p[$star_id]['max_mass']) ? $this->stars_p[$star_id]['max_mass'] : round($this->stars[$star_id]['mass']*$CI->config->item('sun_mass')/(50000*$CI->config->item('earth_mass')));
		$this->stars_p[$star_id]['max_mass']	= $this->stars_p[$star_id]['max_mass'] > 60000000 ? 60000000 : $this->stars_p[$star_id]['max_mass'];
		$max_mass = $this->stars_p[$star_id]['max_mass'];

		if($radius < 1E+6)		$density	= mt_rand(15000000, 30000000);
		elseif($radius < 16E+6) $density	= mt_rand(30000000, 150000000);
		elseif($radius < 50E+6) $density	= mt_rand(15000000, 30000000);
		else					$density	= mt_rand(1500000, 15000000);

		$mass	= round(volume($radius)*$density/$CI->config->item('earth_mass'));
		$mass	= $mass > $max_mass ? mt_rand(round($max_mass*0.95), $max_mass) : $mass;

		return $mass;
	}
}

/* End of file Bigbang.php */
/* Location: ./space_settler/libraries/Bigbang.php */