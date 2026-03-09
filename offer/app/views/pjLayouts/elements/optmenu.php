<?php
$active = " ui-tabs-active ui-state-active";
?>
<div class="ui-tabs ui-widget ui-widget-content ui-corner-all b10">
	<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
		<li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjAdminOptions' || $_GET['action'] != 'pjActionIndex' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;action=pjActionIndex"><?php __('menuGeneral'); ?></a></li>
		<li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjAdminOptions' || $_GET['action'] != 'pjActionSubmissions' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;action=pjActionSubmissions"><?php __('menuSubmissions'); ?></a></li>
		<li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] == 'pjAdminOptions' && in_array($_GET['action'], array('pjActionNotification') ) ? $active : NULL; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;action=pjActionNotification"><?php __('menuNotifications'); ?></a></li>
		<li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjAdminTypes' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminTypes&amp;action=pjActionIndex"><?php __('menuTypes'); ?></a></li>
		<li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] == 'pjAdminFeatures' ? $active : NULL; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminFeatures&amp;action=pjActionIndex"><?php __('menuFeatures'); ?></a></li>
		<li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjCountry' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjCountry&amp;action=pjActionIndex"><?php __('plugin_country_menu_countries'); ?></a></li>
		<li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjLocale' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjLocale&amp;action=pjActionIndex&amp;tab=1"><?php __('menuLocales'); ?></a></li>
		<li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjBackup' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBackup&amp;action=pjActionIndex"><?php __('menuBackup'); ?></a></li>
		<?php
		if ($controller->isAdmin() && pjObject::getPlugin('pjSms') !== NULL)
		{
			?><li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjSms' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjSms&amp;action=pjActionIndex"><?php __('plugin_sms_menu_sms'); ?></a></li><?php
		} 
		?>
	</ul>
</div>