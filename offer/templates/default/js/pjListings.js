/*!
 * Property Listing v3.0
 * Layout 1
 * http://www.phpjabbers.com/property-listing-script/
 * 
 * Copyright 2014, PHPJabbers
 * 
 */
(function (window, undefined){
	"use strict";
	var document = window.document,
		validate = (pjQ.$.fn.validate !== undefined);
	
	function log() {
		if (window.console && window.console.log) {
			for (var x in arguments) {
				if (arguments.hasOwnProperty(x)) {
					window.console.log(arguments[x]);
				}
			}
		}
	}
	
	function assert() {
		if (window && window.console && window.console.assert) {
			window.console.assert.apply(window.console, arguments);
		}
	}
	
	function PropertyListing(opts) {
		if (!(this instanceof PropertyListing)) {
			return new PropertyListing(opts);
		}
				
		this.reset.call(this);
		this.init.call(this, opts);
		
		return this;
	}
	
	PropertyListing.inObject = function (val, obj) {
		var key;
		for (key in obj) {
			if (obj.hasOwnProperty(key)) {
				if (obj[key] == val) {
					return true;
				}
			}
		}
		return false;
	};
	
	PropertyListing.size = function(obj) {
		var key,
			size = 0;
		for (key in obj) {
			if (obj.hasOwnProperty(key)) {
				size += 1;
			}
		}
		return size;
	};
	
	PropertyListing.prototype = {
		reset: function () {
			this.$container = null;
			this.container = null;			
			this.opts = {};
			
			return this;
		},
		
		init: function (opts) {
			var self = this;
			this.opts = opts;
			this.container = document.getElementById("pjWrapperPropertyListing_" + this.opts.index);
			this.$container = pjQ.$(this.container);
			var $mapContainer = pjQ.$('#ppMapContainer_' + this.opts.index),
				$mapDetails = pjQ.$('#ppDetailsMap_' + this.opts.index);
			var validate = (pjQ.$.fn.validate !== undefined),
				$frmPLLogin = pjQ.$('#frmPLLogin'),
				$frmPLRegister = pjQ.$('#frmPLRegister'),
				$frmPLForgot = pjQ.$('#frmPLForgot'),
				$frmPLSendRequest = pjQ.$('#frmPLSendRequest');
			
			this.$container.on("click.pl", ".btnFor", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				pjQ.$('.btnFor').removeClass('btn-primary');
				pjQ.$(this).addClass('btn-primary');
				pjQ.$("#frmSearch input[name=for]").val(pjQ.$(this).attr('data-for'));
			}).on("click.pl", ".plThumbnail", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var large_url = pjQ.$(this).children(":first").attr('data-large');
				pjQ.$('#plImageHolder_' + self.opts.index).attr('src', large_url);
			}).on("click.pl", ".btnSendContact", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				$frmPLSendRequest.submit();
			}).on("click.pl", "#pjPlCaptchaImage", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var $captchaImg = pjQ.$(this);
				if($captchaImg.length > 0){
					var rand = Math.floor((Math.random()*999999)+1); 
					$captchaImg.attr("src", self.opts.folder + 'index.php?controller=pjFront&action=pjActionCaptcha&rand=' + rand);
					pjQ.$('#pjPlCaptchaField').val("").removeData("previousValue");
				}
			}).on("click.pl", '#ppCaptchaImage_' + self.opts.index, function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var $captchaImg = pjQ.$(this);
				if($captchaImg.length > 0){
					var rand = Math.floor((Math.random()*999999)+1); 
					$captchaImg.attr("src", self.opts.folder + 'index.php?controller=pjFront&action=pjActionCaptcha&rand=' + rand);
					pjQ.$('#pjPlCaptchaField').val("").removeData("previousValue");
				}
			});
			
			pjQ.$("html").attr('dir', self.opts.direction);
			if(self.opts.direction == 'rtl')
			{
				self.$container.find('.pjPplContainer').addClass('pjPplRtl');
			}else{
				self.$container.find('.pjPplContainer').removeClass('pjPplRtl');
			}
			self.$container.find('.pjPplContainer').show();
			
			if($mapContainer.length > 0 && !(typeof mapProperties === 'undefined'))
			{
				self.initMap.apply(self, [mapProperties]);
			}
			if($mapDetails.length > 0)
			{
				self.initMapDetails.apply(self, [$mapDetails.attr('data-lat'), $mapDetails.attr('data-lng')]);
			}
			if(pjQ.$('#frmPLContactDetails').length > 0)
			{
				pjQ.$('.modal-dialog').css("z-index", "9999");
			}
			
			if ($frmPLLogin.length > 0 && validate) 
			{
				$frmPLLogin.validate({
					messages: {
						"login_email": {
							required: $frmPLLogin.find("input[name='login_email']").attr("data-err"),
							email: $frmPLLogin.find("input[name='login_email']").attr("data-email")
						},
						"login_password": {
							required: $frmPLLogin.find("input[name='login_password']").attr("data-err")
						}
					},
					errorPlacement: function (error, element) {
						error.insertAfter(element);
					},
					errorClass: "err",
					wrapper: "em",
					onkeyup: false
				});
			}
			
			if ($frmPLRegister.length > 0 && validate) 
			{
				$frmPLRegister.validate({
					rules: {
						"reenter_password": {
							equalTo: $frmPLRegister.find("input[name='password']")
						},
						"captcha": {
							remote: $frmPLRegister.find("input[name='captcha']").attr("data-folder") + "index.php?controller=pjFront&action=pjActionCheckCaptcha"
						},
						"email": {
							remote: $frmPLRegister.find("input[name='email']").attr("data-folder") + "index.php?controller=pjListings&action=pjActionCheckEmail"
						}
					},
					messages: {
						"name": {
							required: $frmPLRegister.find("input[name='name']").attr("data-err")
						},
						"email": {
							required: $frmPLRegister.find("input[name='email']").attr("data-err"),
							email: $frmPLRegister.find("input[name='email']").attr("data-email"),
							remote: $frmPLRegister.find("input[name='email']").attr("data-exist")
						},
						"password": {
							required: $frmPLRegister.find("input[name='password']").attr("data-err")
						},
						"reenter_password": {
							required: $frmPLRegister.find("input[name='reenter_password']").attr("data-err"),
							equalTo: $frmPLRegister.find("input[name='reenter_password']").attr("data-match")
						},
						"captcha": {
							required: $frmPLRegister.find("input[name='captcha']").attr("data-err"),
							remote: $frmPLRegister.find("input[name='captcha']").attr("data-captcha")
						}
					},
					errorPlacement: function (error, element) {
						if(element.attr('name') == 'captcha')
						{
							error.insertAfter(element.parent().parent());
						}else{
							error.insertAfter(element);
						}
					},
					errorClass: "err",
					wrapper: "em",
					onkeyup: false
				});
			}
			if ($frmPLForgot.length > 0 && validate) 
			{
				$frmPLForgot.validate({
					messages: {
						"email": {
							required: $frmPLForgot.find("input[name='email']").attr("data-err"),
							email: $frmPLForgot.find("input[name='email']").attr("data-email")
						}
					},
					errorPlacement: function (error, element) {
						error.insertAfter(element);
					},
					errorClass: "err",
					wrapper: "em",
					onkeyup: false
				});
			}
			if ($frmPLSendRequest.length > 0 && validate) 
			{
				$frmPLSendRequest.validate({
					rules: {
						"captcha": {
							remote: $frmPLSendRequest.find("input[name='captcha']").attr("data-folder") + "index.php?controller=pjFront&action=pjActionCheckCaptcha"
						}
					},
					messages: {
						"email": {
							required: $frmPLSendRequest.find("input[name='email']").attr("data-err"),
							email: $frmPLSendRequest.find("input[name='email']").attr("data-email")
						},
						"name": {
							required: $frmPLSendRequest.find("input[name='name']").attr("data-err")
						},
						"message": {
							required: $frmPLSendRequest.find("textarea[name='message']").attr("data-err")
						},
						"captcha": {
							required: $frmPLSendRequest.find("input[name='captcha']").attr("data-err"),
							remote: $frmPLSendRequest.find("input[name='captcha']").attr("data-captcha")
						}
					},
					errorPlacement: function (error, element) {
						if(element.attr('name') == 'captcha')
						{
							error.insertAfter(element.parent().parent());
						}else{
							error.insertAfter(element);
						}
					},
					errorClass: "err",
					wrapper: "em",
					onkeyup: false,
					submitHandler: function(form){
						$frmPLSendRequest.find('input[type="submit"]').attr('disabled','disabled');
						pjQ.$('.ppFormWarning').parent().show();
						pjQ.$('.ppFormSuccess').hide();
						pjQ.$.post($frmPLSendRequest.attr('action'), $frmPLSendRequest.serialize()).done(function (data) {
							pjQ.$('.ppFormWarning').hide();
							if(data.code == '200')
							{
								pjQ.$('.ppFormSuccess').show().delay(3000).fadeOut(function(){
									self.resetForm.apply(self);
									pjQ.$('.ppFormSuccess').parent().hide();
									pjQ.$('#frmPLContactDetails').modal('hide')
								});
								
							}else{
								$frmPLSendRequest.find('input[type="submit"]').removeAttr('disabled');
							}
						});
						return false;
					}
				});
			}
		},
		resetForm: function()
		{
			var self = this,
				$frmPLSendRequest = pjQ.$('#frmPLSendRequest'),
				$catpchaImage = pjQ.$('#ppCaptchaImage_' + self.opts.index);
			
			$frmPLSendRequest.find("input[name='name']").val('');
			$frmPLSendRequest.find("input[name='email']").val('');
			$frmPLSendRequest.find("input[name='phone']").val('');
			$frmPLSendRequest.find("textarea[name='message']").val('');
			$frmPLSendRequest.find("input[name='captcha']").val('');
			if($catpchaImage.length > 0){
				var rand = Math.floor((Math.random()*999999)+1); 
				$catpchaImage.attr("src", self.opts.folder + 'index.php?controller=pjFront&action=pjActionCaptcha&rand=' + rand);
			}
		},
		initMapDetails: function(lat, lng)
		{
			var self = this;
			if (typeof window.initializePL === "undefined") 
			{
				window.initializePL = function () 
				{
					var mapOptions = {
						zoom: 15,
						minZoom: 3,
						mapTypeId: google.maps.MapTypeId.ROADMAP
					};
					var mapStyle = [
						{
							featureType: 'all',
							elementType: 'all',
							stylers: [
								{
									saturation: -100
								}
							]
						}
					];
					var map = new google.maps.Map(document.getElementById("ppDetailsMap_" + self.opts.index), mapOptions);
					var mapType = new google.maps.StyledMapType(mapStyle, {name: 'Map'});
					var bounds = new google.maps.LatLngBounds ();
					var myLatLng = new google.maps.LatLng(lat, lng);
					map.setCenter(myLatLng);
					bounds.extend (myLatLng);
					var marker = new google.maps.Marker({
						animation: google.maps.Animation.DROP,
						position: myLatLng,
						map: map,
						clickable: true
					});
					if(pjQ.$('.ppMapDetailsContainer').length > 0 && pjQ.$('.ppPrintWrapper').length > 0)
					{
						google.maps.event.addListenerOnce(map, 'idle', function () {
							google.maps.event.trigger(map, 'resize');
						    window.setTimeout(function(){
						    	if (window.print) {
			    					window.print();
			    				}
						    },2000);
						});
					}
				};
				pjQ.$.getScript("https://maps.googleapis.com/maps/api/js?"+self.opts.google_key+"callback=initializePL");
			}
		},
		initMap: function(mapProperties)
		{
			var self = this;
			if (typeof window.initializePL === "undefined") 
			{
				window.initializePL = function () 
				{
					var mapOptions = {
						zoom: 15,
						minZoom: 3,
						mapTypeId: google.maps.MapTypeId.ROADMAP
					};
					var mapStyle = [
						{
							featureType: 'all',
							elementType: 'all',
							stylers: [
								{
									saturation: -100
								}
							]
						}
					];
					var map = new google.maps.Map(document.getElementById("ppMapContainer_" + self.opts.index), mapOptions);
					var mapType = new google.maps.StyledMapType(mapStyle, {name: 'Map'});
					var bounds = new google.maps.LatLngBounds ();
					var infowindow = new google.maps.InfoWindow({
						maxWidth: 200
					});
					for (var i = 0; i < mapProperties.length; i++) 
					{
						var property = mapProperties[i];
						var myLatLng = new google.maps.LatLng(property[0], property[1]);
						map.setCenter(myLatLng);
						bounds.extend (myLatLng);
						var marker = new google.maps.Marker({
							animation: google.maps.Animation.DROP,
							position: myLatLng,
							map: map,
							clickable: true
						});
						google.maps.event.addListener(marker, 'click', (function(marker, i) {
							return function() {
								infowindow.setContent(mapProperties[i][2]);
								infowindow.open(map, marker);
							}
						})(marker, i));
					};
					map.fitBounds (bounds);
				};
				pjQ.$.getScript("https://maps.googleapis.com/maps/api/js?"+self.opts.google_key+"callback=initializePL");
			}
		}
	};
	
	window.PropertyListing = PropertyListing;	
})(window);