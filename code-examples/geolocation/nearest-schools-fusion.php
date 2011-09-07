<!DOCTYPE html>
<html>
<head>
<style type="text/css">
	body {
		font-family: helvetica;
	}
	#map { height: 800px; width: 800px; }
</style>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
(function() {
	
	var brighton,
		fusionlayer,
		map;
	
	function init() {
		
		addControlEvents();
		
		brighton = new google.maps.LatLng(50.850522, -0.13642);
		var myOptions = {
			zoom: 12,
			center: brighton,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.querySelector("#map"), myOptions);
		
		// Set up a routing renderer for later.
		directionsService = new google.maps.DirectionsService();
		directionsDisplay = new google.maps.DirectionsRenderer();
		directionsDisplay.setMap(map);
	}
	
	function showSchools(worst) {
		var where = 'ApsEngmatTest09 < 100';
		if (worst) {
			where = 'ApsEngmatTest09 < 26';
		}
		if (fusionlayer) {
			fusionlayer.setMap(null);
		}
		
		fusionlayer = new google.maps.FusionTablesLayer({
			query: {
				select: 'PostCode',
				from: '1420682',
				where: where
			}
		});
		fusionlayer.setMap(map);
	}
	
	function addControlEvents() {
		document.querySelector("#school-controls").addEventListener("click", function(e) {
			e.preventDefault();
			showSchools( (e.target.id === "worst") );
		}, true);
	}
	
	window.onload = init;
	
})();
</script>
</head>
<body>
	<h1>Nearest schools to us</h1>
	<div id="map"></div>
	<p id="school-controls"><a href="#" id="all">All primary schools</a> | <a href="#" id="worst">Less than 26 average point score for English and maths in 2009</a></p>
	<p>This uses the W3C geolocation API to find our position, and then looks up the nearest Brighton schools ordered by highest pupil absence - as stored in SimpleGeo&rsquo;s Storage API.</p>
	<p>Similar queries are available through a REST API: <a href="https://www.google.com/fusiontables/api/query?sql=SELECT+PostCode+FROM+1420682+WHERE+ApsEngmatTest09%20%3C%20100&jsonCallback=me">https://www.google.com/fusiontables/api/query?sql=SELECT+PostCode+FROM+1420682+WHERE+ApsEngmatTest09%20%3C%20100&jsonCallback=me</a>
</body>
</html>