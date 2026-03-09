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
				<form class="pjPplFormAcc" action="<?php echo PJ_INSTALL_URL;?>index.php?controller=pjAdmin&amp;action=pjActionLogin" method="post" target="_blank"id="frmPLLogin" name="frmPLLogin">
					<input type="hidden" name="login_user" value="1" />
					<?php
					if (isset($_GET['iframe']))
					{
						?><input type="hidden" name="iframe" value="" /><?php
					}
					?>
					<h2 class="text-center pjPplFormAccTitle"><?php __('front_layout1_login_to_account');?></h2>
		
					<p class="text-center"><?php __('front_layout1_login_text');?></p>
		
					<br>
		
					<div class="form-group">
						<input type="text" name="login_email" class="form-control required email" placeholder="<?php __('front_layout1_email');?>" data-err="<?php __('front_layout1_email_required');?>" data-email="<?php __('front_layout1_email_invalid');?>"/>
					</div>
		
					<div class="form-group">
						<input type="password" name="login_password" class="form-control required" placeholder="<?php __('front_layout1_password');?>" data-err="<?php __('front_layout1_password_required');?>"/>
					</div>
					
					<div class="form-group">
						<button type="submit" class="btn btn-block btn-default"><?php __('front_layout1_login');?></button>
					</div>
		
					<p class="text-center"><a href="?controller=pjListings&amp;action=pjActionForgot"><?php __('front_layout1_forgot_password');?></a></p>
				</form>
			</div><!-- /.col-md-6 -->
			<?php
			if($tpl['option_arr']['o_allow_add_property'] == 'Yes')
			{ 
				?>
				<div class="col-md-6 col-sm-6">
					<form class="pjPplFormAcc" action="?controller=pjListings&amp;action=pjActionAccount" method="post" id="frmPLRegister" name="frmPLRegister">
						<input type="hidden" name="register" value="1" />
						
						<h2 class="text-center pjPplFormAccTitle"><?php __('front_layout1_create_account');?></h2>
			
						<p class="text-center"><?php __('front_layout1_account_text');?></p>
						<br>
						<?php
						if(isset($tpl['err']))
						{ 
							$register_err = __('register_err', true);
							?>
							<div class="form-group">
								<div class="alert alert-danger" role="alert"><?php echo $register_err[$tpl['err']];?></div>
							</div>
							<?php
						}
						if(isset($_GET['status']))
						{ 
							$register_statuses = __('register_statuses', true);
							?>
							<div class="form-group">
								<div class="alert alert-success" role="alert"><?php echo $register_statuses[$_GET['status']];?></div>
							</div>
							<?php
						} 
						?>
						<div class="form-group">
							<input type="text" name="name" class="form-control required" placeholder="<?php __('front_layout1_name');?>" data-err="<?php __('front_layout1_name_required');?>" value="<?php echo isset($_POST['name']) ? htmlspecialchars(stripslashes($_POST['name'])) : null;?>"/>
						</div>
			
						<div class="form-group">
							<input type="text" name="email" class="form-control required email" placeholder="<?php __('front_layout1_email');?>" data-folder="<?php echo PJ_INSTALL_FOLDER;?>" data-exist="<?php __('front_email_exists');?>" data-err="<?php __('front_layout1_email_required');?>" data-email="<?php __('front_layout1_email_invalid');?>" value="<?php echo isset($_POST['email']) ? htmlspecialchars(stripslashes($_POST['email'])) : null;?>"/>
						</div>
			
						<div class="form-group">
							<input type="password" name="password" class="form-control required" placeholder="<?php __('front_layout1_password');?>" data-err="<?php __('front_layout1_password_required');?>"/>
						</div>
			
						<div class="form-group">
							<input type="password" name="reenter_password" class="form-control required" placeholder="<?php __('front_layout1_reenter_password');?>" data-err="<?php __('front_layout1_reenter_password_required');?>" data-match="<?php __('front_layout1_password_match');?>"/>
						</div>
						<div class="form-group">
							<input type="text" name="phone" class="form-control" placeholder="<?php __('front_layout1_phone');?>" value="<?php echo isset($_POST['phone']) ? htmlspecialchars(stripslashes($_POST['phone'])) : null;?>"/>
						</div>
			
						<div class="form-group">
							<input type="text" name="fax" class="form-control" placeholder="<?php __('front_layout1_fax');?>" value="<?php echo isset($_POST['fax']) ? htmlspecialchars(stripslashes($_POST['fax'])) : null;?>"/>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<input type="text" id="pjPlCaptchaField" name="captcha" class="form-control ppCaptchaField required" placeholder="<?php __('front_layout1_captcha');?>" maxlength="6" autocomplete="off" data-folder="<?php echo PJ_INSTALL_FOLDER;?>" data-err="<?php __('front_layout1_captcha_required');?>" data-captcha="<?php __('front_layout1_captcha_incorrect');?>"/>
								</div>
								<div class="col-md-6 col-sm-6">
									<img id="pjPlCaptchaImage" src="<?php echo PJ_INSTALL_FOLDER; ?>index.php?controller=pjFront&amp;action=pjActionCaptcha&amp;rand=<?php echo rand(1, 999999); ?>" alt="Captcha" style="vertical-align:top;cursor: pointer;"/>
								</div>
							</div>
						</div><!-- /.form-group -->
						<div class="form-group">
							<button type="submit" class="btn btn-block btn-default"><?php __('front_layout1_send');?></button>
						</div><!-- /.form-group -->
					</form>
				</div><!-- /.col-md-6 -->
				<?php
			} 
			?>
		</div><!-- /.row -->
	</div><!-- /.container-fluid pjPplContainer -->
</div>
<?php include_once dirname(__FILE__) . '/elements/loadjs.php';?>