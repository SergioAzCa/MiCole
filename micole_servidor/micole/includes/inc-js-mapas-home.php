<script>
var url_geoserver = 'http://54.38.180.7:8080/geoserver/wms?';

var mymap_home = L.map('map', {
    crs: L.CRS.EPSG3857
}).setView([39.46975, -0.37739], 12);
// CAPAS
//CAPA BASE
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
	maxZoom: 18,
	id: 'mapbox.streets'
}).addTo(mymap_home);
//------------------------------------------------------------------------------- VISTAS GEOSERVER
//LOCALIZACION DEL CENTRO
var datos_localizacion_centro = 'id_vial:'+34342342+';num_policia:'+5;
var localizacion_centro = L.tileLayer.wms(url_geoserver,{
            layers: 'colegios:localizacion_centro',
            viewparams:[datos_localizacion_centro],
            format: 'image/png',
            transparent: true,
            }).addTo(mymap_home);
localizacion_centro.setZIndex(2);
// MAPA CONTADOR DE ALUMNOS POR ZONA
var datos_nivel_zona_alumnos = 'id_nivel:'+4; //-------RODRIGO añadir despues del +
var contador_zonas = L.tileLayer.wms(url_geoserver,{
            layers: '	colegios:contador_alumnos_zonas',
						viewparams:[datos_nivel_zona_alumnos],
            format: 'image/png',
            transparent: true,
					}).addTo(mymap_home);


//ZONAS DEL CENTRO ALUMNOS FUERA DENTRO
// var datos_zona_centro_dentro = 'id_centro:'+4+';id_nivel:'+4; //-------RODRIGO añadir despues del +
// var localizacion_alumno_centro_dentro = L.tileLayer.wms(url_geoserver,{
//           layers: 'colegios:alumnos_centros_dentro',
// 					viewparams:[datos_zona_centro_dentro],
//           format: 'image/png',
//           transparent: true,
//         }).addTo(mymap_home);;
// var datos_zona_centro_fuera = 'id_centro:'+4+';id_nivel:'+4; //-------RODRIGO añadir despues del +
// var localizacion_alumno_centro_fuera = L.tileLayer.wms(url_geoserver,{
//           layers: 'colegios:alumnos_centros_fuera',
// 					viewparams:[datos_zona_centro_fuera],
//           format: 'image/png',
//           transparent: true,
//         }).addTo(mymap_home);

//mymap_home.panTo(new L.LatLng(39.571666666667, -0.33111111111111));

//REFRESH MAPA
contador_zonas.redraw()

//LEYENDA
var url_leyenda ='http://54.38.180.7:8080/geoserver/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=colegios:contador_alumnos_zonas';
L.wmsLegend(url_leyenda);
</script>
