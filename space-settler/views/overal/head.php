<?php echo doctype('xhtml-rdfa-2'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo current_lang(); ?>">
<head>
	<title><?php echo config_item('game_name'); ?></title>
	<link rel="shortcut icon" href="<?php //echo site_url("images/".skin()."/favicon.ico"); ?>" />
	<meta http-equiv="content-script-type" content="text/javascript" />
	<meta http-equiv="content-style-type" content="text/css" />
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8"/>
	<meta name="description" content="<?php echo config_item('description'); ?>" />
	<meta name="keywords" content="<?php echo config_item('keywords'); ?>" />
	<?php if ($this->config->item('debug')) : ?>
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("css/profiler.css"); ?>" />
	<?php endif; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("css/".skin()."/overal.css"); ?>" />
	<?php if (defined('INGAME')) : ?>
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("css/".skin()."/ingame.css"); ?>" />
	<?php else : ?>
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("css/".skin()."/public.css"); ?>" />
	<?php endif; ?>
	<link href="<?php echo base_url(); ?>" title="<?php echo config_item('game_name'); ?>" rel="index" />
	<link rel="canonical" href="<?php echo base_url(); ?>" />
	<?php echo $skin; ?>
</head>
<body <?php if ( ! config_item('debug')) : ?>style="overflow: hidden;" <?php endif; ?>>