<?php
$months = __('months', true);
$days = __('days', true);
?>
if (jQuery_1_8_2.datagrid !== undefined) {
	jQuery_1_8_2.extend(jQuery_1_8_2.datagrid.messages, {
		empty_result: "<?php __('gridEmptyResult', false, true); ?>",
		choose_action: "<?php __('gridChooseAction', false, true); ?>",
		goto_page: "<?php __('gridGotoPage', false, true); ?>",
		total_items: "<?php __('gridTotalItems', false, true); ?>",
		items_per_page: "<?php __('gridItemsPerPage', false, true); ?>",
		prev_page: "<?php __('gridPrevPage', false, true); ?>",
		prev: "<?php __('gridPrev', false, true); ?>",
		next_page: "<?php __('gridNextPage', false, true); ?>",
		next: "<?php __('gridNext', false, true); ?>",
		month_names: ['<?php echo $months[1]; ?>', '<?php echo $months[2]; ?>', '<?php echo $months[3]; ?>', '<?php echo $months[4]; ?>', '<?php echo $months[5]; ?>', '<?php echo $months[6]; ?>', '<?php echo $months[7]; ?>', '<?php echo $months[8]; ?>', '<?php echo $months[9]; ?>', '<?php echo $months[10]; ?>', '<?php echo $months[11]; ?>', '<?php echo $months[12]; ?>'],
		day_names: ['<?php echo $days[1]; ?>', '<?php echo $days[2]; ?>', '<?php echo $days[3]; ?>', '<?php echo $days[4]; ?>', '<?php echo $days[5]; ?>', '<?php echo $days[6]; ?>', '<?php echo $days[0]; ?>'],
		delete_title: "<?php __('gridDeleteConfirmation', false, true); ?>",
		delete_text: "<?php __('gridConfirmationTitle', false, true); ?>",
		action_empty_title: "<?php __('gridEmptyTitle', false, true); ?>",
		action_empty_body: "<?php __('gridEmptyBody', false, true); ?>",
		action_title: "<?php __('gridActionTitle', false, true); ?>",
		btn_ok: "<?php __('gridBtnOk', false, true); ?>",
		btn_cancel: "<?php __('gridBtnCancel', false, true); ?>",
		btn_delete: "<?php __('gridBtnDelete', false, true); ?>"
	});
}

if (jQuery_1_8_2.gallery !== undefined) {
	jQuery_1_8_2.extend(jQuery_1_8_2.gallery.messages, {
		alt: "<?php __('plugin_gallery_alt'); ?>",
		title: "<?php __('plugin_gallery_title'); ?>",
		description: "<?php __('plugin_gallery_description'); ?>",
		btn_delete: "<?php __('plugin_gallery_btn_delete'); ?>",
		btn_cancel: "<?php __('plugin_gallery_btn_cancel'); ?>",
		btn_save: "<?php __('plugin_gallery_btn_save'); ?>",
		btn_set_watermark: "<?php __('plugin_gallery_btn_set_watermark'); ?>",
		btn_clear_current: "<?php __('plugin_gallery_btn_clear_current'); ?>",
		btn_compress: "<?php __('plugin_gallery_btn_compress'); ?>",
		btn_recreate: "<?php __('plugin_gallery_btn_recreate'); ?>",
		compress_note: "<?php __('plugin_gallery_compression_note'); ?>",
		compression: "<?php __('plugin_gallery_compression'); ?>",
		compression_title: "<?php __('plugin_gallery_compression_title'); ?>",
		delete_all: "<?php __('plugin_gallery_delete_all'); ?>",
		delete_confirmation: "<?php __('plugin_gallery_delete_confirmation'); ?>",
		delete_confirmation_single: "<?php __('plugin_gallery_confirmation_single'); ?>",
		delete_confirmation_multi: "<?php __('plugin_gallery_confirmation_multi'); ?>",
		drag_drop_title: "<?php __('plugin_gallery_drag_drop_title'); ?>",
		drag_drop_sub_title: "<?php __('plugin_gallery_drag_drop_sub_title'); ?>",
		edit: "<?php __('plugin_gallery_edit'); ?>",
		empty_result: "<?php __('plugin_gallery_empty_result'); ?>",
		erase: "<?php __('plugin_gallery_delete'); ?>",
		image_settings: "<?php __('plugin_gallery_image_settings'); ?>",
		move: "<?php __('plugin_gallery_move'); ?>",
		originals: "<?php __('plugin_gallery_originals'); ?>",
		photos: "<?php __('plugin_gallery_photos'); ?>",
		position: "<?php __('plugin_gallery_position'); ?>",
		resize: "<?php __('plugin_gallery_resize'); ?>",
		rotate: "<?php __('plugin_gallery_rotate'); ?>",
		thumbs: "<?php __('plugin_gallery_thumbs'); ?>",
		upload: "<?php __('plugin_gallery_upload'); ?>",
		uploading: "<?php __('plugin_gallery_uploading'); ?>",
		watermark: "<?php __('plugin_gallery_watermark'); ?>",
		watermark_title:  "<?php __('plugin_gallery_watermark_image'); ?>",
		watermark_text:  "<?php __('plugin_gallery_watermark_text'); ?>",
		watermark_position: "<?php __('plugin_gallery_watermark_position'); ?>",
		watermark_positions: {
			tl: "<?php __('plugin_gallery_top_left'); ?>",
			tr: "<?php __('plugin_gallery_top_right'); ?>",
			tc: "<?php __('plugin_gallery_top_center'); ?>",
			bl: "<?php __('plugin_gallery_bottom_left'); ?>",
			br: "<?php __('plugin_gallery_bottom_right'); ?>",
			bc: "<?php __('plugin_gallery_bottom_center'); ?>",
			cl: "<?php __('plugin_gallery_center_left'); ?>",
			cr: "<?php __('plugin_gallery_center_right'); ?>",
			cc: "<?php __('plugin_gallery_center_center'); ?>"
		}
	});
}

if (jQuery_1_8_2.multilang !== undefined) {
	jQuery_1_8_2.extend(jQuery_1_8_2.multilang.messages, {
		tooltip: "<?php __('multilangTooltip', false, true); ?>"
	});
}

if (plApp !== undefined) {
	plApp = jQuery_1_8_2.extend(plApp, {
		locale: {
			button: <?php echo pjAppController::jsonEncode(__('buttons', true)); ?>
		}
	});
}