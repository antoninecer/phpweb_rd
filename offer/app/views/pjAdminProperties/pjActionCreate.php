<?php
if (isset($tpl['status']))
{
	$status = __('status', true);
	switch ($tpl['status'])
	{
		case 2:
			pjUtil::printNotice(NULL, $status[2]);
			break;
	}
} else {
	$week_start = isset($tpl['option_arr']['o_week_start']) && in_array((int) $tpl['option_arr']['o_week_start'], range(0,6)) ? (int) $tpl['option_arr']['o_week_start'] : 0;
	$jqDateFormat = pjUtil::jqDateFormat($tpl['option_arr']['o_date_format']);
	
	pjUtil::printNotice(__('infoPropertyAddTitle', true), __('infoPropertyAddDesc', true)); 
	?>		
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminProperties&amp;action=pjActionCreate" method="post" id="frmCreateProperty" class="form pj-form">
		<input type="hidden" name="property_create" value="1" />
		<p>
			<label class="title"><?php __('lblType'); ?></label>
			<span class="inline_block">
				<select name="for" id="for" class="pj-form-field required"  data-msg-required="<?php __('pj_field_required');?>">
					<option value="">-- <?php __('lblChoose'); ?> --</option>
					<?php
					foreach (__('types', true) as $k => $v)
					{
						?><option value="<?php echo $k; ?>"><?php echo stripslashes($v); ?></option><?php
					}
					?>
				</select>
			</span>
		</p>
		<p>
			<label class="title"><?php __('lblRefId'); ?></label>
			<span class="inline_block">
				<input type="text" name="ref_id" id="ref_id" value="<?php echo $tpl['ref_id']; ?>" class="pj-form-field required"  data-msg-required="<?php __('pj_field_required');?>"/>
				<a href="#" class="pj-form-langbar-tip listing-tip" title="<?php __('lblRefIdTip'); ?>"></a>
			</span>
		</p>
		<p>
			<label class="title"><?php __('lblSpecial'); ?></label>
			<span class="inline_block">
				<select name="special" id="special" class="pj-form-field required"  data-msg-required="<?php __('pj_field_required');?>">
					<option value="">-- <?php __('lblChoose'); ?> --</option>
					<?php
					foreach (__('special_items', true) as $k => $v)
					{
						?><option value="<?php echo $k; ?>"><?php echo stripslashes($v); ?></option><?php
					}
					?>
				</select>
			</span>
		</p>
		<?php
		if(!empty($tpl['type_arr']))
		{ 
			?>
			<p>
				<label class="title"><?php __('lblType'); ?></label>
				<span class="inline_block">
					<select name="type_id" id="type_id" class="pj-form-field w200 required"  ata-msg-required="<?php __('pj_field_required');?>">
						<option value="">-- <?php __('lblChoose'); ?> --</option>
						<?php
						foreach ($tpl['type_arr'] as $v)
						{
							?><option value="<?php echo $v['id']; ?>"><?php echo stripslashes($v['name']); ?></option><?php
						}
						?>
					</select>
				</span>
			</p>
			<?php
		}else{
			$add_type_message = __('lblAddTypeMessage', true);
			$add_type_message = str_replace('{ADD_TYPE_TAG}', '<a href="'.$_SERVER['PHP_SELF'].'?controller=pjAdminTypes&amp;action=pjActionCreate">', $add_type_message);
			$add_type_message = str_replace('{ADD_TYPE_ENDTAG}', '</a>', $add_type_message);
			?>
			<p>
				<label class="title"><?php __('lblType'); ?></label>
				<span class="inline_block">
					<label class="content"><?php echo $add_type_message;?></label>
				</span>
			</p>
			<?php
		}
		if (!$controller->isOwner())
		{
			?>
			<p>
				<label class="title"><?php __('lblStatus'); ?></label>
				<span class="inline_block">
					<select name="status" id="status" class="pj-form-field w200 required"  data-msg-required="<?php __('pj_field_required');?>">
						<option value="">-- <?php __('lblChoose'); ?> --</option>
						<?php
						foreach (__('publish_statuses', true) as $k => $v)
						{
							?><option value="<?php echo $k; ?>"><?php echo stripslashes($v); ?></option><?php
						}
						?>
					</select>
					<a href="#" class="pj-form-langbar-tip listing-tip" title="<?php echo pjSanitize::html(__('lblStatusTip', true)); ?>"></a>
				</span>
			</p>
			<p id="expiration_container" style="display:none;">
				<label class="title"><?php __('lblExpire'); ?></label>
				<span class="pj-form-field-custom pj-form-field-custom-after">
					<input type="text" name="expire" id="expire" class="pj-form-field pointer w80 datepick" readonly="readonly" rel="<?php echo $week_start; ?>" rev="<?php echo $jqDateFormat; ?>" value="<?php echo date($tpl['option_arr']['o_date_format']); ?>" />
					<span class="pj-form-field-after"><abbr class="pj-form-field-icon-date"></abbr></span>
					<a href="#" class="pj-form-langbar-tip listing-tip" title="<?php echo pjSanitize::html(__('lblExpireTip', true)); ?>"></a>
				</span>
			</p>
			<p>
				<label class="title"><?php __('lblFeatured'); ?></label>
				<span class="left">
					<?php
					foreach (__('_yesno', true) as $k => $v)
					{
						?>
						<label class="r5"><input type="radio" name="is_featured" value="<?php echo $k; ?>"<?php echo 'F' == $k ? ' checked="checked"' : NULL; ?> /> <?php echo $v; ?></label>
						<?php
					}
					?>
					<a href="#" class="pj-form-langbar-tip listing-tip" title="<?php __('lblFeaturedTip'); ?>"></a>
				</span>
			</p>
			<?php
		}
		?>
		
		<p>
			<label class="title">&nbsp;</label>
			<input type="submit" value="<?php __('btnSave'); ?>" class="pj-button" />
			<input type="button" value="<?php __('btnCancel'); ?>" class="pj-button" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminProperties&action=pjActionIndex';" />
		</p>
	</form>
	<script type="text/javascript">
	var myLabel = myLabel || {};
	myLabel.field_required = "<?php __('pj_field_required'); ?>";
	</script>
	<?php
}
?>