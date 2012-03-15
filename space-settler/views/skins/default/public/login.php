<?php echo $menu; ?>

<div id="content">
	<div id="login_desc"><?php echo lang('login.server_message').' '.config_item('game_name'); ?>!</div>
	<?php echo form_open('/'); ?>
		<div><?php echo lang('login.user'); ?>: <input title="<?php echo lang('login.user'); ?>" name="username" size="20" maxlength="20" value="" type="text" /></div>
		<div><?php echo lang('login.pass'); ?>: <input title="<?php echo lang('login.pass'); ?>" name="password" size="20" maxlength="20" value="" type="password" /></div>
		<div><?php echo anchor('reset_password', lang('login.lost_password')); ?></div>
		<div><?php echo lang('login.remember_pass'); ?> <input title="<?php echo lang('login.remember_pass'); ?>" name="rememberme" type="checkbox" /></div>
		<div><input style="margin: 5px;" name="submit" value="<?php echo lang('login.login'); ?>" type="submit" /></div>
	</form>
</div>

<?php echo $copyright; ?>