var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var dialog = ($.fn.dialog !== undefined),
			$dialogDeletePeriod = $("#dialogDeletePeriod"),
			$frmUpdateOptions = $("#frmUpdateOptions"),
			$frmUpdatePreview = $("#frmUpdatePreview"),
			validate = ($.fn.validate !== undefined),
			tipsy = ($.fn.tipsy !== undefined),
			tabs = ($.fn.tabs !== undefined),
			$tabs = $("#tabs"),
			$seo_tabs = $("#seo_tabs"),
			tOpt = {
				select: function (event, ui) {
					$(":input[name='tab_id']").val(ui.panel.id);
				}
			},
			seo_tOpt = {
				select: function (event, ui) {
					$(":input[name='seo_tab_id']").val(ui.panel.id);
				}
			};
		if (tipsy) {
			$(".center-langbar-tip").tipsy({
				offset: 1,
				opacity: 1,
				html: true,
				className: "tipsy-listing-center"
			});
			$(".listing-tip").tipsy({
				offset: 1,
				opacity: 1,
				html: true,
				gravity: "nw",
				className: "tipsy-listing"
			});
		}
		if ($tabs.length > 0 && tabs) {
			$tabs.tabs(tOpt);
		}
		if ($seo_tabs.length > 0 && tabs) {
			$seo_tabs.tabs(seo_tOpt);
		}
		$(".field-int").spinner({
			min: 0
		});
		
		if ($frmUpdateOptions.length > 0 && validate) {
			$.validator.addMethod('positiveNumber',
				function (value) 
				{ 
		        	return Number(value) > 0;
				}
			);
			$frmUpdateOptions.validate({
				messages:{
					"value-int-o_items_per_page":{
						required: myLabel.field_required,
						digits: myLabel.digits_only,
						positiveNumber: myLabel.positive_number
					},
					"value-int-o_featured_items_per_page":{
						required: myLabel.field_required,
						digits: myLabel.digits_only,
						positiveNumber: myLabel.positive_number
					}
				},
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				},
				onkeyup: false,
				errorClass: "err",
				wrapper: "em",
				ignore: ""
			});
		}
		if ($frmUpdatePreview.length > 0 && validate) {
			
			$.validator.addMethod('positiveNumber',
				function (value) 
				{ 
		        	return Number(value) > 0;
				}
			);
			$frmUpdatePreview.validate({
				messages:{
					"value-int-o_items_per_page":{
						required: myLabel.field_required,
						digits: myLabel.digits_only,
						positiveNumber: myLabel.positive_number
					},
					"value-int-o_featured_items_per_page":{
						required: myLabel.field_required,
						digits: myLabel.digits_only,
						positiveNumber: myLabel.positive_number
					}
				},
				errorPlacement: function (error, element) {
					if(element.attr('name') == 'value-int-o_featured_items_per_page')
					{
						error.insertAfter(element.parent().parent());
					}else{
						error.insertAfter(element.parent());
					}
				},
				onkeyup: false,
				errorClass: "err",
				wrapper: "em"
			});
		}
		$("#content").on("focusin", ".textarea_install", function (e) {
			$(this).select();
		}).on("change", "select[name='value-enum-o_send_email']", function (e) {
			switch ($("option:selected", this).val()) {
			case 'mail|smtp::mail':
				$(".boxSmtp").hide();
				break;
			case 'mail|smtp::smtp':
				$(".boxSmtp").show();
				break;
			}
		}).on("change", "select[name='value-enum-o_allow_paypal']", function (e) {
			switch ($("option:selected", this).val()) {
			case 'Yes|No::No':
				$(".boxPaypal").hide();
				break;
			case 'Yes|No::Yes':
				$(".boxPaypal").show();
				break;
			}
		}).on("change", "select[name='value-enum-o_allow_authorize']", function (e) {
			switch ($("option:selected", this).val()) {
			case 'Yes|No::No':
				$(".boxAuthorize").hide();
				break;
			case 'Yes|No::Yes':
				$(".boxAuthorize").show();
				break;
			}
		}).on("change", "select[name='value-enum-o_allow_bank']", function (e) {
			switch ($("option:selected", this).val()) {
			case 'Yes|No::No':
				$(".boxBankAccount").hide();
				break;
			case 'Yes|No::Yes':
				$(".boxBankAccount").show();
				break;
			}
		}).on("change", "select[name='value-enum-o_email_request']", function (e) {
			switch ($("option:selected", this).val()) {
			case '0|1::0':
				$(".boxOwnerRequest").hide();
				break;
			case '0|1::1':
				$(".boxOwnerRequest").show();
				break;
			}
		}).on("change", "select[name='value-enum-o_email_registration']", function (e) {
			switch ($("option:selected", this).val()) {
			case '0|1::0':
				$(".boxOwnerRegistration").hide();
				break;
			case '0|1::1':
				$(".boxOwnerRegistration").show();
				break;
			}
		}).on("change", "select[name='value-enum-o_email_submission']", function (e) {
			switch ($("option:selected", this).val()) {
			case '0|1::0':
				$(".boxOwnerSubmission").hide();
				break;
			case '0|1::1':
				$(".boxOwnerSubmission").show();
				break;
			}
		}).on("change", "select[name='value-enum-o_admin_email_request']", function (e) {
			switch ($("option:selected", this).val()) {
			case '0|1::0':
				$(".boxAdminRequest").hide();
				break;
			case '0|1::1':
				$(".boxAdminRequest").show();
				break;
			}
		}).on("change", "select[name='value-enum-o_admin_email_registration']", function (e) {
			switch ($("option:selected", this).val()) {
			case '0|1::0':
				$(".boxAdminRegistration").hide();
				break;
			case '0|1::1':
				$(".boxAdminRegistration").show();
				break;
			}
		}).on("change", "select[name='value-enum-o_admin_email_submission']", function (e) {
			switch ($("option:selected", this).val()) {
			case '0|1::0':
				$(".boxAdminSubmission").hide();
				break;
			case '0|1::1':
				$(".boxAdminSubmission").show();
				break;
			}
		}).on("change", "select[name='value-enum-o_sms_request']", function (e) {
			switch ($("option:selected", this).val()) {
			case '0|1::0':
				$(".boxOwnerSMSRequest").hide();
				break;
			case '0|1::1':
				$(".boxOwnerSMSRequest").show();
				break;
			}
		}).on("change", "select[name='value-enum-o_sms_registration']", function (e) {
			switch ($("option:selected", this).val()) {
			case '0|1::0':
				$(".boxOwnerSMSRegistration").hide();
				break;
			case '0|1::1':
				$(".boxOwnerSMSRegistration").show();
				break;
			}
		}).on("change", "select[name='value-enum-o_sms_submission']", function (e) {
			switch ($("option:selected", this).val()) {
			case '0|1::0':
				$(".boxOwnerSMSSubmission").hide();
				break;
			case '0|1::1':
				$(".boxOwnerSMSSubmission").show();
				break;
			}
		}).on("change", "select[name='value-enum-o_admin_sms_registration']", function (e) {
			switch ($("option:selected", this).val()) {
			case '0|1::0':
				$(".boxAdminSMSRegistration").hide();
				break;
			case '0|1::1':
				$(".boxAdminSMSRegistration").show();
				break;
			}
		}).on("change", "select[name='value-enum-o_admin_sms_submission']", function (e) {
			switch ($("option:selected", this).val()) {
			case '0|1::0':
				$(".boxAdminSMSSubmission").hide();
				break;
			case '0|1::1':
				$(".boxAdminSMSSubmission").show();
				break;
			}
		}).on("click", ".btnAddPeriod", function () {
			var $c = $("#tblPeriodClone tbody").clone(),
			r = $c.html().replace(/\{INDEX\}/g, 'new_' + Math.ceil(Math.random() * 99999));
			$(this).closest("form").find("table").find("tbody").append(r);
		}).on("click", ".btnDeletePeriod", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			if ($dialogDeletePeriod.length > 0 && dialog) {
				$dialogDeletePeriod.data("link", $(this)).dialog("open");
			}
			return false;
		}).on("click", ".btnRemovePeriod", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $tr = $(this).closest("tr");
			$tr.css("backgroundColor", "#FFB4B4").fadeOut("slow", function () {
				$tr.remove();
			});			
			return false;
		}).on("change", "#plTheme", function (e) {
			var $this = $(this);
			updatePreview('o_layout');
		}).on("change keyup paste spinstop", "#plItemPerPage", function (e) {
			if($(this).valid())
			{
				var $this = $(this);
				delay(function(){
					updatePreview('o_items_per_page');
			    }, 1000 );
			}
		}).on("click", ".pj-use-theme", function (e) {
			var theme = $(this).attr('data-theme');
			$('.pj-loader').css('display', 'block');
			$.ajax({
				type: "GET",
				async: false,
				url: 'index.php?controller=pjAdminOptions&action=pjActionUpdateTheme&theme=' + theme,
				success: function (data) {
					$('.theme-holder').html(data);
					$('.pj-loader').css('display', 'none');
				}
			});
		}).on("change", "input[name='bootstrap_site']", function (e) {
			if($(this).is(':checked'))
			{
				$('#install_code').hide();
				$('#install_code_bootstrap').show();
			}else{
				$('#install_code').show();
				$('#install_code_bootstrap').hide();
			}
		});
		var delay = (function(){
			var timer = 0;
			return function(callback, ms){
				clearTimeout (timer);
				timer = setTimeout(callback, ms);
			};
		})();
		function updatePreview(key)
		{
			$frmUpdatePreview.find("input[name='key']").val(key);
			$.post("index.php?controller=pjAdminOptions&action=pjActionUpdatePreview", $frmUpdatePreview.serialize()).done(function (data) {
				if (data.code !== undefined && data.code == 200) {
					console.log(data.code);
				}
			});
		}
		if ($dialogDeletePeriod.length > 0 && dialog) {
			var buttons = {};
			buttons[myLabel.btn_delete] = function () {
				var $this = $(this),
					$link = $this.data("link"),
					$tr = $link.closest("tr"),
					id = $link.data("id");
				
				$.post("index.php?controller=pjAdminOptions&action=pjActionDeletePeriod", {
					"id": id
				}).done(function (data) {
					if (data.code === undefined) {
						return;
					}
					switch (data.code) {
						case 200:
							$tr.css("backgroundColor", "#FFB4B4").fadeOut("slow", function () {
								$tr.remove();
								$this.dialog("close");
							});
							break;
					}
				});
			};
			buttons[myLabel.btn_cancel] = function () {
				$(this).dialog("close");
			};
			$dialogDeletePeriod.dialog({
				modal: true,
				autoOpen: false,
				resizable: false,
				draggable: false,
				buttons: buttons,
				width: 350
			});
		}
	});
})(jQuery_1_8_2);