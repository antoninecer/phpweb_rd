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
}else{
	$types = __('types', true, false);
	?>
	<div class="dashboard_header">
		<div class="item">
			<div class="stat properties">
				<div class="info">
					<abbr><?php echo $tpl['total_properties'];?></abbr>
					<?php echo $tpl['total_properties'] != 1 ? __('lblTotalProperties', true) : mb_strtolower(__('lblProperty', true), 'UTF-8');?>
				</div>
			</div>
		</div>
		<div class="item">
			<div class="stat properties">
				<div class="info">
					<abbr><?php echo $tpl['active_for_rent'];?></abbr>
					<?php __('lblActiveForRent');?>
				</div>
			</div>
		</div>
		<div class="item">
			<div class="stat properties">
				<div class="info">
					<abbr><?php echo $tpl['active_for_sale'];?></abbr>
					<?php __('lblActiveForSale');?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="dashboard_box">
		<div class="dashboard_top">
			<div class="dashboard_column_top"><?php __('lblLatestAdded')?></div>
			<div class="dashboard_column_top"><?php __('lblLatestUpdated')?></div>
			<div class="dashboard_column_top"><?php __('lblNextExpiring')?></div>
		</div>
		<div class="dashboard_middle">
			<div class="dashboard_column">
				<div class="dashboard_list dashboard_latest_list">
					<?php
					if(!empty($tpl['latest_added_arr']))
					{
						foreach($tpl['latest_added_arr'] as $v)
						{
							$thumb_path = PJ_IMG_PATH . 'backend/' . 'no_img.png';
							if(!empty($v['pic']))
							{
								$thumb_path = $v['pic'];
							}
							?>
							<div class="dashboard_row">
								<div class="dashboard_thumb"><a href="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminProperties&amp;action=pjActionUpdate&amp;id=<?php echo $v['id']; ?>"><img src="<?php echo $thumb_path;?>" alt="<?php echo pjSanitize::html($v['ref_id']);?>"/></a></div>
								<label><?php echo date($tpl['option_arr']['o_date_format'], strtotime($v['created']));?>, <?php echo date($tpl['option_arr']['o_time_format'], strtotime($v['created']));?></label>
								<label class="dash_id"><span><?php __('lblID')?></span>: <a href="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminProperties&amp;action=pjActionUpdate&amp;id=<?php echo $v['id']; ?>"><?php echo pjSanitize::html($v['ref_id']);?></a></label>
								<label><?php echo $v['type']?>, <span><?php echo $types[$v['for']];?></span></label>
							</div>
							<?php
						}
					}else{
						?>
						<div class="dashboard_row">
							<label><span><?php __('lblNoPropertiesFound');?></span></label>
						</div>
						<?php
					} 
					?>
				</div>
			</div>
			
			<div class="dashboard_column">
				<div class="dashboard_list dashboard_latest_list">
					<?php
					if(!empty($tpl['latest_updated_arr']))
					{
						foreach($tpl['latest_updated_arr'] as $v)
						{
							$thumb_path = PJ_IMG_PATH . 'backend/' . 'no_img.png';
							if(!empty($v['pic']))
							{
								$thumb_path = $v['pic'];
							}
							?>
							<div class="dashboard_row">
								<div class="dashboard_thumb"><a href="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminProperties&amp;action=pjActionUpdate&amp;id=<?php echo $v['id']; ?>"><img src="<?php echo $thumb_path;?>" alt="<?php echo pjSanitize::html($v['ref_id']);?>"/></a></div>
								<label><?php echo date($tpl['option_arr']['o_date_format'], strtotime($v['modified']));?>, <?php echo date($tpl['option_arr']['o_time_format'], strtotime($v['modified']));?></label>
								<label class="dash_id"><span><?php __('lblID')?></span>: <a href="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminProperties&amp;action=pjActionUpdate&amp;id=<?php echo $v['id']; ?>"><?php echo pjSanitize::html($v['ref_id']);?></a></label>
								<label><?php echo $v['type']?>, <span><?php echo $types[$v['for']];?></span></label>
							</div>
							<?php
						}
					}else{
						?>
						<div class="dashboard_row">
							<label><span><?php __('lblNoPropertiesFound');?></span></label>
						</div>
						<?php
					} 
					?>
				</div>
			</div>
			<div class="dashboard_column">
				<div class="dashboard_list dashboard_latest_list">
					<?php
					if(!empty($tpl['next_expiring_arr']))
					{
						foreach($tpl['next_expiring_arr'] as $v)
						{
							$thumb_path = PJ_IMG_PATH . 'backend/' . 'no_img.png';
							if(!empty($v['pic']))
							{
								$thumb_path = $v['pic'];
							}
							?>
							<div class="dashboard_row">
								<div class="dashboard_thumb"><a href="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminProperties&amp;action=pjActionUpdate&amp;id=<?php echo $v['id']; ?>"><img src="<?php echo $thumb_path;?>" alt="<?php echo pjSanitize::html($v['ref_id']);?>"/></a></div>
								<label><?php __('lblID')?>: <a href="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminProperties&amp;action=pjActionUpdate&amp;id=<?php echo $v['id']; ?>"><?php echo pjSanitize::html($v['ref_id']);?></a></label>
								<label><?php echo $v['type']?>, <span><?php echo $types[$v['for']];?></span></label>
								<label><?php __('lblExpireOn')?>: <span><?php echo date($tpl['option_arr']['o_date_format'], strtotime($v['expire']));?></span></label>
							</div>
							<?php
						}
					}else{
						?>
						<div class="dashboard_row">
							<label><span><?php __('lblNoPropertiesFound');?></span></label>
						</div>
						<?php
					} 
					?>
				</div>
			</div>
		</div>
		<div class="dashboard_bottom"></div>
	</div>
	
	<div class="clear_left t20 overflow dash_date">
		<div class="float_left black t30 t20"><span class="gray"><?php echo ucfirst(__('lblDashLastLogin', true)); ?>:</span> <?php echo pjUtil::formatDate(date('Y-m-d', strtotime($_SESSION[$controller->defaultUser]['last_login'])), 'Y-m-d', $tpl['option_arr']['o_date_format']) . ', ' . pjUtil::formatTime(date('H:i:s', strtotime($_SESSION[$controller->defaultUser]['last_login'])), 'H:i:s', $tpl['option_arr']['o_time_format']); ?></div>
		<div class="float_right overflow">
		<?php
		$days = __('days', true, false);
		?>
			<div class="dashboard_date">
				<abbr><?php echo $days[date('w')]; ?></abbr>
				<?php echo pjUtil::formatDate(date('Y-m-d'), 'Y-m-d', $tpl['option_arr']['o_date_format']); ?>
			</div>
			<div class="dashboard_hour"><?php echo date($tpl['option_arr']['o_time_format']); ?></div>
		</div>
	</div>
	<?php
}
?>