<?php echo $topbar; ?>
<div class="clear"></div>
<?php echo $menu; ?>

<div id="content">
<div id="support_ticket">
	<div id="support_title">
		<span class="support_title_tag"><?php echo lang('support.title'); ?>: </span>
		<span class="support_title_text"><?php echo $ticket->title; ?></span>
	</div>
	<div id="support_creator">
		<span class="support_creator_tag"><?php echo lang('support.user'); ?>: </span>
		<span class="support_creator_name"><?php echo $ticket->user; ?></span>
	</div>
	<div id="suport_text">
		<?php echo $ticket->text; ?>
	</div>
	<?php if(count($ticket->replies) > 0): ?>
	<div id="support_replies">
		<div><?php echo lang('support.replies'); ?>:</div>
		<?php foreach($ticket->replies as $key => $reply): ?>
		<div class="sypport_reply">
			<span class="support_reply_creator"><?php echo (isset($reply['user_id']) ? get_name($reply['user_id']) : get_name($reply['admin_id'], TRUE)); ?>: </span>
			<span class="support_reply"><?php echo $reply['text']; ?></span>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
	<div id="support_reply">
	<?php
			echo form_open('support/ticket/');

			echo '<div>'.form_label(lang('support.reply'), 'form_reply').':<br />';
			echo form_textarea($reply_textarea).'</div>';

			echo '<div>'.form_submit('submit', lang('support.submit')).'</div>';

			echo form_close(); ?>
	</div>
</div>
</div>

<?php echo $license; ?>