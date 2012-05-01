<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Planet class
 *
 * @subpackage	Entities
 * @author		Razican
 * @category	Bodies
 * @link		http://www.razican.com/
 */
final class Planet extends Body
{
	public $star;
	public $position;
	public $terrestrial;
	public $double_planet;
	public $atmosphere;
	public $albedo;
	public $habitable;
	public $water;
	public $constructions;
	public $ground;
	public $owner;

	public function __construct()
	{
		$args	= func_get_args();
		if(func_num_args() === 1)
		{
			//$this->_load($args[0]);
		}
		else
		{
			parent::__construct();

			$this->id				= $args[1]+1;
			$this->star				= &$args[0];
			$this->position			= $args[2]+1;
			$this->planet			= NULL;
			$this->_orbit($args[3]);
		//	$this->_type();
		//	$this->_properties();
		//	$this->_density();
		//	$this->_luminosity();
		//	$this->is_habitable(TRUE);

		//	$this->_titius_bode();
		}
	}

	private function _orbit($last_distance)
	{
		$this->orbit = array();

		$sma					= exp($this->star->tn['m']*$this->position - $this->star->tn['n'])*100;
		$sma					= mt_rand(round($sma*0.9), round($sma*1.1))/100;
		$this->orbit['sma']		= $sma < $last_distance ? $last_distance+0.05 : $sma;
		$this->orbit['ecc']		= ($this->orbit['sma'] < ($this->star->mass/2) ? mt_rand(50, 250) : mt_rand(0, 100))/1000;
		$this->orbit['incl']	= (mt_rand(0, 100)/10)*M_PI/180;
		$this->orbit['lan']		= (mt_rand(0, 3599)/10)*M_PI/180;
		$this->orbit['ArgPe']	= (mt_rand(0, 3599)/10)*M_PI/180;
		$this->orbit['Ma0']		= (mt_rand(0, 3599)/10)*M_PI/180;
	}
}


/* End of file planet.php */
/* Location: ./space_settler/entities/bodies/planet.php */