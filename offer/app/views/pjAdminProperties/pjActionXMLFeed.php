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
			<li class="ui-state-default ui-corner-top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminProperties&amp;action=pjActionIndex"><?php __('menuProperties'); ?></a></li>
			<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminProperties&amp;action=pjActionXMLFeed"><?php __('menuXMLFeed'); ?></a></li>
		</ul>
	</div>
	
	<?php
	pjUtil::printNotice(__('infoXMLFeedTitle', true), __('infoXMLFeedDesc', true));
	?>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminProperties&amp;action=pjActionXMLFeed" method="post" id="frmXMLFeed" class="form pj-form">
		<input type="hidden" name="xml_feed" value="1" />
		<p>
			<label class="title"><?php __('lblOrderBy');?></label>
			<span class="inline-block">
				<select id="order_by" name="order_by" class="pj-form-field w150 required" data-msg-required="<?php __('pj_field_required');?>">
					<option value="">-- <?php __('lblChoose'); ?> --</option>
					<?php
					foreach (__('order_by', true) as $k => $v)
					{
						?><option value="<?php echo $k; ?>"<?php echo isset($_POST['order_by']) ? ($k == $_POST['order_by'] ? ' selected="selected"' : null) : null;?>><?php echo stripslashes($v); ?></option><?php
					}
					?>
				</select>
				<select id="direction" name="direction" class="pj-form-field w80">
					<?php
					foreach (__('direction', true) as $k => $v)
					{
						?><option value="<?php echo $k; ?>"<?php echo isset($_POST['direction']) ? ($k == $_POST['direction'] ? ' selected="selected"' : null) : null;?>><?php echo stripslashes($v); ?></option><?php
					}
					?>
				</select>
			</span>
		</p>
		<p>
			<label class="title"><?php __('menuProperties');?></label>
			<span class="inline-block">
				<input id="properties" name="properties" class="pj-form-field w100 field-int" value="<?php echo isset($_POST['properties']) ? $_POST['properties'] : 10;?>"/>
			</span>
		</p>
		<p>
			<label class="title"><?php __('lblEnterPassword');?></label>
			<span class="pj-form-field-custom pj-form-field-custom-before">
				<span class="pj-form-field-before"><abbr class="pj-form-field-icon-password"></abbr></span>
				<input type="text" id="feed_password" name="password" class="pj-form-field w200 required" value="<?php echo isset($_POST['password']) ? $_POST['password'] : null; ?>" data-msg-required="<?php __('pj_field_required');?>"/>
			</span>
		</p>
		
		<p>
			<label class="title">&nbsp;</label>
			<input type="submit" value="<?php __('btnGetFeedURL'); ?>" class="pj-button" />
		</p>
		<?php
		if(isset($_POST['xml_feed']))
		{ 
			?>
			<div class="plFeedContainer">
				<br/>
				<?php pjUtil::printNotice(__('infoPropertiesFeedTitle', true), __('infoPropertiesFeedDesc', true)); ?>
				<span class="inline_block">
					<textarea id="properties_feed" name="properties_feed" class="pj-form-field h80" style="width: 726px;"><?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminProperties&amp;action=pjActionGetXMLFeed&amp;p=<?php echo isset($tpl['password']) ? $tpl['password'] : null;?>&amp;sortby=<?php echo $_POST['order_by']?>&amp;direction=<?php echo $_POST['direction']?>&amp;limit=<?php echo $_POST['properties']?></textarea>
				</span>
			</div>
			<?php
		} 
		?>
			
	</form>
	<?php
}
?>