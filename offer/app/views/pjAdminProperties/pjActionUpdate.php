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
	$titles = __('error_titles', true);
	$bodies = __('error_bodies', true);
	if (isset($_GET['err']))
	{
		pjUtil::printNotice(@$titles[$_GET['err']], @$bodies[$_GET['err']]);
	}
	$week_start = isset($tpl['option_arr']['o_week_start']) && in_array((int) $tpl['option_arr']['o_week_start'], range(0,6)) ? (int) $tpl['option_arr']['o_week_start'] : 0;
	$jqDateFormat = pjUtil::jqDateFormat($tpl['option_arr']['o_date_format']);
	$jqTimeFormat = pjUtil::jqTimeFormat($tpl['option_arr']['o_time_format']);
	
	$bedroom_arr = array('0'=>'0', '1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'>10');
	$bathroom_arr = array('0'=>'0', '1'=>'1', '1.5'=>'1.5', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'>5');
	
	$floor_metrics = __('floor_metrics', true);
	?>
	<style type="text/css">
	/*.ui-widget-content{
		border: medium none;
	}
	.ui-tabs .ui-tabs-nav li a {
		padding: 0.5em 0.8em;
	}*/
	.mceEditor > table{
		width: 570px !important;
	}
	.ui-menu{
		height: 230px;
		overflow-y: scroll;
	}
	.ui-tabs .ui-tabs-panel{
		overflow: visible;
	}
	</style>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminProperties&amp;action=pjActionUpdate" method="post" id="frmUpdateProperty" class="form pj-form" enctype="multipart/form-data">
		<input type="hidden" name="property_update" value="1" />
		<input type="hidden" name="id" value="<?php echo $tpl['arr']['id']; ?>" />
		<input type="hidden" name="tab_id" value="<?php echo isset($_GET['tab_id']) && !empty($_GET['tab_id']) ? $_GET['tab_id'] : 'tabs-1'; ?>" />
		<?php $locale = isset($_GET['locale']) && (int) $_GET['locale'] > 0 ? (int) $_GET['locale'] : $controller->getLocaleId(); ?>
		<input type="hidden" name="locale" value="<?php echo $locale; ?>" />

		<div class="property-title">
			<?php
			$title_arr = array();
			$title_arr[] =  htmlspecialchars($tpl['arr']['ref_id']);
			if(!empty($tpl['arr']['i18n'][$locale]['title']))
			{
				$title_arr[] = htmlspecialchars($tpl['arr']['i18n'][$locale]['title']);
			}
			echo __('lblProperty', true) . ': ' . join(', ', $title_arr);
			?>
		</div>

		<div id="tabs">
			<ul>
				<li><a href="#tabs-1"><?php __('lblSummary'); ?></a></li>
				<li><a href="#tabs-2"><?php __('lblDetails'); ?></a></li>
				<li><a href="#tabs-3"><?php __('lblDescription'); ?></a></li>
				<li><a href="#tabs-4"><?php __('lblFeatures'); ?></a></li>
				<li><a href="#tabs-5"><?php __('lblPhotos'); ?></a></li>
				<li><a href="#tabs-6"><?php __('lblFloorPlan'); ?></a></li>
				<li><a href="#tabs-7"><?php __('lblOwner'); ?></a></li>
				<li><a href="#tabs-8"><?php __('lblAddress'); ?></a></li>
				<li><a href="#tabs-9"><?php __('lblSeo'); ?></a></li>
			</ul>
		
			<div id="tabs-1">
				<?php
				if($controller->isOwner())
				{
					pjUtil::printNotice(__('infoPropertySummaryTitle', true), __('infoPropertySummaryDesc', true));
				}else{
					pjUtil::printNotice(__('infoSummaryTitle', true), __('infoSummaryDesc', true));
				} 
				?>	
				<p><label class="title"><?php __('lblAddedOn'); ?></label><span class="left"><?php echo pjUtil::formatDate(date('Y-m-d', strtotime($tpl['arr']['created'])), 'Y-m-d', $tpl['option_arr']['o_date_format']) . ' ' . pjUtil::formatTime(date('H:i:s', strtotime($tpl['arr']['created'])), 'H:i:s', $tpl['option_arr']['o_time_format']); ?></span></p>
				<p><label class="title"><?php __('lblLastUpdateOn'); ?></label><span class="left"><?php echo pjUtil::formatDate(date('Y-m-d', strtotime($tpl['arr']['modified'])), 'Y-m-d', $tpl['option_arr']['o_date_format']) . ' ' . pjUtil::formatTime(date('H:i:s', strtotime($tpl['arr']['modified'])), 'H:i:s', $tpl['option_arr']['o_time_format']); ?></span></p>
				<p><label class="title"><?php __('lblViews'); ?></label><span class="left"><?php echo $tpl['arr']['views']; ?></span></p>
				<p><label class="title"><?php __('lblSendToEmail'); ?></label><span class="left"><?php echo $tpl['arr']['sents']; ?></span></p>
				<p><label class="title"><?php __('lblPrinted'); ?></label><span class="left"><?php echo $tpl['arr']['prints']; ?></span></p>
				<p>
					<label class="title"><?php __('lblType'); ?></label>
					<span class="inline_block">
						<select name="for" id="for" class="pj-form-field required" data-msg-required="<?php __('pj_field_required');?>">
							<option value="">-- <?php __('lblChoose'); ?> --</option>
							<?php
							foreach (__('types', true) as $k => $v)
							{
								?><option value="<?php echo $k; ?>"<?php echo $k==$tpl['arr']['for'] ? ' selected="selected"' : null;?>><?php echo stripslashes($v); ?></option><?php
							}
							?>
						</select>
					</span>
				</p>
				<p>
					<label class="title"><?php __('lblRefId'); ?></label>
					<span class="inline_block">
						<input type="text" name="ref_id" id="ref_id" value="<?php echo htmlspecialchars(stripslashes($tpl['arr']['ref_id'])); ?>" class="pj-form-field required" />
					</span>
				</p>
				<p>
					<label class="title"><?php __('lblSpecial'); ?></label>
					<span class="inline_block">
						<select name="special" id="special" class="pj-form-field required" data-msg-required="<?php __('pj_field_required');?>">
							<option value="">-- <?php __('lblChoose'); ?> --</option>
							<?php
							foreach (__('special_items', true) as $k => $v)
							{
								?><option value="<?php echo $k; ?>"<?php echo $k==$tpl['arr']['special'] ? ' selected="selected"' : null;?>><?php echo stripslashes($v); ?></option><?php
							}
							?>
						</select>
					</span>
				</p>
				<?php
				if (!$controller->isOwner())
				{
					?>
					<p><label class="title"><?php __('lblStatus'); ?></label>
						<span class="inline_block">
							<select name="status" id="status" class="pj-form-field required" data-msg-required="<?php __('pj_field_required');?>">
								<option value="">-- <?php __('lblChoose'); ?> --</option>
								<?php
								foreach (__('publish_statuses', true) as $k => $v)
								{
									if ($tpl['arr']['status'] == $k)
									{
										?><option value="<?php echo $k; ?>" selected="selected"><?php echo stripslashes($v); ?></option><?php
									} else {
										?><option value="<?php echo $k; ?>"><?php echo stripslashes($v); ?></option><?php
									}
								}
								?>
							</select>
							<a href="#" class="pj-form-langbar-tip listing-tip" title="<?php echo pjSanitize::html(__('lblStatusTip', true)); ?>"></a>
						</span>
					</p>
					<p id="expiration_container" style="display:<?php echo $tpl['arr']['status'] == 'E' ? 'block' : 'none'; ?>;">
						<label class="title"><?php __('lblExpire'); ?></label>
						<span class="pj-form-field-custom pj-form-field-custom-after">
							<input type="text" name="expire" id="expire" class="pj-form-field pointer w80 required datepick" value="<?php echo pjUtil::formatDate($tpl['arr']['expire'], "Y-m-d", $tpl['option_arr']['o_date_format']); ?>" readonly="readonly" rel="<?php echo $week_start; ?>" rev="<?php echo $jqDateFormat; ?>" data-msg-required="<?php __('pj_field_required');?>"/>
							<span class="pj-form-field-after"><abbr class="pj-form-field-icon-date"></abbr></span>
						</span>
						<a href="#" class="pj-form-langbar-tip listing-tip" title="<?php echo pjSanitize::html(__('lblExpireTip', true)); ?>"></a>
					</p>
					<?php
				} else {
					?>
					<p>
						<?php
						if($tpl['arr']['status'] == 'F')
						{
							?>
							<label class="title color-red"><?php __('lblExpire'); ?></label>
							<span class="left float_left"><?php __('lblNotActive'); ?></span>
							<a class="pj-button float_left l10" href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminProperties&amp;action=pjActionPayment&amp;id=<?php echo $tpl['arr']['id']; ?>"><?php __('lblPublish'); ?></a>
							<?php
						}else if($tpl['arr']['status'] == 'T'){
							?>
							<label class="title"><?php __('lblExpire'); ?></label>
							<span class="left"><?php __('lblUnlimited'); ?></span>
							<?php
						}else{ 
							?>
							<label class="title"><?php __('lblExpire'); ?></label>
							<span class="left float_left"><?php echo pjUtil::formatDate($tpl['arr']['expire'], 'Y-m-d', $tpl['option_arr']['o_date_format']); ?></span>
							<a class="pj-button float_left l10" href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminProperties&amp;action=pjActionPayment&amp;id=<?php echo $tpl['arr']['id']; ?>"><?php __('lblExtend'); ?></a>
							<?php
						}
						?>
					</p>
					<?php
				}
				if (!$controller->isOwner())
				{
					?>
					<p>
						<label class="title"><?php __('lblFeatured'); ?></label>
						<span class="left">
						<?php
						foreach (__('_yesno', true) as $k => $v)
						{
							?>
							<label class="r5"><input type="radio" name="is_featured" value="<?php echo $k; ?>"<?php echo $tpl['arr']['is_featured'] == $k ? ' checked="checked"' : NULL; ?> /> <?php echo $v; ?></label>
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
					<input type="submit" value="<?php __('btnSave'); ?>" class="pj-button pj-button-save" />
					<input type="button" value="<?php __('btnCancel'); ?>" class="pj-button" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminProperties&action=pjActionIndex';" />
				</p>
			</div>
			<div id="tabs-2">
				<?php pjUtil::printNotice(__('infoDetailsTitle', true), __('infoDetailsDesc', true));?>
				<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1 && count($tpl['lp_arr']) > 1) : ?>
				<div class="multilang b10 first_multilang"></div>
				<?php endif;?>
				<div class="clear_both">
					<?php
					foreach ($tpl['lp_arr'] as $v)
					{
						?>
						<p class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
							<label class="title"><?php __('lblTitle'); ?></label>
							<span class="inline_block">
								<input type="text" name="i18n[<?php echo $v['id']; ?>][title]" class="pj-form-field w500<?php echo (int) $v['is_default'] === 0 ? NULL : ' required'; ?>" value="<?php echo pjSanitize::html(@$tpl['arr']['i18n'][$v['id']]['title']); ?>" data-msg-required="<?php __('pj_field_required');?>"/>
								<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1 && count($tpl['lp_arr']) > 1) : ?>
								<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
								<?php endif;?>
							</span>
						</p>
						<?php
					}
					?>
					<p>
						<label class="title"><?php __('lblType'); ?></label>
						<span class="inline_block" id="boxType">
							<select name="type_id" id="type_id" class="pj-form-field required" data-msg-required="<?php __('pj_field_required');?>">
								<option value="">-- <?php __('lblChoose'); ?> --</option>
								<?php
								foreach ($tpl['type_arr'] as $v)
								{
								    ?><option value="<?php echo $v['id']; ?>"<?php echo $v['id'] == $tpl['arr']['type_id'] ? ' selected="selected"' : null;?>><?php echo pjSanitize::html($v['name']); ?></option><?php
								}
								?>
							</select>
						</span>
					</p>
					<p>
						<label class="title"><?php __('lblPrice'); ?></label>
						<span class="inline_block">
							<span class="pj-form-field-custom pj-form-field-custom-before float_left r10">
								<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
								<input type="text" name="price" class="pj-form-field w70 align_right" value="<?php echo pjSanitize::html($tpl['arr']['price']);?>"/>
							</span>
							<span class="priceBox" style="display:<?php echo $tpl['arr']['for']=='rent' ? ' inline-block' : 'none'; ?>">
								<select name="price_per" id="price_per" class="pj-form-field">
									<?php
									foreach (pjUtil::sortArrayByArray(__('price_per', true), array('day', 'week', 'month', 'year')) as $k => $v)
									{
										?><option value="<?php echo $k; ?>"<?php echo $k == $tpl['arr']['price_per'] ? ' selected="selected"' : null;?>><?php echo stripslashes($v); ?></option><?php
									}
									?>
								</select>
							</span>
						</span>
					</p>
					<p>
						<label class="title"><?php __('lblYearBuilt'); ?></label>
						<span class="inline_block">
							<input type="text" name="year_built" id="year_built" value="<?php echo pjSanitize::html($tpl['arr']['year_built']); ?>" class="pj-form-field w80" />
						</span>
					</p>
					<p>
						<label class="title"><?php __('lblLotDimensions'); ?></label>
						<span class="inline_block">
							<input type="text" name="lot" id="lot" value="<?php echo pjSanitize::html($tpl['arr']['lot']); ?>" class="pj-form-field w80" />
							<span class="inline_block"><?php echo $floor_metrics[preg_replace('/\s+/', '', $tpl['option_arr']['o_floor_metric'])];?></span>
						</span>
					</p>
					<p>
						<label class="title"><?php __('lblFloorArea'); ?></label>
						<span class="inline_block">
							<input type="text" name="floor_area" id="floor_area" value="<?php echo pjSanitize::html($tpl['arr']['floor_area']); ?>" class="pj-form-field w80" />
							<span class="inline_block"><?php echo $floor_metrics[preg_replace('/\s+/', '', $tpl['option_arr']['o_floor_metric'])];?></span>
						</span>
					</p>
					<p>
						<label class="title"><?php __('lblBedrooms'); ?></label>
						<span class="inline_block">
							<select name="bedrooms" id="bedrooms" class="pj-form-field w120">
								<option value="na"><?php __('lblNA');?></option>
								<?php
								foreach ($bedroom_arr as $v)
								{
									?><option value="<?php echo $v; ?>"<?php echo $v == $tpl['arr']['bedrooms'] ? ' selected="selected"' : null;?>><?php echo stripslashes($v); ?></option><?php
								}
								?>
							</select>
						</span>
					</p>
					<p>
						<label class="title"><?php __('lblBathrooms'); ?></label>
						<span class="inline_block">
							<select name="bathrooms" id="bathrooms" class="pj-form-field w120">
								<option value="na"><?php __('lblNA');?></option>
								<?php
								foreach ($bathroom_arr as $v)
								{
									?><option value="<?php echo $v; ?>"<?php echo $v == $tpl['arr']['bathrooms'] ? ' selected="selected"' : null;?>><?php echo stripslashes($v); ?></option><?php
								}
								?>
							</select>
						</span>
					</p>
					<p>
						<label class="title">&nbsp;</label>
						<input type="submit" value="<?php __('btnSave'); ?>" class="pj-button pj-button-save" />
						<input type="button" value="<?php __('btnCancel'); ?>" class="pj-button" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminProperties&action=pjActionIndex';" />
					</p>
				</div>
			</div><!-- tabs-2 -->
			<div id="tabs-3">
				<?php
				pjUtil::printNotice(__('infoDescriptionTitle', true), __('infoDescriptionDesc', true));
				?>
				<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1 && count($tpl['lp_arr']) > 1) : ?>
				<div class="multilang b10 first_multilang"></div>
				<?php endif;?>
				<div class="clear_both">
					<?php
					foreach ($tpl['lp_arr'] as $v)
					{
						?>
						<p class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
							<label class="title"><?php __('lblDescription'); ?></label>
							<span class="inline_block">
								<textarea name="i18n[<?php echo $v['id']; ?>][description]" class="mceEditor<?php echo (int) $v['is_default'] === 0 ? NULL : ' required'; ?>" style="width: 570px; height: 250px" data-msg-required="<?php __('pj_field_required');?>"><?php echo !empty(@$tpl['arr']['i18n'][$v['id']]['description']) ? stripslashes(@$tpl['arr']['i18n'][$v['id']]['description']) : ''; ?></textarea>
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
						<input type="submit" value="<?php __('btnSave'); ?>" class="pj-button pj-button-save" />
						<input type="button" value="<?php __('btnCancel'); ?>" class="pj-button" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminProperties&action=pjActionIndex';" />
					</p>
				</div>
			</div><!-- tab-3 -->
			<div id="tabs-4">
				<?php
				if($controller->isOwner())
				{
					pjUtil::printNotice(__('infoOwnerFeatureTitle', true), __('infoOwnerFeatureDesc', true));
				}else{
					pjUtil::printNotice(__('infoFeatureTitle', true), __('infoFeatureDesc', true));
				}
				$feature_categories = __('feature_categories', true); 
				?>
				<fieldset class="fieldset white">
					<legend><?php echo $feature_categories[2];?></legend>
					<?php
					$i = 1;
					$is_open = true;
					foreach ($tpl['property_feature_arr'] as $v)
					{
						$is_open = true;
						?>
						<div class="float_left w200 b5 r20 pj-checkbox gradient<?php echo in_array($v['id'], $tpl['property_feature_id_arr']) ? ' pj-checkbox-checked' : NULL; ?>">
							<input type="checkbox"  style="vertical-align: middle" name="feature[]" id="feature_<?php echo $v['id']; ?>" value="<?php echo $v['id']; ?>"<?php echo in_array($v['id'], $tpl['property_feature_id_arr']) ? ' checked="checked"' : NULL; ?> />
							<label for="feature_<?php echo $v['id']; ?>"><?php echo pjSanitize::html($v['name']); ?></label>
						</div>
						<?php
						if ($i % 3 === 0)
						{
							$is_open = false;
							?><div class="clear_left"></div><?php
						}
						$i++;
						
					}
					if ($is_open) {
						?><div class="clear_left"></div><?php
					}
					?>
				</fieldset>
				<fieldset class="fieldset white">
					<legend><?php echo $feature_categories[1];?></legend>
					<?php
					$i = 1;
					foreach ($tpl['community_feature_arr'] as $v)
					{
						
						$is_open = true;
						?>
						<div class="float_left w200 b5 r20 pj-checkbox gradient<?php echo in_array($v['id'], $tpl['property_feature_id_arr']) ? ' pj-checkbox-checked' : NULL; ?>">
							<input type="checkbox"  style="vertical-align: middle" name="feature[]" id="feature_<?php echo $v['id']; ?>" value="<?php echo $v['id']; ?>"<?php echo in_array($v['id'], $tpl['property_feature_id_arr']) ? ' checked="checked"' : NULL; ?> />
							<label for="feature_<?php echo $v['id']; ?>"><?php echo pjSanitize::html($v['name']); ?></label>
						</div>
						<?php
						if ($i % 3 === 0)
						{
							$is_open = false;
							?><div class="clear_left"></div><?php
						}
						$i++;
						
					}
					if ($is_open) {
						?><div class="clear_left"></div><?php
					}
					?>
				</fieldset>
				<p>
					<input type="submit" value="<?php __('btnSave'); ?>" class="pj-button pj-button-save" />
					<input type="button" value="<?php __('btnCancel'); ?>" class="pj-button" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminProperties&action=pjActionIndex';" />
				</p>
			</div><!-- tabs-4 -->
			<div id="tabs-5">
				<?php
				pjUtil::printNotice(__('infoGalleryTitle', true), __('infoGalleryDesc', true));
				?>
				<div id="gallery"></div>
			</div><!-- tabs-5 -->
			<div id="tabs-6">
				<?php
				pjUtil::printNotice(__('infoFloorPlanTitle', true), __('infoFloorPlanDesc', true));  
				?>
				<div class="p">
					<label class="title"><?php __('lblFile'); ?></label>
					<div class="block float_left custom-file">
						<div class="file-upload">
                          	<div class="file-select">
                            	<div class="file-select-button" id="fileName"><?php __('lblChooseFile');?></div>
                            	<div class="file-select-name w300" id="noFile"><?php __('lblNoFileChosen');?></div> 
                            	<input type="file" name="file" id="chooseFile">
                          	</div>
                    	</div>
					</div>
				</div>
				<?php
				if(!empty($tpl['arr']['floor_plan_filepath']))
				{
					$file_url = PJ_INSTALL_URL . $tpl['arr']['floor_plan_filepath'];
					?>
					<p id="file_container">
						<label class="title">&nbsp;</label>
						<span class="inline_block">
							<a href="<?php echo PJ_INSTALL_URL . 'file.php?id='.$tpl['arr']['id'].'&amp;hash=' .$tpl['arr']['floor_plan_hash']; ?>" target="_blank"><?php echo $tpl['arr']['floor_plan_filename'];?></a>&nbsp;&nbsp;
							<a href="javascript:void(0);" class="pj-delete-file" data-href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminProperties&amp;action=pjActionDeleteFile&id=<?php echo $tpl['arr']['id'];?>"><?php __('btnDelete');?></a>
						</span>
					</p>
					<?php
				} 
				?>
				<p>
					<label class="title">&nbsp;</label>
					<input type="submit" value="<?php __('btnSave'); ?>" class="pj-button pj-button-save" />
					<input type="button" value="<?php __('btnCancel'); ?>" class="pj-button" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminProperties&action=pjActionIndex';" />
				</p>
			</div><!-- tabs-6 -->
			<div id="tabs-7">
				<?php
				if($controller->isOwner())
				{
					pjUtil::printNotice(__('infoOwnerContactTitle', true), __('infoOwnerContactDesc', true)); 
				}else{
					pjUtil::printNotice(__('infoContactTitle', true), __('infoContactDesc', true)); 
				}
				
				if ($controller->isAdmin() || $controller->isEditor())
				{
					?>
					<p>
						<label class="title"><?php __('lblChooseOwner'); ?></label>
						<span class="inline_block">
							<select name="owner_id" id="owner_id" class="pj-form-field w200">
								<option value="">-- <?php __('lblChoose'); ?> --</option>
								<?php
								foreach ($tpl['user_arr'] as $k => $v)
								{
								    ?><option value="<?php echo $v['id']; ?>" <?php echo $v['id'] == $tpl['arr']['owner_id'] ? 'selected="selected"' : null;?>><?php echo pjSanitize::html($v['name']); ?></option><?php
								}
								?>
							</select>
						</span>
					</p>	
					<?php
				} 
				?>
				<p>
					<label class="title"><?php __('lblOwnerShow'); ?></label>
					<span class="inline_block">
						<select name="owner_show" id="owner_show" class="pj-form-field w150">
							<?php
							if(empty($tpl['arr']['owner_show']))
							{
								$tpl['arr']['owner_show'] = 'T';
							}
							foreach (__('_yesno', true) as $k => $v)
							{
								?><option value="<?php echo $k; ?>" <?php echo $tpl['arr']['owner_show'] == $k ? 'selected="selected"' : null;?>><?php echo stripslashes($v); ?></option><?php
							}
							?>
						</select>
						<a href="#" class="pj-form-langbar-tip listing-tip" title="<?php __('lblOwnerTip'); ?>"></a>
					</span>
				</p>
				<p>
					<label class="title">&nbsp;</label>
					<span class="inline_block"><label class="content"><a class="resetContact" href="#"><?php __('lblResetContactDetails')?></a></label></span>
				</p>
				
				<p>
					<label class="title"><?php __('lblName'); ?></label>
					<span class="inline_block">
						<input type="text" name="owner_name" id="owner_name" value="<?php echo pjSanitize::html($tpl['arr']['owner_name']); ?>" class="pj-form-field w250" />
					</span>
				</p>
				<p>
					<label class="title"><?php __('email'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-before">
						<span class="pj-form-field-before"><abbr class="pj-form-field-icon-email"></abbr></span>
						<input type="text" name="owner_email" id="owner_email" class="pj-form-field email w200" value="<?php echo pjSanitize::html($tpl['arr']['owner_email']); ?>" />
					</span>
				</p>
				<p>
					<label class="title"><?php __('lblPhone'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-before">
						<span class="pj-form-field-before"><abbr class="pj-form-field-icon-phone"></abbr></span>
						<input type="text" name="owner_phone" id="owner_phone" value="<?php echo pjSanitize::html($tpl['arr']['owner_phone']); ?>" class="pj-form-field w200" placeholder="(123) 456-7890"/>
					</span>
				</p>
				<p>
					<label class="title"><?php __('lblFax'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-before">
						<span class="pj-form-field-before"><abbr class="pj-form-field-icon-phone"></abbr></span>
						<input type="text" name="owner_fax" id="owner_fax" value="<?php echo pjSanitize::html($tpl['arr']['owner_fax']); ?>" class="pj-form-field w200" placeholder="(123) 456-7890"/>
					</span>
				</p>
				<p>
					<label class="title">&nbsp;</label>
					<input type="submit" value="<?php __('btnSave'); ?>" class="pj-button pj-button-save" />
					<input type="button" value="<?php __('btnCancel'); ?>" class="pj-button" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminProperties&action=pjActionIndex';" />
				</p>
			</div><!-- tabs-7 -->
			<div id="tabs-8">
				<?php
				pjUtil::printNotice(__('infoAddressTitle', true), __('infoAddressDesc', true));
				include PJ_VIEWS_PATH . 'pjAdminProperties/elements/address.php';
				?>
			</div><!-- tabs-8 -->
			<div id="tabs-9">
				<?php
				pjUtil::printNotice(__('infoSEOTitle', true), __('infoSEODesc', true));  
				?>
				<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1 && count($tpl['lp_arr']) > 1) : ?>
				<div class="multilang b10"></div>
				<?php endif;?>
				<div class="clear_both">
					<?php
					foreach ($tpl['lp_arr'] as $v)
					{
						?>
						<p class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
							<label class="title">
								<span class="title-tooltip"><?php __('lblMetaTitle'); ?></span>
								&nbsp;
								<a href="#" class="pj-form-langbar-tip listing-tip" title="<?php __('lblMetaTitleTip'); ?>"></a>
							</label>
							<span class="inline_block">
								<input type="text" name="i18n[<?php echo $v['id']; ?>][meta_title]" class="pj-form-field w500" value="<?php echo pjSanitize::html(@$tpl['arr']['i18n'][$v['id']]['meta_title']); ?>" />
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
							<label class="title"><span class="title-tooltip"><?php __('lblMetaKeywords'); ?></span>&nbsp;<a href="#" class="pj-form-langbar-tip listing-tip" title="<?php __('lblMetaKeywordTip'); ?>"></a></label>
							<span class="inline_block">
								<textarea name="i18n[<?php echo $v['id']; ?>][meta_keywords]" class="pj-form-field w500 h100"><?php echo pjSanitize::html(@$tpl['arr']['i18n'][$v['id']]['meta_keywords']); ?></textarea>
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
							<label class="title"><span class="title-tooltip"><?php __('lblMetaDesc'); ?></span>&nbsp;<a href="#" class="pj-form-langbar-tip listing-tip" title="<?php __('lblMetaDescTip'); ?>"></a></label>
							<span class="inline_block">
								<textarea name="i18n[<?php echo $v['id']; ?>][meta_description]" class="pj-form-field w500 h100"><?php echo pjSanitize::html(@$tpl['arr']['i18n'][$v['id']]['meta_description']); ?></textarea>
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
						<input type="submit" value="<?php __('btnSave'); ?>" class="pj-button pj-button-save" />
						<input type="button" value="<?php __('btnCancel'); ?>" class="pj-button" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminProperties&action=pjActionIndex';" />
					</p>
				</div>
			</div><!-- tabs-9 -->
			
		</div> <!-- #tabs -->
	</form>
	
	<div id="dialogDeleteFile" title="<?php __('gridDeleteConfirmation'); ?>" style="display:none;">
		<?php __('lblDeleteFileConfirmation'); ?>
	</div>
	
	<script type="text/javascript">
	var myGallery = myGallery || {};
	myGallery.foreign_id = "<?php echo $tpl['arr']['id']; ?>";
	myGallery.hash = "";
	var myLabel = myLabel || {};
	myLabel.isOwner = <?php echo $controller->isOwner() ? 'true' : 'false'; ?>;
	myLabel.address_not_found = "<?php __('lblAddressNotFound'); ?>";
	myLabel.localeId = "<?php echo $controller->getLocaleId(); ?>";
	(function ($) {
		$(function() {
			$(".multilang").multilang({
				langs: <?php echo $tpl['locale_str']; ?>,
				flagPath: "<?php echo PJ_FRAMEWORK_LIBS_PATH; ?>pj/img/flags/",
				select: function (event, ui) {
					$("input[name='locale']").val(ui.index);
					$.get("index.php?controller=pjAdminProperties&action=pjActionGetLocale", {
						"locale" : ui.index
					}).done(function (data) {
						tid = $("#type_id").find("option:selected").val();
						$("#boxType").html(data.type);
						$("#type_id").find("option[value='"+tid+"']").prop("selected", true);
					});
				}
			});
			$(".first_multilang").find("a[data-index='<?php echo $locale; ?>']").trigger("click");
			$(".multilang").find("a[data-index='<?php echo $locale; ?>']").addClass("pj-form-langbar-item-active");
		});
	})(jQuery_1_8_2);
	</script>
	
	<?php
	if (isset($_GET['tab_id']) && !empty($_GET['tab_id']))
	{
		$tab_id = explode("-", $_GET['tab_id']);
		$tab_id = (int) $tab_id[1] - 1;
		$tab_id = $tab_id < 0 ? 0 : $tab_id;
		?>
		<script type="text/javascript">
		(function ($) {
			$(function () {
				$("#tabs").tabs("option", "active", <?php echo $tab_id; ?>);
			});
		})(jQuery_1_8_2);
		</script>
		<?php
	}
}
?>