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
	
	include_once PJ_VIEWS_PATH . 'pjLayouts/elements/optmenu.php';
	pjUtil::printNotice(__('infoTypesTitle', true), __('infoTypesDesc', true));
	?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
		<input type="hidden" name="controller" value="pjAdminTypes" />
		<input type="hidden" name="action" value="pjActionCreate" />
		<input type="submit" class="pj-button" value="<?php __('btnAddType'); ?>" />
		<p>&nbsp;</p>
	</form>
	
	<div id="grid"></div>
	<script type="text/javascript">
		var myLabel = myLabel || {};
		myLabel.type = "<?php __('lblType'); ?>";
		myLabel.status = "<?php __('lblStatus'); ?>";
		myLabel.active = "<?php __('lblActive'); ?>";
		myLabel.inactive = "<?php __('lblInactive'); ?>";
		myLabel.delete_selected = "<?php __('delete_selected'); ?>";
		myLabel.delete_confirmation = "<?php __('delete_confirmation'); ?>";
	</script>
	<?php
}
?>