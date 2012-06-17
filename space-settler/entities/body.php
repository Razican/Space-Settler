<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Body class
 *
 * @subpackage	Entities
 * @author		Razican
 * @category	Bodies
 * @link		http://www.razican.com/
 */
class Body {

	public $id;
	public $orbit;
	public $type;
	public $mass;
	public $radius;
	public $density;
	public $temperature;

	public function __construct()
	{
		//Nothing for the moment
	}

	/**
	 * Return the volume of a body
	 *
	 * @return	float	Volume in m³
	 */
	public function volume()
	{
		return 4/3*M_PI*pow($this->radius, 3);
	}

	/**
	 * Calculate the density of a body
	 */
	private function _density()
	{
		$this->density	= $this->mass/$this->volume();
	}
}


/* End of file body.php */
/* Location: ./space_settler/entities/body.php */