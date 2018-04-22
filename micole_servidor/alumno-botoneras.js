function activaInputs(){
  $("input[type='text']").prop('disabled', false);}
function desactivaInputs(){
  $("input[type='text']").prop('disabled', true);}
function borraCapaBaseZona(){
  grupoCapasBase.eachLayer(function (layer) {
		if (layer.options.className === "capaBaseZona"){
			grupoCapasBase.removeLayer(layer)
		}
	});
}
//Defino el mapa como una vble global
var url_geoserver = 'http://54.38.180.7:8080/geoserver/wms?';
var map_alumno = L.map('map', {crs: L.CRS.EPSG3857});
var grupoCapasBase = L.layerGroup().addTo(map_alumno);
var grupoCapasAlumno = L.layerGroup().addTo(map_alumno);

console.log(grupoCapasAlumno.getLayers());
var datos_localizacion_portal = 'portal:'+4554;   //-------RODRIGO añadir despues del +
var localizacion_portal = L.tileLayer.wms(url_geoserver,{
            layers: 'colegios:localizacion_portal',
						viewparams:[datos_localizacion_portal],
            format: 'image/png',
            transparent: true,
            }).addTo(map_alumno);
localizacion_portal.setZIndex(5);
console.log(grupoCapasAlumno.getLayers());


$(document).ready(function(){
    if($("input[name='nivel']").val() == ''){
      desactivaInputs();
    }else{
      activaInputs();
      //Hay un nivel cargado
      var nivel = $("input[name='nivel']").val();
      borraCapaBaseZona();
      if(nivel==1){
        //ZONAS Primaria
        var zonas_primaria = L.tileLayer.wms(url_geoserver,{
                  layers: 'colegios:zonas_primaria',
                  format: 'image/png',
                  className: "capaBaseZona",
                  transparent: true,
                //}).addTo(mymap_informacion);
                }).addTo(grupoCapasBase);
        zonas_primaria.setZIndex(2);
      }else if(nivel==2){
        var zonas_bachiller = L.tileLayer.wms(url_geoserver,{
                  layers: 'colegios:zonas_bachiller',
                  format: 'image/png',
                  className: "capaBaseZona",
                  transparent: true,
                //}).addTo(mymap_informacion);
                }).addTo(grupoCapasBase);
        zonas_bachiller.setZIndex(2);
      }
      console.log(grupoCapasBase.getLayers());
    }
    $("input[name='nivel']").change(function(){
      if($(this).val() == ''){
        desactivaInputs();
      }else{
        activaInputs();
        //Hay un nivel cargado
        var nivel = $("input[name='nivel']").val();
        borraCapaBaseZona();
        if(nivel==1){
          //ZONAS Primaria
          var zonas_primaria = L.tileLayer.wms(url_geoserver,{
                    layers: 'colegios:zonas_primaria',
                    format: 'image/png',
                    className: "capaBaseZona",
                    transparent: true,
                  }).addTo(grupoCapasBase);
          zonas_primaria.setZIndex(2);
        }else if(nivel==2){
          var zonas_bachiller = L.tileLayer.wms(url_geoserver,{
                    layers: 'colegios:zonas_bachiller',
                    format: 'image/png',
                    className: "capaBaseZona",
                    transparent: true,
                  }).addTo(grupoCapasBase);
          zonas_bachiller.setZIndex(2);
        }
        console.log(grupoCapasBase.getLayers());
      }
    });


    // Carga el mapa centrandolo unicamente en la posición del centro
    $.ajax({
        url: "ajax/carga-mapas.php",
        type: 'POST',
        data: {
            "mapa"  : "alumno",
            "modo"  : "inicio"
        },
        cache: false,
        success: function(response) {
            var jsonData = JSON.parse(response);
            map_alumno.setView([jsonData[0]['latitud'], jsonData[0]['longitud']], 13);
            //CAPA BASE
            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
              maxZoom: 18,
              className: "capaBase",
              id: 'mapbox.streets'
            }).addTo(grupoCapasBase);
            //LOCALIZACION DEL CENTRO
            var datos_localizacion_centro = 'id_vial:'+jsonData[0]['id_vial']+';num_policia:'+jsonData[0]['num_poli'];
            var localizacion_centro = L.tileLayer.wms(url_geoserver,{
                        layers: 'colegios:localizacion_centro',
            						viewparams:[datos_localizacion_centro],
                        className: "capaBase",
                        format: 'image/png',
                        transparent: true,
                        //}).addTo(map_alumno);
                        }).addTo(grupoCapasBase);
            localizacion_centro.setZIndex(3);
        }
    });
    //Cuando pincha sobre una direccion valida, agrega capas
    $("input[name='num_policia']").change(function(){
      alert("ok");
      var nivel = $("input[name='nivel']").val();
      var id_vial = $("input[name='id_calle']").val();
      var num_poli = $(this).val();
      $.ajax({
          url: "ajax/carga-mapas.php",
          type: 'POST',
          data: {
              "mapa"  : "alumno",
              "modo"  : "recarga",
              "nivel" : nivel,
              "vial"  : id_vial,
              "num_poli": num_poli
          },
          cache: false,
          success: function(response) {
              var jsonData = JSON.parse(response);
              map_alumno.setView([jsonData[0]['lat_nvo_mapa'], jsonData[0]['lon_nvo_mapa']], 13);
              // LOCALIZACION DEL PORTAL
              var datos_localizacion_portal = 'portal:'+jsonData[0]['id_portal_alumno'];   //-------RODRIGO añadir despues del +
              var localizacion_portal = L.tileLayer.wms(url_geoserver,{
                          layers: 'colegios:localizacion_portal',
              						viewparams:[datos_localizacion_portal],
                          format: 'image/png',
                          className: "capaAlumno",
                          transparent: true,
                          }).addTo(grupoCapasAlumno);
              localizacion_portal.setZIndex(3);
              //console.log(grupoCapasAlumno.getLayers());
          }
      });

      //alert(nivel + "kk" + id_vial+"kk" + num_poli);
    });


    // Pincha sobre una imagen de nivel
    $(".contNivel > .nivel").click(function(){
        //Cogemos el id de la imagen que nos marca el id del nivel pinchado
        var idNivel = $(this).attr("id");
        idNivel= idNivel.split("_");
        idNivel=idNivel[1];
        //funcion para limpiar los niveles seleccionados
        limpiaIconosNiveles();
        //Cojo el nombre de la imagen de fondo
        var img_fondo = $("div#nvl_"+idNivel).css("background-image");
        img_fondo = img_fondo.split("_");
        var largo = img_fondo.length;
        img_fondo = img_fondo[largo-2]+"_act.png";
        $("div#nvl_"+idNivel).css("background-image", img_fondo);
        $("input[name='nivel']").val(idNivel).trigger("change");
    });
});
function limpiaIconosNiveles(){
    $(".nivelDisp").each(function(){
        var img_fondo = $(this).css("background-image");
        img_fondo = img_fondo.split("_");
        var largo = img_fondo.length;
        img_fondo = img_fondo[largo-2]+"_des.png";
        $(this).css("background-image", img_fondo);
    });
}
