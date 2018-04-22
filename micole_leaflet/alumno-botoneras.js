/*function activaInputs(){
  $("input[type='text']").prop('disabled', false);
  $("input[type='number']").prop('disabled', false);
  $("select").prop('disabled', false);
}
function desactivaInputs(){
  $("input[type='text']").prop('disabled', true);
  $("select").prop('disabled', true);
  $("input[type='number']").prop('disabled', true);
}*/


$(document).ready(function(){
    //Inputs y selects desactivados hasta que no activa nivel+modalidad+idiomas
    /*if($("input[name='idioma']").val() == ''){
      desactivaInputs();
    }else{
      activaInputs();
    }
    $(document).on("change", "input[name='idioma']",function(e){
      alert("kk");
      if($(this).val() == ''){
        desactivaInputs();
      }else{
        alert("kk");
        activaInputs();
      }
    });
    $("input[name='idioma']").change(function(){

      if($(this).val() == ''){
        desactivaInputs();
      }else{
        alert("kk");
        activaInputs();
      }
    });*/


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
            var url_geoserver = 'http://54.38.180.7:8080/geoserver/wms?';
            var map_alumno = L.map('map', {
                crs: L.CRS.EPSG3857
            }).setView([jsonData[0]['latitud'], jsonData[0]['longitud']], 14);
            //CAPA BASE
            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
              maxZoom: 18,
              id: 'mapbox.streets'
            }).addTo(map_alumno);
            //LOCALIZACION DEL CENTRO
            var datos_localizacion_centro = 'id_vial:'+jsonData[0]['id_vial']+';num_policia:'+jsonData[0]['num_poli'];
            var localizacion_centro = L.tileLayer.wms(url_geoserver,{
                        layers: 'colegios:localizacion_centro',
            						viewparams:[datos_localizacion_centro],
                        format: 'image/png',
                        transparent: true,
                        }).addTo(map_alumno);
            localizacion_centro.setZIndex(2);


        }
    });



    // Pincha sobre una imagen de nivel
    $(".contNivel > .nivel").click(function(){
        //Cogemos el id de la imagen que nos marca el id del nivel pinchado
        var idNivel = $(this).attr("id");
        idNivel= idNivel.split("_");
        idNivel=idNivel[1];
        $.ajax({
            url: "ajax/carga-modalidades.php",
            type: 'POST',
            data: {
                "carga"  : "modalidades",
                "nivel"  : idNivel
            },
            cache: false,
            success: function(response) {
                var jsonData = JSON.parse(response);
                if(jsonData.length>0){
                    //pincha en uno que tiene

                    //limpiar contenedores de idiomas
                    $(".contElemsIdioma").html('');
                    //limpiar inputs de modalidades e idiomas
                    $("input[name='modalidad']").val('');
                    $("input[name='idioma']").val('');

                    //funcion para limpiar los niveles seleccionados
                    limpiaIconosNiveles();

                    //Cojo el nombre de la imagen de fondo
                    var img_fondo = $("div#nvl_"+idNivel).css("background-image");
                    img_fondo = img_fondo.split("_");
                    var largo = img_fondo.length;
                    img_fondo = img_fondo[largo-2]+"_act.png";
                    $("div#nvl_"+idNivel).css("background-image", img_fondo);

                    //Si es bachiller agrega el input
                    if(idNivel == 4){
                        //Si es bachiller agrega el contenido de la nota media
                        var txtAgregaInput = '<div class="form-group">'+
                                            '<label class="col-sm-4 control-label">Media ESO/FP</label>'+
                                            '<div class="col-sm-6">'+
                                                '<input class="form-control" name="param_10" autocomplete="off" type="number" min="1" max="10" value="5" step="1">'+
                                            '</div>'+
                                        '</div>';
                        $(".contMedia").html(txtAgregaInput);
                    }else{
                        $(".contMedia").html('');
                    }

                    var txtAgrega = "<div class='form-group'><div class='col-sm-offset-2 col-sm-8'>";
                    var ancho = Math.floor(100/jsonData.length);
                    for(var i=0; i<jsonData.length; i++){
                        var id_modalidad = jsonData[i]['id_mod'];
                        var nombre_modalidad = jsonData[i]['nombre'];
                        var imagen = jsonData[i]['img'];
                        var disponibilidad = jsonData[i]['disponible'];
                        switch(disponibilidad){
                            case true:
                                var anexo = "_des.png";
                                var cursor = "pointer";
                                var claseMod= "modalidadDisp";
                                break;
                            case false:
                                var anexo = "_inac.png";
                                var cursor = "no-drop";
                                var claseMod= "modalidadNoDisp";
                                break;
                        }
                        var nombreImg = "img/modalidades/"+imagen+anexo;
                        txtAgrega +="<div class='contModalidad'>"+
                            "<div class='modalidad "+claseMod+"' id='mod_"+id_modalidad+"' style='cursor:"+cursor+"; background-image:url(\""+nombreImg+"\")';></div>"+
                            "<div class='nomModalidad'>"+nombre_modalidad+"</div>"+
                        "</div>";
                    }
                    txtAgrega +="</div></div>";
                    $(".contElemsModalidad").html(txtAgrega);
                    $("input[name='nivel']").val(idNivel);
                    $(".contModalidad").css("width", ancho+"%");
                }
            }
        });
    });
    //pincha sobre una imagen de modalidad
    $(document).on("click", ".contModalidad > .modalidad", function(){
        //Cogemos el id de la imagen que nos marca el id de la modalidad pinchada
        var idMod = $(this).attr("id");
        idMod= idMod.split("_");
        idMod=idMod[1];
        $.ajax({
            url: "ajax/carga-modalidades.php",
            type: 'POST',
            data: {
                "carga"  : "idiomas",
                "modalidad"  : idMod
            },
            cache: false,
            success: function(response) {
                var jsonData = JSON.parse(response);
                if(jsonData.length>0){
                    //pincha en uno que tiene

                    //funcion para limpiar los niveles seleccionados
                    limpiaIconosModalidades();

                    //limpiar inputs de idiomas
                    $("input[name='idioma']").val('');

                    //Cojo el nombre de la imagen de fondo
                    var img_fondo = $("div#mod_"+idMod).css("background-image");
                    img_fondo = img_fondo.split("_");
                    var largo = img_fondo.length;
                    img_fondo = img_fondo[largo-2]+"_act.png";
                    $("div#mod_"+idMod).css("background-image", img_fondo);

                    var txtAgrega = "<div class='form-group'><div class='col-sm-offset-2 col-sm-8'>";
                    var ancho = Math.floor(100/jsonData.length);
                    for(var i=0; i<jsonData.length; i++){
                        var id_idioma = jsonData[i]['id_idioma'];
                        var nombre_idioma = jsonData[i]['nombre'];
                        var imagen = jsonData[i]['img'];
                        var disponibilidad = jsonData[i]['disponible'];
                        switch(disponibilidad){
                            case true:
                                var anexo = "_des.png";
                                var cursor = "pointer";
                                var claseIdioma= "idiomaDisp";
                                break;
                            case false:
                                var anexo = "_inac.png";
                                var cursor = "no-drop";
                                var claseIdioma= "idiomaNoDisp";
                                break;
                        }
                        var nombreImg = "img/idiomas/"+imagen+anexo;
                        txtAgrega +="<div class='contIdioma'>"+
                            "<div class='idioma "+claseIdioma+"' id='lng_"+id_idioma+"' style='cursor:"+cursor+"; background-image:url(\""+nombreImg+"\")';></div>"+
                            "<div class='nomIdioma'>"+nombre_idioma+"</div>"+
                        "</div>";
                    }
                    txtAgrega +="</div></div>";
                    $(".contElemsIdioma").html(txtAgrega);
                    $("input[name='modalidad']").val(idMod);
                    $(".contIdioma").css("width", ancho+"%");
                }
            }
        });
    });
    //pincha sobre una imagen de idioma
    $(document).on("click", ".contIdioma > .idioma", function(){
        //Cogemos el id de la imagen que nos marca el id del idioma pinchado
        var idLng = $(this).attr("id");
        idLng= idLng.split("_");
        idLng=idLng[1];
        var idMod = $("input[name='modalidad']").val();
        var idNvl = $("input[name='nivel']").val();
        $.ajax({
            url: "ajax/carga-modalidades.php",
            type: 'POST',
            data: {
                "comprueba"  : "seleccion",
                "idioma"     : idLng,
                "modalidad"  : idMod,
                "nivel"      : idNvl
            },
            cache: false,
            success: function(response) {
                if(response == 'T'){
                    //funcion para limpiar los lenguajes seleccionados
                    limpiaIconosIdiomas();

                    //Cojo el nombre de la imagen de fondo
                    var img_fondo = $("div#lng_"+idLng).css("background-image");
                    img_fondo = img_fondo.split("_");
                    var largo = img_fondo.length;
                    img_fondo = img_fondo[largo-2]+"_act.png";
                    $("div#lng_"+idLng).css("background-image", img_fondo);

                    $("input[name='idioma']").val(idLng);
                }
            }
        });
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
function limpiaIconosModalidades(){
    $(".modalidadDisp").each(function(){
        var img_fondo = $(this).css("background-image");
        img_fondo = img_fondo.split("_");
        var largo = img_fondo.length;
        img_fondo = img_fondo[largo-2]+"_des.png";
        $(this).css("background-image", img_fondo);
    });
}
function limpiaIconosIdiomas(){
    $(".idiomaDisp").each(function(){
        var img_fondo = $(this).css("background-image");
        img_fondo = img_fondo.split("_");
        var largo = img_fondo.length;
        img_fondo = img_fondo[largo-2]+"_des.png";
        $(this).css("background-image", img_fondo);
    });
}
