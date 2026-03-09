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
	if (isset($_GET['err']))
	{
		$titles = __('error_titles', true);
		$bodies = __('error_bodies', true);
		pjUtil::printNotice(@$titles[$_GET['err']], @$bodies[$_GET['err']]);
	}
	?>
	<div class="ui-tabs ui-widget ui-widget-content ui-corner-all b10">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminProperties&amp;action=pjActionIndex"><?php __('menuProperties'); ?></a></li>
			<?php
			if($controller->isAdmin())
			{ 
				?>
				<li class="ui-state-default ui-corner-top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminProperties&amp;action=pjActionXMLFeed"><?php __('menuXMLFeed'); ?></a></li>
				<?php
			} 
			?>
		</ul>
	</div>
	<?php
	pjUtil::printNotice(__('infoPropertiesTitle', true), __('infoPropertiesDesc', true)); 
	?>
	<div class="b10">
		<?php
		if($controller->isAdmin() || $controller->isEditor() || ($controller->isOwner() && $tpl['option_arr']['o_allow_add_property'] == 'Yes'))
		{ 
			?>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" class="float_left pj-form r10">
				<input type="hidden" name="controller" value="pjAdminProperties" />
				<input type="hidden" name="action" value="pjActionCreate" />
				<input type="submit" class="pj-button" value="<?php __('btnAddProperty'); ?>" />
			</form>
			<?php
		} 
		?>
		<form action="" method="get" class="float_left pj-form frm-filter">
			<input type="text" name="q" class="pj-form-field pj-form-field-search w150" placeholder="<?php __('btnSearch'); ?>" />
			<button type="button" class="pj-button pj-button-detailed"><span class="pj-button-detailed-arrow"></span></button>
		</form>
		<?php
		$filter = __('filter', true);
		?>
		<div class="float_right t5">
			<a href="#" class="pj-button btn-all"><?php __('lblAll');?></a>
			<a href="#" class="pj-button btn-filter btn-status" data-column="status" data-value="T"><?php echo $filter['active']; ?></a>
			<a href="#" class="pj-button btn-filter btn-status" data-column="status" data-value="F"><?php echo $filter['inactive']; ?></a>
			<a href="#" class="pj-button btn-filter btn-featured" data-column="is_featured" data-value="T"><?php echo $filter['featured']; ?></a>
		</div>
		<br class="clear_both" />
	</div>
	
	<div class="pj-form-filter-advanced" style="display: none">
		<span class="pj-menu-list-arrow"></span>
		<form action="" method="get" class="form pj-form pj-form-search frm-filter-advanced">
			<div class="float_left w350">
				<p>
					<label class="title"><?php __('lblRefId'); ?></label>
					<input type="text" name="ref_id" id="ref_id" class="pj-form-field w150" />
				</p>
				
				<p>
					<label class="title"><?php __('lblKeyword'); ?></label>
					<input type="text" name="keyword" id="keyword" class="pj-form-field w150" />
				</p>
				<p>
					<label class="title"><?php __('lblType'); ?></label>
					<select name="type_id" id="type_id" class="pj-form-field w150">
						<option value="">-- <?php __('lblChoose'); ?> --</option>
						<?php
						foreach ($tpl['type_arr'] as $v)
						{
							?><option value="<?php echo $v['id']; ?>"<?php echo isset($_GET['type_id']) && (int) $_GET['type_id'] == $v['id'] ? ' selected="selected"' : NULL; ?>><?php echo stripslashes($v['name']); ?></option><?php
						}
						?>
					</select>
				</p>
			</div>
			<div class="float_right w350">
				<?php
				if ($controller->isAdmin())
				{
					?>
					<p style="overflow: visible;">
						<label class="title"><?php __('lblOwner'); ?></label>
						<select name="owner_id" id="owner_id" class="pj-form-field w150">
							<option value="">-- <?php __('lblChoose'); ?> --</option>
							<?php
							foreach ($tpl['user_arr'] as $v)
							{
								?><option value="<?php echo $v['id']; ?>"<?php echo isset($_GET['user_id']) && (int) $_GET['user_id'] == $v['id'] ? ' selected="selected"' : NULL; ?>><?php echo stripslashes($v['name']); ?></option><?php
							}
							?>
						</select>
					</p>
					<?php
				} 
				?>
				<p>
					<label class="title"><?php __('lblState'); ?></label>
					<input type="text" name="address_state" id="address_state" class="pj-form-field w150" />
				</p>
				<p>
					<label class="title"><?php __('lblCity'); ?></label>
					<input type="text" name="address_city" id="address_city" class="pj-form-field w150" />
				</p>
			</div>
			<br class="clear_both" />
			<p>
				<label class="title"><?php __('lblCountry'); ?></label>
				<select name="address_country" id="address_country" class="pj-form-field w350">
					<option value="">-- <?php __('lblChoose'); ?> --</option>
					<?php
					foreach ($tpl['country_arr'] as $v)
					{
						?><option value="<?php echo $v['id']; ?>"<?php echo isset($_GET['address_country']) && (int) $_GET['address_country'] == $v['id'] ? ' selected="selected"' : NULL; ?>><?php echo stripslashes($v['name']); ?></option><?php
					}
					?>
				</select>
			</p>
			<p>
				<label class="title">&nbsp;</label>
				<input type="submit" value="<?php __('btnSearch'); ?>" class="pj-button" />
				<input type="reset" value="<?php __('btnCancel'); ?>" class="pj-button" />
			</p>
		</form>
	</div>
	
	<div id="grid"></div>
	<script type="text/javascript">
	var pjGrid = pjGrid || {};
	pjGrid.jqDateFormat = "<?php echo pjUtil::jqDateFormat($tpl['option_arr']['o_date_format']); ?>";
	pjGrid.jsDateFormat = "<?php echo pjUtil::jsDateFormat($tpl['option_arr']['o_date_format']); ?>";
	pjGrid.queryString = "";
	pjGrid.isOwner = <?php echo $controller->isOwner() ? 'true' : 'false'; ?>;
	pjGrid.isEditor = <?php echo $controller->isEditor() ? 'true' : 'false'; ?>;
	<?php
	if (isset($_GET['user_id']) && (int) $_GET['user_id'] > 0)
	{
		?>pjGrid.queryString += "&user_id=<?php echo (int) $_GET['user_id']; ?>";<?php
	}
	?>
	var myLabel = myLabel || {};
	myLabel.image = "<?php __('lblImage'); ?>";
	myLabel.ref_id = "<?php __('lblID'); ?>";
	myLabel.type = "<?php __('lblType'); ?>";
	myLabel.publish = "<?php __('lblPublish'); ?>";
	myLabel.active = "<?php __('lblActive'); ?>";
	myLabel.inactive = "<?php __('lblInactive'); ?>";
	myLabel.delete_selected = "<?php __('delete_selected'); ?>";
	myLabel.delete_confirmation = "<?php __('delete_confirmation'); ?>";
	myLabel.published = "<?php __('lblPublished'); ?>";
	myLabel.not_published = "<?php __('lblNotPublished'); ?>";
	myLabel.extend_exp_date = "<?php __('lblExtendExpDate'); ?>";
	myLabel.price = "<?php __('lblPrice'); ?>";
	myLabel.exp_date = "<?php __('lblExpDate'); ?>";
	myLabel.owner = "<?php __('lblOwner'); ?>";
	myLabel.exp_date_plus_30 = "<?php __('lblExpDatePlus30'); ?>";
	myLabel.unlimited = "<?php __('lblUnlimited');?>";
	</script>
	<?php
}
?>