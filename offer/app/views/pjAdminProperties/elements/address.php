<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1 && count($tpl['lp_arr']) > 1) : ?>
<div class="multilang b10 first_multilang"></div>
<?php endif;?>

<?php
$yesno = __('_yesno', true); 
?>

<div class="clear_both overflow">	
	<p><label class="title"><?php __('lblShowOnMap'); ?></label>
		<input type="radio" name="show_googlemap" id="show_googlemap_1" class="t5" value="T"<?php echo empty($tpl['arr']['show_googlemap']) ? ' checked="checked"' : ($tpl['arr']['show_googlemap'] == 'T' ? ' checked="checked"' : NULL); ?> /> <label for="show_googlemap_1"><?php echo $yesno['T']; ?></label>
		<input type="radio" name="show_googlemap" id="show_googlemap_0" class="t5"  value="F"<?php echo $tpl['arr']['show_googlemap'] == 'F' ? ' checked="checked"' : NULL; ?> /> <label for="show_googlemap_0"><?php echo $yesno['F']; ?></label>
	</p>
	<?php
	foreach ($tpl['lp_arr'] as $v)
	{
		?>
		<p class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
			<label class="title"><?php __('lblGoogleMapAddress'); ?></label>
			<span class="inline_block">
				<input type="text" id="i18n_<?php echo $v['id']; ?>_google_address" name="i18n[<?php echo $v['id']; ?>][google_address]" class="pj-form-field w500<?php echo (int) $v['is_default'] === 0 ? ' pjPLGoogleAddressSecondary' : ' pjPLGoogleAddress'; ?>" value="<?php echo isset($tpl['arr']['i18n'][$v['id']]['google_address']) && !empty($tpl['arr']['i18n'][$v['id']]['google_address']) ?  htmlspecialchars(stripslashes($tpl['arr']['i18n'][$v['id']]['google_address'])) : pjSanitize::html(@$tpl['arr']['i18n'][$v['id']]['address_1']); ?>"/>
				<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1 && count($tpl['lp_arr']) > 1) : ?>
				<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
				<?php endif;?>
			</span>
		</p>
		<?php
	}
	
	foreach ($tpl['lp_arr'] as $v)
	{
		?>
		<p class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
			<label class="title"><?php __('lblAddress'); ?></label>
			<span class="inline_block">
				<input type="text" id="i18n_<?php echo $v['id']; ?>_address_1" name="i18n[<?php echo $v['id']; ?>][address_1]" class="pj-form-field w500<?php echo (int) $v['is_default'] === 0 ? ' pjPLAddressSecondary' : ' pjPLAddress'; ?>" value="<?php echo pjSanitize::html(@$tpl['arr']['i18n'][$v['id']]['address_1']); ?>"/>
				<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1 && count($tpl['lp_arr']) > 1) : ?>
				<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
				<?php endif;?>
			</span>
		</p>
		<?php
	}
	?>
	<p><label class="title"><?php __('lblZip'); ?></label><input type="text" name="address_zip" id="address_zip" value="<?php echo pjSanitize::html($tpl['arr']['address_zip']); ?>" class="pj-form-field" /></p>
	<p style="overflow: visible">
		<label class="title"><?php __('lblCountry'); ?></label>
		<select name="address_country" id="address_country" class="pj-form-field w300">
			<option value="">-- <?php __('lblChoose'); ?> --</option>
			<?php
			foreach ($tpl['country_arr'] as $v)
			{
				if ($tpl['arr']['address_country'] == $v['id'])
				{
					?><option value="<?php echo $v['id']; ?>" selected="selected"><?php echo stripslashes($v['name']); ?></option><?php
				} else {
					?><option value="<?php echo $v['id']; ?>"><?php echo stripslashes($v['name']); ?></option><?php
				}
			}
			?>
		</select>
	</p>
	<p><label class="title"><?php __('lblState'); ?></label><input type="text" name="address_state" id="address_state" value="<?php echo pjSanitize::html($tpl['arr']['address_state']); ?>" class="pj-form-field w200" /></p>
	<?php
	foreach ($tpl['lp_arr'] as $v)
	{
		?>
		<p class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
			<label class="title"><?php __('lblCity'); ?></label>
			<span class="inline_block">
				<input type="text" id="i18n_<?php echo $v['id']; ?>_address_city" name="i18n[<?php echo $v['id']; ?>][address_city]" class="pj-form-field w200<?php echo (int) $v['is_default'] === 0 ? ' pjPLCitySecondary' : ' pjPLCity'; ?>" value="<?php echo pjSanitize::html(@$tpl['arr']['i18n'][$v['id']]['address_city']); ?>"/>
				<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1 && count($tpl['lp_arr']) > 1) : ?>
				<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
				<?php endif;?>
			</span>
		</p>
		<?php
	}
	?>
	<p>
		<label class="title">&nbsp;</label>
		<span><?php __('lblGMapNote'); ?></span>
	</p>
	<div class="left-content">
		<p>
			<label class="title">&nbsp;</label>
			<span class="inline_block">
				<input type="button" value="<?php __('btnGoogleMapsApi'); ?>" class="pj-button btnGoogleMapsApi" />
			</span>
		</p>
		<p>
			<label class="title"><?php __('lblLatitude'); ?></label>
			<input type="text" name="lat" id="lat" value="<?php echo pjSanitize::html($tpl['arr']['lat']); ?>" class="pj-form-field w200 number" />
		</p>
		<p>
			<label class="title"><?php __('lblLongitude'); ?></label>
			<input type="text" name="lng" id="lng" value="<?php echo pjSanitize::html($tpl['arr']['lng']); ?>" class="pj-form-field w200 number" />
		</p>
		<p>
			<label class="title">&nbsp;</label>
			<input type="submit" value="<?php __('btnSave'); ?>" class="pj-button" />
			<input type="button" value="<?php __('btnCancel'); ?>" class="pj-button" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminProperties&action=pjActionIndex';" />
		</p>
	</div>
	<div class="right-content">
		<span id="map-message"></span>
		<div id="map_canvas" class="map-canvas"></div>
	</div>
</div>