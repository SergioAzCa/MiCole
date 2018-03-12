

<!-- Copyright © 2016 Sergio Aznar Cabotá & Rodrigo Diaz & Cristina Sesé Martínez
   EMPRESA : GEOMODEL (info@geomodel.es) -->

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Visor Cartográfico</title>
    <?php include("includes/metas.php");?>
</head>
<body class="quitaPadd" style="background-color:#f0f0fe;">
	<div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
	            <h1 class="titPpal" style="text-align:left;">micolees.es</h1>
                <p class="aclaracionBuscador">Localiza tus centros de estudio mas cercanos introduciendo tu dirección y el tipo de centro que buscas. También puedes calcular los puntos que te corresponden para cada centro!</p>
                <form action="visor.php" method="POST">
                     <div class="paso-1">
                     	<h3 class="titPaso">¿Dónde vives?</h3>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Calle</span>
                            <input type="text" name="direccion" class="form-control inputAcceso" placeholder="Nombre de calle" aria-describedby="basic-addon1" autocomplete="off" required>
                        </div>
                        <div class="sugiereCalle"></div>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Portal</span>
                            <input type="text" name="portal" class="form-control inputAcceso" placeholder="Número de portal" aria-describedby="basic-addon1" autocomplete="off" required>
                        </div>
                         <h3 class="titPaso">Tipo de centro</h3>
                        <div tipo="1" class="col-md-3 col-xs-6 elemEd">
                            <div class="contElemEdu">
                                <div class="btnTipo tipoInf"></div>               
                                <h4>Infantil</h4>
                            </div>
                        </div>
                        <div tipo="2" class="col-md-3 col-xs-6 elemEd">
                            <div class="contElemEdu">
                                <div class="btnTipo tipoPrim"></div>
                                <h4>Primaria</h4>
                            </div>
                        </div>
                        <div tipo="3" class="col-md-3 col-xs-6 elemEd">
                            <div class="contElemEdu">
                                <div class="btnTipo tipoEso"></div>
                                <h4>E.S.O.</h4>
                            </div>
                        </div>
                        <div tipo="4" class="col-md-3 col-xs-6 elemEd">
                            <div class="contElemEdu">
                                 <div class="btnTipo tipoBach"></div>
                                 <h4>Bachiller</h4>
                            </div>
                        </div>
                        <div class="col-md-12 quitaPadd">
                            <div class="btn-group col-md-12 col-xs-12 quitaPadd" role="group" aria-label="..." id="btnCalcularPuntos">
                                <button class="btn btn-primary btnAcceso" paso="1" id="btnCalcular">Calcular puntos</button>
                            </div>
                            <!--<div class="btn-group  col-md-6 col-xs-6" role="group" aria-label="..." id="btnVerCentros">
                                <button type="submit" class="btn btn-primary btnAcceso">Ver centros</button>
                            </div>-->
                        </div>
                    </div>
                    <div class="paso-2 ocultaBtn">
                    	<h3 class="titPaso">Hermanos en centros escolares.</h3>
                    	<div class="descPaso">¿El alumno tiene hermanos estudiando actualmente? Introduce el centro para cada uno de ellos. <br/><strong>NOTA:</strong> se deben introducir aquellos hermanos que están estudiando hasta nivel de bachiller.</div>
                        <div class="separador"></div>
                        <div class="input_fields_wrap">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Hermano Nº1</span>
                                <input type="text" name="centrosHnos[]" elemento="1" class="form-control inputAcceso" placeholder="Centro de estudios" aria-describedby="basic-addon1" autocomplete="off">
                                <input type="hidden" name="idCentrosHnos[]" elemento="1">
                            </div>
                            <div class="sugiereCentro" elemento="1"></div>
                        </div>
                        <div class="add_field_button">Añadir Hermano</div>
                        <div class="col-md-12 quitaPadd">
                            <div class="btn-group col-md-12 col-xs-12 quitaPadd" role="group" aria-label="...">
                                <button class="btn btn-primary btnAcceso" id="btnPaso2">Siguiente</button>
                            </div>
                        </div>
                    </div>    
                    <div class="paso-3 ocultaBtn">
                    	<h3 class="titPaso">Padres que trabajan en centros escolares.</h3>
                    	<div class="descPaso">¿El alumno tiene padres trabajando en centros escolares? Introduce el centro para cada uno de ellos. <br/><strong>NOTA:</strong> si no se cumpliera la condición dejar el campo vacío.</div>
                        <div class="separador"></div>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Padre</span>
                            <input type="text" name="centrosPadres[]" elemento="1" class="form-control inputAcceso" placeholder="Centro de estudios" aria-describedby="basic-addon1" autocomplete="off">
                            <input type="hidden" name="idCentrosPadres[]" elemento="1">
                        </div>
                        <div class="sugiereCentroPadres" elemento="1"></div>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Madre</span>
                            <input type="text" name="centrosPadres[]" elemento="2" class="form-control inputAcceso" placeholder="Centro de estudios" aria-describedby="basic-addon1" autocomplete="off">
                            <input type="hidden" name="idCentrosPadres[]" elemento="2">
                        </div>
                        <div class="sugiereCentroPadres" elemento="2"></div>
                        <div class="col-md-12 quitaPadd">
                            <div class="btn-group col-md-12 col-xs-12 quitaPadd" role="group" aria-label="...">
                                <button class="btn btn-primary btnAcceso" id="btnPaso3">Siguiente</button>
                            </div>
                        </div>
                    </div>   
                    <div class="paso-4 ocultaBtn">
                    	<h3 class="titPaso">Renta anual familiar.</h3>
                    	<div class="descPaso">¿La renta anual familiar supera los 14.910,00€?</div>
                        <div class="separador"></div>
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input  name="renta" value="2" type="radio" aria-label="Radio button for following text input" checked>
                          </span>
                           <input type="text" class="form-control" value="NO" aria-describedby="basic-addon1" readonly>
                        </div>
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input name="renta" value="0" type="radio" aria-label="Radio button for following text input">
                          </span>
                          <input type="text" class="form-control" value="SI" aria-describedby="basic-addon1" readonly>
                        </div>
                        <div class="separador"></div>
                        <h3 class="titPaso">Familia numerosa</h3>
                        <div class="descPaso">¿El alumno pertenece a familia numerosa general o familia numerosa especial?</div>
                        <div class="separador"></div>
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input  name="famnum" value="0" type="radio" aria-label="Radio button for following text input" checked>
                          </span>
                           <input type="text" class="form-control" value="No es Familia Numerosa" aria-describedby="basic-addon1" readonly>
                        </div>
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input name="famnum" value="3" type="radio" aria-label="Radio button for following text input">
                          </span>
                          <input type="text" class="form-control" value="Familia Numerosa General" aria-describedby="basic-addon1" readonly>
                        </div>
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input name="famnum" value="5" type="radio" aria-label="Radio button for following text input">
                          </span>
                          <input type="text" class="form-control" value="Familia Numerosa Especial" aria-describedby="basic-addon1" readonly>
                        </div>
                        <div class="col-md-12 quitaPadd">
                            <div class="btn-group col-md-12 col-xs-12 quitaPadd" role="group" aria-label="...">
                                <button class="btn btn-primary btnAcceso" id="btnPaso4">Siguiente</button>
                            </div>
                        </div>
                    </div>
                   	<div class="paso-5 ocultaBtn">
                    	<h3 class="titPaso">Familia monoparental.</h3>
                    	<div class="descPaso">¿El alumno pertenece a una familia monoparental general o monoparental especial?<br/> <strong>NOTA:</strong> Familia monoparental de categoría especial.<br/>Caso 1 - La familia tiene 2 o más hijos.<br/>Caso 2: o bien la persona progenitora o bien un hijo/hija sea persona discapacitada o esté incapacitada para trabajar.</div>
                        <div class="separador"></div>
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input  name="monoparental" value="0" type="radio" aria-label="Radio button for following text input" checked>
                          </span>
                           <input type="text" class="form-control" value="No es Familia Monoparental" aria-describedby="basic-addon1" readonly>
                        </div>
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input  name="monoparental" value="3" type="radio" aria-label="Radio button for following text input">
                          </span>
                           <input type="text" class="form-control" value="Familia Monoparental General" aria-describedby="basic-addon1" readonly>
                        </div>
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input name="monoparental" value="5" type="radio" aria-label="Radio button for following text input">
                          </span>
                          <input type="text" class="form-control" value="Familia Monoparental Especial" aria-describedby="basic-addon1" readonly>
                        </div>
                        <div class="notaMedia"></div>
                        
                        <div class="col-md-12 quitaPadd">
                            <div class="btn-group col-md-12 col-xs-12 quitaPadd" role="group" aria-label="...">
                                <button class="btn btn-primary btnAcceso" id="btnPaso5">Siguiente</button>
                            </div>
                        </div>
                    </div>
                    <div class="paso-6 ocultaBtn">
                    	<h3 class="titPaso">Discapacidad</h3>
                    	<div class="descPaso">¿El alumno tiene alguna discapacidad?</div>
                        <div class="separador"></div>
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input  name="alumDisc" value="0" type="radio" aria-label="Radio button for following text input" checked>
                          </span>
                           <input type="text" class="form-control" value="No tiene discapacidad" aria-describedby="basic-addon1" readonly>
                        </div>
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input  name="alumDisc" value="4" type="radio" aria-label="Radio button for following text input">
                          </span>
                           <input type="text" class="form-control" value="Discapacidad entre 33% y 65%" aria-describedby="basic-addon1" readonly>
                        </div>
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input name="alumDisc" value="7" type="radio" aria-label="Radio button for following text input">
                          </span>
                          <input type="text" class="form-control" value="Discapacidad superior a 65%" aria-describedby="basic-addon1" readonly>
                        </div>
                        
                        <div class="descPaso">¿Algún miembro de la familia posee una discapacidad superior al 33%?<br/><strong>NOTA:</strong> Se considerará a un miembro de la familia computable, a padre, madre, tutor, hermano o hermana del alumno.</div>
                        <div class="separador"></div>
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1">Entre 33% y 65%</span>
                          <select class="form-control" name="discMedia">
                          	<option value="0">Sin este tipo</option>
                            <option value="3">1 Miembro</option>
                            <option value="6">2 Miembros</option>
                            <option value="9">3 Miembros</option>
                            <option value="12">4 Miembros</option>
                            <option value="15">5 Miembros</option>
                          </select>
                        </div>
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1">Superior al 65%</span>
                          <select class="form-control" name="discGrave">
                          	<option value="0">Sin este tipo</option>
                            <option value="5">1 Miembro</option>
                            <option value="10">2 Miembros</option>
                            <option value="15">3 Miembros</option>
                            <option value="20">4 Miembros</option>
                            <option value="25">5 Miembros</option>
                          </select>
                        </div>
                        <div class="col-md-12 quitaPadd">
                            <div class="btn-group col-md-12 col-xs-12 quitaPadd" role="group" aria-label="...">
                                <button type="submit" class="btn btn-primary btnAcceso" id="btnPaso6">Calcular Puntos</button>
                            </div>
                        </div>
                    </div> 
					<input type="hidden" name="tipoCentro">
                    <input type="hidden" name="idCalle">
                    <input type="hidden" name="tipoEntrada" value="calculadora"/>
                </form>
			</div>
		</div>
    </div>
	<script>
		$(document).on("keyup","input[name='centrosHnos[]']", function(){
			if ($(this).val().length > 2){
				var centro = $(this).val();
				var hno = $(this).attr("elemento");
				$.ajax({
				  method: "POST",
				  url: "sacaCentroHno.php",
				  data: { "centro": centro, "hermano": hno},
				  success:  function (response) {
					$(".sugiereCentro[elemento='"+hno+"']").html(response);
				  }
				});
			}
		});
		$(document).on("click", ".centroResultado", function(){
			var contenido = $(this).html();
			var hno = $(this).parent().attr("elemento");
			var idCentro = $(this).attr("id");
			$(".sugiereCentro").html("");
			$("input[name='centrosHnos[]'][elemento='"+hno+"']").val(contenido);
			$("input[name='idCentrosHnos[]'][elemento='"+hno+"']").val(idCentro);
		});
		
		$(document).on("keyup","input[name='centrosPadres[]']", function(){
			if ($(this).val().length > 2){
				var centro = $(this).val();
				var padre = $(this).attr("elemento");
				$.ajax({
				  method: "POST",
				  url: "sacaCentroPadre.php",
				  data: { "centro": centro, "padre": padre},
				  success:  function (response) {
					$(".sugiereCentroPadres[elemento='"+padre+"']").html(response);
				  }
				});
			}
		});
		$(document).on("click", ".centroResultadoPadre", function(){
			var contenido = $(this).html();
			var padre = $(this).parent().attr("elemento");
			var idCentro = $(this).attr("id");
			$(".sugiereCentroPadres").html("");
			$("input[name='centrosPadres[]'][elemento='"+padre+"']").val(contenido);
			$("input[name='idCentrosPadres[]'][elemento='"+padre+"']").val(idCentro);
		});
		$("input[name='direccion']").keyup(function(){
			if ($(this).val().length > 2){
				var calleVal = $(this).val();
				$.ajax({
				  method: "POST",
				  url: "sacaCalle2.php",
				  data: { calle: calleVal},
				  success:  function (response) {
					$(".sugiereCalle").html(response);
				  }
				});
			}
		});
		
		var max_fields      = 10; //maximum input boxes allowed
		var wrapper         = $(".input_fields_wrap"); //Fields wrapper
		var add_field_button      = $(".add_field_button"); //Add button ID
	   
		var x = 1; //initial text box count
		$(add_field_button).click(function(){ //on add input button click
			if(x < max_fields){ //max input box allowed
				x++; //text box increment
				$("div.remove_field").each(function(){
					if($(this).attr("elemento") != x){
						$(this).css("display", "none");
					}
				})
				$(wrapper).append('<div>'+
									'<div class="input-group">'+
										'<span class="input-group-addon" id="basic-addon1">Hermano Nº'+x+'</span>'+
										'<input type="text" name="centrosHnos[]" elemento="'+x+'" class="form-control inputAcceso" placeholder="Centro de estudios" aria-describedby="basic-addon1" autocomplete="off">'+
										'<input type="hidden" name="idCentrosHnos[]" elemento="'+x+'">'+
									'</div>'+
									'<div class="sugiereCentro" elemento="'+x+'"></div>'+
									'<div class="remove_field" elemento="'+x+'">Eliminar hermano</div>'+
								  '</div>');
			}else{
				alert("Se desean añadir demasiados valores");
			}
		});
	   
		$(wrapper).on("click",".remove_field", function(){ //user click on remove text
			$(this).parent('div').remove(); 
			x--;
			$("div.remove_field").each(function(){
				if($(this).attr("elemento") == x){
					$(this).css("display", "block");
				}
			})
		})
		$(document).on("click", ".elemResultado", function(){
			var contenido = $(this).html();
			$(".sugiereCalle").html("");
			$("input[name='direccion']").val(contenido).addClass("pinchado");
			$("input[name='idCalle']").val($(this).attr("idCalle"));
		});
		$(".elemEd").mouseover(function(){
			$(this).find("h4").addClass("activoTit");
			$(this).find("div.btnTipo").addClass("activo");
		});
		$(".elemEd").mouseout(function(){
			$(this).find("h4").removeClass("activoTit");
			$(this).find("div.btnTipo").removeClass("activo");
		});
		$(".elemEd").click(function(){
			$(".elemEd h4").removeClass("selecTit");
			$(".elemEd div.btnTipo").removeClass("seleccionado");
			$("input[name='tipoCentro']").val($(this).attr("tipo"));
			$(this).find("h4").addClass("selecTit");
			$(this).find("div.btnTipo").addClass("seleccionado");
		});
		$(".btnAcceso").click(function(e){
			if($("input[name='tipoCentro']").val()==''){
				e.preventDefault();
			}
		});
		$("#btnCalcular[paso='1']").click(function(e){
			e.preventDefault();
			var tipoError = compruebaInicio();
			if(tipoError != "ok"){
				alert(tipoError);
			}else{
				$(this).attr("paso", "2");
				$("#btnVerCentros").css("display","none");
				$(".paso-1").slideUp();
				/*Si ha pinchado bachiller se carga el código para la nota media*/
				if($(".tipoBach").hasClass("seleccionado")){
					$(".notaMedia").append('<div class="separador"></div>'+
												'<h3 class="titPaso">Nota media</h3>'+
												'<div class="descPaso">Introduce la nota media obtenida en la E.S.O. o en el Módulo de Grado Medio.</div>'+
												'<div class="separador"></div>'+
												'<div class="input-group">'+
													'<span class="input-group-addon" id="basic-addon1">Nota media</span>'+
													'<input type="text" name="media" class="form-control inputAcceso" placeholder="Introduce la nota media" aria-describedby="basic-addon1" autocomplete="off" required>'+
												'</div>');
				}
				$(".paso-2").slideDown();
			}
		});
		$("#btnPaso2").click(function(e){
			e.preventDefault();
			/*Se ha dado a "añadir hermano"*/
			/*if($("input[name='centrosHnos[]'][elemento='2']").length > 0){
				checkaHermanos();
			}*/
			$(".paso-2").slideUp();
			$(".paso-3").slideDown();
		});
		$("#btnPaso3").click(function(e){
			e.preventDefault();
			$(".paso-3").slideUp();
			$(".paso-4").slideDown();
		});
		$("#btnPaso4").click(function(e){
			e.preventDefault();
			$(".paso-4").slideUp();
			$(".paso-5").slideDown();
		});
		$("#btnPaso5").click(function(e){
			e.preventDefault();
			if($("input[name='media']").val()==''){
				alert("Debes introducir una nota media");
			}else{
				$(".paso-5").slideUp();
				$(".paso-6").slideDown();
			}
		});
		function compruebaInicio(){
			var errores =["Debes introducir una calle válida.", "Debes introducir un número de portal.", "Debes seleccionar un tipo de centro.", "ok"];
			var error;
			var centroPinchado = false;
			/*Comprueba que se ha pinchado algun centro*/
			$( "div.btnTipo" ).each(function() {
			  if($(this).hasClass("seleccionado")){
				 centroPinchado = true;
			  }
			});		
			if(!$("input[name='direccion']").hasClass("pinchado")){
				error = errores[0];
			}else if($("input[name='portal']").val()==''){
				error = errores[1]; 
			}else if(!centroPinchado){
				error = errores[2]; 
			}else{
				error = errores[3];
			}
			return error;
		}
		function checkaHermanos(){
			var vacio = false;
			/*Voy a seleccionar los campos hidden con id de centro y si hay alguno sin completar saco mensaje*/
			$("input[name='idCentrosHnos[]'").each(function() {
				if($(this).val()==''){
					vacio = true;
				}				                   
			});
			return vacio;
		}
	</script>
<!-- ANALITICS-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-77426809-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>