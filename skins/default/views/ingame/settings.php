<?php echo $topbar; ?>
<div class="clear"></div>
<?php echo $menu; ?>

<div id="content">
	<?php
		echo form_open('settings/save');

		echo '<div>'.form_label(lang('settings.name'), 'form_name').': ';
		echo form_input($name).'</div>';

		echo '<div>'.form_label(lang('settings.pass'), 'form_pass').': ';
		echo form_password($pass).'</div>';

		echo '<div>'.form_label(lang('settings.passconf'), 'form_passconf').': ';
		echo form_password($pass_conf).'</div>';

		echo '<div>'.form_label(lang('settings.email'), 'form_email').': ';
		echo form_input($email).'</div>';

		echo '<div>'.form_label(lang('settings.skin'), 'form_skin').': ';
		echo form_dropdown('skin', $skins, skin()).'</div>';

		echo '<div>'.form_label(lang('settings.hibernate'), 'form_hibernate').': ';
		echo form_checkbox($hibernating).'</div>';

		echo '<div>'.form_submit('submit', lang('settings.submit')).'</div>';

		echo form_close();
	?>
</div>

<?php echo $license; ?>