<!doctype html>
<html>
	<head>
		<title>Property Listing Script by PHPJabbers.com | Print</title>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<?php
		foreach ($controller->getCss() as $css)
		{
			echo '<link type="text/css" rel="stylesheet" href="'.(isset($css['remote']) && $css['remote'] ? NULL : PJ_INSTALL_URL).$css['path'].htmlspecialchars($css['file']).'" />';
		}
		?>
	</head>
	<body>
		<div id="container" style="margin: 0 auto; width: 1024px;">
			<?php require $content_tpl; ?>
		</div>
	</body>
</html>
<?php
if(!isset($tpl['arr']))
{
	?>
	<script type="text/javascript">
	if (window.print) {
		window.print();
	}
	</script>
	<?php
}
?>