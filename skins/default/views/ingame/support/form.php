<?php echo $topbar; ?>
<div class="clear"></div>
<?php echo $menu; ?>

<div id="content">
<div id="support_form">
<?php
	echo form_open('support/new_ticket');

	echo '<div>'.form_label(lang('support.title'), 'form_title').': ';
	echo form_input($title).'</div>';

	echo '<div>'.form_label(lang('support.type'), 'form_type').': ';
	echo form_dropdown('type', $type, '1', array('id' => 'form_type')).'</div>';

	echo '<div>'.form_label(lang('support.text'), 'form_text').':<br />';
	echo form_textarea($text).'</div>';

	echo '<div>'.form_submit('submit', lang('support.submit')).'</div>';

	echo form_close();
?>
</div>
</div>

<?php echo $license; ?>