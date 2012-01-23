<?php echo $head; ?>

<div id="main">
		<div id="mainmenu" style="margin-top: 20px;">
			<?php echo anchor('/', lang('overal.index')); ?>
			<?php echo anchor('register', lang('overal.register')); ?>
			<?php echo anchor($forum_url, lang('overal.forum'), 'target="_blank"'); ?>
		</div>
		<?php echo form_open('register'); ?>
		<div id="login">
			<div id="login_input" style="text-align: center;">
				<div><?php echo lang('login.user'); ?>: <input name="username" size="20" maxlength="20" type="text" /></div>
				<div><?php echo lang('login.email'); ?>: <input name="email" size="20" maxlength="50" type="text" /></div>
				<div><b><?php echo lang('login.accept_TaC'); ?><input name="TaC" type="checkbox" /></b></div>
			</div>
		</div>
		<div id="rightmenu" class="rightmenu">
		<div id="title"><?php echo lang('login.reg_message').' '.$game_name; ?></div>
			<div id="content">
				<div id="text1">
					<div style="text-align: justify;"><strong><?php echo $game_name.'</strong> '.lang('login.game_description'); ?></div>
				</div>
				<input type="submit" value="<?php echo lang('login.server_register'); ?>" name="submit" id="register_input" class="bigbutton" />
				<div id="text2">
					<div id="text3">
						<strong><?php echo lang('login.server_message').' '.$game_name; ?>!</strong>
					</div>
					<!-- PLEASE DO NOT REMOVE THE COPYRGHT LINE // POR FAVOR NO BORRES LA LINEA DE COPYRIGHTS -->
					<div id="copyright">
						<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/deed.es_ES">
							<img alt="Licencia Creative Commons" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/3.0/80x15.png" />
						</a>
						<br />
						<span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/InteractiveResource" property="dct:title" rel="dct:type">Space Settler</span> por <a xmlns:cc="http://creativecommons.org/ns#" href="http://informatica.razican.com/" property="cc:attributionName" rel="cc:attributionURL">Razican</a> se encuentra bajo una Licencia <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/deed.es_ES">Creative Commons</a>.
					</div>
					<!-- PLEASE DO NOT REMOVE THE COPYRGHT LINE // POR FAVOR NO BORRES LA LINEA DE COPYRIGHTS -->
				</div>
			</div>
		</div>
	</form>
</div>

<?php echo $footer; ?>