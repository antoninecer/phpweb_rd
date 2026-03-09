var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		var $frmCreateType = $("#frmCreateType"),
			$frmUpdateType = $("#frmUpdateType"),
			validate = ($.fn.validate !== undefined),
			datagrid = ($.fn.datagrid !== undefined);

		if ($frmCreateType.length > 0 && validate) {
			$frmCreateType.validate({
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				},
				onkeyup: false,
				errorClass: "err",
				wrapper: "em",
				ignore: "",
				invalidHandler: function (event, validator) {
					var localeId = $(validator.errorList[0].element, this).attr('lang');
					$(".pj-multilang-wrap").each(function( index ) {
						if($(this).attr('data-index') == localeId)
						{
							$(this).css('display','block');
						}else{
							$(this).css('display','none');
						}
					});
					$(".pj-form-langbar-item").each(function( index ) {
						if($(this).attr('data-index') == localeId)
						{
							$(this).addClass('pj-form-langbar-item-active');
						}else{
							$(this).removeClass('pj-form-langbar-item-active');
						}
					});
				}
			});
			if(myLabel.locale_array.length > 0)
			{
				var locale_array = myLabel.locale_array;
				for(var i = 0; i < locale_array.length; i++)
				{
					var element = $("#i18n_name_" + locale_array[i]),
						locale = element.attr('lang');
					element.rules('add', {
						remote: {
							url: "index.php?controller=pjAdminTypes&action=pjActionCheckType",
							type: 'post',
							data: {locale: locale}
						},
						messages: {
					    	required: myLabel.field_required,
					    	remote: myLabel.same_type
					    }
					});
				}
			}
		}
		if ($frmUpdateType.length > 0 && validate) {
			$frmUpdateType.validate({
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				},
				onkeyup: false,
				errorClass: "err",
				wrapper: "em",
				ignore: "",
				invalidHandler: function (event, validator) {
					var localeId = $(validator.errorList[0].element, this).attr('lang');
					$(".pj-multilang-wrap").each(function( index ) {
						if($(this).attr('data-index') == localeId)
						{
							$(this).css('display','block');
						}else{
							$(this).css('display','none');
						}
					});
					$(".pj-form-langbar-item").each(function( index ) {
						if($(this).attr('data-index') == localeId)
						{
							$(this).addClass('pj-form-langbar-item-active');
						}else{
							$(this).removeClass('pj-form-langbar-item-active');
						}
					});
				}
			});
			if(myLabel.locale_array.length > 0)
			{
				var locale_array = myLabel.locale_array;
				for(var i = 0; i < locale_array.length; i++)
				{
					var element = $("#i18n_name_" + locale_array[i]),
						locale = element.attr('lang'),
						id = $frmUpdateType.find("input[name='id']").val();
					element.rules('add', {
						remote: {
							url: "index.php?controller=pjAdminTypes&action=pjActionCheckType",
							type: 'post',
							data: {id: id, locale: locale}
						},
						messages: {
					    	required: myLabel.field_required,
					    	remote: myLabel.same_type
					    }
					});
				}
			}
		}
		
		if ($("#grid").length > 0 && datagrid) {
			var $grid = $("#grid").datagrid({
				buttons: [{type: "edit", url: "index.php?controller=pjAdminTypes&action=pjActionUpdate&id={:id}"},
				          {type: "delete", url: "index.php?controller=pjAdminTypes&action=pjActionDeleteType&id={:id}"}
				          ],
				columns: [{text: myLabel.type, type: "text", sortable: true, editable: true, width: 530},
				          {text: myLabel.status, type: "select", sortable: true, editable: true, options: [
				                                                                                     {label: myLabel.active, value: "T"}, 
				                                                                                     {label: myLabel.inactive, value: "F"}
				                                                                                     ], applyClass: "pj-status"}],
				dataUrl: "index.php?controller=pjAdminTypes&action=pjActionGetType",
				dataType: "json",
				fields: ['name', 'status'],
				paginator: {
					actions: [
					   {text: myLabel.delete_selected, url: "index.php?controller=pjAdminTypes&action=pjActionDeleteTypeBulk", render: true, confirmation: myLabel.delete_confirmation}
					],
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: "index.php?controller=pjAdminTypes&action=pjActionSaveType&id={:id}",
				select: {
					field: "id",
					name: "record[]"
				}
			});
		}
	});
})(jQuery_1_8_2);