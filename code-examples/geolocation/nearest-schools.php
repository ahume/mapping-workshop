<!DOCTYPE html>
<html>
<head>
<style type="text/css">
	#map { height: 800px; width: 800px; }
</style>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="http://cdn.simplegeo.com/js/1.3/simplegeo.storage.min.js"></script>
<script type="text/javascript">
(function() {
	
	var current_coords,
		map,
		directionsService,
		directionsDisplay,
		simple_geo_token = "dPCyPfyxGDP85j7ztP5PGMcWCwY8AhFc",
		layer = "schools.keystage2";
	
	function init() {
		
		navigator.geolocation.getCurrentPosition(function(p) {
			
			// Set up a new Google map, based on the current location.
			current_coords = new google.maps.LatLng(p.coords.latitude, p.coords.longitude);
			var myOptions = {
				zoom: 15,
				center: current_coords,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			map = new google.maps.Map(document.querySelector("#map"), myOptions);
			
			// Set up a routing renderer for later.
			directionsService = new google.maps.DirectionsService();
			directionsDisplay = new google.maps.DirectionsRenderer();
			directionsDisplay.setMap(map);
			
			// Call SimpleGeo for nearest school data.
			var client = new simplegeo.StorageClient(simple_geo_token);
				client.getNearby(layer, current_coords.lat(), current_coords.lng(),
				{ "limit": 1, "radius": 2, "prop_type": "string", "prop_name": "PAbsTot", "order": "-property" },
				function(err, data) {
					if (err) {
						alert("Catch error.");
					} else {
						var s = data.features[0]
						window.setTimeout(function() {
							addMarkerAndRoute(s.geometry.coordinates, s.properties);
						}, 3000);
					}
				}
			);
		});
	}
	
	function addMarkerAndRoute(position, props) {
		var school_position = new google.maps.LatLng(position[1], position[0]);
		var marker = new google.maps.Marker({
			position: school_position,
			title: props.SchoolName
		});
		marker.setMap(map);
		//map.panTo(new google.maps.LatLng(position[1], position[0]));
		
		var html = "<p>" + props.SchoolName + "<br><strong>Total Pupil Absence:</strong> " + props.PAbsTot + "</p>";
		var infowindow = new google.maps.InfoWindow({
		    content: html
		});
		
		google.maps.event.addListener(marker, 'click', function() {
		  infowindow.open(map,marker);
		});
		
		var request = {
			origin:current_coords,
			destination:school_position,
			travelMode: google.maps.TravelMode.WALKING
		};
		
		directionsService.route(request, function(result, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(result);
			}
		});
	}
	
	window.onload = init;
	
})();
</script>
</head>
<body>
	<h1>Nearest schools to us</h1>
	<div id="map"></div>
	<p>This uses the W3C geolocation API to find our position, and then looks up the nearest Brighton schools ordered by highest pupil absence - as stored in SimpleGeo&rsquo;s Storage API.</p>
</body>
</html>