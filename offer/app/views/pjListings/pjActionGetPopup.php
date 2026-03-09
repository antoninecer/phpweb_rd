<?php
if($_GET['type'] == 'Request')
{ 
	include_once ROOT_PATH . PJ_TEMPLATE_PATH . PJ_TEMPLATE_SCRIPT_PATH . 'elements/request-popup.php';
}else{
	include_once ROOT_PATH . PJ_TEMPLATE_PATH . PJ_TEMPLATE_SCRIPT_PATH . 'elements/send-email-popup.php';
}
?>