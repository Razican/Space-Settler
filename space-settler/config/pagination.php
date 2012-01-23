<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Pagination Configuration
|--------------------------------------------------------------------------
|
| This is the main configuation for the pagination class. We will then add
| more configuration options in the controller.
|
*/
$config['num_links']		= 2;

$config['full_tag_open']	= '<div id="pagination">';
$config['full_tag_close']	= '</div>';

$config['next_link']		= '&gt;';
$config['prev_link']		= '&lt;';

$config['cur_tag_open']		= '<b>';
$config['cur_tag_close']	= '</b>';

$config['anchor_class']		= 'pagination';


/* End of file pagination.php */
/* Location: ./megapublik/config/pagination.php */