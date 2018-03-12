

<!-- Copyright © 2016 Sergio Aznar Cabotá & Rodrigo Diaz & Cristina Sesé Martínez
   EMPRESA : GEOMODEL (info@geomodel.es) -->

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Visor Cartográfico</title>
    <?php include("includes/metas.php");?>
</head>
<body class="quitaPadd" style="background-color:#F5DABD;">
	<div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
            	<h1 class="titPpal" style="text-align:left;">micolees.es</h1>
                <p class="aclaracionBuscador">Localiza tus centros de estudio mas cercanos introduciendo tu dirección y el tipo de centro que buscas. También puedes calcular los puntos que te corresponden para cada centro!</p>
                <h3 class="titPaso">¿Dónde vives?</h3>
                <form action="visor.php" method="POST">
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
					<input type="hidden" name="tipoCentro">
                    <input type="hidden" name="tipoEntrada" value="verCentros"/>
                    <!--<div class="btnTipo tipoInf"></div>                    
                    <div class="btnTipo tipoPrim"></div>
                    <div class="btnTipo tipoEso"></div>
                    <div class="btnTipo tipoBach"></div>-->
                    <!--<button class="btn btn-default btnAcceso" type="submit">Acceder</button>-->
                    <div class="btn-group" role="group" aria-label="...">
                        <button type="submit" class="btn btn-primary btnAcceso">Acceder</button>
                    </div>
                </form>
			</div>
		</div>
    </div>
	<script>
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
		$(document).on("click", ".elemResultado", function(){
			var contenido = $(this).html();
			$(".sugiereCalle").html("");
			$("input[name='direccion']").val(contenido);
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
				alert("Debes seleccionar un tipo de centro");
			}
		})
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