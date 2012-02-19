<?php echo $menu; ?>

<div id="content" >
<?php echo anchor('support/new_ticket', lang('support.new_ticket')); ?>
<div id="support_table" >
<?php if($tickets): ?>
	<div class="support_table-row">
		<div class="support_table-cell"><?php echo lang('support.id'); ?></div>
		<div class="support_table-cell"><?php echo lang('support.user'); ?></div>
		<div class="support_table-cell"><?php echo lang('support.status'); ?></div>
		<div class="support_table-cell"><?php echo lang('support.type'); ?></div>
		<div class="support_table-cell"><?php echo lang('support.title'); ?></div>
		<div class="support_table-cell"><?php echo lang('support.replies'); ?></div>
	</div>
	<?php foreach($tickets as $ticket): ?>
	<div class="support_table-row">
		<div class="support_table-cell"><?php echo $ticket->id; ?></div>
		<div class="support_table-cell"><?php echo $ticket->user; ?></div>
		<div class="support_table-cell"><?php echo $ticket->status; ?></div>
		<div class="support_table-cell"><?php echo $ticket->type; ?></div>
		<div class="support_table-cell"><?php echo anchor('support/ticket/'.$ticket->id, $ticket->title); ?></div>
		<div class="support_table-cell"><?php echo $ticket->replies; ?></div>
	</div>
	<?php endforeach; ?>
<?php else: ?>
	<div id="no_support_tickets"><?php echo lang('support.no_tickets'); ?></div>
<?php endif; ?>
</div>
</div>