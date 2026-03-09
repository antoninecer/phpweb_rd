<ul class="nav nav-tabs pjPplHeading">
	<?php
	if ($tpl['option_arr']['o_seo_url'] == 'No')
	{
		?>
		<li<?php echo $_GET['action'] == 'pjActionProperties' ||  $_GET['action'] == 'pjActionPreview' ? ' class="active pjPplBtnActive"' : null;?>><a href="<?php echo $_SERVER['SCRIPT_NAME'] . '?controller=pjListings&amp;action=pjActionProperties'; ?>"><?php __('front_layout1_all');?></a></li>
		<?php
	}else{
		?>
		<li<?php echo $_GET['action'] == 'pjActionProperties' ||  $_GET['action'] == 'pjActionPreview' ? ' class="active pjPplBtnActive"' : null;?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>"><?php __('front_layout1_all');?></a></li>
		<?php
	}
	?>
	<li<?php echo $_GET['action'] == 'pjActionMap' ? ' class="active pjPplBtnActive"' : null;?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjListings&amp;action=pjActionMap"><?php __('front_layout1_map');?></a></li>
	<li class="pull-right">
		<?php
		if (isset($tpl['locale_arr']))
		{ 
			if (count($tpl['locale_arr']) > 1)
			{
				$locale_id = $controller->pjActionGetLocale();
				$selected_lang = '';
				$selected_flag = '';
				foreach ($tpl['locale_arr'] as $locale)
				{
					if($locale_id == $locale['id'])
					{
						$selected_lang = $locale['language_iso'];
						$lang_iso = explode("-", $selected_lang);
						if(isset($lang_iso[1]))
						{
							$selected_lang = $lang_iso[1];
						}
						if (!empty($locale['flag']) && is_file(PJ_INSTALL_PATH . $locale['flag']))
						{
							$selected_flag = PJ_INSTALL_FOLDER . $locale['flag'];
						} elseif (!empty($locale['file']) && is_file(PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $locale['file'])) {
							$selected_flag = PJ_INSTALL_FOLDER . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $locale['file'];
						}
					}
				}
				?>
				<div class="dropdown pjPplLanguage">
					
					<button class="btn btn-default btn-block dropdown-toggle pjPplBtnNav" type="button" id="dropdownMenu1" data-pj-toggle="dropdown" aria-expanded="true">
						<img src="<?php echo $selected_flag; ?>" alt="">
						<span class="title"><?php echo $selected_lang;?>&nbsp;<span class="caret"></span></span>
					</button>
		
					<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
						<?php
						foreach ($tpl['locale_arr'] as $k => $locale)
						{
							$selected_flag = '';
							if (!empty($locale['flag']) && is_file(PJ_INSTALL_PATH . $locale['flag']))
							{
								$selected_flag = PJ_INSTALL_FOLDER . $locale['flag'];
							} elseif (!empty($locale['file']) && is_file(PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $locale['file'])) {
								$selected_flag = PJ_INSTALL_FOLDER . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $locale['file'];
							}
							?>
							<li role="presentation">
								<a role="menuitem" tabindex="-1" href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?controller=pjListings&amp;action=pjActionSetLocale&amp;locale=<?php echo $locale['id']; ?><?php echo isset($_GET['iframe']) ? '&amp;iframe' : NULL; ?>">
									<img src="<?php echo $selected_flag; ?>" alt="">									
									<span class="title"><?php echo pjSanitize::html($locale['name']); ?></span>
								</a>
							</li>
							<?php
						} 
						?>
					</ul>
				</div>
				<?php
			}
		} 
		?>
	</li>
	<li class="pull-right">
		<button class="btn btn-link active pjPplBtnAcc" type="button" onclick="window.location='<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjListings&amp;action=pjActionAccount';"><?php $tpl['option_arr']['o_allow_add_property'] == 'Yes'? __('front_layout1_menu_login') : __('front_menu_login');?></button>

		&nbsp;
		&nbsp;
	</li>
</ul>