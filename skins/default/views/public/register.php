<?php echo $menu; ?>

<div id="content">
	<div id="register_desc"><?php echo lang('login.reg_message').' '.config_item('game_name'); ?></div>
	<?php echo form_open('register'); ?>
		<div><label for="form_user"><?php echo lang('login.user'); ?></label>: <input title="<?php echo lang('login.user'); ?>" id="form_user" name="username" size="20" maxlength="20" value="" type="text" /></div>
		<div><label for="form_email"><?php echo lang('login.email'); ?></label>: <input title="<?php echo lang('login.email'); ?>" id="form_email" name="email" size="20" maxlength="50" value="" type="text" /></div>
		<div><label for="form_TaC"><?php echo lang('login.accept_TaC'); ?></label> <input id="form_TaC" name="TaC" type="checkbox" /></div>
		<div><input name="submit" value="<?php echo lang('login.server_register'); ?>" type="submit" /></div>
	</form>
</div>

<?php echo $license; ?>