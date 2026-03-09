<?php 
if (pjObject::getPlugin('pjPaypal') !== NULL)
{
    $controller->requestAction(array('controller' => 'pjPaypal', 'action' => 'pjActionForm', 'params' => $tpl['params']));
}
?>