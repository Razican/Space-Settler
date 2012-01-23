<?php header ('Content-type: application/xhtml+xml; charset=utf-8');
		echo doctype('xhtml-rdfa-2'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es<?php //echo $this->lang->lang(); ?>">
<head>
	<title><?php echo config_item('game_name'); ?></title>
	<link rel="shortcut icon" href="<?php echo site_url("images/favicon.ico"); ?>" />
	<meta http-equiv="content-script-type" content="text/javascript" />
	<meta http-equiv="content-style-type" content="text/css" />
	<!-- <meta name="description" content="<?php echo lang('overal.description'); ?>" />
	<meta name="keywords" content="" /> -->
	<?php if ($this->config->item('debug')) : ?>
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("css/profiler.css"); ?>" />
	<?php endif; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("css/overal.css"); ?>" />
	<?php if (defined('ADMIN')) : ?>
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("css/admin.css"); ?>" />
	<?php elseif (defined('LOGIN')) : ?>
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("css/login.css"); ?>" />
	<?php else : ?>
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("css/ingame.css"); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("css/".skin()."/style.css"); ?>" />
	<?php endif; ?>
	<!-- <link href="http://x-batle.razican.com/" title="<?php echo lang('overal.title'); ?>" rel="index" />
	<link rel="canonical" href="<?php echo base_url(); ?>" /> -->
	<script charset="utf-8" type="text/javascript" src="<?php echo site_url("javascript/overlib.js"); ?>"></script>
</head>
<body <?php if ( ! $this->config->item('debug')) : ?>style="overflow: hidden;" <?php endif; ?>>
