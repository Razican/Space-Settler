<?php echo $topbar; ?>
<div class="clear"></div>
<?php echo $menu; ?>

<div id="content">
	<div class="section_title"><?php echo lang('overview.title'); ?></div>
	<?php echo lang('overview.distance'); ?>: <?php echo $planet->distance.' '.(($planet->type === 0) ? lang('overal.AU') : 'Km'); ?><br />
	<?php echo lang('overview.position'); ?>: <?php echo $planet->position; ?><br />
	<?php echo lang('overview.type'); ?>: <?php echo lang('overview.type_'.$planet->type); ?><br />
	<?php echo lang('overview.mass'); ?>: <?php echo $planet->mass; ?> Kg<br />
	<?php echo lang('overview.radius'); ?>: <?php echo $planet->radius/1000; ?> Km<br />
	<?php echo lang('overview.density'); ?>: <?php echo $planet->density; ?> Kg/m³<br />
	<?php echo lang('overview.water'); ?>: <?php echo $planet->water; ?>%<br />
</div>

<?php echo $license; ?>