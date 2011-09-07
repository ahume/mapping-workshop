<html>
  <head>
	<title>Visualisation of turnout in Brighton &amp; Hove Council Elections 2011</title>
	<style type="text/css">

html, body {
	width: 100%;
	height: 100%;
	margin: 0;
}

body .olControlAttribution {
	right: 10px;
	bottom: 10px;
	color: #000000;
}

</style>
	<script type="text/javascript" src="http://www.openlayers.org/api/OpenLayers.js"></script>
	<script type="text/javascript" src="http://www.openstreetmap.org/openlayers/OpenStreetMap.js"></script>
	<script type="text/javascript" src="wards-geom.js"></script>
	<script>

(function(){
	
	var map;
	
	function init() {
		map = new OpenLayers.Map("map", {
			"controls": [
				new OpenLayers.Control.Navigation(),
				new OpenLayers.Control.PanZoomBar(),
				new OpenLayers.Control.ScaleLine({"geodesic": true}),
				new OpenLayers.Control.MousePosition({
					displayProjection: new OpenLayers.Projection("EPSG:4326") // WGS 1984
				}),
				new OpenLayers.Control.Attribution()
			]
		});

		map.addLayer(new OpenLayers.Layer.OSM.Mapnik("Mapnik"));

		var wards = new OpenLayers.Layer.Vector("Wards", {
			"attribution": "boundary data from <a href=\"http://www.ordnancesurvey.co.uk/oswebsite/opendata/\">OS OpenData</a>"});
			
		
		// Some values from the turnout data.	
		var highest_value = 52.76;
		var lowest_value = 31.81;
		var range = highest_value - lowest_value;
		
		// 0-255 is 31.81-52.76;
		var increment = 255 / range;

		for (var ward in ward_data) {
			var turn_out = ward_data[ward]["turn_out"];
			var green = parseInt((turn_out - lowest_value) * increment);
			var red = 255 - green;
			var rgb = "rgb(" + red + "," + green + ",0)";
			
			AddPolygon(wards, ward_data[ward]["geom"], {
				strokeColor: "#333",
				strokeWidth: 1,
				fillColor: rgb,
				fillOpacity: 0.4,
				label: ward,// + " (" + turn_out + ")" ,
				fontFamily: "Helvetica, sans serif",
				fontSize: "14px",
				fontWeight: "bold"
				});
		}
		map.addLayer(wards);

		var centre = new OpenLayers.LonLat(-0.13315, 50.84385).transform(
			new OpenLayers.Projection("EPSG:4326"), // from WGS 1984
			new OpenLayers.Projection("EPSG:900913") // to Spherical Mercator Projection
			);
		var zoom = 13;
		map.setCenter(centre, zoom);
	}
	
	function Reproject(coordinates) {
		var points = new Array();
		for (var i = 0; i < coordinates.length; ++i)
		{
			var lonlat = new OpenLayers.LonLat(coordinates[i][0], coordinates[i][1]).transform(
				new OpenLayers.Projection("EPSG:4326"), // from WGS 1984
				new OpenLayers.Projection("EPSG:900913") // to Spherical Mercator Projection
				);
			points.push(new OpenLayers.Geometry.Point(lonlat.lon, lonlat.lat));
		}
		return points;
	}

	function AddPolygon(layer, coordinates, style) {
		var points = Reproject(coordinates);
		var linearRing = new OpenLayers.Geometry.LinearRing(points);
		var polygon = new OpenLayers.Geometry.Polygon([linearRing]);
		var vector = new OpenLayers.Feature.Vector(polygon, null, style);
		layer.addFeatures([vector]);
	}
	
	window.onload = init;
	
})();

	</script>
  </head>
  <body>
	<div id="map"></div>
  </body>
</html>