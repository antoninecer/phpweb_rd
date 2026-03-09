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
	?>
	<?php pjUtil::printNotice(__('infoThemeTitle', true), __('infoThemeDesc', true), false, false); ?>
	<div class="theme-holder pj-loader-outer">
		<?php include PJ_VIEWS_PATH . 'pjAdminOptions/elements/theme.php'; ?>
	</div>
	<div class="clear_both"></div>
	<script type="text/javascript">
	var myLabel = myLabel || {};
	myLabel.field_required = "<?php __('pj_field_required'); ?>";
	myLabel.digits_only = "<?php __('pj_digits_only'); ?>";
	myLabel.positive_number = "<?php __('pj_positive_number'); ?>";
	</script>
	<?php
}
?>