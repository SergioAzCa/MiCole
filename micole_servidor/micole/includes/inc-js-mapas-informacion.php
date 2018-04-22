<script>
//AJAX par rellenar automaticamente los valores en los campos
$(document).ready(function(){
    $.ajax({
        url: "ajax/carga-mapas.php",
        type: 'POST',
        data: {
            "mapa"  : "informacion"
        },
        cache: false,
        success: function(response) {
            var jsonData = JSON.parse(response);
            var url_geoserver = 'http://54.38.180.7:8080/geoserver/wms?';
            var mymap_informacion = L.map('map', {
                crs: L.CRS.EPSG3857
            }).setView([jsonData[0]['latitud'], jsonData[0]['longitud']], 12);
            //CAPA BASE
            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
              maxZoom: 18,
              id: 'mapbox.streets'
            }).addTo(mymap_informacion);
            //LOCALIZACION DEL CENTRO
            var datos_localizacion_centro = 'id_vial:'+jsonData[0]['id_vial']+';num_policia:'+jsonData[0]['num_poli'];
            var localizacion_centro = L.tileLayer.wms(url_geoserver,{
                        layers: 'colegios:localizacion_centro',
            						viewparams:[datos_localizacion_centro],
                        format: 'image/png',
                        transparent: true,
                        }).addTo(mymap_informacion);
            localizacion_centro.setZIndex(3);
            //ZONAS Primaria
            var zonas_primaria = L.tileLayer.wms(url_geoserver,{
                      layers: 'colegios:zonas_primaria',
                      format: 'image/png',
                      transparent: true,
                    }).addTo(mymap_informacion);
            zonas_primaria.setZIndex(1);
            //ZONAS Bachiller
            var zonas_bachiller = L.tileLayer.wms(url_geoserver,{
                      layers: 'colegios:zonas_bachiller',
                      format: 'image/png',
                      transparent: true,
                    }).addTo(mymap_informacion);
            zonas_bachiller.setZIndex(1);
            //LAYER TREE
            var baseTree = [
                {
                    label: 'Zonas de influencia',
                    children: [
                        {label: 'E.S.O|Bachiller', layer: zonas_bachiller, name: 'Zona E.S.O|Bachiller'},
                        {label: 'Infantil|Primaria', layer: zonas_primaria, name: 'Zona Infantil|Primaria'}
                    ]
                }
            ];
            var overlaysTree = {};
    				L.control.layers.tree(baseTree,overlaysTree,
                {
                    namedToggle: true,
                }).addTo(mymap_informacion);
            //ZOOM
            mymap_informacion.panTo(new L.LatLng(jsonData[0]['latitud'], jsonData[0]['longitud']));
            //REFRESH MAPA
            mymap_informacion.redraw();
        }
    });
});
</script>
