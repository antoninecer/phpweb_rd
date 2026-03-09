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
	include_once PJ_VIEWS_PATH . 'pjLayouts/elements/optmenu.php';
	pjUtil::printNotice(__('infoFeatureCreateTitle', true), __('infoFeatureCreateDesc', true));
	?>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminFeatures&amp;action=pjActionCreate" method="post" id="frmCreateFeature" class="pj-form form">
		<input type="hidden" name="feature_create" value="1" />
		<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1 && count($tpl['lp_arr']) > 1) : ?>
		<div class="multilang"></div>
		<?php endif;?>
		<div class="clear_both">
			<?php
			foreach ($tpl['lp_arr'] as $v)
			{
			?>
				<p class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
					<label class="title"><?php __('lblFeatureName'); ?></label>
					<span class="inline_block">
						<input type="text" id="i18n_name_<?php echo $v['id'];?>" name="i18n[<?php echo $v['id']; ?>][name]" class="pj-form-field w300<?php echo (int) $v['is_default'] === 0 ? NULL : ' required'; ?>" lang="<?php echo $v['id']; ?>" data-msg-required="<?php __('pj_field_required');?>"/>
						<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1 && count($tpl['lp_arr']) > 1) : ?>
						<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
						<?php endif;?>
					</span>
				</p>
				<?php
			}
			?>
			<p>
				<label class="title"><?php __('lblFeatureCategory'); ?></label>
				<span class="inline_block">
					<select name="category_id" id="category_id" class="pj-form-field w200">
						<?php
						foreach (__('feature_categories', true) as $k => $v)
						{
							?><option value="<?php echo $k; ?>"><?php echo stripslashes($v); ?></option><?php
						}
						?>
					</select>
				</span>
			</p>
			<p>
				<label class="title">&nbsp;</label>
				<input type="submit" value="<?php __('btnSave'); ?>" class="pj-button" />
				<input type="button" value="<?php __('btnCancel'); ?>" class="pj-button" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminFeatures&action=pjActionIndex';" />
			</p>
		</div>
	</form>
	
	<script type="text/javascript">
	var locale_array = new Array(); 
	var myLabel = myLabel || {};
	myLabel.field_required = "<?php __('pj_field_required'); ?>";
	<?php
	foreach ($tpl['lp_arr'] as $v)
	{
		?>locale_array.push(<?php echo $v['id'];?>);<?php
	} 
	?>
	myLabel.locale_array = locale_array;
	(function ($) {
		$(function() {
			$(".multilang").multilang({
				langs: <?php echo $tpl['locale_str']; ?>,
				flagPath: "<?php echo PJ_FRAMEWORK_LIBS_PATH; ?>pj/img/flags/",
				select: function (event, ui) {
					
				}
			});
		});
	})(jQuery_1_8_2);
	</script>
	<?php
}
?>