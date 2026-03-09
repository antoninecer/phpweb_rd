<?php
mt_srand();
$index = mt_rand(1, 9999);
?>
<div id="pjWrapperPropertyListing_<?php echo $index;?>" >
	<div class="container-fluid pjPplContainer">
		<br>
		<?php include_once dirname(__FILE__) . '/elements/header.php';?>
		<br>
		<?php
		if($tpl['status'] == '200')
		{
			if (@$_GET['controller'] == 'pjListings' && @$_GET['action'] == 'pjActionView')
			{
				$back = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_SERVER['PHP_SELF'] .'?controller=pjListings&amp;action=pjActionProperties'. (isset($_GET['iframe']) ? '&amp;iframe' : NULL);
			}
			$listing_title = pjSanitize::html(stripslashes($tpl['arr']['title']));
			$special_items = __('front_layout1_special_items', true);
			$per_arr = __('price_per', true);
			$types = __('front_layout1_for', true);
			?>
			<div class="row">
				<?php
				if($tpl['arr']['special'] != 'none')
				{
					?>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<h1 class="pjPplProductTitle"><?php echo $listing_title;?></h1>	
					</div><!-- /.col-md-8 -->
			
					<div class="col-md-2 col-sm-2 col-xs-12">
						<h3 class="text-right text-primary pjPplProductTitle"><?php echo $special_items[$tpl['arr']['special']];?></h3>
					</div>
					<?php
				}else{
					?>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h1 class="pjPplProductTitle"><?php echo $listing_title;?></h1>	
					</div><!-- /.col-md-8 -->
					<?php
				} 
				?>
			</div><!-- /.row -->
			<div class="row">
				<?php
				if (count($tpl['gallery_arr']) > 0)
				{ 
					$large_url = $medium_url = PJ_INSTALL_URL . PJ_IMG_PATH . 'frontend/768x526.png';
					if(is_file(PJ_INSTALL_PATH . $tpl['gallery_arr'][0]['large_path']))
					{
						$large_url = PJ_INSTALL_URL . $tpl['gallery_arr'][0]['large_path'];
					}
					if(is_file(PJ_INSTALL_PATH . $tpl['gallery_arr'][0]['medium_path']))
					{
						$medium_url = PJ_INSTALL_URL . $tpl['gallery_arr'][0]['medium_path'];
					}
					?>
					<div class="col-md-7">
						<br/>
						<a rel="lytebox[allphotos]" href="<?php echo $large_url; ?>">
							<img id="plImageHolder_<?php echo $index;?>" src="<?php echo $medium_url; ?>" class="img-responsive" title="<?php echo pjSanitize::clean($tpl['gallery_arr'][0]['title']);?>" alt="<?php echo pjSanitize::clean($tpl['gallery_arr'][0]['alt']);?>">
						</a>
					    <br>
				    	<div class="row pjPplThumbs">
				    		<?php
							foreach ($tpl['gallery_arr'] as $k => $v)
							{
								$large_url = $medium_url = PJ_INSTALL_URL . PJ_IMG_PATH . 'frontend/768x526.png';
								if(is_file(PJ_INSTALL_PATH . $v['large_path']))
								{
									$large_url = PJ_INSTALL_URL . $v['large_path'];
								}
								if(is_file(PJ_INSTALL_PATH . $v['medium_path']))
								{
									$medium_url = PJ_INSTALL_URL . $v['medium_path'];
								}
								?>
								<div class="col-md-2 col-sm-2 col-xs-4">
							    	<a class="plThumbnail" rel="lytebox[allphotos]" href="<?php echo $large_url; ?>" title="<?php echo pjSanitize::clean($v['title']);?>">
							    		<img src="<?php echo PJ_INSTALL_URL . $v['small_path']; ?>" class="img-responsive" alt="<?php echo pjSanitize::clean($v['alt']);?>" title="<?php echo pjSanitize::clean($v['title']);?>" data-large="<?php echo $medium_url; ?>">
							    		<span class="pjPplImageBorder pjPplImageBorderTop"></span>
							    		<span class="pjPplImageBorder pjPplImageBorderRight"></span>
							    		<span class="pjPplImageBorder pjPplImageBorderBottom"></span>
							    		<span class="pjPplImageBorder pjPplImageBorderLeft"></span>
								    </a>
			
								    <br>
							    </div><!-- /.col-md-3 -->
								<?php
							} 
							?>
				    	</div><!-- /.row -->
					</div><!-- /.col-md-7 -->
					<?php
				} 
				?>
				<div class="col-md-<?php echo count($tpl['gallery_arr']) > 0 ? '5' : '12';?>">
					<?php
					if($tpl['arr']['price'] != '')
					{ 
						if (is_numeric($tpl['arr']['price']))
						{
							?>
							<h2 class="pjPplProductPrice"><?php echo pjUtil::formatPrice($tpl['arr']['price'], $tpl['option_arr']['o_price_format'], $tpl['option_arr']['o_currency']) . ($tpl['arr']['for'] == 'rent' ? ' <small>' . $per_arr[$tpl['arr']['price_per']] . '</small>' : null);?></h2>
							<?php
						}else{
							?>
							<h2 class="pjPplProductPrice"><?php echo pjSanitize::html($tpl['arr']['price']) . ($tpl['arr']['for'] == 'rent' ? ' <small>' . $per_arr[$tpl['arr']['price_per']] . '</small>' : null);?></h2>
							<?php
						}
					} 
					?>
		
					<h4 class="pjPplProductType"><?php __('front_layout1_label_for');?> <?php echo $types[$tpl['arr']['for']];?></h4>
		
					<br>
		
					<ul class="list-group pjPplProductMeta">
						<li class="list-group-item clearfix"><span class="pull-left"><?php __('front_layout1_reference_id');?>:</span> <strong class="pull-right"><?php echo pjSanitize::html($tpl['arr']['ref_id']);?></strong></li>
						<li class="list-group-item clearfix"><span class="pull-left"><?php __('front_layout1_type');?>:</span> <strong class="pull-right"><?php echo pjSanitize::html($tpl['arr']['type']);?></strong></li>
						<?php
						if($tpl['arr']['bedrooms'] != 'na')
						{ 
							?>
							<li class="list-group-item clearfix"><span class="pull-left"><?php $tpl['arr']['bedrooms'] != 1 ? __('front_layout1_bedrooms') : __('front_layout1_bedroom');?>:</span> <strong class="pull-right"><?php echo $tpl['arr']['bedrooms'];?></strong></li>
							<?php
						} 
						if($tpl['arr']['bathrooms'] != 'na')
						{
							?>
							<li class="list-group-item clearfix"><span class="pull-left"><?php $tpl['arr']['bathrooms'] != 1 ? __('front_layout1_bathrooms') : __('front_layout1_bathroom');?>:</span> <strong class="pull-right"><?php echo $tpl['arr']['bathrooms'];?></strong></li>
							<?php
						}
						if(!empty($tpl['arr']['year_built']))
						{ 
							?>
							<li class="list-group-item clearfix"><span class="pull-left"><?php __('front_layout1_year_built');?>:</span> <strong class="pull-right"><?php echo pjSanitize::html($tpl['arr']['year_built']);?></strong></li>
							<?php
						}
						$floor_metrics = __('floor_metrics', true);
						if(!empty($tpl['arr']['lot']))
						{ 
							?>
							<li class="list-group-item clearfix"><span class="pull-left"><?php __('front_layout1_lot_dimensions');?>:</span> <strong class="pull-right"><?php echo pjSanitize::html($tpl['arr']['lot']);?> <?php echo $floor_metrics[preg_replace('/\s+/', '', $tpl['option_arr']['o_floor_metric'])];?></strong></li>
							<?php
						}
						if(!empty($tpl['arr']['floor_area']))
						{ 
							?>
							<li class="list-group-item clearfix"><span class="pull-left"><?php __('front_layout1_floor_area');?>:</span> <strong class="pull-right"><?php echo pjSanitize::html($tpl['arr']['floor_area']);?> <?php echo $floor_metrics[preg_replace('/\s+/', '', $tpl['option_arr']['o_floor_metric'])];?></strong></li>
							<?php 
						}
						if(!empty($tpl['arr']['floor_plan_filepath']))
						{ 
							?><li class="list-group-item clearfix"><a href="<?php echo PJ_INSTALL_URL . 'file.php?id='.$tpl['arr']['id'].'&amp;hash=' .$tpl['arr']['floor_plan_hash']; ?>" target="_blank"><?php __('front_layout1_floor_plan');?></a></li><?php
						} 
						?>
						<li class="list-group-item clearfix"><span class="pull-left"><a href="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjListings&amp;action=pjActionPrint&id=<?php echo $tpl['arr']['id'];?>" class="btn btn-default" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;<?php __('front_print');?></a></span></li>
					</ul>
				</div><!-- /.col-md-6 -->
			</div><!-- /.row -->
			<div class="panel panel-default pjPplProductPanel">
				<!-- Default panel contents -->
				<div class="panel-heading">
					<strong><?php __('front_layout1_description');?></strong>
				</div>
			
				<div class="panel-body pjPplProductDesc">
					<?php echo stripslashes($tpl['arr']['description']);?>
				</div>
			</div><!-- /. panel -->
			<?php
			foreach(__('feature_categories', true) as $k => $category)
			{
				ob_start();
				if(isset($tpl['feature_arr'][$k]))
				{
					?>
					<div class="row">
						<?php 
						$feature_arr = $tpl['feature_arr'][$k];
						foreach($feature_arr as $v)
						{
							?>
							<div class="col-sm-3">
								<p><?php echo $v;?></p>
							</div><!-- /.col-md-3 -->
							<?php
						}
						?>
					</div><!-- /.row -->
					<?php
				}
				$ob_feature = ob_get_contents();
				ob_end_clean();
				if(!empty($ob_feature))
				{
					?>
					<div class="panel panel-default pjPplProductPanel">
						<div class="panel-heading">
							<strong><?php echo $category;?></strong>
						</div><!-- /.panel-heading -->
				
						<div class="panel-body">
							<?php
							echo $ob_feature; 
							?>
						</div><!-- /.panel-body -->
					</div><!-- /.panel -->
					<?php
				}
			}
			if($tpl['arr']['show_googlemap'] == 'T')
			{ 
				?>
				<div class="panel panel-default pjPplProductPanel">
					<!-- Default panel contents -->
					<div class="panel-heading">
						<strong><?php __('front_layout1_map');?></strong>
					</div>
				
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-12">
								<div id="ppDetailsMap_<?php echo $index;?>" class="ppMapDetailsContainer" data-lat="<?php echo $tpl['arr']['lat'];?>" data-lng="<?php echo $tpl['arr']['lng'];?>"></div>
							</div>
						</div><!-- /.row -->
					</div>
				</div><!-- /. panel -->
				<?php
			}
			?>
			<div class="row">
				<?php
				ob_start();
				include_once dirname(__FILE__) . '/elements/address_'.$controller->getDirection().'.php';
				$ob_address = ob_get_contents();
				ob_end_clean();
				if(!empty($ob_address))
				{
					?>
					<div class="col-md-6">
						<div class="panel panel-default pjPplProductPanel">
							<!-- Default panel contents -->
							<div class="panel-heading">
								<strong><?php __('front_layout1_address');?></strong>
							</div>
							<div class="panel-body">
								<?php
								echo $ob_address; 
								?>
							</div>
						</div><!-- /. panel -->
					</div><!-- /.col-md-6 -->
					<?php
				}
				if($tpl['arr']['owner_show'] == 'T')
				{
					ob_start();
					include_once dirname(__FILE__) . '/elements/owner_'.$controller->getDirection().'.php';
					$ob_contact = ob_get_contents();
					ob_end_clean();
					if(!empty($ob_contact))
					{
						?>
						<div class="col-md-6">
							<div class="panel panel-default pjPplProductPanel">
								<div class="panel-heading">
									<strong><?php __('front_layout1_contact_details');?></strong>
								</div>
							
								<div class="panel-body">
									<?php
									echo $ob_contact;
									if($tpl['option_arr']['o_show_contact'] == 'Yes')
									{
										?>
										<div class="row">
											<div class="col-sm-4">
												&nbsp;
											</div><!-- /.col-md-3 -->
											
											<div class="col-sm-8">
												<p><a href="#" class="btn btn-default" data-pj-toggle="modal" data-pj-target="#frmPLContactDetails"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;<?php __('front_request_details');?></a></p>
											</div><!-- /.col-md-3 -->
										</div><!-- /.row -->
										<?php
									} 
									?>
								</div>
							</div><!-- /. panel -->
						</div><!-- /.col-md-6 -->
						<?php
					} 
				}
				?>
			</div><!-- /.row -->
			<div class="modal fade" id="frmPLContactDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
				    <div class="modal-content">
				      	<div class="modal-header">
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        	<h4 class="modal-title" id="myModalLabel"><?php __('front_request_details');?></h4>
				      	</div>
				      	<div class="modal-body">
				        	<form id="frmPLSendRequest"action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjListings&amp;action=pjActionSend" method="post">
								<input type="hidden" name="send" value="request" />
								<input type="hidden" name="id" value="<?php echo $tpl['arr']['id']?>"/>
								
								
								<div class="form-group">
									<label><?php __('front_layout1_name')?></label>
									<input type="text" name="name" class="form-control required" data-err="<?php __('front_layout1_name_required');?>"/>
								</div>
				
								<div class="form-group">
									<label><?php __('front_layout1_email')?></label>
									<input type="text" name="email" class="form-control required email" data-err="<?php __('front_layout1_email_required');?>" data-email="<?php __('front_layout1_email_invalid');?>"/>
								</div>
								<div class="form-group">
									<label><?php __('front_layout1_phone')?></label>
									<input type="text" name="phone" class="form-control"/>
								</div>
								<div class="form-group">
									<label><?php __('front_layout1_message')?></label>
									<textarea name="message" class="form-control required" cols="30" rows="5" data-err="<?php __('front_layout1_message_required');?>"></textarea>
								</div>
								<div class="form-group">
									<label><?php __('front_layout1_captcha');?></label>
									<div class="row">
										<div class="col-md-6 col-sm-6">
											<input type="text" id="pjPlCaptchaField" name="captcha" class="form-control ppCaptchaField required" maxlength="6" autocomplete="off" data-folder="<?php echo PJ_INSTALL_FOLDER;?>" data-err="<?php __('front_layout1_captcha_required');?>" data-captcha="<?php __('front_layout1_captcha_incorrect');?>"/>
										</div>
										<div class="col-md-6 col-sm-6">
											<img id="ppCaptchaImage_<?php echo $index;?>" src="<?php echo PJ_INSTALL_FOLDER; ?>index.php?controller=pjFront&amp;action=pjActionCaptcha&amp;rand=<?php echo rand(1, 999999); ?>" alt="Captcha" style="vertical-align:top;cursor: pointer;"/>
										</div>
									</div>
								</div><!-- /.form-group -->
								<div class="form-group" style="display:none;">
									<label class="ppFormWarning alert alert-info" role="alert"><?php __('front_request_sending');?></label>
									<label class="ppFormSuccess alert alert-success" role="alert"><?php __('front_request_sent');?></label>
								</div>
							</form>
				      	</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-default pjPplBtnNav" data-dismiss="modal"><?php __('front_layout1_close');?></button>
				        	<button type="button" class="btn btn-default btnSendContact"><?php __('front_layout1_send');?></button>
				      	</div>
				    </div>
				 </div>
			</div>
			<?php
		}else{
			$property_statuses = __('property_statuses', true);
			?>
			<div class="row">
				<div class="col-md-8 col-sm-8 col-xs-12">
					<?php echo $property_statuses[$tpl['status']];?>
				</div><!-- /.col-md-8 -->
			</div><!-- /.row -->
			<?php
		} 
		?>
	</div><!-- /.container-fluid pjPplContainer -->
</div>
<?php include_once dirname(__FILE__) . '/elements/loadjs.php';?>