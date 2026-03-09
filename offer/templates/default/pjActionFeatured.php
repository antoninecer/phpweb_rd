<?php
mt_srand();
$index = mt_rand(1, 9999);

$special_items = __('front_layout1_special_items', true);
$types = __('front_layout1_for', true);
if(count($tpl['arr']) > 0)
{
	?>
	<div id="pjWrapperPropertyListing_<?php echo $index;?>" >
		<div class="container-fluid pjPplContainer">
			<br>
			<div class="features row">
				<?php
				foreach($tpl['arr'] as $v)
				{ 
					$image = PJ_INSTALL_URL . PJ_IMG_PATH . 'frontend/300x226.png';
					
					if(!empty($v['medium_image']))
					{
						if(is_file(PJ_INSTALL_PATH . $v['medium_image']))
						{
							$image = PJ_INSTALL_URL . $v['medium_image'];
						}
					}
					$listing_title = pjSanitize::html(stripslashes($v['title']));
					if ($tpl['option_arr']['o_seo_url'] == 'No')
					{
						$url = $_SERVER['SCRIPT_NAME'] . '?controller=pjListings&amp;action=pjActionView&amp;id=' . $v['id'] .(isset($_GET['iframe']) ? '&amp;iframe' : NULL);
						if(!empty($tpl['option_arr']['o_property_page']))
						{
							$url = $tpl['option_arr']['o_property_page'] . '?controller=pjListings&amp;action=pjActionView&amp;id=' . $v['id'];
						}
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
					?>
					<div class="col-sm-4">
						<div class="feature">
							<div class="feature-head">
								<h4><a href="<?php echo $url;?>"><?php echo $listing_title;?></a></h4>
			
								<p><?php echo implode(", ", $address_arr);?></p>
							</div><!-- /.feature-head -->
			
							<div class="feature-image">
								<a href="<?php echo $url;?>"><img class="img-responsive" alt="" src="<?php echo $image;?>"></a>
							</div><!-- /.feature-image -->
			
							<div class="feature-info">
								<div>
								<br/>
								<?php
								if($v['price'] != '')
								{
									if (is_numeric($v['price']))
									{
										?>
										<p class="pull-left">
											<strong class="pjPplProductPrice"><?php echo pjUtil::formatPrice($v['price'], $tpl['option_arr']['o_price_format'], $tpl['option_arr']['o_currency']);?></strong>
											<?php
											if($v['for'] == 'rent')
											{ 
												$per_arr = __('price_per', true);
												?><small><?php echo $per_arr[$v['price_per']];?></small><?php
											} 
											?>
										</p>
										<?php
									}else{
										?>
										<p class="pull-left">
											<strong class="pjPplProductPrice"><?php echo pjSanitize::html($v['price']);?></strong>
											<?php
											if($v['for'] == 'rent')
											{ 
												$per_arr = __('price_per', true);
												?><small><?php echo $per_arr[$v['price_per']];?></small><?php
											} 
											?>
										</p>
										<?php
									}
								}
								?>
								<?php
								if($v['price'] != '')
								{ 
									?>
									<p class="pull-right"><small><?php __('front_layout1_label_for');?></small> <span class="pjPplProductType"><?php echo $types[$v['for']];?></span></p>
									<?php 
								}else{
									?><p class="pull-right"><small><?php __('front_layout1_label_for');?></small> <strong><?php echo $types[$v['for']];?></strong></p><?php 
								}
								$floor_metrics = __('floor_metrics', true);
								?>
								</div>
								<div style="clear: both;"></div>
								<ul class="list-inline">
									<li><strong><?php __('front_layout1_type');?>:</strong> <?php echo pjSanitize::html($v['type']);?> </li>
									<?php
									if(!empty($v['floor_area']))
									{ 
										?>
										<li><strong><?php __('front_layout1_area');?>:</strong> <?php echo pjSanitize::html($v['floor_area']);?> <?php echo $floor_metrics[preg_replace('/\s+/', '', $tpl['option_arr']['o_floor_metric'])];?></li>
										<?php
									}
									if($v['bedrooms'] != 'na')
									{ 
										?><li><strong><?php __('front_layout1_beds');?>:</strong> <?php echo $v['bedrooms'];?></li><?php
									} 
									if($v['bathrooms'] != 'na')
									{
										?><li><strong><?php __('front_layout1_baths');?>:</strong> <?php echo $v['bathrooms'];?></li><?php
									} 
									?>
								</ul>
							</div><!-- /.feature-info -->
			
							<div class="feature-content">
								<p class="pjPplProductDesc"><?php echo stripslashes(pjUtil::truncateDescription(pjUtil::html2txt($v['description']), 300, ' '));?></p>
								<br/>
								<div class="buttons">
									<a href="<?php echo $url;?>" class="btn btn-primary"><?php __('front_layout1_full_details');?></a>
								</div>
							</div><!-- /.feature-content -->
						</div><!-- /.feature -->
			
						<br>
					</div><!-- /.col-sm-4 -->
					<?php
				} 
				?>
			</div><!-- /.row -->
		</div><!-- /.container -->
	</div>
	<?php
}else{
	?>
	<div id="ppContainer_<?php echo $index;?>" class="container-fluid pjPplContainer">
		<br>
		<div class="features row">
			<p class="pjPplNoProducts"> <?php __('front_no_featured_properties'); ?> </p>
		</div>
	</div>
	<?php
} 
?>