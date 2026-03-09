<script type="text/javascript">
var pjQ = pjQ || {},
	PropertyListing_<?php echo $index; ?>;
(function () {
	"use strict";
	var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor),

	loadCssHack = function(url, callback){
		var link = document.createElement('link');
		link.type = 'text/css';
		link.rel = 'stylesheet';
		link.href = url;

		document.getElementsByTagName('head')[0].appendChild(link);

		var img = document.createElement('img');
		img.onerror = function(){
			if (callback && typeof callback === "function") {
				callback();
			}
		};
		img.src = url;
	},
	loadRemote = function(url, type, callback) {
		if (type === "css" && isSafari) {
			loadCssHack(url, callback);
			return;
		}
		var _element, _type, _attr, scr, s, element;
		
		switch (type) {
		case 'css':
			_element = "link";
			_type = "text/css";
			_attr = "href";
			break;
		case 'js':
			_element = "script";
			_type = "text/javascript";
			_attr = "src";
			break;
		}
		
		scr = document.getElementsByTagName(_element);
		s = scr[scr.length - 1];
		element = document.createElement(_element);
		element.type = _type;
		if (type == "css") {
			element.rel = "stylesheet";
		}
		if (element.readyState) {
			element.onreadystatechange = function () {
				if (element.readyState == "loaded" || element.readyState == "complete") {
					element.onreadystatechange = null;
					if (callback && typeof callback === "function") {
						callback();
					}
				}
			};
		} else {
			element.onload = function () {
				if (callback && typeof callback === "function") {
					callback();
				}
			};
		}
		element[_attr] = url;
		s.parentNode.insertBefore(element, s.nextSibling);
	},
	loadScript = function (url, callback) {
		loadRemote(url, "js", callback);
	},
	loadCss = function (url, callback) {
		loadRemote(url, "css", callback);
	},
	options = {
		server: "<?php echo PJ_INSTALL_URL; ?>",
		folder: "<?php echo PJ_INSTALL_FOLDER; ?>",
		index: <?php echo $index; ?>,
		google_key: "<?php echo $api_key_str = isset($tpl['option_arr']['o_google_map_api']) && !empty($tpl['option_arr']['o_google_map_api']) ? 'key=' . $tpl['option_arr']['o_google_map_api'] . '&' : '';?>",
		direction: "<?php echo $controller->getDirection(); ?>",
	};
	<?php
	$dm = new pjDependencyManager(PJ_INSTALL_PATH, PJ_THIRD_PARTY_PATH);
	$dm->load(PJ_CONFIG_PATH . 'dependencies.php')->resolve();
	?>
	loadScript("<?php echo PJ_INSTALL_URL . preg_replace('|^' . PJ_INSTALL_PATH . '|', '', $dm->getPath('pj_jquery')); ?>pjQuery.min.js", function () {
		loadScript("<?php echo PJ_INSTALL_URL . preg_replace('|^' . PJ_INSTALL_PATH . '|', '', $dm->getPath('pj_validate')); ?>pjQuery.validate.min.js", function () {
			loadScript("<?php echo PJ_INSTALL_URL . preg_replace('|^' . PJ_INSTALL_PATH . '|', '', $dm->getPath('lytebox')); ?>lytebox.js", function () {
				loadScript("<?php echo PJ_INSTALL_URL . preg_replace('|^' . PJ_INSTALL_PATH . '|', '', $dm->getPath('pj_bootstrap')); ?>pjQuery.bootstrap.min.js", function () {
					loadScript("<?php echo PJ_INSTALL_URL . PJ_TEMPLATE_PATH . basename(dirname(dirname(__FILE__))); ?>/js/pjListings.js", function () {
						PropertyListing_<?php echo $index; ?> = new PropertyListing(options);
					});
				});
			});
		});
	});
})();
</script>