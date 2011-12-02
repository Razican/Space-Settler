<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Game Version
|--------------------------------------------------------------------------
|
| This is the default version of the game. It will appear in the admin
| pages and will be used mainly for tracking.
|
*/

$config['version']		= '0.0.0';

/*
|--------------------------------------------------------------------------
| Timezone
|--------------------------------------------------------------------------
|
| This is the default timezone for the game. It will be used for every task
| which needs a time parameter.
|
*/

$config['timezone']		= 'Europe/Madrid';

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['language']		= 'spanish';

/*
|--------------------------------------------------------------------------
| Forum URL
|--------------------------------------------------------------------------
|
| This is the URL of the forum.
|
*/
$config['forum_url']	= 'http://www.razican.com/';

/*
|--------------------------------------------------------------------------
| Game Name
|--------------------------------------------------------------------------
|
| This will be the name used when referring to the game.
|
*/
$config['game_name']	= 'Space Settler';

/*
|--------------------------------------------------------------------------
| Minimum password lenght
|--------------------------------------------------------------------------
|
| This will be the minimum lenght for a password
|
*/
$config['min_pass_lenght']	= 6;

/*
|--------------------------------------------------------------------------
| Starting resources
|--------------------------------------------------------------------------
|
| These options will decide which will be the resources of each new user
|
*/
$config['start_fields']		= 170;
$config['start_metal_h']	= 20;
$config['start_crystal_h']	= 10;
$config['start_deuter_h']	= 0;
$config['start_metal']		= 500;
$config['start_crystal']	= 250;
$config['start_deuterium']	= 0;

/*
|--------------------------------------------------------------------------
| Maximum galaxies, systems and planets
|--------------------------------------------------------------------------
|
| These options will decide haw meny galaxies, system and planets will the
| universe have.
|
*/
$config['max_galaxies']		= 9;
$config['max_systems']		= 499;
$config['max_planets']		= 15;

/*
|--------------------------------------------------------------------------
| Default date format
|--------------------------------------------------------------------------
|
| This will be the default format when showing date
|
*/
$config['date_format']	= '%WEEKDAY% %DAY-0% %OF% %MONTHNAME% %OF% %YEAR% - %HOUR%:%MINUTE%'; //Jueves 1 de Diciembre de 2011 - 18:50


/* End of file space-settler.php */
/* Location: ./application/config/space-settler.php */