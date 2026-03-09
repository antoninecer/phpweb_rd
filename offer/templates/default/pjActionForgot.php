<?php
mt_srand();
$index = mt_rand(1, 9999);
?>
<div id="pjWrapperPropertyListing_<?php echo $index;?>" >
	<div class="container-fluid pjPplContainer">
		<br>
		<?php include_once dirname(__FILE__) . '/elements/header.php';?>
		<br>
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<form class="pjPplFormAcc" action="?controller=pjListings&amp;action=pjActionForgot" method="post" id="frmPLForgot" name="frmPLForgot">
					<input type="hidden" name="forgot" value="1" />
					<?php
					if (isset($_GET['iframe']))
					{
						?><input type="hidden" name="iframe" value="" /><?php
					}
					?>
					<h2 class="text-center pjPplFormAccTitle"><?php __('front_layout1_forgot_password');?></h2>
		
					<p class="text-center"><?php __('front_layout1_forgot_text');?></p>
		
					<br>
					<?php
					if(isset($_GET['err']))
					{ 
						$forgot_err = __('forgot_err', true);
						?>
						<div class="form-group">
							<div class="alert alert-danger" role="alert"><?php echo $forgot_err[$_GET['err']];?></div>
						</div>
						<?php
					} 
					if(isset($_GET['status']))
					{ 
						$forgot_statuses = __('forgot_statuses', true);
						?>
						<div class="form-group">
							<div class="alert alert-success" role="alert"><?php echo $forgot_statuses[$_GET['status']];?></div>
						</div>
						<?php
					} 
					?>	
		
					<div class="form-group">
						<input type="text" name="email" class="form-control required email" placeholder="<?php __('front_layout1_email');?>" data-err="<?php __('front_layout1_email_required');?>" data-email="<?php __('front_layout1_email_invalid');?>" value="<?php echo isset($_POST['email']) ? htmlspecialchars(stripslashes($_POST['email'])) : null;?>"/>
					</div>
		
					<div class="form-group">
						<button type="submit" class="btn btn-block btn-default"><?php __('front_layout1_send');?></button>
					</div>
		
					<p class="text-center"><a href="?controller=pjListings&amp;action=pjActionAccount"><?php __('front_layout1_login');?></a></p>
				</form>
			</div><!-- /.col-md-6 -->
	
			<div class="col-md-6 col-sm-6">
				
			</div><!-- /.col-md-6 -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid pjPplContainer -->
</div>
<?php include_once dirname(__FILE__) . '/elements/loadjs.php';?>