<?php echo $menu; ?>

<div id="content">
<div id="support_ticket"
	<div id="support_title">
		<span class="support_title_tag"><?php echo lang('support.title'); ?>: </span>
		<span class="support_title_text"><?php echo $ticket->title; ?></span>
	</div>
	<div id="support_creator">
		<span class="support_creator_tag"><?php echo lang('support.user'); ?>: </span>
		<span class="support_creator_name"><?php echo $ticket->user; ?></span>
	</div>
	<div id="suport_text">
		<?php echo $ticket->text[0]['text']; ?>
	</div>
	<?php if(count($ticket->text) > 0): ?>
	<div id="support_replies">
		<?php
			foreach($ticket->text as $key => $reply):
			if($key):
		?>
		<div class="support_reply_creator"><?php echo (isset($reply['user_id']) ? get_name($reply['user_id']) : get_name($reply['admin_id'], TRUE)); ?></div>
		<div class="support_reply"><?php echo $reply['text']; ?></div>
		<?php
			endif;
			endforeach;
		?>
	</div>
	<?php endif; ?>
	<div id="support_reply">
	<?php echo form_open('support/reply/'.$ticket->id); ?>

	<?php echo form_close(); ?>
	</div>
</div>
</div>