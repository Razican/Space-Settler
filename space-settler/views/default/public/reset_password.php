<?php echo $head; ?>

<div id="main">
	<?php echo form_open('reset_password'); ?>
		<div id="mainmenu" style="margin-top: 20px;">
			<?php echo anchor('/', lang('overal.index')); ?>
			<?php echo anchor('register', lang('overal.register')); ?>
			<?php echo anchor($forum_url, lang('overal.forum'), 'target="_blank"'); ?>
		</div>
		<div id="rightmenu" class="rightmenu">
		<div id="title"><?php echo lang('login.lost_pass_title'); ?></div>
			<div id="content">
				<div id="text1">
					<div style="text-align: justify;">
						<?php echo lang('login.lost_pass_text'); ?>
					</div>
				</div>
				<input type="submit" value="<?php echo lang('login.retrieve_pass'); ?>" name="submit" id="register_input" class="bigbutton" />
				<div id="text2">
					<div id="text3" style="text-align: center;">
						<strong><?php echo lang('login.email'); ?>: <input title="<?php echo lang('login.email'); ?>" size="20" maxlength="50" type="text" name="email" /></strong>
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