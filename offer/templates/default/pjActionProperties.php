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
		<br>
		
		<?php
		if(count($tpl['arr']) > 0)
		{
			$special_items = __('front_layout1_special_items', true);
			$types = __('front_layout1_for', true);
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
				} else {
					$path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
					$path = $path == '/' ? '' : $path;
					$url = $path .'/'. $controller->friendlyURL($listing_title) . "-". $v['id'] . ".html";
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
				<div class="pjPplProduct">
					<div class="clearfix">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<h3 class="text-capitalize pjPplProductTitle"><a href="<?php echo $url;?>" class="clearfix"><?php echo $listing_title;?></a></h3>
								</div><!-- /.col-md-8 -->
							</div><!-- /.row -->
						</div><!-- /.col-sm-12 -->
						<div class="col-md-4 col-sm-4 col-xs-12">
							<?php
							if($v['special'] != 'none')
							{ 
								?><span class="label label-<?php echo $v['special']=='premium' ? 'warning' : ($v['special']=='sold' ? 'danger' : ($v['special']=='underoffer' ? 'success' : null)); ?>"><?php echo $special_items[$v['special']];?></span><?php
							} 
							?>
							<div class="pjPplImagesWrapper">
								<a href="<?php echo $url;?>" class="clearfix"><img src="<?php echo $image;?>" alt="<?php echo $listing_title;?>" class="img-responsive pjPplProductImage"></a>
							</div><!-- /.pjPplImagesWrapper -->
						</div><!-- /.col-md-4 -->
						<div class="col-md-8 col-sm-8 col-xs-12">
							<div class="row">
								<div class="col-md-10 col-sm-10">
									<?php
									if($v['price'] != '')
									{ 
										?>
										<h2>
											<strong class="pjPplProductPrice"><?php echo pjUtil::formatPrice($v['price'], $tpl['option_arr']['o_price_format'], $tpl['option_arr']['o_currency']);?></strong>
											<?php
											if($v['for'] == 'rent')
											{ 
												$per_arr = __('price_per', true);
												?><small><?php echo $per_arr[$v['price_per']];?></small><?php
											} 
											?>
										</h2>
										<?php
									} 
									$floor_metrics = __('floor_metrics', true);
									?>
								</div><!-- /.col-md-12 -->
			
								<div class="col-md-2 col-sm-2">
									<?php
									if($v['price'] != '')
									{ 
										?>
										<h4><small><?php __('front_layout1_label_for');?></small> <br> <span class="pjPplProductType"><?php echo $types[$v['for']];?></span></h4>
										<?php 
									}else{
										?><small><?php __('front_layout1_label_for');?></small> <br> <strong><?php echo $types[$v['for']];?></strong><?php 
									}
									?>
								</div><!-- /.col-md-6 -->
							</div><!-- /.row -->
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<ul class="list-inline pjPplProductMeta" style="padding-right: 0px;">
										<li class="text-info"><strong><?php __('front_layout1_type');?>:</strong> <?php echo pjSanitize::html($v['type']);?></li>
										<?php
										if(!empty($v['floor_area']))
										{ 
											?>
											<li class="text-info"><strong><?php __('front_layout1_area');?>:</strong> <?php echo $v['floor_area'];?> <?php echo $floor_metrics[preg_replace('/\s+/', '', $tpl['option_arr']['o_floor_metric'])];?></li>
											<?php
										}
										if($v['bedrooms'] != 'na')
										{ 
											?><li class="text-info"><strong><?php __('front_layout1_beds');?>:</strong> <?php echo $v['bedrooms'];?></li><?php
										} 
										if($v['bathrooms'] != 'na')
										{
											?><li class="text-info"><strong><?php __('front_layout1_baths');?>:</strong> <?php echo $v['bathrooms'];?></li><?php
										} 
										?>
									</ul>
								</div>
							</div>
    						<?php
							if(!empty($address_arr))
							{
								?><p class="pjPplProductAddress"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> <?php echo join(', ', $address_arr);?></p><?php
							} 
							?>
							<p class="pjPplProductDesc"><?php echo stripslashes(pjUtil::truncateDescription(pjUtil::html2txt($v['description']), 300, ' '));?></p>
							<br/>
							<a href="<?php echo $url;?>" class="btn btn-default"><?php __('front_layout1_full_details');?></a>
						</div>
					</div><!-- thumbnail -->
					<div class="col-md-12"><hr></div><!-- /.col-md-12 -->
				</div><!-- /.row pjPplProduct -->
				<?php
			}
			include_once dirname(__FILE__) . '/elements/paginator.php';
		}else{
			?> <p class="pjPplNoProducts"><?php __('front_no_properties_found'); ?> </p> <?php
		} 
		
		?>
	</div><!-- /.container-fluid pjPplContainer -->
</div>
<?php include_once dirname(__FILE__) . '/elements/loadjs.php';?>