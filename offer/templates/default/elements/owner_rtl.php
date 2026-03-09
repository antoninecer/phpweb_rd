<?php
$owner_name = !empty($tpl['arr']['owner_name']) ? $tpl['arr']['owner_name'] : (!empty($tpl['arr']['name']) ? $tpl['arr']['name'] : null);
if(!empty($owner_name))
{
    ?>
	<div class="row">
		<div class="col-sm-8">
			<p><?php echo pjSanitize::html($owner_name);?></p>
		</div><!-- /.col-md-3 -->
		<div class="col-sm-4">
			<strong><?php __('front_layout1_name');?>:</strong>
		</div><!-- /.col-md-3 -->
	</div><!-- /.row -->
	<?php
}
$owner_email = !empty($tpl['arr']['owner_email']) ? $tpl['arr']['owner_email'] : (!empty($tpl['arr']['email']) ? $tpl['arr']['email'] : null);
if(!empty($owner_email))
{ 
	?>
	<div class="row">
		<div class="col-sm-8">
			<p><?php echo !preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i', $owner_email) ? $owner_email : '<a href="mailto:'.$owner_email.'">'.$owner_email.'</a>'; ?></p>
		</div><!-- /.col-md-3 -->
		<div class="col-sm-4">
			<strong><?php __('front_layout1_email');?>:</strong>
		</div><!-- /.col-md-3 -->
	</div><!-- /.row -->
	<?php
}
$owner_phone = !empty($tpl['arr']['owner_phone']) ? $tpl['arr']['owner_phone'] : (!empty($tpl['arr']['phone']) ? $tpl['arr']['phone'] : null);
if(!empty($owner_phone))
{ 
	?>
	<div class="row">
		<div class="col-sm-8">
			<p><?php echo pjSanitize::html($owner_phone);?></p>
		</div><!-- /.col-md-3 -->
		<div class="col-sm-4">
			<strong><?php __('front_layout1_phone');?>:</strong>
		</div><!-- /.col-md-3 -->
	</div><!-- /.row -->
	<?php
}
$owner_fax = !empty($tpl['arr']['owner_fax']) ? $tpl['arr']['owner_fax'] : (!empty($tpl['arr']['fax']) ? $tpl['arr']['fax'] : null);
if(!empty($owner_fax))
{ 
	?>
	<div class="row">
		<div class="col-sm-8">
			<p><?php echo pjSanitize::html($owner_fax);?></p>
		</div><!-- /.col-md-3 -->
		<div class="col-sm-4">
			<strong><?php __('front_layout1_fax');?>:</strong>
		</div><!-- /.col-md-3 -->
	</div><!-- /.row -->
	<?php
}
?>