<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Physics constants
 *
 * @subpackage	Libraries
 * @author		Razican
 * @category	Libraries
 * @link		http://www.razican.com/
 */

$config['Boltzman_constant']	= 8.972012087E-016; //Based on solar parameters, not in IS (1/5778^4)
$config['gas_constant']			= 8.3144621; // J/(mol*K)
$confis['star_types']			= 'OBAFGKM';
$config['UA']					= 1.49597870E+012; //m

/**
 * Sun constants
 */

$config['sun_radius']		= 696E+006; //m
$config['sun_mass']			= 19891E+026; //Kg
$config['sun_luminosity']	= 384.6E+024; //W
$config['sun_temperature']	= 5778; //K

/**
 * Earth constants
 */

$config['earth_radius']		= 6371E+003; //m
$config['earth_mass']		= 5.9736E+024; //Kg
$config['earth_atmosphere']	= 101325; //Pa
$config['earth_density']	= 5515; //Kg/m³