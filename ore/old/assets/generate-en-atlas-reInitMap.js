
		var useYandexMap = 0;
		var useGoogleMap = 0;
		var useOSMap = 1;

		function reInitMap(elem) {
			// place code to end of queue
			if(useGoogleMap){
				setTimeout(function(){
					var tmpGmapCenter = mapGMap.getCenter();

					google.maps.event.trigger($("#googleMap")[0], "resize");
					mapGMap.setCenter(tmpGmapCenter);

					if (($("#gmap-panorama").length > 0)) {
						initializeGmapPanorama();
					}
				}, 0);
			}

			if(useYandexMap){
				setTimeout(function(){
					ymaps.ready(function () {
						globalYMap.container.fitToViewport();
						globalYMap.setCenter(globalYMap.getCenter());
					});
				}, 0);
			}

			if(useOSMap){
				setTimeout(function(){
					L.Util.requestAnimFrame(mapOSMap.invalidateSize,mapOSMap,!1,mapOSMap._container);
				}, 0);
			}
		}
	