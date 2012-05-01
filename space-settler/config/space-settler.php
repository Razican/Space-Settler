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

$config['version']		= 'Pre-Alpha 3-dev';

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
| than spanish.
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
| Minimum password lenght
|--------------------------------------------------------------------------
|
| This will be the minimum lenght for a password
|
*/
$config['min_pass_lenght']	= 6;

/*
|--------------------------------------------------------------------------
| Default date format
|--------------------------------------------------------------------------
|
| This will be the default format when showing date
|
*/
$config['date_format']	= '%WEEKDAY% %DAY-0% %OF% %MONTHNAME% %OF% %YEAR% - %HOUR%:%MINUTE%'; //Jueves 1 de Diciembre de 2011 - 18:50

/*
|--------------------------------------------------------------------------
| Game's name, description and keywords
|--------------------------------------------------------------------------
|
| These variables will add a description, a name and some keywords for the
| game.
|
*/
$config['game_name']	= 'Space Settler';
$config['keywords']		= 'juego, online, multijugador, online, espacio, realista, naves, planetas, universo';
$config['description']	= 'Juego online multijugador de colonización realista';
$config['long_descr']	= 'Space Settler es un juego online multijugador, en el que controlarás un imperio con el que podrás colonizar otros mundos, entrar en guerra con otros usuarios y descubrir las sorprendentes cosas que te deparará un universo casi infinito.';

/*
|--------------------------------------------------------------------------
| Inactives management
|--------------------------------------------------------------------------
|
| These are the 	reasons for considering an user inactive, in seconds:
| reg_inactive: 	Once a user is registered, the ammount of time it has
| 					to validate it's email address.
| hib_inactive:		The max ammount of time an user can hibernate. After this,
| 					the user will automatically des-hibernate.
| email_inactive:	The ammount of time the user has to activate he's email
|					address after he has changed.
| inactive:			The ammount of time an ordinary user can be without visiting
| 					the game.
| min points:		The minimum points an user must have a given time after
| 					registering to the game.
| min_p_time:		The time for calculating the minimum points.
| warn_inact:		The time before deleting an account when a user gets warned.
|
*/
$config['reg_inactive']		= 259200; //60*60*24*3
$config['email_inactive']	= 604800; //60*60*24*7
$config['hib_inactive']		= 2592000; //60*60*24*30
$config['inactive']			= 604800; //60*60*24*7
//$config['min_points']		= 0;
//$config['min_p_time']		= 432000; //60*60*24*5
$config['warn_inact']		= 86400; //60*60*24


/* End of file space-settler.php */
/* Location: ./application/config/space-settler.php */