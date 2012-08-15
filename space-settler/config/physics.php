<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Physics constants
 *
 * @subpackage	Configuration
 * @author		Razican
 * @category	Physics
 * @link		http://www.razican.com/
 */

$config['Boltzman_constant']	= 5.6704E-8; // W*m⁻²*K⁻⁴
$config['gas_constant']			= 8.3144621; // J*mol⁻¹*K⁻¹
$config['AU']					= 1.4959787E+11; //m
$config['G']					= 6.67428E-11; //N*m²*Kg⁻²
$config['c']					= 299792458; //m*s⁻¹

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
$config['earth_density']	= 5515; //Kg*m⁻³

/* End of file physics.php */
/* Location: ./space_settler/config/physics.php */