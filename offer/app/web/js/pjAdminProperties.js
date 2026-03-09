var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		var datagrid = ($.fn.datagrid !== undefined),
			datepicker = ($.fn.datepicker !== undefined),
			gallery = ($.fn.gallery !== undefined),
			chosen = ($.fn.chosen !== undefined),
			dialog = ($.fn.dialog !== undefined),
			validate = ($.fn.validate !== undefined),
			tipsy = ($.fn.tipsy !== undefined),
			$frmCreateProperty = $("#frmCreateProperty"),
			$frmUpdateProperty = $("#frmUpdateProperty"),
			$frmFreeExtend = $('#frmFreeExtend'),
			$frmXMLFeed = $("#frmXMLFeed"),
			$dialogDeletePrice = $("#dialogDeletePrice"),
			$dialogDeleteFile = $("#dialogDeleteFile"),
			$dialogFreePlan = $("#dialogFreePlan"),
			$gallery = $("#gallery"),
			$tabs = $("#tabs"),
			tOpt = {
				activate: function (event, ui) {
					$(":input[name='tab_id']").val($(ui.newPanel).prop('id'));
					if($(ui.newPanel).prop('id') == 'tabs-8')
					{
						if($('#lat').val() != '' && $('#lng').val() != '')
						{
							initGMap(parseFloat($('#lat').val()), parseFloat($('#lng').val()));
						}
					}
				}
			};
		
		if ($tabs.length > 0 && tabs) {
			$tabs.tabs(tOpt);
		}
		$(".field-int").spinner({
			min: 0
		});
		if ($frmFreeExtend.length > 0 && validate) {
			$frmFreeExtend.validate({
				onkeyup: false,
				ignore: "",
				submitHandler: function(form){
					var id = $(form).find('input[name="id"]').val();
					$.post("index.php?controller=pjAdminProperties&action=pjActionCheckFreePlan", {
						id: id
					}).done(function (data) {
						if(data.code == '101')
						{
							$dialogFreePlan.dialog('open');
						}else if(data.code == '200'){
							form.submit();
						}
					});
					return false;
				}
			});
		}
		if ($frmXMLFeed.length > 0 && validate) {
			$frmXMLFeed.validate({
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				},
				errorClass: "err",
				wrapper: "em",
				onkeyup: false,
				ignore: ""
			});
		}
		
		if ($frmCreateProperty.length > 0 && validate) {
			$frmCreateProperty.validate({
				rules: {
					"ref_id": {
						required: true,
						remote: "index.php?controller=pjAdminProperties&action=pjActionCheckRefId"
					},
					"expire": {
						required: function(e){
							if($('#status').val() == 'E'){
								return true;
							}else{
								return false;
							}
						}
		            }
				},
				messages: {
					"ref_id": {
						required: myLabel.field_required
					},
					"type_id": {
						required: myLabel.field_required
					},
					"status": {
						required: myLabel.field_required
					},
					"expire": {
						required: myLabel.field_required
					}
				},
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				},
				errorClass: "err",
				wrapper: "em",
				onkeyup: false,
				ignore: ""
			});
		}
		
		if (chosen) {
			$("#user_id").chosen();
		}
		
		if($('.frm-filter-advanced').length > 0)
		{
			$("#address_country").chosen();
			$("#owner_id").chosen();
		}
		if ($dialogFreePlan.length > 0 && dialog) {
			$dialogFreePlan.dialog({
				modal: true,
				autoOpen: false,
				resizable: false,
				draggable: false,
				buttons: {
					"OK": function () {
						$(this).dialog("close");
					}
				}
			});
		}
		if ($dialogDeletePrice.length > 0 && dialog) {
			$dialogDeletePrice.dialog({
				modal: true,
				autoOpen: false,
				resizable: false,
				draggable: false,
				buttons: {
					"Delete": function () {
						var $this = $(this),
							$link = $this.data("link"),
							$tr = $link.closest("tr");
						$.post("index.php?controller=pjAdminProperties&action=pjActionDeletePrice", {
							id: $link.data("id")
						}).done(function () {
							$tr.css("backgroundColor", "#FFB4B4").fadeOut("slow", function () {
								$tr.remove();
								$this.dialog("close");
							});
						});
					},
					"Cancel": function () {
						$(this).dialog("close");
					}
				}
			});
		}
		
		if ($dialogDeleteFile.length > 0 && dialog) 
		{
			$dialogDeleteFile.dialog({
				modal: true,
				autoOpen: false,
				resizable: false,
				draggable: false,
				width: 400,
				buttons: (function () {
					var buttons = {};
					buttons[plApp.locale.button.delete] = function () {
						$.ajax({
							type: "GET",
							dataType: "json",
							url: $dialogDeleteFile.data('href'),
							success: function (res) {
								if(res.code == 200){
									$('#file_container').remove();
									$dialogDeleteFile.dialog('close');
								}
							}
						});
					};
					buttons[plApp.locale.button.cancel] = function () {
						$dialogDeleteFile.dialog("close");
					};
					
					return buttons;
				})()
			});
		}
		
		function initGMap(lat, lng)
		{
			var latlng = new google.maps.LatLng(lat, lng);
			var mapOptions = {
					  center: latlng,
					  zoom: 12,
					  mapTypeId: google.maps.MapTypeId.ROADMAP
					};
			var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
			var marker = new google.maps.Marker({
								draggable: true,
								position: latlng,
								map: map
							});
			google.maps.event.addListener(marker, 'dragend', function (event) {
			    $('#lat').val(this.getPosition().lat());
			    $('#lng').val(this.getPosition().lng());
			});
		}
		
		$("#content").on("click", ".btnDeletePrice", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			if ($dialogDeletePrice.length > 0 && dialog) {
				$dialogDeletePrice.data('link', $(this)).dialog("open");
			}
			return false;
		}).on("click", ".btnRemovePrice", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $tr = $(this).closest("tr");
			$tr.css("backgroundColor", "#FFB4B4").fadeOut("slow", function () {
				$tr.remove();
			});
			return false;
		}).on("click", "input[name='o_allow_paypal']", function (e) {
			if ($(this).is(":checked")) {
				$(".PayPal").show();
				$(".PayPal input").addClass('email required');
			} else {
				$(".PayPal").hide();
				$(".PayPal input").removeClass('email required');
			}
		}).on("click", "input[name='o_allow_authorize']", function (e) {
			if ($(this).is(":checked")) {
				$(".AuthorizeNet").show();
				$(".AuthorizeNet input").addClass('required');
			} else {
				$(".AuthorizeNet").hide();
				$(".AuthorizeNet input").removeClass('required');
			}
		}).on("click", "input[name='o_allow_bank']", function (e) {
			if ($(this).is(":checked")) {
				$(".BankAccount").show();
				$(".BankAccount textarea").addClass('required');
			} else {
				$(".BankAccount").hide();
				$(".BankAccount textarea").removeClass('required');
			}
		}).on("click", "#btnAddPrice", function (e) {
			var $tr,
				$tbody = $("#tblPrices tbody"),
				h = $tbody.find("tr:last").find("td:first").html(),
				i = (h === null) ? 0 : parseInt(h, 10);
			i = !isNaN(i) ? i : 0;
			$tr = $("#tblPricesClone").find("tbody").clone();
			$tbody.find(".notFound").remove();
			$tbody.append($tr.html().replace(/\{INDEX\}/g, i + 1));
		}).on("focusin", ".datepick", function (e) {
			var minDate, maxDate,
				$this = $(this),
				custom = {},
				o = {
					firstDay: $this.attr("rel"),
					dateFormat: $this.attr("rev")
			};
			switch ($this.attr("name")) {
			case "date_from[]":
				maxDate = $this.closest("tr").find(".datepick[name='date_to[]']").datepicker({
					firstDay: $this.attr("rel"),
					dateFormat: $this.attr("rev")
				}).datepicker("getDate");
				$this.closest("tr").find(".datepick[name='date_to[]']").datepicker("destroy").removeAttr("id");
				if (maxDate !== null) {
					custom.maxDate = maxDate;
				}
				break;
			case "date_to[]":
				minDate = $this.closest("tr").find(".datepick[name='date_from[]']").datepicker({
					firstDay: $this.attr("rel"),
					dateFormat: $this.attr("rev")
				}).datepicker("getDate");
				$this.closest("tr").find(".datepick[name='date_from[]']").datepicker("destroy").removeAttr("id");
				if (minDate !== null) {
					custom.minDate = minDate;
				}
				break;
			}
			$this.not('.hasDatepicker').datepicker($.extend(o, custom));
		}).on("click", ".pj-checkbox", function () {
			var $this = $(this);
			if ($this.find("input[type='checkbox']").is(":checked")) {
				$this.addClass("pj-checkbox-checked");
			} else {
				$this.removeClass("pj-checkbox-checked");
			}
		}).on("click", ".listing-tip", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			return false;
		}).on("click", ".btnPaymentRenew", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $property_id = $(this).attr('data-property_id'),
				$period_id = $(this).attr('data-period_id');
			$('.paypalPaymentForm').html('');
			$.get("index.php?controller=pjAdminProperties&action=pjActionGetPaymentForm&property_id=" +$property_id + "&period_id=" + $period_id).done(function (data) {
				$('.paypalPaymentForm').html(data);
				$('.modal-dialog').css("z-index", "9999");
			});
		});
		
		if ($frmUpdateProperty.length > 0 && validate) {
			
			$frmUpdateProperty.validate({
				rules: {
					"ref_id": {
						required: true,
						remote: "index.php?controller=pjAdminProperties&action=pjActionCheckRefId&id=" + $frmUpdateProperty.find("input[name='id']").val()
					},
					"expire": {
						required: function(e){
							if($('#status').val() == 'E'){
								return true;
							}else{
								return false;
							}
						}
		            },
		            "address_1":{
		            	required: function (e){
		            		if($('input[name=show_googlemap]:checked', '#frmUpdateProperty').val() == 'T')
		            		{
		            			return true;
		            		}else{
		            			return false;
		            		}
		            	}
		            }
				},
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				},
				errorClass: "err",
				wrapper: "em",
				onkeyup: false,
				ignore: "",
				invalidHandler: function (event, validator) {
				    if (validator.numberOfInvalids()) {
				    	var index = $(validator.errorList[0].element, this).closest("div[id^='tabs-']").index();
				    	if ($tabs.length > 0 && tabs && index !== -1) {
				    		$tabs.tabs(tOpt).tabs("option", "active", index-1);
				    	}
				    }
				    $(".pj-multilang-wrap").each(function( index ) {
						if($(this).attr('data-index') == myLabel.localeId)
						{
							$(this).css('display','block');
						}else{
							$(this).css('display','none');
						}
					});
					$(".pj-form-langbar-item").each(function( index ) {
						if($(this).attr('data-index') == myLabel.localeId)
						{
							$(this).addClass('pj-form-langbar-item-active');
						}else{
							$(this).removeClass('pj-form-langbar-item-active');
						}
					});
				}
				
			});

			if ($frmUpdateProperty.length > 0) 
			{
				tinymce.init({
				    selector: "textarea.mceEditor",
				    theme: "modern",
				    width: 570,
				    plugins: [
				         "advlist autolink link lists charmap",
				         "save directionality paste textcolor code"
				   ],
				   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons"
				 }); 
			}
	
			$("a.fancybox").fancybox();
			
			$(".field-int").spinner({
				min: 0
			});
			$('.pj-button-save').click(function() {
				tinyMCE.triggerSave();
			});
			if (chosen) {
				$("#owner_id").chosen();
				$("#address_country").chosen();
			}
		}
		
		if (tipsy) {
			$(".listing-tip").tipsy({
				offset: 1,
				opacity: 1,
				html: true,
				gravity: "nw",
				className: "tipsy-listing"
			});
			$(".center-langbar-tip").tipsy({
				offset: 1,
				opacity: 1,
				html: true,
				className: "tipsy-listing-center"
			});
		}
		
		if ($gallery.length > 0 && gallery) {
			$gallery.gallery({
				compressUrl: "index.php?controller=pjGallery&action=pjActionCompressGallery&model=pjProperty&foreign_id=" + myGallery.foreign_id,
				getUrl: "index.php?controller=pjGallery&action=pjActionGetGallery&model=pjProperty&foreign_id=" + myGallery.foreign_id,
				deleteUrl: "index.php?controller=pjGallery&action=pjActionDeleteGallery",
				emptyUrl: "index.php?controller=pjGallery&action=pjActionEmptyGallery&model=pjProperty&foreign_id=" + myGallery.foreign_id,
				rebuildUrl: "index.php?controller=pjGallery&action=pjActionRebuildGallery&model=pjProperty&foreign_id=" + myGallery.foreign_id,
				resizeUrl: "index.php?controller=pjGallery&action=pjActionCrop&id={:id}&model=pjProperty&foreign_id=" + myGallery.foreign_id + "&hash=" + myGallery.hash + ($frmUpdateProperty.length > 0 ? "&query_string=" + encodeURIComponent("controller=pjAdminProperties&action=pjActionUpdate&id=" + myGallery.foreign_id + "&tab_id=tabs-5") : ""),
				//rotateUrl: "index.php?controller=pjGallery&action=pjActionRotateGallery",
				sortUrl: "index.php?controller=pjGallery&action=pjActionSortGallery",
				updateUrl: "index.php?controller=pjGallery&action=pjActionUpdateGallery",
				uploadUrl: "index.php?controller=pjGallery&action=pjActionUploadGallery&model=pjProperty&foreign_id=" + myGallery.foreign_id,
				watermarkUrl: "index.php?controller=pjGallery&action=pjActionWatermarkGallery&model=pjProperty&foreign_id=" + myGallery.foreign_id
			});
		}
		
		$(".spin").spinner({
			min: 0
		});
		
		if ($("#grid").length > 0 && datagrid) {
			
			function formatImage(val, obj) {
				var src = val ? val : 'app/web/img/backend/no_img.png';
				return ['<a href="index.php?controller=pjAdminProperties&action=pjActionUpdate&id=', obj.id ,'"><img src="', src, '" style="width: 90px" /></a>'].join("");
			}
			
			function formatOwner(val, obj) {
				return ['<a href="index.php?controller=pjAdminUsers&action=pjActionUpdate&id=', obj.owner_id, '">', $.datagrid.wordwrap(obj.owner_name, 20, '<br>', true), '</a>'].join("");
			}
			
			function formatRefid(val, obj) {
				return $.datagrid.wordwrap(val, 25, '<br>', true);
			}
			function _formatPrice(val, obj) {
				return val;
			}
			function _formatStatus(val, obj) 
			{
				if(obj.status == 'F')
				{
					return '<span class="pj-table-cell-label pj-status pj-status-F">'+myLabel.inactive+'</span>';
				}else if(obj.status == 'E'){
					if(obj.is_expired == 1)
					{
						return '<span class="pj-table-cell-label pj-status b5 pj-status-E">'+myLabel.exp_date+'</span><span class="color-red">'+obj.expire+'</span>';
					}else{
						return '<span class="pj-table-cell-label pj-status b5 pj-status-E">'+myLabel.exp_date+'</span><span>'+obj.expire+'</span>';
					}
				}else{
					return '<span class="pj-table-cell-label pj-status b10 pj-status-T">'+myLabel.active+'</span>' + myLabel.unlimited;
				}
			}
			var menuOpts = [  
			                  {text: myLabel.exp_date_plus_30, url: "index.php?controller=pjAdminProperties&action=pjActionExpireProperty&id={:id}", ajax: true, render: true},
				              {text: myLabel.view_enquiries, url: "index.php?controller=pjAdminEnquiries&action=pjActionIndex&property_id={:id}"}
				           ];
			if (pjGrid.isEditor === true) {
				menuOpts = [  
				              {text: myLabel.view_enquiries, url: "index.php?controller=pjAdminEnquiries&action=pjActionIndex&property_id={:id}"}
				           ];
			}
			var gridOpts = {
				buttons: [{type: "edit", url: "index.php?controller=pjAdminProperties&action=pjActionUpdate&id={:id}"},
				          {type: "delete", url: "index.php?controller=pjAdminProperties&action=pjActionDeleteProperty&id={:id}"},
				          {type: "menu", url: "#", text: myLabel.more, items:menuOpts}],
				columns: [{text: myLabel.image, type: "text", width: 100, sortable: false, editable: false, renderer: formatImage},
				          {text: myLabel.ref_id, type: "text", sortable: true, width: 50, editable: true, renderer: formatRefid},
				          {text: myLabel.type, type: "text", sortable: true, editable: false, width: 140},
				          {text: myLabel.owner, type: "text", sortable: true, editable: false, renderer: formatOwner, width: 100},
				          {text: myLabel.price, type: "text", sortable: true, editable: false, width: 80, renderer: _formatPrice},
				          {text: myLabel.publish, type: "text", width: 80, sortable: true, editable: false, renderer: _formatStatus}
				          ],
				dataUrl: "index.php?controller=pjAdminProperties&action=pjActionGetProperty" + pjGrid.queryString,
				dataType: "json",
				fields: ['image', 'ref_id', 'type_title', 'owner_name', 'price', 'status'],
				paginator: {
					actions: [
						{text: myLabel.delete_selected, url: "index.php?controller=pjAdminProperties&action=pjActionDeletePropertyBulk", render: true, confirmation: myLabel.delete_confirmation},
						{text: myLabel.published, url: "index.php?controller=pjAdminProperties&action=pjActionStatusProperty&status=T", render: true},
						{text: myLabel.not_published, url: "index.php?controller=pjAdminProperties&action=pjActionStatusProperty&status=F", render: true}
					],
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: "index.php?controller=pjAdminProperties&action=pjActionSaveProperty&id={:id}",
				select: {
					field: "id",
					name: "record[]"
				}
			};
			if (pjGrid.isOwner === true) {
				function formatExtend(val, obj) {
					if(obj.status == 'F')
					{
						return '<span class="pj-table-cell-label pj-status b10 pj-status-F">'+myLabel.inactive+'</span>' + ['<a class="pj-button" href="index.php?controller=pjAdminProperties&action=pjActionPayment&id=', val, '">', myLabel.publish, '</a>'].join("");
					}if(obj.status == 'T'){
						return '<span class="pj-table-cell-label pj-status b5 pj-status-T">'+myLabel.active+'</span>' + myLabel.unlimited;
					}else{
						return '<span class="pj-table-cell-label pj-status b5 pj-status-E">'+myLabel.exp_date+'</span><span class="block b10">'+obj.expire+'</span>' + ['<a class="pj-button" href="index.php?controller=pjAdminProperties&action=pjActionPayment&id=', val, '">', myLabel.extend_exp_date, '</a>'].join("");
					}
				}
				function _formatDate(val, obj){
					if(obj.status == 'F')
					{
						return myLabel.inactive;
					}if(obj.status == 'T'){
						return myLabel.unlimited;
					}else{
						if(obj.is_expired == 1)
						{
							return '<span class="color-red">'+val+'</span>';
						}else{
							return val;
						}
					}
				}
				gridOpts.buttons = [
				    {type: "edit", url: "index.php?controller=pjAdminProperties&action=pjActionUpdate&id={:id}"},
				    {type: "delete", url: "index.php?controller=pjAdminProperties&action=pjActionDeleteProperty&id={:id}"}
				];
				gridOpts.columns = [
				    {text: myLabel.image, type: "text", sortable: false, editable: false, renderer: formatImage, width: 100},
				    {text: myLabel.ref_id, type: "text", sortable: true, editable: true, width: 80},
					{text: myLabel.price, type: "text", sortable: true, editable: false, renderer: _formatPrice, width: 170},
					{text: myLabel.publish, type: "text", sortable: false, editable: false, renderer: formatExtend, width: 200}
				];
				gridOpts.fields = ['image', 'ref_id', 'price', 'id'];
				gridOpts.paginator.actions = [{text: myLabel.delete_selected, url: "index.php?controller=pjAdminProperties&action=pjActionDeletePropertyBulk", render: true, confirmation: myLabel.delete_confirm}];
			}
			
			var $grid = $("#grid").datagrid(gridOpts);
			
			$(document).on("click", ".btn-all", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				$(this).addClass("pj-button-active").siblings(".pj-button").removeClass("pj-button-active");
				var content = $grid.datagrid("option", "content"),
					cache = $grid.datagrid("option", "cache");
				$.extend(cache, {
					status: "",
					is_featured: "",
					ref_id: "",
					address_country: "",
					type_id: "",
					owner_id: "",
					keyword: "",
					address_state: "",
					address_city: ""
				});
				$grid.datagrid("option", "cache", cache);
				$grid.datagrid("load", "index.php?controller=pjAdminProperties&action=pjActionGetProperty", "id", "DESC", content.page, content.rowCount);
				return false;
			}).on("click", ".btn-filter", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var $this = $(this),
					content = $grid.datagrid("option", "content"),
					cache = $grid.datagrid("option", "cache"),
					obj = {};
				$this.addClass("pj-button-active").siblings(".pj-button").removeClass("pj-button-active");
				obj.status = "";
				obj.is_featured = "";
				obj[$this.data("column")] = $this.data("value");
				$.extend(cache, obj);
				$grid.datagrid("option", "cache", cache);
				$grid.datagrid("load", "index.php?controller=pjAdminProperties&action=pjActionGetProperty", "id", "DESC", content.page, content.rowCount);
				return false;
			}).on("click", ".pj-button-detailed, .pj-button-detailed-arrow", function (e) {
				e.stopPropagation();
				$(".pj-form-filter-advanced").toggle();
			}).on("submit", ".frm-filter-advanced", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var obj = {},
					$this = $(this),
					arr = $this.serializeArray(),
					content = $grid.datagrid("option", "content"),
					cache = $grid.datagrid("option", "cache");
				for (var i = 0, iCnt = arr.length; i < iCnt; i++) {
					obj[arr[i].name] = arr[i].value;
				}
				$.extend(cache, obj);
				$grid.datagrid("option", "cache", cache);
				$grid.datagrid("load", "index.php?controller=pjAdminProperties&action=pjActionGetProperty", "id", "ASC", content.page, content.rowCount);
				return false;
			}).on("reset", ".frm-filter-advanced", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				$(".pj-button-detailed").trigger("click");
				if (chosen) {
					$("#owner_id").val('').trigger("liszt:updated");
					$("#address_country").val('').trigger("liszt:updated");
				}
				$('#ref_id').val('');
				$('#keyword').val('');
				$('#type_id').val('');
				$('#address_state').val('');
				$('#address_city').val('');
			}).on("submit", ".frm-filter", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var $this = $(this),
					content = $grid.datagrid("option", "content"),
					cache = $grid.datagrid("option", "cache");
				$.extend(cache, {
					q: $this.find("input[name='q']").val(),
					ref_id: "",
					keyword: "",
					type_id: "",
					owner_id: "",
					address_country: "",
					address_state: "",
					address_city: ""
				});
				$grid.datagrid("option", "cache", cache);
				$grid.datagrid("load", "index.php?controller=pjAdminProperties&action=pjActionGetProperty", "id", "ASC", content.page, content.rowCount);
				return false;
			});
			
		}
		
		$(document).on("click", ".pj-form-field-icon-date", function (e) {
			var $dp = $(this).parent().siblings("input[type='text']");
			if ($dp.hasClass("hasDatepicker")) {
				$dp.datepicker("show");
			} else {
				$dp.trigger("focusin").datepicker("show");
			}
		}).on("change", "#status", function (e) {
			if($(this).val() == 'E')
			{
				$('#expiration_container').css('display', 'block');
			}else{
				$('#expiration_container').css('display', 'none');
			}
		}).on("change", "#for", function (e) {
			if($(this).val() == 'rent')
			{
				$('.priceBox').css('display', 'inline-block');
			}else{
				$('.priceBox').css('display', 'none');
			}
		}).on("click", ".resetContact", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var href = 'index.php?controller=pjAdminProperties&action=pjActionResetContact',
				can_request = false;
			if($('#owner_id').length > 0)
			{
				if($('#owner_id').val() != '')
				{
					href += '&id=' + $('#owner_id').val();
					can_request = true;
				}
			}else{
				if(myLabel.isOwner == true)
				{
					can_request = true;
				}
			}
			if(can_request == true)
			{
				$.get(href).done(function (data) {
					if(data.hasOwnProperty('name')){
						$('#owner_name').val(data.name);
					}
					if(data.hasOwnProperty('email')){
						$('#owner_email').val(data.email);
					}
					if(data.hasOwnProperty('phone')){
						$('#owner_phone').val(data.phone);
					}
					if(data.hasOwnProperty('fax')){
						$('#owner_fax').val(data.fax);
					}
				});
			}
		}).on("click", ".pj-delete-file", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$dialogDeleteFile.data('href', $(this).data('href')).dialog("open");
		}).on("focus", "#properties_feed", function (e) {
			$(this).select();
		}).on("click", ".btnGoogleMapsApi", function (e) {
			var $this = $(this);
			$.post("index.php?controller=pjAdminProperties&action=pjActionGetGeocode", $(this).closest("form").serialize()).done(function (data) {
				if (data.code !== undefined && data.code == 200) {
					$("#lat").val(data.lat);
					$("#lng").val(data.lng);
					$this.siblings("span").hide().html("");
					initGMap(parseFloat(data.lat), parseFloat(data.lng));
				} else {
					$this.siblings("span").html("<br>" + myLabel.address_not_found).show();
				}
			});
		});
		
		if($('#frmUpdateProperty').length > 0)
		{
			var input_arr = document.getElementsByClassName('pjPLGoogleAddress'); 
			var input = input_arr[0];
			var address = document.getElementsByClassName('pjPLAddress'); 
			var $address = $(address[0]);
		    var autocomplete = new google.maps.places.Autocomplete(input, {
		        types: ["geocode"]
		    });
		    
			$('#frmUpdateProperty').on("keypress", function(e) {
				var code = e.keyCode || e.which; 
				if (code  == 13) {
					var $focused = $(':focus');
					if($focused.hasClass('pjPLGoogleAddress') )
					{
						e.preventDefault();
						return false;
					}
				}
			});
			
		    google.maps.event.addListener(autocomplete, 'place_changed', function() {
		        fillInAddress();
		    });	
		    function fillInAddress() 
		    {
		    	var place = autocomplete.getPlace();
		    	var address_arr = [];
		    	$('#address_state').val("");
		    	$('.pjPLCity').val("");
		    	$('#address_zip').val("");
		    	$("#address_country").val("");
		    	$('#address_country').trigger("liszt:updated");
		    	$address.val("");
		    	for (var i = 0; i < place.address_components.length; i++) 
		    	{
		    	    var addressType = place.address_components[i].types[0];
	    	    	if(addressType == 'administrative_area_level_1')
	    	    	{
	    	    		$('#address_state').val(place.address_components[i]['short_name']);
	    	    	}
		    	    if(addressType == 'locality')
			    	{    
	    	    		$('.pjPLCity').val(place.address_components[i]['long_name']);
	    	    	}
			    	if(addressType == 'postal_code')
			    	{    
	    	    		$('#address_zip').val(place.address_components[i]['short_name']);
	    	    	}
				    if(addressType == 'street_number')
				    {    
				    	address_arr.push(place.address_components[i]['short_name']);
			    	}
					if(addressType == 'route')
					{    
						address_arr.push(place.address_components[i]['long_name']);
			    	}
					if(addressType == 'country')
					{    
						var country = place.address_components[i]['long_name']; 
						$("#address_country").find("option:contains('"+country+"')").each(function(){
							if( $(this).text() == country ) {
								$(this).attr("selected","selected");
								$(this).trigger("liszt:updated");
							}
						});
			    	}
		    	}
		    	if(address_arr.length > 0)
		    	{
		    		$address.val(address_arr.join(" "));
		    	}else{
		    		$address.val("");
		    	}
		    	$('#lat').val(place.geometry.location.lat());
		    	$('#lng').val(place.geometry.location.lng());
		    	initGMap(parseFloat(place.geometry.location.lat()), parseFloat(place.geometry.location.lng()));
		    }
		}
		
		$('#chooseFile').bind('change', function () {
			  var filename = $("#chooseFile").val();
			  if (/^\s*$/.test(filename)) {
			    $(".file-upload").removeClass('active');
			    $("#noFile").text("No file chosen..."); 
			  }
			  else {
			    $(".file-upload").addClass('active');
			    $("#noFile").text(filename.replace("C:\\fakepath\\", "")); 
			  }
		});
	});
})(jQuery_1_8_2);