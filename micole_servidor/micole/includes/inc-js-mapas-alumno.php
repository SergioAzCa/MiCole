<script>
var url_geoserver = 'http://54.38.180.7:8080/geoserver/wms?';

var mymap_alumno = L.map('map', {
    crs: L.CRS.EPSG3857
}).setView([39.46975, -0.37739], 13);
// CAPAS
//CAPA BASE
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
	maxZoom: 18,
	id: 'mapbox.streets'
}).addTo(mymap_alumno);
//------------------------------------------------------------------------------- VISTAS GEOSERVER

// LOCALIZACION DEL PORTAL
var datos_localizacion_portal = 'portal:'+4554;   //-------RODRIGO añadir despues del +
var localizacion_portal = L.tileLayer.wms(url_geoserver,{
            layers: 'colegios:localizacion_portal',
						viewparams:[datos_localizacion_portal],
            format: 'image/png',
            transparent: true,
            }).addTo(mymap_alumno);
localizacion_portal.setZIndex(2);

//LOCALIZACION DEL CENTRO
var datos_localizacion_centro = 'id_vial:'+jsonData[0]['id_vial']+';num_policia:'+jsonData[0]['num_poli'];
var localizacion_centro = L.tileLayer.wms(url_geoserver,{
            layers: 'colegios:localizacion_centro',
            viewparams:[datos_localizacion_centro],
            format: 'image/png',
            transparent: true,
            }).addTo(map_alumno);
localizacion_centro.setZIndex(2);
//REFRESH CAPA PARA CUANDO CAMBIE la localización
localizacion_centro.redraw()

//ZONAS DEL CENTRO
var datos_zona_centro = 'id_vial:'+10+';num_policia:'+4+';id_nivel:'+4; //-------RODRIGO añadir despues del +
var zona_centro = L.tileLayer.wms(url_geoserver,{
          layers: 'colegios:zona_centro',
					viewparams:[datos_zona_centro],
          format: 'image/png',
          transparent: true,
        }).addTo(mymap_alumno);

//AÑADIR CAPAS
mymap_alumno.addLayer(zona_centro);
//BORRAR CAPA
//mymap_alumno.removeLayer(zona_centro);

//ZOOM AL ALUMNO
mymap_alumno.panTo(new L.LatLng(jsonData[0]['latitud'], jsonData[0]['longitud']));// AQUI PONER LAT LONG DEL ALUMNO AL HACER LA CARGA



</script>
