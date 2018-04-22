<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
  <!-- CSS de todos los mapas de Leaflet -->
  <link rel="stylesheet" href="leaflet/leaflet.css" crossorigin=""/>
    
</head>
<body>
	<div id="map" style="width: 640px; height: 400px;"></div>
	
	<script src="leaflet/leaflet.js" ></script>
	<script>
		var mymap = L.map('map').setView([41.789, 1.630], 8);

		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
			maxZoom: 9,
			minZoom: 6,
			id: 'mapbox.light'
		}).addTo(mymap);
	</script>
</body>
</html>