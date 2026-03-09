<?php
mt_srand();
$index = mt_rand(1, 9999);
?>
<div id="pjWrapperPropertyListing_<?php echo $index;?>" >
	<div class="container-fluid pjPplContainer">
		<br>
		<?php include_once dirname(__FILE__) . '/elements/header.php';?>
		<br>
		<?php include_once dirname(__FILE__) . '/elements/search.php';?>
		<br>
		<div class="row">
			<div class="col-md-12">
				<?php
				if(count($tpl['arr']) > 0)
				{ 
					?>
					<div id="ppMapContainer_<?php echo $index;?>" class="ppMapContainer"></div>
					<?php
				}else{
					?>
					<p><?php __('front_no_properties_found');?></p>
					<?php
				} 
				?>
			</div>
		</div><!-- /.row -->
		<br>
		<br>
	</div><!-- /.container-fluid pjPplContainer -->
</div>
<script type="text/javascript">
	var mapProperties = [];
	<?php
	if(count($tpl['arr']) > 0)
	{
		$special_items = __('special_items', true);
		$per_arr = __('price_per', true);
		foreach($tpl['arr'] as $v)
		{
			$image = PJ_INSTALL_URL . PJ_TEMPLATE_SCRIPT_PATH . 'images/no_img.png';
			if(!empty($v['image']))
			{
				if(is_file(PJ_INSTALL_PATH . $v['image']))
				{
					$image = PJ_INSTALL_URL . $v['image'];
				}
			}
			$listing_title = pjSanitize::html(stripslashes($v['title']));
			if ($tpl['option_arr']['o_seo_url'] == 'No')
			{
				$url = $_SERVER['SCRIPT_NAME'] . '?controller=pjListings&amp;action=pjActionView&amp;id=' . $v['id'] .(isset($_GET['iframe']) ? '&amp;iframe' : NULL);
			} else {
				$path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
				$path = $path == '/' ? '' : $path;
				$url = $path .'/'. $controller->friendlyURL($v['title']) . "-". $v['id'] . ".html";
			}
			$address_arr = array();
			if(!empty($v['address_1']))
			{
				$address_arr[] = pjSanitize::html($v['address_1']);
			}
			if(!empty($v['address_city']))
			{
				$address_arr[] = pjSanitize::html($v['address_city']);
			}
			if(!empty($v['address_state']))
			{
				$address_arr[] = pjSanitize::html($v['address_state']);
			}
			if(!empty($v['address_zip']))
			{
				$address_arr[] = pjSanitize::html($v['address_zip']);
			}
			if(!empty($v['country_title']))
			{
				$address_arr[] = pjSanitize::html($v['country_title']);
			}
			$infoWindow = '<div class="ppMapProduct ppMapProduct'. ($v['for'] == 'rent' ? 'Rent' : 'Sale') . '">';
			$infoWindow .= '<a href="'.$url.'">';
			$infoWindow .= '<header class="ppMapProductHead">';
			$infoWindow .= '<div class="ppMapProductImage">';
			$infoWindow .= '<img alt="" src="'.$image.'">';
			$infoWindow .= '</div>';
			$infoWindow .= '<div class="ppMapProductOverlay">';
			$infoWindow .= '<h6>';
			$infoWindow .= pjSanitize::html($v['type']);
			if($v['price'] != '')
			{
				if (is_numeric($v['price']))
				{
					if($v['for'] == 'rent')
					{
						$infoWindow .= '<strong> '.pjUtil::formatPrice($v['price'], $tpl['option_arr']['o_price_format'], $tpl['option_arr']['o_currency']).'<small> '.$per_arr[$v['price_per']].'</small></strong>';
					}else{
						$infoWindow .= '<strong> '.pjUtil::formatPrice($v['price'], $tpl['option_arr']['o_price_format'], $tpl['option_arr']['o_currency']).'</strong>';
					}
				}else{
					if($v['for'] == 'rent')
					{
						$infoWindow .= '<strong> '.pjSanitize::html($v['price']).'<small> '.$per_arr[$v['price_per']].'</small></strong>';
					}else{
						$infoWindow .= '<strong> '.pjSanitize::html($v['price']).'</strong>';
					}
				}
			}
			$floor_metrics = __('floor_metrics', true);
			$infoWindow .= '</h6>';
			$infoWindow .= '</div>';
			$infoWindow .= '</header>';
			$infoWindow .= '<div class="ppMapProductBody">';
			$infoWindow .= '<h5>';
			$infoWindow .= $listing_title;
			$infoWindow .= '</h5>';
			$infoWindow .= '<div class="ppMapProductMeta">';
			if(!empty($v['floor_area']))
			{
				$infoWindow .= '<div>';
				$infoWindow .= '<i class="ppIco ppIcoArea"></i>';
				$infoWindow .= __('front_area', true) . ': ' . pjSanitize::html($v['floor_area']) . ' '. $floor_metrics[preg_replace('/\s+/', '', $tpl['option_arr']['o_floor_metric'])];
				$infoWindow .= '</div>';
			}
			$infoWindow .= '<div>';
			$infoWindow .= '<i class="ppIco ppIcoBed"></i>';
			$infoWindow .= __('front_beds', true) . ': ' . $v['bedrooms'];
			$infoWindow .= '</div>';
			$infoWindow .= '<div>';	
			$infoWindow .= '<i class="ppIco ppIcoBath"></i>';
			$infoWindow .= __('front_baths', true) . ': ' . $v['bathrooms'];
			$infoWindow .= '</div>';
			$infoWindow .= '</div>';
			$infoWindow .= '<p>';
			$infoWindow .= '<i class="ppIco ppIcoMap"></i>';
			$infoWindow .= join(', ', $address_arr);
			$infoWindow .= '</p>';
			$infoWindow .= '</div>';
			$infoWindow .= '</a>';
			$infoWindow .= '</div>';
			?>
			var info_arr = [];
			info_arr.push(<?php echo $v['lat']?>);
			info_arr.push(<?php echo $v['lng']?>);
			info_arr.push('<?php echo $infoWindow;?>');
			mapProperties.push(info_arr);
			<?php
		}
	} 
	?>
</script>
<?php include_once dirname(__FILE__) . '/elements/loadjs.php';?>