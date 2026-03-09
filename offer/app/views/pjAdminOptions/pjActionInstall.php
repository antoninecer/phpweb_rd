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
	?>
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1"><?php __('menuInstall'); ?></a></li>
			<li><a href="#tabs-2"><?php __('menuFeatured'); ?></a></li>
			<li><a href="#tabs-3"><?php __('lblOptional'); ?></a></li>
		</ul>
		<div id="tabs-1" class="form pj-form">
			<?php pjUtil::printNotice(NULL, __('lblInstallPhp1Title', true), false, false); ?>
			<form action="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminOptions&amp;action=pjActionUpdate" method="post" class="form pj-form b20">
				<input type="hidden" name="options_update" value="1" />
				<input type="hidden" name="next_action" value="pjActionInstall" />
				<?php
				$listing_page = NULL;
				foreach ($tpl['o_arr'] as $item)
				{
					if ($item['key'] == 'o_property_page')
					{
						if(empty($item['value']))
						{
							$listing_page = PJ_INSTALL_URL . 'preview.php';
						}else{
							$listing_page = $item['value'];
						}
						?>
						<p>
							<label class="float_left w320 pt5"><?php __('opt_' . $item['key']); ?></label>
							<span class="pj-form-field-custom pj-form-field-custom-before float_left">
								<span class="pj-form-field-before"><abbr class="pj-form-field-icon-url"></abbr></span>
								<input type="text" name="value-<?php echo $item['type']; ?>-<?php echo $item['key']; ?>" class="pj-form-field w300" value="<?php echo htmlspecialchars(stripslashes($listing_page)); ?>" />
							</span>
							<input type="submit" value="<?php __('btnSave'); ?>" class="pj-button float_left l5 align_middle" />
						</p>
						<?php
						break;
					}
				}
				?>
				<p>
					<label class="float_left w320 pt5"><?php __('lblInstallBootstrapSite');?></label>
					<span class="inline-block">
						<span class="block t5">
							<input type="checkbox" name="bootstrap_site"/>
						</span>
					</span>
				</p>
			</form>
			<p style="margin: 0 0 10px; font-weight: bold"><?php __('lblInstallPhp1_1'); ?></p>
			<textarea class="pj-form-field w700 textarea_install" style="overflow: auto; height:50px">
&lt;?php
ob_start();
?&gt;</textarea>
			<p style="margin: 20px 0 10px; font-weight: bold"><?php __('lblInstallPhp1_2'); ?></p>
			<textarea class="pj-form-field w700 textarea_install" style="overflow: auto; height:30px">{PL_LISTINGS}</textarea>
			<p style="margin: 20px 0 10px; font-weight: bold"><?php __('lblInstallPhp1_2a'); ?></p>
			<textarea class="pj-form-field w700 textarea_install" style="overflow: auto; height:30px">{PL_META}</textarea>
			<p style="margin: 20px 0 10px; font-weight: bold"><?php __('lblInstallPhp1_3'); ?></p>
			<textarea id="install_code" class="pj-form-field w700 textarea_install" style="overflow: auto; height:60px">
&lt;?php include '<?php echo dirname($_SERVER['SCRIPT_FILENAME']); ?>/app/views/pjLayouts/pjActionListings.php'; ?&gt;</textarea>
<textarea id="install_code_bootstrap" class="pj-form-field w700 textarea_install" style="overflow: auto; height:60px; display: none;">
&lt;?php
$Bootstrap_Site = true; 
include '<?php echo dirname($_SERVER['SCRIPT_FILENAME']); ?>/app/views/pjLayouts/pjActionListings.php'; 
?&gt;</textarea>
		</div>
		
		<div id="tabs-2" class="form pj-form">
			<?php pjUtil::printNotice(NULL, __('lblFeaturedInstall', true), false, false); ?>
			
			<p style="margin: 0 0 10px; font-weight: bold"><?php __('lblInstallPhp1_1'); ?></p>
			<textarea class="pj-form-field w700 textarea_install" style="overflow: auto; height:50px">
&lt;?php
ob_start();
?&gt;</textarea>
			<p style="margin: 20px 0 10px; font-weight: bold"><?php __('lblInstallPhp1_2'); ?></p>
			<textarea class="pj-form-field w700 textarea_install" style="overflow: auto; height:30px">{PL_FEATURED}</textarea>
			<p style="margin: 20px 0 10px; font-weight: bold"><?php __('lblInstallPhp1_3'); ?></p>
			<textarea class="pj-form-field w700 textarea_install" style="overflow: auto; height:30px">
&lt;?php include '<?php echo dirname($_SERVER['SCRIPT_FILENAME']); ?>/app/views/pjLayouts/pjActionFeatured.php'; ?&gt;</textarea>
		</div>
		
		<div id="tabs-3" class="form pj-form">
			<?php pjUtil::printNotice(NULL, __('lblInstallPhp2Title', true), false, false); ?>
			<form action="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminOptions&amp;action=pjActionUpdate" method="post" class="form pj-form b20">
				<input type="hidden" name="options_update" value="1" />
				<input type="hidden" name="next_action" value="pjActionInstall" />
				<input type="hidden" name="seo_update" value="1" />
				<input type="hidden" name="tab_id" value="<?php echo isset($_GET['tab_id']) && !empty($_GET['tab_id']) ? $_GET['tab_id'] : 'tabs-1'; ?>" />
				<input type="hidden" name="seo_tab_id" value="<?php echo isset($_GET['seo_tab_id']) && !empty($_GET['seo_tab_id']) ? $_GET['seo_tab_id'] : 'seo_tabs-1'; ?>" />
				<?php $locale = isset($_GET['locale']) && (int) $_GET['locale'] > 0 ? (int) $_GET['locale'] : $controller->getLocaleId(); ?>
				<input type="hidden" name="locale" value="<?php echo $locale; ?>" />
				
				<?php
				foreach ($tpl['o_arr'] as $item)
				{
					if ($item['key'] == 'o_seo_url')
					{
						?>
						<p>
							<label class="float_left w150 pt5"><?php __('opt_' . $item['key']); ?></label>
							<select name="value-<?php echo $item['type']; ?>-<?php echo $item['key']; ?>" class="pj-form-field float_left">
							<?php
							$default = explode("::", $item['value']);
							$enum = explode("|", $default[0]);
							
							$enumLabels = array();
							if (!empty($item['label']) && strpos($item['label'], "|") !== false)
							{
								$enumLabels = explode("|", $item['label']);
							}
							
							foreach ($enum as $k => $el)
							{
								if ($default[1] == $el)
								{
									?><option value="<?php echo $default[0].'::'.$el; ?>" selected="selected"><?php echo array_key_exists($k, $enumLabels) ? stripslashes($enumLabels[$k]) : stripslashes($el); ?></option><?php
								} else {
									?><option value="<?php echo $default[0].'::'.$el; ?>"><?php echo array_key_exists($k, $enumLabels) ? stripslashes($enumLabels[$k]) : stripslashes($el); ?></option><?php
								}
							}
							?>
							</select>
							<input type="submit" value="<?php __('btnSave'); ?>" class="pj-button float_left l5 align_middle" />
						</p>
						<?php
						break;
					}
				}
				?>
			
			
			<?php
			$parts = parse_url($listing_page);
			$prefix = NULL;
			if (substr($parts['path'], -1) !== "/")
			{
				$prefix = basename($parts['path']);
			}
			if (isset($parts['query']) && !empty($parts['query']))
			{
				$prefix .= "?" . $parts['query'];
			}
			$prefix .= (strpos($prefix, "?") === false) ? "?" : "&";
			?>
			<p style="margin: 0 0 10px; font-weight: bold"><?php __('lblInstallPhp2_1'); ?></p>
			<textarea class="pj-form-field w700 textarea_install" style="overflow: auto; height:35px">
RewriteEngine On
RewriteRule ^(.*)-(\d+).html$ <?php echo $prefix; ?>controller=pjListings&action=pjActionView&id=$2</textarea>
			<p style="margin: 20px 0 10px; font-weight: bold"><?php __('lblInstallPhp2_2'); ?></p>
			<textarea class="pj-form-field w700 textarea_install" style="overflow: auto; height:35px">
&lt;base href="<?php echo $listing_page; ?>" /&gt;</textarea>
			
				<br/><br/>
				<?php
				pjUtil::printNotice(NULL, __('infoInstallSEODesc', true),false, false);  
				?>
				<div id="seo_tabs">
					<ul>
						<li><a href="#seo_tabs-1"><?php __('lblHomePage'); ?></a></li>
						<li><a href="#seo_tabs-2"><?php __('lblMapPage'); ?></a></li>
						<li><a href="#seo_tabs-3"><?php __('lblAccountPage'); ?></a></li>
					</ul>
					<div id="seo_tabs-1">
						<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1 && count($tpl['lp_arr']) > 1) : ?>
						<div class="multilang b10"></div>
						<?php endif;?>
						<?php include_once PJ_VIEWS_PATH . 'pjAdminOptions/elements/home.php';?>
					</div>
					<div id="seo_tabs-2">
						<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1 && count($tpl['lp_arr']) > 1) : ?>
						<div class="multilang b10"></div>
						<?php endif;?>
						<?php include_once PJ_VIEWS_PATH . 'pjAdminOptions/elements/map.php';?>
					</div>
					<div id="seo_tabs-3">
						<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1 && count($tpl['lp_arr']) > 1) : ?>
						<div class="multilang b10"></div>
						<?php endif;?>
						<?php include_once PJ_VIEWS_PATH . 'pjAdminOptions/elements/account.php';?>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<script type="text/javascript">
	(function ($) {
		$(function() {
			$(".multilang").multilang({
					langs: <?php echo $tpl['locale_str']; ?>,
					flagPath: "<?php echo PJ_FRAMEWORK_LIBS_PATH; ?>pj/img/flags/",
					select: function (event, ui) {
						$("input[name='locale']").val(ui.index);
					}
				});
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
				$("#tabs").tabs("option", "selected", <?php echo $tab_id; ?>);
			});
		})(jQuery_1_8_2);
		</script>
		<?php
	}
	if (isset($_GET['seo_tab_id']) && !empty($_GET['seo_tab_id']))
	{
		$tab_id = explode("-", $_GET['seo_tab_id']);
		$tab_id = (int) $tab_id[1] - 1;
		$tab_id = $tab_id < 0 ? 0 : $tab_id;
		?>
		<script type="text/javascript">
		(function ($) {
			$(function () {
				$("#seo_tabs").tabs("option", "selected", <?php echo $tab_id; ?>);
			});
		})(jQuery_1_8_2);
		</script>
		<?php
	}
}
?>