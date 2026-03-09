<?php
$types = __('front_types', true);
$property_bedrooms = array(0 => '0', 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9', 10 => '>10');
$property_bathrooms = array(0 => '0', 1 => '1', '1.5' => '1.5', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '>5'); 
?>
<form id="frmSearch" name="frmSearch" method="get" class="pjPplFormSearch">
	<input type="hidden" value="pjListings" name="controller">
	<input type="hidden" value="<?php echo $_GET['action'] == 'pjActionMap' ? 'pjActionMap' : 'pjActionProperties'?>" name="action">
	<input type="hidden" value="1" name="listing_search">
	<input type="hidden" name="for" value="<?php echo isset($_GET['for']) ? $_GET['for'] : null;?>"/>
	<div class="row">
		<div class="col-md-3">
			<label class="control-label">&nbsp;</label>
			
			<div class="btn-group btn-group-justified pjPplBtnGroupType" role="group" aria-label="...">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-default btnFor<?php echo isset($_GET['for']) ? ($_GET['for'] == 'sale' ? ' btn-primary' : null) : null;?>" data-for="sale"><?php echo $types['sale'];?></button>
				</div>
				
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-default btnFor<?php echo isset($_GET['for']) ? ($_GET['for'] == 'rent' ? ' btn-primary' : null) : null;?>" data-for="rent"><?php echo $types['rent'];?></button>
				</div>
			</div>
		</div><!-- /.col-md-3 -->
		<div class="col-md-3">
			<label class="control-label"><?php __('front_layout1_keyword');?>:</label>
			
			<input type="text" name="keyword" class="form-control" value="<?php echo isset($_GET['keyword']) ? pjSanitize::html($_GET['keyword']) : null;?>" placeholder="<?php __('front_search_for');?>"/>
		</div><!-- /.col-md-3 -->
		<div class="col-md-3">
			<label class="control-label"><?php __('front_layout1_location');?>:</label>
			
			<input type="text" name="location" class="form-control" value="<?php echo isset($_GET['location']) ? pjSanitize::html($_GET['location']) : null;?>"/>
		</div><!-- /.col-md-3 -->
		<div class="col-md-3">
			<label class="control-label"><?php __('front_layout1_type');?>:</label>

			<select name="type_id" class="form-control">
				<option value="">-- <?php __('front_layout1_choose');?> --</option>
				<?php
				foreach($tpl['type_arr'] as $v)
				{
					?><option value="<?php echo $v['id'];?>"<?php echo isset($_GET['type_id']) ? ($_GET['type_id'] == $v['id'] ? ' selected="selected"' : null) : null;?>><?php echo pjSanitize::html($v['name']);?></option><?php
				} 
				?>
			</select>
		</div><!-- /.col-md-3 -->
		<div class="col-md-3">
			<label class="control-label"><?php __('front_layout1_specials');?>:</label>

			<select name="specials" class="form-control">
				<option value=""><?php __('front_layout1_all');?></option>
				<?php
				foreach (__('special_items', true) as $k => $v)
				{
					?><option value="<?php echo $k; ?>"<?php echo isset($_GET['specials']) ? ($_GET['specials'] == $k ? ' selected="selected"' : null) : null;?>><?php echo stripslashes($v); ?></option><?php
				}
				?>
			</select>
		</div><!-- /.col-md-3 -->
		<div class="col-md-3">
			<label class="control-label"><?php __('front_layout1_feature');?>:</label>

			<select name="feature_id" class="form-control">
				<option value="">-- <?php __('front_layout1_choose');?> --</option>
				<?php
				foreach($tpl['feature_arr'] as $v)
				{
					?><option value="<?php echo $v['id'];?>"<?php echo isset($_GET['feature_id']) ? ($_GET['feature_id'] == $v['id'] ? ' selected="selected"' : null) : null;?>><?php echo pjSanitize::html($v['name']);?></option><?php
				} 
				?>
			</select>
		</div><!-- /.col-md-3 -->
		<div class="col-md-3">
			<label class="control-label"><?php __('front_layout1_bedrooms');?>:</label>

			<div class="row">
				<div class="col-xs-6">
					<select name="min_bedrooms" class="form-control">
						<option value="">-- <?php __('front_layout1_min');?> --</option>
						<?php
						foreach($property_bedrooms as $k => $v)
						{
							?><option value="<?php echo $k;?>"<?php echo isset($_GET['min_bedrooms']) && $_GET['min_bedrooms'] != '' ? ($_GET['min_bedrooms'] == $k ? ' selected="selected"' : null) : null;?>><?php echo $v;?></option><?php
						}
						?>
					</select>
				</div><!-- /.col-sm-6 -->

				<div class="col-xs-6">
					<select name="max_bedrooms" class="form-control">
						<option value="">-- <?php __('front_layout1_max');?> --</option>
						<?php
						foreach($property_bedrooms as $k => $v)
						{
							?><option value="<?php echo $k;?>"<?php echo isset($_GET['max_bedrooms']) && $_GET['max_bedrooms'] != '' ? ($_GET['max_bedrooms'] == $k ? ' selected="selected"' : null) : null;?>><?php echo $v;?></option><?php
						}
						?>
					</select>
				</div><!-- /.col-sm-6 -->
			</div><!-- /.row -->
		</div><!-- /.col-md-3 -->
		<div class="col-md-3">
			<label class="control-label"><?php __('front_layout1_bathrooms');?>:</label>

			<div class="row">
				<div class="col-xs-6">
					<select name="min_bathrooms" class="form-control">
						<option value="">-- <?php __('front_layout1_min');?> --</option>
						<?php
						foreach($property_bathrooms as $k => $v)
						{
							?><option value="<?php echo $k;?>"<?php echo isset($_GET['min_bathrooms']) && $_GET['min_bathrooms'] != '' ? ($_GET['min_bathrooms'] == $k ? ' selected="selected"' : null) : null;?>><?php echo $v;?></option><?php
						}
						?>
					</select>
				</div><!-- /.col-sm-6 -->

				<div class="col-xs-6">
					<select name="max_bathrooms" class="form-control">
						<option value="">-- <?php __('front_layout1_max');?> --</option>
						<?php
						foreach($property_bathrooms as $k => $v)
						{
							?><option value="<?php echo $k;?>"<?php echo isset($_GET['max_bathrooms']) && $_GET['max_bathrooms'] != '' ? ($_GET['max_bathrooms'] == $k ? ' selected="selected"' : null) : null;?>><?php echo $v;?></option><?php
						}
						?>
					</select>
				</div><!-- /.col-sm-6 -->
			</div><!-- /.row -->
		</div><!-- /.col-md-3 -->
		<div class="col-md-3">
			<label class="control-label"><?php __('front_layout1_floor_area');?>:</label>

			<div class="row">
				<div class="col-xs-6">
					<input type="text" name="min_floor_area" value="<?php echo isset($_GET['min_floor_area']) ? pjSanitize::html($_GET['min_floor_area']) : null;?>" class="form-control" placeholder="<?php __('front_layout1_min');?>">
				</div><!-- /.col-sm-6 -->

				<div class="col-xs-6">
					<input type="text" name="max_floor_area" value="<?php echo isset($_GET['max_floor_area']) ? pjSanitize::html($_GET['max_floor_area']) : null;?>" class="form-control" placeholder="<?php __('front_layout1_max');?>">
				</div><!-- /.col-sm-6 -->
			</div><!-- /.row -->
		</div><!-- /.col-md-3 -->
		<div class="col-md-3">
			<label class="control-label">&nbsp;</label>
			<br>

			<input type="submit" class="btn btn-default btn-block" value="<?php __('front_layout1_button_search');?>">
		</div><!-- /.col-md-3 -->
	</div>
</form>