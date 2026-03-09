<?php
if(!empty($tpl['arr']['country_title']))
{
    ?>
	<div class="row">
		<div class="col-sm-8">
			<p><?php echo pjSanitize::html($tpl['arr']['country_title']);?></p>
		</div><!-- /.col-md-3 -->
		<div class="col-sm-4">
			<strong><?php __('front_layout1_country');?>:</strong>
		</div><!-- /.col-md-3 -->
	</div><!-- /.row -->
	<?php
}
if(!empty($tpl['arr']['address_state']))
{
	?>
	<div class="row">
		<div class="col-sm-8">
			<p><?php echo pjSanitize::html($tpl['arr']['address_state']);?></p>
		</div><!-- /.col-md-3 -->
		<div class="col-sm-4">
			<strong><?php __('front_layout1_state');?>:</strong>
		</div><!-- /.col-md-3 -->

	</div><!-- /.row -->
	<?php
}
if(!empty($tpl['arr']['address_city']))
{
	?>
	<div class="row">
		
		<div class="col-sm-8">
			<p><?php echo pjSanitize::html($tpl['arr']['address_city']);?></p>
		</div><!-- /.col-md-3 -->
		<div class="col-sm-4">
			<strong><?php __('front_layout1_city');?>:</strong>
		</div><!-- /.col-md-3 -->
		
	</div><!-- /.row -->
	<?php
}
if(!empty($tpl['arr']['address_1']))
{
	?>
	<div class="row">
		<div class="col-sm-8">
			<p><?php echo pjSanitize::html($tpl['arr']['address_1']);?></p>
		</div><!-- /.col-md-3 -->
		<div class="col-sm-4">
			<strong><?php __('front_layout1_address_1');?>:</strong>
		</div><!-- /.col-md-3 -->
	</div><!-- /.row -->
	<?php
}
if(!empty($tpl['arr']['address_2']))
{
	?>
	<div class="row">
		<div class="col-sm-8">
			<p><?php echo pjSanitize::html($tpl['arr']['address_2']);?></p>
		</div><!-- /.col-md-3 -->
		<div class="col-sm-4">
			<strong><?php __('front_layout1_address_2');?>:</strong>
		</div><!-- /.col-md-3 -->
		
	</div><!-- /.row -->
	<?php
}
if(!empty($tpl['arr']['address_zip']))
{
	?>
	<div class="row">
		<div class="col-sm-8">
			<p><?php echo pjSanitize::html($tpl['arr']['address_zip']);?></p>
		</div><!-- /.col-md-3 -->
		<div class="col-sm-4">
			<strong><?php __('front_layout1_zip');?>:</strong>
		</div><!-- /.col-md-3 -->
	</div><!-- /.row -->
	<?php
}
?>