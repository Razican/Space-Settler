<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Physics constants
 *
 * @subpackage	Libraries
 * @author		Razican
 * @category	Libraries
 * @link		http://www.razican.com/
 */

$config['Boltzman_constant']	= 8.972012087E-16; //Based on solar parameters, not in IS (1/5778^4)
$config['gas_constant']			= 8.3144621; // J/(mol*K)
$config['star_types']			= 'OBAFGKM';
$config['UA']					= 1.49597870E+12; //m

/**
 * Sun constants
 */

$config['sun_radius']		= 696E+6; //m
$config['sun_mass']			= 19891E+26; //Kg
$config['sun_luminosity']	= 384.6E+24; //W
$config['sun_temperature']	= 5778; //K

/**
 * Earth constants
 */

$config['earth_radius']		= 6371E+3; //m
$config['earth_mass']		= 5.9736E+24; //Kg
$config['earth_atmosphere']	= 101325; //Pa
$config['earth_density']	= 5515; //Kg/m³

/* End of file physics.php */
/* Location: ./space_settler/config/physics.php */