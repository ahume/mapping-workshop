<!DOCTYPE html>
<html>
<head>
<style type="text/css">
	#map { height: 600px; width: 600px; }
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="http://www.heatmapapi.com/Javascript/HeatmapAPIGoogle3.js"></script>
<script type="text/javascript" src="http://www.heatmapapi.com/Javascript/HeatMapAPI3.aspx?k=ffd2f1d1-a911-48d4-8e6a-a459cb6eb17c"></script>
<script type="text/javascript">

(function() {
	
	var strikes = [
		{"lat": 31.451111, "lon": 15.248889 },
		{"lat": 30.755556, "lon": 20.225278 },
		{"lat": 32.530833, "lon": 13.021111 },
		{"lat": 32.649722, "lon": 14.264444 },
		{"lat": 31.9833, "lon": 11.6667 },
		{"lat": 32.752222, "lon": 12.727778 },
		{"lat": 32.059444, "lon": 11.543056 },
		{"lat": 31.766667, "lon": 13.983333 },
		{"lat": 30.3997, "lon": 19.6161 },
		{"lat": 32.6833, "lon": 13.1833 },
		{"lat": 32.3167, "lon": 12.5667 },
		{"lat": 29.5, "lon": 17.8333 },
		{"lat": 30.0833, "lon": 16.55 },
		{"lat": 32.169722, "lon": 13.016667 },
		{"lat": 29.1166667, "lon": 15.9333333 },
		{"lat": 31.95, "lon": 12.0166667 },
		{"lat": 32.377533, "lon": 15.092017 },
		{"lat": 31.445, "lon": 12.983056 },
		{"lat": 31.8683, "lon": 10.9828 },
		{"lat": 32.895, "lon": 13.280278 },
		{"lat": 30.2925, "lon": 19.425556 },
		{"lat": 30.474722, "lon": 18.573611 },
		{"lat": 27.038889, "lon": 14.426389 },
		{"lat": 31.205314, "lon": 16.588936 },
		{"lat": 32.7563889, "lon": 12.575 },
		{"lat": 32.433611, "lon": 13.634722 },
		{"lat": 32.0167, "lon": 11.3667 },
		{"lat": 32.902222, "lon": 13.185833 },
		{"lat": 31.8683, "lon": 10.9828 },
		{"lat": 32.0167, "lon": 15.1167 },
		{"lat": 28.1, "lon": 20 },
		{"lat": 29.161111, "lon": 16.143611 },
		{"lat": 32.062778, "lon": 12.526667 },
		{"lat": 31.930556, "lon": 12.248333 },
		{"lat": 32.466667, "lon": 14.566667 },
		{"lat": 32.933333, "lon": 12.083333 }
	];
	
	function init() {
		
		var myHeatmap = new GEOHeatmap();
		data = [];
		
		for (var i = 0, j = strikes.length; i<j; ++i) {
			data.push(strikes[i].lat);
			data.push(strikes[i].lon);
			data.push(5);
		}
		// configure HeatMapAPI
		myHeatmap.Init(400, 300); // set at pixels for your map
		myHeatmap.SetBoost(0.1);
		myHeatmap.SetDecay(0); // see documentation
		myHeatmap.SetData(data);
		myHeatmap.SetProxyURL('http://localhost/code-examples/heatmap-api/proxy.php');
		
		var latlng = new google.maps.LatLng(26.273714, 17.226563);
		var myOptions = {
			zoom: 5,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.querySelector("#map"), myOptions);
		google.maps.event.addListener(map, 'idle', function(event) {
			myHeatmap.AddOverlay(this, myHeatmap);
		});
	}
	
	window.onload = init;
	
})();
</script>
</head>
<body>
	<h1>Nato Libya Attacks</h1>
	<div id="map"></div>
	<p>This uses <a href="http://www.heatmapapi.com">HeatmapAPI.com</a> to overlay a dynamic heatmap image on top of a Google map. You need to code a little bit of JavaScript as well as copy the proxy.php file on to a PHP enabled web server on your local machine.</p>
		
		
		
</body>
</html>