<div id="logo">Logo</div>
<?php echo $topbar; ?>
<div class="clear"></div>
<?php echo $menu; ?>

<div id="content">
	<?php echo lang('overview.planets'); ?>: <?php echo $planets; ?><br />
	<?php echo lang('overview.moons'); ?>: <?php echo $moons; ?><br />
	<?php echo lang('overview.ships'); ?>: 0<?php //echo $ships; ?>
</div>

<?php echo $license; ?>