<?php echo $head; ?>

<div id="main">
	<div id="login">
		<div id="login_input">
			<?php echo form_open('/'); ?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr style="vertical-align: top;">
					<td style="padding-right: 4px;">
						<?php echo lang('login.user'); ?> <input title="<?php echo lang('login.user'); ?>" name="username" value="" type="text" />
						<?php echo lang('login.pass'); ?> <input title="<?php echo lang('login.pass'); ?>" name="password" value="" type="password" />
					</td>
				</tr><tr>
					<td style="padding-right: 4px;">
						<?php echo lang('login.remember_pass'); ?> <input title="<?php echo lang('login.remember_pass'); ?>" name="rememberme" type="checkbox" /><input name="submit" value="<?php echo lang('login.login'); ?>" type="submit" />
					</td>
				</tr><tr>
					<td style="padding-right: 4px;"><?php echo anchor('reset_password', lang('login.lostpassword')); ?></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<div id="mainmenu" style="margin-top: 20px;">
		<?php echo anchor('/', lang('overal.index')); ?>
		<?php echo anchor('register', lang('overal.register')); ?>
		<?php echo anchor($forum_url, lang('overal.forum'), 'target="_blank"'); ?>
	</div>
	<div id="rightmenu" class="rightmenu">
		<div id="title"><?php echo lang('login.welcome_to').' '.$game_name; ?></div>
		<div id="content">
			<div id="text1">
				<div style="text-align: justify;"><strong><?php echo $game_name.'</strong> '.lang('login.game_description'); ?></div>
			</div>
			<div id="register" class="bigbutton" onclick="document.location.href='<?php echo site_url('register'); ?>';"><?php echo lang('login.server_register'); ?></div>
			<div id="text2">
				<div id="text3" style="text-align: center;">
					<strong><?php echo lang('login.server_message').' '.$game_name; ?>!</strong>
				</div>
				<!-- PLEASE DO NOT REMOVE THE COPYRGHT LINE // POR FAVOR NO BORRES LA LINEA DE COPYRIGHTS -->
				<div id="copyright">
					<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/deed.es_ES">
						<img alt="Licencia Creative Commons" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/3.0/80x15.png" />
					</a>
					<br />
					<span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/InteractiveResource" property="dct:title" rel="dct:type">X-Battle</span> por <a xmlns:cc="http://creativecommons.org/ns#" href="http://www.razican.com/" property="cc:attributionName" rel="cc:attributionURL">Razican</a> se encuentra bajo una Licencia <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons</a>.
				</div>
				<!-- PLEASE DO NOT REMOVE THE COPYRGHT LINE // POR FAVOR NO BORRES LA LINEA DE COPYRIGHTS -->
			</div>
		</div>
	</div>
</div>

<?php echo $footer; ?>