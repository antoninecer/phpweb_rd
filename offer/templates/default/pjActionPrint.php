<?php
mt_srand();
$index = mt_rand(1, 9999);
?>
<div id="pjWrapperPropertyListing_<?php echo $index;?>" >
	<div class="container-fluid ppPrintWrapper">
		<br>
		<?php
		if($tpl['status'] == '200')
		{ 
			if (@$_GET['controller'] == 'pjListings' && @$_GET['action'] == 'pjActionView')
			{
				$back = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_SERVER['PHP_SELF'] .'?controller=pjListings&amp;action=pjActionIndex'. (isset($_GET['iframe']) ? '&amp;iframe' : NULL);
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
						<h1><?php echo $listing_title;?></h1>	
					</div><!-- /.col-md-8 -->
			
					<div class="col-md-2 col-sm-2 col-xs-12">
						<h3 class="text-right text-primary"><?php echo $special_items[$tpl['arr']['special']];?></h3>
					</div>
					<?php
				}else{
					?>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h1><?php echo $listing_title;?></h1>	
					</div><!-- /.col-md-8 -->
					<?php
				} 
				?>
			</div><!-- /.row -->
			<div class="row">
				<?php
				if (count($tpl['gallery_arr']) > 0)
				{ 
					?>
					<div class="col-md-7">
						<br/>
						<img id="plImageHolder_<?php echo $index;?>" src="<?php echo PJ_INSTALL_URL . $tpl['gallery_arr'][0]['large_path']; ?>" class="img-responsive" alt="">
						<br />
					</div><!-- /.col-md-7 -->
					<?php
				} 
				?>
				<div class="col-md-<?php echo count($tpl['gallery_arr']) > 0 ? '5' : '12';?>">
					<?php
					if($tpl['arr']['price'] != '')
					{ 
						?>
						<h2><?php echo pjUtil::formatPrice($tpl['arr']['price'], $tpl['option_arr']['o_price_format'], $tpl['option_arr']['o_currency']) . ($tpl['arr']['for'] == 'rent' ? ' <small>' . $per_arr[$tpl['arr']['price_per']] . '</small>' : null);?></h2>
						<?php
					} 
					?>
		
					<h4><?php __('front_layout1_label_for');?> <?php echo $types[$tpl['arr']['for']];?></h4>
		
					<br>
		
					<ul class="list-group">
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
							<li class="list-group-item clearfix"><span class="pull-left"><?php __('front_layout1_lot_dimensions');?>:</span> <strong class="pull-right"><?php echo $tpl['arr']['lot'];?> <?php echo $floor_metrics[preg_replace('/\s+/', '', $tpl['option_arr']['o_floor_metric'])];?></strong></li>
							<?php
						}
						if(!empty($tpl['arr']['floor_area']))
						{ 
							?>
							<li class="list-group-item clearfix"><span class="pull-left"><?php __('front_layout1_floor_area');?>:</span> <strong class="pull-right"><?php echo $tpl['arr']['floor_area'];?> <?php echo $floor_metrics[preg_replace('/\s+/', '', $tpl['option_arr']['o_floor_metric'])];?></strong></li>
							<?php 
						}
						?>
					</ul>
				</div><!-- /.col-md-6 -->
			</div><!-- /.row -->
			<div class="panel panel-default">
				<!-- Default panel contents -->
				<div class="panel-heading">
					<strong><?php __('front_layout1_description');?></strong>
				</div>
			
				<div class="panel-body">
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
					<div class="panel panel-default">
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
			?>
			<div class="row">
				<?php
				ob_start();
				if(!empty($tpl['arr']['country_title']))
				{
					?>
					<div class="row">
						<div class="col-sm-4">
							<strong><?php __('front_layout1_country');?>:</strong>
						</div><!-- /.col-md-3 -->
	
						<div class="col-sm-8">
							<p><?php echo pjSanitize::html($tpl['arr']['country_title']);?></p>
						</div><!-- /.col-md-3 -->
					</div><!-- /.row -->
					<?php
				}
				if(!empty($tpl['arr']['address_state']))
				{
					?>
					<div class="row">
						<div class="col-sm-4">
							<strong><?php __('front_layout1_state');?>:</strong>
						</div><!-- /.col-md-3 -->
	
						<div class="col-sm-8">
							<p><?php echo pjSanitize::html($tpl['arr']['address_state']);?></p>
						</div><!-- /.col-md-3 -->
					</div><!-- /.row -->
					<?php
				}
				if(!empty($tpl['arr']['address_city']))
				{
					?>
					<div class="row">
						<div class="col-sm-4">
							<strong><?php __('front_layout1_city');?>:</strong>
						</div><!-- /.col-md-3 -->
	
						<div class="col-sm-8">
							<p><?php echo pjSanitize::html($tpl['arr']['address_city']);?></p>
						</div><!-- /.col-md-3 -->
					</div><!-- /.row -->
					<?php
				}
				if(!empty($tpl['arr']['address_1']))
				{
					?>
					<div class="row">
						<div class="col-sm-4">
							<strong><?php __('front_layout1_address_1');?>:</strong>
						</div><!-- /.col-md-3 -->
	
						<div class="col-sm-8">
							<p><?php echo pjSanitize::html($tpl['arr']['address_1']);?></p>
						</div><!-- /.col-md-3 -->
					</div><!-- /.row -->
					<?php
				}
				if(!empty($tpl['arr']['address_2']))
				{
					?>
					<div class="row">
						<div class="col-sm-4">
							<strong><?php __('front_layout1_address_2');?>:</strong>
						</div><!-- /.col-md-3 -->
	
						<div class="col-sm-8">
							<p><?php echo pjSanitize::html($tpl['arr']['address_2']);?></p>
						</div><!-- /.col-md-3 -->
					</div><!-- /.row -->
					<?php
				}
				if(!empty($tpl['arr']['address_zip']))
				{
					?>
					<div class="row">
						<div class="col-sm-4">
							<strong><?php __('front_layout1_zip');?>:</strong>
						</div><!-- /.col-md-3 -->
	
						<div class="col-sm-8">
							<p><?php echo pjSanitize::html($tpl['arr']['address_zip']);?></p>
						</div><!-- /.col-md-3 -->
					</div><!-- /.row -->
					<?php
				}
				$ob_address = ob_get_contents();
				ob_end_clean();
				if(!empty($ob_address))
				{
					?>
					<div class="col-md-6">
						<div class="panel panel-default">
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
				ob_start();
				$owner_name = !empty($tpl['arr']['owner_name']) ? $tpl['arr']['owner_name'] : (!empty($tpl['arr']['name']) ? $tpl['arr']['name'] : null);
				if(!empty($owner_name))
				{
					?>
					<div class="row">
						<div class="col-sm-4">
							<strong><?php __('front_layout1_name');?>:</strong>
						</div><!-- /.col-md-3 -->
						
						<div class="col-sm-8">
							<p><?php echo pjSanitize::html($owner_name);?></p>
						</div><!-- /.col-md-3 -->
					</div><!-- /.row -->
					<?php
				}
				$owner_email = !empty($tpl['arr']['owner_email']) ? $tpl['arr']['owner_email'] : (!empty($tpl['arr']['email']) ? $tpl['arr']['email'] : null);
				if(!empty($owner_email))
				{ 
					?>
					<div class="row">
						<div class="col-sm-4">
							<strong><?php __('front_layout1_email');?>:</strong>
						</div><!-- /.col-md-3 -->
						
						<div class="col-sm-8">
							<p><?php echo $owner_email ?></p>
						</div><!-- /.col-md-3 -->
					</div><!-- /.row -->
					<?php
				}
				$owner_phone = !empty($tpl['arr']['owner_phone']) ? $tpl['arr']['owner_phone'] : (!empty($tpl['arr']['phone']) ? $tpl['arr']['phone'] : null);
				if(!empty($owner_phone))
				{ 
					?>
					<div class="row">
						<div class="col-sm-4">
							<strong><?php __('front_layout1_phone');?>:</strong>
						</div><!-- /.col-md-3 -->
						
						<div class="col-sm-8">
							<p><?php echo pjSanitize::html($owner_phone);?></p>
						</div><!-- /.col-md-3 -->
					</div><!-- /.row -->
					<?php
				}
				$owner_fax = !empty($tpl['arr']['owner_fax']) ? $tpl['arr']['owner_fax'] : (!empty($tpl['arr']['fax']) ? $tpl['arr']['fax'] : null);
				if(!empty($owner_fax))
				{ 
					?>
					<div class="row">
						<div class="col-sm-4">
							<strong><?php __('front_layout1_fax');?>:</strong>
						</div><!-- /.col-md-3 -->
						
						<div class="col-sm-8">
							<p><?php echo pjSanitize::html($owner_fax);?></p>
						</div><!-- /.col-md-3 -->
					</div><!-- /.row -->
					<?php
				}
				$ob_contact = ob_get_contents();
				ob_end_clean();
				if(!empty($ob_contact))
				{
					?>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<strong><?php __('front_layout1_contact_details');?></strong>
							</div>
						
							<div class="panel-body">
								<?php
								echo $ob_contact;
								?>
							</div>
						</div><!-- /. panel -->
					</div><!-- /.col-md-6 -->
					<?php
				} 
				?>
			</div><!-- /.row -->
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
	</div><!-- /.container-fluid -->
</div>
<?php include_once dirname(__FILE__) . '/elements/loadjs.php';?>
<script type="text/javascript">
if (window.print) {
	window.print();
}
</script>