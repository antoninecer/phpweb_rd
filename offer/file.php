<?php
if (!defined("ROOT_PATH"))
{
	define("ROOT_PATH", dirname(__FILE__) . '/');
}
require ROOT_PATH . 'app/config/options.inc.php';
require_once PJ_FRAMEWORK_PATH . 'pjAutoloader.class.php';
pjAutoloader::register();
$_GET['controller'] = 'pjFront';
$_GET['action'] = 'pjActionDownloadFile';
$pjObserver = pjObserver::factory();
$pjObserver->init();
?>