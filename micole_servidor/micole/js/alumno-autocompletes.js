$("input[name='calle']").keyup(function(){
    var contenido = $(this).val();
    if(contenido.length > 2){
        $.ajax({
            url: "ajax/carga-sugerencias.php",
            type: 'POST',
            data: {
                "tipo"  : "calles",
                "valor" : contenido
            },
            cache: false,
            success: function(response) {
                $(".contSugerenciasCalles").css("display", "block");
                $("#contSugerenciasCalles").html(response).css("border", "1px solid #468ecb");
            }
        });
    }
});
$(document).on("click", "#contSugerenciasCalles>.elemSugerido", function(){
    var idCalle = $(this).attr("valor");
    var nombreCalle = $(this).attr("nombre");
    $("#contSugerenciasCalles").html('').css("border", "none");
    $(".contSugerenciasCalles").css("display", "none");
    $("input[name='calle']").val(nombreCalle);
    $("input[name='id_calle']").val(idCalle);
    $.ajax({
        url: "ajax/carga-sugerencias.php",
        type: 'POST',
        data: {
            "tipo"  : "numero",
            "valor" : idCalle,
            "numero": ''
        },
        cache: false,
        success: function(response) {
            $(".contSugerenciasNum").css("display", "block");
            $("#contSugerenciasNum").html(response).css("border", "1px solid #468ecb");
        }
    });
});
$("input[name='num_policia']").keyup(function(){
    var contenido = $(this).val();
    var idCalle = $("input[name='id_calle']").val();
    if(idCalle){
        $.ajax({
            url: "ajax/carga-sugerencias.php",
            type: 'POST',
            data: {
                "tipo"  : "numero",
                "valor" : idCalle,
                "numero": contenido
            },
            cache: false,
            success: function(response) {
                $(".contSugerenciasNum").css("display", "block");
                $("#contSugerenciasNum").html(response).css("border", "1px solid #468ecb");
            }
        });
    }else{
        alert("no tienes calle");
    }

});
$(document).on("click", "#contSugerenciasNum>.elemSugerido", function(){
    var valor = $(this).attr("valor");
    var nombreTramo = $(this).attr("tramo");
    $("#contSugerenciasNum").html('').css("border", "none");
    $(".contSugerenciasNum").css("display", "none");
    $("input[name='num_policia']").val(valor).attr("tramo", nombreTramo).trigger("change");
});
