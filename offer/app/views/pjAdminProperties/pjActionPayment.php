<?php
if (isset($tpl['status']))
{
	$status = __('status', true);
	switch ($tpl['status'])
	{
		case 2:
			pjUtil::printNotice(NULL, $status[2]);
			break;
	}
} else {
	if (isset($_GET['err']))
	{
		$titles = __('error_titles', true);
		$bodies = __('error_bodies', true);
		pjUtil::printNotice(__('lblFreePlan', true), __('lblFreePlanUsed', true));
	}
	?>
	<div class="ui-tabs ui-widget ui-widget-content ui-corner-all b10">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminProperties&amp;action=pjActionPayment&amp;id=<?php echo $_GET['id']; ?>"><?php __('lblExtendExpireDate'); ?></a></li>
		</ul>
	</div>
	<?php
	pjUtil::printNotice(__('infoExtendTitle', true), __('infoExtendDesc', true));
	?>
	<div class="form pj-form b10">
		<p>
			<label class="title"><?php __('lblProperty'); ?>:</label>
			<span class="left"><?php echo stripslashes($tpl['arr']['property_title']); ?> / <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminProperties&amp;action=pjActionUpdate&amp;id=<?php echo $tpl['arr']['id']; ?>"><?php echo $tpl['arr']['id']; ?></a></span>
		</p>
		<p>
			<label class="title"><?php __('lblExpire'); ?>:</label>
			<?php
			if($tpl['arr']['status'] == 'F')
			{ 
				?><span class="left"><?php echo strtolower(__('lblNotActive', true)); ?></span><?php
			}else{
				?><span class="left"><?php echo pjUtil::formatDate($tpl['arr']['expire'], 'Y-m-d', $tpl['option_arr']['o_date_format']); ?></span><?php
			} 
			?>
		</p>
	</div>
	<?php
	$dm = new pjDependencyManager(PJ_INSTALL_PATH, PJ_THIRD_PARTY_PATH);
	$dm->load(PJ_CONFIG_PATH . 'dependencies.php')->resolve();
	?>
	<link href="<?php echo PJ_INSTALL_URL;?>core/framework/libs/pj/css/pj.bootstrap.min.css" type="text/css" rel="stylesheet" />
	<script src="<?php echo PJ_INSTALL_URL . $dm->getPath('pj_jquery'); ?>pjQuery.min.js"></script>
	<script src="<?php echo PJ_INSTALL_URL . $dm->getPath('pj_bootstrap'); ?>pjQuery.bootstrap.min.js"></script>
	<table class="pj-table" cellpadding="0" cellspacing="0" style="width: 100%">
		<thead>
			<tr>
				<th><?php __('payment_period'); ?></th>
				<th><?php __('payment_price'); ?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php
		$pjPaypal = pjObject::getPlugin('pjPaypal') !== NULL;
		foreach ($tpl['period_arr'] as $period)
		{
			if ((int) $period['days'] > 0)
			{
				if ((float) $period['price'] > 0)
				{
					?>
					<tr>
						<td><?php echo $period['days']; ?> <?php __('lblDays'); ?></td>
						<td><?php echo $period['price']; ?> <?php echo $tpl['option_arr']['o_currency']; ?></td>
						<td>
						<?php
						if ($pjPaypal)
						{
						    ?>
						    <button type="button" class="btn pj-button btnPaymentRenew" data-property_id="<?php echo $_GET['id'];?>" data-period_id="<?php echo $period['id'];?>"><?php __('payment_renew_paypal');?></button>
						    <?php 
						}
						?>
						</td>
					</tr>
					<?php
				} else {
					?>
					<tr>
						<td><?php echo $period['days']; ?> <?php __('lblDays'); ?></td>
						<td><?php __('listing_payment_free'); ?></td>
						<td>
							<form id="frmFreeExtend" action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminProperties&amp;action=pjActionExtend" method="post">
								<input type="hidden" name="extend" value="1" />
								<input type="hidden" name="id" value="<?php echo $tpl['arr']['id']; ?>" />
								<input type="hidden" name="period_id" value="<?php echo $period['id']; ?>" />
								<input type="submit" value="<?php __('listing_payment_renew_free'); ?>" class="pj-button" />
							</form>
						</td>
					</tr>
					<?php
				}
			}
		}
		?>
		</tbody>
	</table>
	<div id="dialogFreePlan" title="<?php __('lblFreePlan'); ?>" style="display:none;">
		<?php __('lblFreePlanUsed'); ?>
	</div>
	<div id="pjWrapperPropertyListing">
		<div class="paypalPaymentForm"></div>
	</div>
	<?php
}
?>