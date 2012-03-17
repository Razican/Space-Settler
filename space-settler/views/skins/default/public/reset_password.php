<?php echo $menu; ?>

<div id="content">
	<div id="reset_title"><?php echo lang('login.lost_pass_title'); ?></div>
	<div id="reset_desc"><?php echo lang('login.lost_pass_text'); ?></div>
	<?php echo form_open('reset_password'); ?>
		<div><label for="form_email"><?php echo lang('login.email'); ?></label>: <input id="form_email" title="<?php echo lang('login.email'); ?>" name="email" size="20" maxlength="20" value="" type="text" /></div>
		<div><input name="submit" value="<?php echo lang('login.retrieve_pass'); ?>" type="submit" /></div>
	</form>
</div>

<?php echo $license; ?>