<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Protocol
|--------------------------------------------------------------------------
|
| The mail sending protocol. These are the posibe values for the protocol:
| mail, sendmail, or smtp.
|
*/
$config['protocol']		= 'smtp';

/*
|--------------------------------------------------------------------------
| SMTP host
|--------------------------------------------------------------------------
|
| SMTP Server Address. For Gmail, use ssl://smtp.googlemail.com.
|
*/
$config['smtp_host']	= 'ssl://smtp.googlemail.com';

/*
|--------------------------------------------------------------------------
| SMTP username
|--------------------------------------------------------------------------
|
| The username for the SMTP host for sending email.
|
*/
$config['smtp_user']	= 'space-settler@razican.com';

/*
|--------------------------------------------------------------------------
| SMTP password
|--------------------------------------------------------------------------
|
| The password for the SMTP username. in case there is no need for it,
| leave it blank: '';
|
*/
$config['smtp_pass']	= 'verysecretpass';

/*
|--------------------------------------------------------------------------
| SMTP port
|--------------------------------------------------------------------------
|
| The port the SMTP server uses. For Gmail, use 465, if not, use the
| one for that server. If you don't have a default, comment the line:
| //$config['smtp_port']	= 465;
|
*/
$config['smtp_port']	= 465;

/*
|--------------------------------------------------------------------------
| Mail type
|--------------------------------------------------------------------------
|
| Type of mail. If you send HTML email you must send it as a complete web
| page. Make sure you don't have any relative links or relative image
| paths otherwise they will not work. Possible values: 	text or html.
|
*/
$config['mailtype']		= 'html';

/*
|--------------------------------------------------------------------------
| New lines
|--------------------------------------------------------------------------
|
| Newline character. (Use "\r\n" to comply with RFC 822). Possible values:
| "\r\n" or "\n" or "\r". IMPORTANT: use " instead of '.
|
*/
$config['newline']		= "\r\n";

/*
|--------------------------------------------------------------------------
| User Agent
|--------------------------------------------------------------------------
|
| The user agent the mail class will use when sending the email.
|
*/
$config['useragent']		= 'Space Settler';


/* End of file email.php */
/* Location: ./application/config/email.php */