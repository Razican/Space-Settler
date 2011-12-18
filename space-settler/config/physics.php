<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Physics constants
 *
 * @subpackage	Libraries
 * @author		Razican
 * @category	Libraries
 * @link		http://www.razican.com/
 */

$config['Stephan-Boltzman']		= 8.972012087E-016; //Based on solar parameters, not in IS (1/5778^4)
$confis['star_types']			= 'OBAFGKM';
$config['UA']					= 1.49597870E+009; //Km

/**
 * Sun constants
 */

$config['sun_radius']		= 696E+003; //Km
$config['sun_mass']			= 19891E+026; //Kg
$config['sun_luminosity']	= 384.6E+024; //W
$config['sun_temperature']	= 5778; //K