var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		var $frmCreateFeature = $("#frmCreateFeature"),
			$frmUpdateFeature = $("#frmUpdateFeature"),
			validate = ($.fn.validate !== undefined),
			datagrid = ($.fn.datagrid !== undefined);

		if ($frmCreateFeature.length > 0 && validate) {
			$frmCreateFeature.validate({
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
						messages: {
					    	required: myLabel.field_required
					    }
					});
				}
			}
		}
		if ($frmUpdateFeature.length > 0 && validate) {
			$frmUpdateFeature.validate({
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
						id = $frmUpdateFeature.find("input[name='id']").val();
					element.rules('add', {
						messages: {
					    	required: myLabel.field_required
					    }
					});
				}
			}
		}
		
		if ($("#grid").length > 0 && datagrid) {
			var $grid = $("#grid").datagrid({
				buttons: [{type: "edit", url: "index.php?controller=pjAdminFeatures&action=pjActionUpdate&id={:id}"},
				          {type: "delete", url: "index.php?controller=pjAdminFeatures&action=pjActionDeleteFeature&id={:id}"}
				          ],
				columns: [{text: myLabel.feature_name, type: "text", sortable: true, editable: true, width: 350, editableWidth: 330},
				          {text: myLabel.feature_category, type: "text", sortable: true, editable: false, width: 180},
				          {text: myLabel.status, type: "select", sortable: true, editable: true, options: [
				                                                                                     {label: myLabel.active, value: "T"}, 
				                                                                                     {label: myLabel.inactive, value: "F"}
				                                                                                     ], applyClass: "pj-status"}],
				dataUrl: "index.php?controller=pjAdminFeatures&action=pjActionGetFeature",
				dataFeature: "json",
				fields: ['name', 'category', 'status'],
				paginator: {
					actions: [
					   {text: myLabel.delete_selected, url: "index.php?controller=pjAdminFeatures&action=pjActionDeleteFeatureBulk", render: true, confirmation: myLabel.delete_confirmation}
					],
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: "index.php?controller=pjAdminFeatures&action=pjActionSaveFeature&id={:id}",
				select: {
					field: "id",
					name: "record[]"
				}
			});
		}
	});
})(jQuery_1_8_2);