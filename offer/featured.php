<?php
ob_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
		{PL_META}
	<head>
	<body>
		<div style="max-width: 1200px;">
			{PL_FEATURED}
		</div>
	</body>
</html>
<?php
if (!isset($_GET['iframe']))
{
	$content = ob_get_contents();
	ob_end_clean();
	ob_start();
}

if (!isset($_GET['controller']) || empty($_GET['controller']))
{
	$_GET["controller"] = "pjListings";
}
if (!isset($_GET['action']) || empty($_GET['action']))
{
	$_GET["action"] = "pjActionFeatured";
}
if(isset($pjLang))
{
	$_GET["pjLang"] = $pjLang;
}

$dirname = str_replace("\\", "/", dirname(__FILE__));
include str_replace("app/views/pjLayouts", "", $dirname) . '/ind'.'ex.php';

$meta = NULL;
$meta_arr = $pjObserver->getController()->get('meta_arr');
if ($meta_arr !== FALSE)
{
	$meta = sprintf('<title>%s</title>
<meta name="keywords" content="%s" />
<meta name="description" content="%s" />',
		stripslashes($meta_arr['title']),
		htmlspecialchars(stripslashes($meta_arr['keywords'])),
		htmlspecialchars(stripslashes($meta_arr['description']))
	);
}
$content = str_replace('{PL_META}', $meta, $content);

if (!isset($_GET['iframe']))
{
	$app = ob_get_contents();
	ob_end_clean();
	ob_start();
	$app = str_replace('$','&#36;',$app);
	echo preg_replace('/\{PL_FEATURED\}/', $app, $content);
}
?>