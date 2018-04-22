<?php
/*
Página encarada de cargar los datos del cliente e insertarlos en el formulario de la página que la llama
*/
$datosCliente = $bd->query("SELECT clientes.id_idioma, clientes.nombre, clientes.apellidos, clientes.telefono, clientes.telefono2, clientes.email, clientes.nombre_fiscal, clientes.nif, clientes.nif_intracomunitario, clientes.direccion_fiscal, clientes.newsletter, clientes.provincia_fiscal, clientes.poblacion_fiscal, clientes.cp_fiscal, clientes.pais_fiscal, clientes.lat, clientes.lng, datos_comercio.whatsapp, datos_comercio.facebook, datos_comercio.twitter, datos_comercio.linkedin, datos_comercio.google_plus, datos_comercio.instagram, datos_comercio.youtube, datos_comercio.alias FROM clientes INNER JOIN datos_comercio ON clientes.id_cliente=datos_comercio.id_cliente WHERE clientes.id_cliente='".$_SESSION['id_cliente'] ."'");
$datosCliente = $datosCliente->fetch_array();
echo '
<script>
	$("#idiomaDefecto").val("'.$datosCliente['id_idioma'].'");
	$("#nombre").val("'.$datosCliente['nombre'].' '.$datosCliente['apellidos'].'");
	$("#telefono").val("'.$datosCliente['telefono'].'");
	$("#telefono2").val("'.$datosCliente['telefono2'].'");
	$("#email").val("'.$datosCliente['email'].'");
	$("#nom_fiscal").val("'.$datosCliente['nombre_fiscal'].'");
	$("#nif").val("'.$datosCliente['nif'].'");
	$("#iva_intracom").val("'.$datosCliente['nif_intracomunitario'].'");
	$("#autocomplete").val("'.$datosCliente['direccion_fiscal'].'");
	if($("#autocomplete").val()!= ""){
		$(".apareceOculto").slideDown();
	}
	if("'.$datosCliente['newsletter'].'" == "T"){
		$("#newsletter").prop("checked", true);
	}
	
	$("#administrative_area_level_2").val("'.$datosCliente['provincia_fiscal'].'");
	$("#locality").val("'.$datosCliente['poblacion_fiscal'].'");
	$("#postal_code").val("'.$datosCliente['cp_fiscal'].'");
	$("#country").val("'.$datosCliente['pais_fiscal'].'");
	$("#latitud").val('.$datosCliente['lat'].');
	$("#longitud").val('.$datosCliente['lng'].');
	
	$("#alias").val("'.$datosCliente['alias'].'");
		
	
		
	$("input[type=text],input[type=email]").each(function(){
		if($(this).val() != ""){
			$(this).parent().addClass("input--filled");
		}
	})
	$(window).load(function(){
		setTimeout("marcaUbicacion()",2000);
	});
</script>';

?>	