<?php
	include("php/config.php");
	if (isset($_POST['tipoEntrada']) && $_POST['tipoEntrada']=='verCentros'){
		$calle  = $_POST['direccion'];
		$portal = $_POST['portal'];
		$tipo   = $_POST['tipoCentro'];
		/*
			Tipo 1 = Infantil;
			Tipo 2 = Primaria;
			Tipo 3 = ESO;
			Tipo 4 = Bachiller;
		*/
	}else if (isset($_POST['tipoEntrada']) && $_POST['tipoEntrada']=='calculadora'){
		$calle = $_POST['direccion'];
		$idCalle = $_POST['idCalle'];
		$portal = $_POST['portal'];
		$tipo = $_POST['tipoCentro'];
		
		/*Encuentro el último id metido en la tabla */
		$txtConsulta = "SELECT MAX(id_alumno) FROM alumnos_a_centros";
		$resultado = pg_exec($txtConsulta);
		$resultado = pg_fetch_row($resultado);
		$idAlumno = $resultado[0] + 1;
		/*Calculo coord X e Y del portal*/
		$extension= pg_exec("SELECT   ST_X(ST_intersection(geom, geom)), ST_Y(ST_intersection(geom, geom)) FROM 
							(SELECT portales.geom FROM portales INNER JOIN viales ON viales.id_vial = portales.id_vial 
					 		WHERE portales.num_por = '$portal' AND portales.id_vial = '$idCalle')AS a");
		$extension2 = pg_fetch_row($extension);
		$coordX = $extension2[0];
		$coordY = $extension2[1];
		
		/*Calculo Distrito y area al que pertenece el portal*/
		$extension= pg_exec("select id from
							(select * from distritos_prim where ST_intersects(ST_GeomFromText('POINT($coordX $coordY)',25830), distritos_prim.geom)) as t");
		$extension2 = pg_fetch_row($extension);
		$distritoAlumno = $extension2[0];
		$select = pg_exec("SELECT distrito FROM distritos_prim WHERE id='".$distritoAlumno."'");
		$resultado = pg_fetch_row($select);
		$distritoAlumno = $resultado[0];
		
		$extension= pg_exec("select id from 
							(select * from areas_bach where ST_intersects(ST_GeomFromText('POINT($coordX $coordY)',25830), areas_bach.geom)) as t");
		$extension2 = pg_fetch_row($extension);
		$areaAlumno = $extension2[0];
		
		$select = pg_exec("SELECT id_area FROM areas_bach WHERE id='".$areaAlumno."'");
		$resultado = pg_fetch_row($select);
		$areaAlumno = $resultado[0];
		
		/*en este punto ya tengo distrito y area del alumno*/
		/*inserto en la bd al alumno*/
		$txtConsulta = pg_exec("INSERT INTO alumnos_a_areas VALUES ('".$idAlumno."', '".$areaAlumno."', '".$distritoAlumno."')");
		
		/*Centros que suman 15ptos por cada hno*/
		/*En el insert, tipo familiar 1->hermanos; tipoFamilair 2 -> padres*/
		
		$idCentrosHnos = array();
		foreach($_POST['idCentrosHnos'] as $item){
		  if($item!=''){
		      $txtConsulta = pg_exec("INSERT INTO alumnos_a_familiar VALUES ('".$idAlumno."', '".$item."', '1')");
		  }
		}
		
		/*Centros que suman 5ptos por uno o ambos padres*/
		$idCentrosPadres = array();
		foreach($_POST['idCentrosPadres'] as $item){
			if($item!=''){
			  $txtConsulta = pg_exec("INSERT INTO alumnos_a_familiar VALUES ('".$idAlumno."', '".$item."', '2')");
			}
		}
		$puntosRenta = $_POST['renta'];
		$familiaNum = $_POST['famnum'];
		$familiaMono = $_POST['monoparental'];
		$discAlumno = $_POST['alumDisc'];
		$discFamMedia = $_POST['discMedia'];
		$discFamGrave = $_POST['discGrave'];
		$media = $_POST['media'];
		
		$ptosBase = $puntosRenta + $familiaNum + $familiaMono + $discAlumno + $discFamMedia + $discFamGrave + $media;
		
			
		/*Identifico los centros para esta eleccion de formulario*/
		$select1 = pg_exec("SELECT id, area, distrit, codigo FROM buffer WHERE nivel_".$tipo." != ''");
		while ($resultado = pg_fetch_row($select1)) {
			$sumaCentro=0;
			$puntosCentro = 0;
			$sumaCentroPorHnos = 0;
			$sumaCentroPorPadres = 0;
			$idCentro = $resultado[0];
			$codCentro = $resultado[3];
			if($tipo == '3' || $tipo == '4'){
				/*Si es ESO o Bachiller*/
				$areaCentro = $resultado[1];
				$areaCentro = explode(" ", $areaCentro);
				/*Lo que suma por estar en la misma área que el alumno*/
				if($areaCentro[1] == $areaAlumno){
					$sumaCentro = 10;
				}else{
					/*En la tabla el area 1 sale en numeros romanos*/
					if($areaCentro[1]=='1'){
						$areaMete='I';
					}else{
						$areaMete=$areaCentro[1];
					}
					if($areaAlumno=='1'){
						$areaMeteAlumno='I';
					}else{
						$areaMeteAlumno=$areaAlumno;
					}
					/*Lo que suma el centro por pertenecer al perimetro del alumno*/
					$select = pg_exec("SELECT * FROM area_limita WHERE idtipo='1' AND elemento='".$areaMete."' AND limite='".$areaMeteAlumno."'");
					$numresultados = intval(pg_numrows($select));
					if($numresultados > 0){
						$sumaCentro = 5;
					}
				}
			}else{
				/*Si es infantil o primaria*/
				$distritoCentro = $resultado[2];
				$distritoCentro = explode(" ", $distritoCentro);
				/*Lo que suma por estar en el mismo distrito que el alumno*/
				if($distritoCentro[1] == $distritoAlumno){
					$sumaCentro = 10;
				}else{
					//echo "distritoCentro = ".$distritoCentro[1]." - distritoAlumno = ". $distritoAlumno;
					/*Lo que suma el centro por pertenecer al perimetro del alumno*/
					$select = pg_exec("SELECT * FROM area_limita WHERE idtipo='2' AND elemento=' ".$distritoCentro[1]."' AND limite=' ".$distritoAlumno."'");
					$numresultados = intval(pg_numrows($select));
					if($numresultados > 0){
						$sumaCentro = 5;
					}
				}
			}
			/*Lo que suma el centro por asistencia de hermanos*/
			$select = pg_exec("SELECT * FROM alumnos_a_familiar WHERE id_tipo_familiar='1' AND id_alumno='".$idAlumno."' AND id_centro='".$codCentro."'");
			$numresultados = intval(pg_numrows($select));
			if($numresultados > 0){
				$sumaCentroPorHnos = $numresultados*15;
			}
			
			/*Lo que suma el centro por padres que trabajan*/
			$select = pg_exec("SELECT * FROM alumnos_a_familiar WHERE id_tipo_familiar='2' AND id_alumno='".$idAlumno."' AND id_centro='".$codCentro."'");
			$numresultados = intval(pg_numrows($select));
			if($numresultados > 0){
				$sumaCentroPorPadres = 5;
			}
			
			/*Calculo puntos finales y los inserto en la bd*/
			$puntosCentro = $sumaCentro + $sumaCentroPorHnos + $sumaCentroPorPadres + $ptosBase;
			$select = pg_exec("INSERT INTO alumnos_a_centros VALUES('".$idAlumno."', '".$idCentro."', '".$puntosCentro."', '".$codCentro."')");
		}
	}
?>
<!-- Copyright © 2016 Sergio Aznar Cabotá & Rodrigo Diaz & Cristina Sesé Martínez
   EMPRESA : GEOMODEL (info@geomodel.es) -->

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<title>Visor Cartográfico</title>
    <?php include("includes/metas.php");?>
</head>
<body class="quitaPadd">
<div style="height: 100%; display: block;" id="loader">
    <div style="display: block;" id="loader-container">
        <div class="loader-spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
        <div class="txtLoader">Cargando visor cartográfico...</div>
    </div>
</div>
<div class="container">
	<?php include("includes/header.php");?>
	
	<div class="row">
		<div class="contDesplegaHerr">
			<div class="contenidoDesplegaHerr contDesplegaHerrActivo"></div>
		</div>
		<div class="contDesplegableHerr">
			<div class="btnTools"></div>
			<div class="btnTools btnZoomExtension"></div>
            <div class="btnTools btnZoomIn"></div>
            <div class="btnTools btnZoomOut"></div>
            <div class="btnTools btnZoomCaja"></div>
            <!--<div class="btnTools btnInfo"></div>-->
            
		</div>
		
		<!-- empieza mapa -->

		
		<div class="col-md-9 col-sm-8 col-xs-12 contMapa map quitaPadd" id="map">
            <div  id="divmapa" class="divmapa"></div>
            <div class="leyendaMvl">
                <div class="contElemLeyenda"><div class="imgElemLeyendaMvl imgElemLeyendaPublico"></div>Público</div>
                <div class="contElemLeyenda"><div class="imgElemLeyendaMvl imgElemLeyendaConcertado"></div>Concertado</div>
            </div>
            <!--<div id='street-view'></div>
            <div class='btnCerrarStreet'></div>
            <div id='elevation_chart'></div>
            <div class='btnCerrarPerfil'></div>-->
			<div id="to-top" class="icon-animation topdisplay">
                <a href="#">
                	<i class="fa fa-angle-down"></i>
                </a>
            </div>
            
        </div>
		
		<div id="popup" class="ol-popup">
        	<div class="ol-popup-closer" id="popup-closer"><span>x</span></div>
			<div id="popup-content">
            	
                <!-- <div class="loader" id="cargaSpinner"></div>-->
                <!--No hay información disponible para el elemento seleccionado.-->
               
            </div>
		
			
		</div>
		<!-- quita Rodri -->
        <!--<div  id="divmapa" class="divmapa"></div>-->
		<!--Rodri -->
		<!-- codigo que tiene que tener el popup para que funcione el boton imprimir -->
		<!-- <div class="btnImprimirPopUp" style="background-color:red; position:absolute; left:50px; cursor:pointer; width:120px;top:30px;text-align:center;">Imprimir en pop-up</div> -->
		<!-- fin de codigo para imprimir en popup -->


		<!-- acaba mapa -->

		<!-- empieza barra info -->
		<!-- DPI <div id='testdiv' style='height: 1in; left: -100%; position: absolute; top: -100%; width: 1in;'></div> -->
		<div id="layertree" class="span6">
			<div class="col-md-3 col-sm-4 col-xs-12 contBarra">
				<div class="contenidoDer">
					<div class="contPestanyas">
						<div class="pestanya pestanyaActiva col-md-4 col-xs-4 quitaMargin quitaPadd" id="act_1">
							<div class="iconoPestanya iconoCapas"></div>
								Capas
						</div>
						<div class="pestanya pestanyaCentral col-md-4 col-xs-4 quitaMargin quitaPadd" id="act_2">
							<div class="iconoPestanya iconoBuscador"></div>
							Buscar
						</div>
						<div class="pestanya col-md-4 col-xs-4 quitaMargin quitaPadd" id="act_3">
							<div class="iconoPestanya iconoContacto"></div>
							Contacto
						</div>
					</div>
					<div class="elemDerecha">
						<div class="contCapas act_1">
							<ul class="listaPpal">
								<li>Capas Base</li>
								<ul class="subLista listaDespl">
									<li id="capa_0" class="capa capaActiva">Capa base  [Bing Maps]</li>
									<li id="capa_10" class="capa">Ortofoto Aérea  [IGN] </li>
									<li id="capa_11" class="capa">Áreas influencia Distritos Primaria y E.D Infantil</li>
									<li id="capa_12" class="capa">Áreas influencia Distritos ESO y Bachiller</li>
								</ul>
								<li>Tipos de centros</li>
								<ul  class="subLista listaCapasPers">
	                                <li id="capa_20" class="capa ">
	                                	<span>Todos los centros</span>
	                                </li>
	                                <div id="layer20" class="barraTransparencia">
	                                	<input class="opacity" type="range" min="0" max="1" step="0.01"/>
	                                </div>
									<li id="capa_21" class="capa">
										<span>Centros Infantil</span>
									</li>
	                                <div id="layer21" class="barraTransparencia">
	                                	<input class="opacity" type="range" min="0" max="1" step="0.01"/>
	                                </div>
									<li id="capa_22" class="capa">
	                                	<span>Centros Primaria</span>
	                                </li>
	                                <div id="layer22" class="barraTransparencia">
	                                	<input class="opacity" type="range" min="0" max="1" step="0.01"/>
	                                </div>
									
									<li id="capa_23" class="capa">
	                                	<span>Centros Secundaria (ESO)</span>
	                                </li>
	                                <div id="layer23" class="barraTransparencia">
	                                	<input class="opacity" type="range" min="0" max="1" step="0.01"/>
	                                </div>
									<li id="capa_24" class="capa">
	                                	<span>Centros Bachillerato</span>
	                                </li>
	                                <div id="layer24" class="barraTransparencia">
	                                	<input class="opacity" type="range" min="0" max="1" step="0.01"/>
	                                </div>
								</ul>
							</ul>
	                        <div class="leyenda col-md-12">
                            	<div class="titLeyenda">Leyenda</div>
                                <div class="elemLeyenda">
									<div class="col-md-6 col-xs-6 quitaPadd">
                                        <div class="imgLeyenda">
                                            <img style="position:relative; left:3px;" src="http://geomodel.xpress.es:8080/geoserver/ows?service=WMS&request=GetLegendGraphic&format=image%2Fpng&width=20&height=20&layer=colegios%3Abusqueda_areas_bach">
                                        </div>
                                        <div class="txtElemLeyenda">Área de Influencia [Propia]</div>
                                    </div>
									<div class="col-md-6 col-xs-6 quitaPadd">
                                        <div class="imgLeyenda">
                                            <img style="position:relative; left:3px;" src="http://geomodel.xpress.es:8080/geoserver/ows?service=WMS&request=GetLegendGraphic&format=image%2Fpng&width=20&height=20&layer=colegios%3Acentros">
                                        </div>
                                       	<div class="txtElemLeyenda">Centros</div>
                                    </div>
                                    
                                </div>
                            
                            </div>
							<?php include("includes/logosFooter.php");?>
						</div>
						<div class="contBuscador act_2">
							<div class="accordion">
							    <div class="accordion-section">
							        <a class="accordion-section-title active col-md-12 col-xs-12" href="#accordion-1">Buscador por calles</a>
							        <div id="accordion-1" class="accordion-section-content open">
							             <!--AJAX Rodri-->
                                         <div class="input-group input-group2">
                                            <span class="input-group-addon" id="basic-addon2">Calle</span>
                                            <input type="text" id="input" name="direccion1" class="form-control inputAcceso" placeholder="Nombre de calle" aria-describedby="basic-addon2" autocomplete="off" required>
                                        </div>
                                        <div class="sugiereCalle"></div>
                                        <div class="input-group input-group2">
                                            <span class="input-group-addon" id="basic-addon2">Portal</span>
                                            <input type="text" name="portal" id="portal" class="form-control inputAcceso" placeholder="Número de portal" aria-describedby="basic-addon2" autocomplete="off" required>
                                        </div>
                                        
                                        <!--AJAX Sergio
                                        <div class="col-md-12 col-xs-12 elemBuscador">
											Nombre de la Calle: <input type="text" id="input" name="campo" onkeyup="javascript:autocompletar('lista',this.value);" required>
											<div class="col-md-12 col-xs-12 elemBuscador quitaPadd">
											Sugerencias:
											<div id="lista" class="divResultados resultadosCalles"></div>
											</div>
											Portal: <input type="text" id="portal" name="campo"  required>

										</div>-->
										<div class="col-md-6 col-md-offset-3 col-xs-8 col-xs-offset-2 elemBuscador">
											<button type="submit" onclick="funcionBuscar();" id="anadirBusqueda">Buscar</button>
										</div>
							        </div>
							    </div>
 								<div class="accordion-section">
							        <a class="accordion-section-title col-md-12 col-xs-12" href="#accordion-2">Buscador por centro</a>
							        <div id="accordion-2" class="accordion-section-content open">
							        	
                                        <!--AJAX Rodri-->
                                        <div class="input-group input-group2">
                                            <span class="input-group-addon" id="basic-addon2">Centro</span>
                                            <input type="text" id="input2" x='' y='' name="campo" class="form-control inputAcceso" placeholder="Nombre del centro" aria-describedby="basic-addon1" autocomplete="off" required>
                                        </div> 
                                        <div class="sugiereCentro"></div> 
                                        
                                        
                                        
                                        
                                        
                                        <!--AJAX Sergio
                                        <div class="col-md-12 col-xs-12 elemBuscador">
											Nombre Centro: <input type="text" id="input2" name="campo" onkeyup="javascript:autocompletar2('lista2',this.value);" required>
											<div class="col-md-12 col-xs-12 elemBuscador quitaPadd">
											Sugerencias:
											<div id="lista2" class="divResultados resultadosCalles"></div>
											</div>
											</div>-->
										<div class="col-md-6 col-md-offset-3 col-xs-8 col-xs-offset-2 elemBuscador">
											<button type="submit" onclick="funcionBuscar_centro();" id="anadirBusqueda">Buscar</button>
										</div>
							        </div>
							    </div>
							</div>
							<!--<div class="accordion">
							    <div class="accordion-section">
							        <a class="accordion-section-title active col-md-12 col-xs-12" href="#accordion-1">Buscador por centro</a>
							        <div id="accordion-1" class="accordion-section-content open">
							            <div class="col-md-12 col-xs-12 elemBuscador">
											Nombre Centro: <input type="text" id="input2" name="campo" onkeyup="javascript:autocompletar2('lista2',this.value);" required>
											<div class="col-md-12 col-xs-12 elemBuscador">
											Sugerencias:
											<div id="lista2" class="divResultados resultadosCalles"></div>
											</div>
											</div>
										<div class="col-md-6 col-md-offset-3 col-xs-8 col-xs-offset-2 elemBuscador">
											<button type="submit" onclick="funcionBuscar_centro();" id="anadirBusqueda">Buscar</button>
										</div>
										

							        </div>
							    </div>


							  
							</div>-->
						<?php include("includes/logosFooter.php");?>
						</div>
						
						<div class="contContacto act_3">
							<div class="tituloContacto">Contacta con nosotros</div>
							<!-- <div class="txtContacto">Con este formulario puedes contactar con los administradores del visor para notificar dudas o sugerencias relacionadas con la información representada.</div> -->
						<div>
							<form action="php/mail.php" method="post">
								<!--<span class="input input--kuro">
									<input class="input__field input__field--kuro" type="text" autocomplete="off" id="input-7" name="nombre" required/>
									<label class="input__label input__label--kuro" for="input-7">
										<span class="input__label-content input__label-content--kuro">Nombre</span>
									</label>
								</span>
								<span class="input input--kuro">
									<input class="input__field input__field--kuro" type="text" autocomplete="off" id="input-8" name="apellidos" required/>
									<label class="input__label input__label--kuro" for="input-8">
										<span class="input__label-content input__label-content--kuro">Apellidos</span>
									</label>
								</span>-->
								<span class="input input--kuro">
									<input class="input__field input__field--kuro" type="email" autocomplete="off" id="input-9" name="email" required />
									<label class="input__label input__label--kuro" for="input-9">
										<span class="input__label-content input__label-content--kuro">Correo Electrónico</span>
									</label>
								</span>
								<!-- <div class="elemContacto col-md-12">Mensaje:</div> -->
								<textarea name="mensaje" placeholder="Escriba su mensaje..." required></textarea>

								<div>
									<input type="checkbox" required> Acepto la <strong><a target="_blank" href="aviso-legal.php">Política de privacidad.</a></strong>
								</div>
								<div class="col-md-6 col-md-offset-3 col-xs-6 col-xs-offset-3">
                                	<button type="submit" id="btnEnviarContacto">Enviar</button>
                                </div>
								<!--<section id="btn-click">
									<p>
										<button class="btn btn-7 btn-7h icon-envelope">Enviar</button>
									</p>
								</section>-->
							</form>
						</div>
						<?php include("includes/logosFooter.php");?>
						</div>	
					</div>
				</div>
			</div>
			<!-- acaba barra info -->
		
	<!--<div class="logoGeomodel">
		<img src="img/geomodel-footer.png" width="170">
	</div>-->
</div>

<div class="mensaje mensajeEnviado">El mensaje se ha enviado correctamente. Gracias por contactar con nosotros, en breves recibirá una respuesta.</div>
<div class="mensaje mensajeNoEnviado">El mensaje no se ha enviado. Inténtelo de nuevo más tarde o escríbanos a info@geomodel.es</div>

<div class="ocultaBtn">
    <ul>
      <li><span>Open Street Maps</span><br>
        <fieldset class="ocultaBtn" id="layer0">
          <label class="checkbox" for="visible0">
            <input id="visible0" class="visible capa_0" type="checkbox"/>Activa
          </label>
        </fieldset>
      </li>
      <li><span>Plan Nacional de Ortofotos Aereas</span><br>
        <fieldset class="ocultaBtn" id="layer10">
          <label class="checkbox" for="visible10">
            <input id="visible10" class="visible capa_10" type="checkbox"/>Activa
          </label>
        </fieldset>
      </li>
	  <li><span>Área de influencia Distritos</span><br>
        <fieldset class="ocultaBtn" id="layer11">
          <label class="checkbox" for="visible11">
            <input id="visible11" class="visible capa_11" type="checkbox"/>Activa
          </label>
        </fieldset>
      </li>
	  <li><span>Área de influencia Distritos</span><br>
        <fieldset class="ocultaBtn" id="layer12">
          <label class="checkbox" for="visible12">
            <input id="visible12" class="visible capa_12" type="checkbox"/>Activa
          </label>
        </fieldset>
      </li>
    </ul>			
    <ul>
        <span>Centros Escolares</span>	
        <ul>
          <li><span>Centros</span>
            <img src="http://geomodel.xpress.es:8080/geoserver/ows?service=WMS&request=GetLegendGraphic&format=image%2Fpng&width=20&height=20&layer=colegios%3centros_infantil">	
            <fieldset class="ocultaBtn" id="layer20"> <!-- Como esta dentro de la capa madre es 10  el primer valor i y el segundo j -->
              <label class="checkbox" for="visible20">
                <input id="visible20" class="visible capa_20" type="checkbox"/>Activa
              </label>
              <label>Transparencia</label>
             <!-- <input class="opacity" type="range" min="0" max="1" step="0.01"/>-->
            </fieldset>
          </li>
          <li><span>Centros Infantiles</span>
          <img src="http://geomodel.xpress.es:8080/geoserver/ows?service=WMS&request=GetLegendGraphic&format=image%2Fpng&width=20&height=20&layer=colegios%3centros_infantil">
            <fieldset id="layer21">
              <label class="checkbox" for="visible21">
                <input id="visible21" class="visible capa_21" type="checkbox"/>Activa
              </label>
              <label>Transparencia</label>
              <!--<input class="opacity" type="range" min="0" max="1" step="0.01"/>-->
            </fieldset>
          </li>
		  <li><span>Centros Primaria</span>
          <img src="http://geomodel.xpress.es:8080/geoserver/ows?service=WMS&request=GetLegendGraphic&format=image%2Fpng&width=20&height=20&layer=colegios%3centros_primaria">
            <fieldset id="layer22">
              <label class="checkbox" for="visible22">
                <input id="visible22" class="visible capa_22" type="checkbox"/>Activa
              </label>
              <label>Transparencia</label>
              <!--<input class="opacity" type="range" min="0" max="1" step="0.01"/>-->
            </fieldset>
          </li>
		  
		  <li><span>Centros Secundaria (ESO)</span>
          <img src="http://geomodel.xpress.es:8080/geoserver/ows?service=WMS&request=GetLegendGraphic&format=image%2Fpng&width=20&height=20&layer=colegios%3centros_eso">
            <fieldset id="layer23">
              <label class="checkbox" for="visible23">
                <input id="visible23" class="visible capa_23" type="checkbox"/>Activa
              </label>
              <label>Transparencia</label>
              <!--<input class="opacity" type="range" min="0" max="1" step="0.01"/>-->
            </fieldset>
          </li>
			<li><span>Centros Bachillerato</span>
          <img src="http://geomodel.xpress.es:8080/geoserver/ows?service=WMS&request=GetLegendGraphic&format=image%2Fpng&width=20&height=20&layer=colegios%3centros_bachiller">
            <fieldset id="layer24">
              <label class="checkbox" for="visible24">
                <input id="visible24" class="visible capa_24" type="checkbox"/>Activa
              </label>
              <label>Transparencia</label>
              <!--<input class="opacity" type="range" min="0" max="1" step="0.01"/>-->
            </fieldset>
          </li>
		  
        </ul>
    </ul>
</div>




<script src="v3.15.1-dist/ol-debug.js"> </script>
<script type="text/javascript" src="js/GEOMODEL.js"> </script>
			
<div class="infoComp ocultaBtn">
	<div class="contMapaInfo">
		<div class ="row">
			<div class="ejemplo">
				<button type="submit" onclick="funcionBuscar();"id="anadirBusqueda">Buscar</button>
				<!--<button  onclick="zoom_objeto();">Zoom</button><br />-->
		 	</div>
		</div>
		<input type="text" id="input" name="campo" onkeyup="javascript:autocompletar('lista',this.value);" />
		<span id="reloj"><img src='image.gif'/></span>
		<div id="lista"></div>
	</div>

</div>

	<input id="info" type="hidden"></input>
	<input id="Getfeatureinfo" type="hidden" >
	<input id="capa" type="hidden" ></input>
	<div id="pano"></div>
	<input id="referencia_dato" name="referencia_dato" type="hidden" >
	<input id="x" hidden="true">
	<input id="y" hidden="true">
	<input id="dist" type="hidden"></input>
	<input id="tipoCole" type="hidden" value="<?php echo $tipo;?>"></input>
	<input id="calle" type="hidden" value="<?php echo $calle;?>"></input>
	<input id="portal2" type="hidden" value="<?php echo $portal;?>"></input>
	<input id="usuario" type="hidden" value="<?php echo $idAlumno;?>"></input>
    <input id="identificadorCalle" type="hidden" value="<?php echo $idCalle;?>"></input>
<script src="js/classie.js"></script>
<script>
	(function() {
		// trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
		if (!String.prototype.trim) {
			(function() {
				// Make sure we trim BOM and NBSP
				var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
				String.prototype.trim = function() {
					return this.replace(rtrim, '');
				};
			})();
		}
	
		[].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
			// in case the input is already filled..
			if( inputEl.value.trim() !== '' ) {
				classie.add( inputEl.parentNode, 'input--filled' );
			}
	
			// events:
			inputEl.addEventListener( 'focus', onInputFocus );
			inputEl.addEventListener( 'blur', onInputBlur );
		} );
	
		function onInputFocus( ev ) {
			classie.add( ev.target.parentNode, 'input--filled' );
		}
	
		function onInputBlur( ev ) {
			if( ev.target.value.trim() === '' ) {
				classie.remove( ev.target.parentNode, 'input--filled' );
			}
		}
	})();
</script>



<script type="text/javascript">
	$("input[name='direccion1']").keyup(function(){
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
	$(document).on("click", ".sugiereCalle .elemResultado", function(){
		var contenido = $(this).html();
		$(".sugiereCalle").html("");
		$("input[name='direccion1']").val(contenido);
	});
	
	
	$("input#input2").keyup(function(){
		if ($(this).val().length > 2){
			var centroVal = $(this).val();
			$.ajax({
			  method: "POST",
			  url: "sacaCentro.php",
			  data: { centro: centroVal},
			  success:  function (response) {
				$(".sugiereCentro").html(response);
			  }
			});
		}
	});
	$(document).on("click", ".sugiereCentro .elemResultado", function(){
		var contenido = $(this).html();
		var coordX = $(this).attr("x");
		var coordY = $(this).attr("y");
		$(".sugiereCentro").html("");
		$("input#input2").val(contenido);
		$("input#input2").attr("x", coordX);
		$("input#input2").attr("y", coordY);
	});

	function dibujaLeyenda(){
        /*txtCont = '';
                txtCont = txtCont + '<div class="elemLeyenda"><div class="txtElemLeyenda">Curvas Is�fonas dB (A)</div><div class="imgLeyenda"><img style="position:relative; left:15px;" src="http://geomodel.xpress.es:8080/geoserver/ows?service=WMS&request=GetLegendGraphic&format=image%2Fpng&width=20&height=20&layer=pam_sagunto%3Ainvierno_dia"></div></div>';
		
       		$(".leyenda").html('<div class="titLeyenda">Leyenda</div>'+txtCont);*/
            $(".leyenda").css('display','block');
        }
	function validaForm() {
        var escala = $("#escala").val();
		var titulo = $("#im-titulo").val();
		var autor = $("#im-autor").val();
		if(escala == 0 || titulo == ""||autor == ""){
			alert ("Faltan valores por especificar.");
			return false;
		}
    }
	$(window).load(function(){
		
		<?php if(isset($_GET['mensaje']) && $_GET['mensaje']=='enviado'){?>
			$(".mensajeEnviado").slideDown(1500, function(){
				setTimeout(function(){
				  $(".mensajeEnviado").slideUp(1500);
				}, 4000);
			});
		<?php }else if(isset($_GET['mensaje']) && $_GET['mensaje']=='incorrecto'){?>
			$(".mensajeNoEnviado").slideDown(1500, function(){
				setTimeout(function(){
				  $(".mensajeNoEnviado").slideUp(1500);
				}, 4000);
			});
		<?php }?>
	});
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
<div id='testdiv' style='height: 1in; left: -100%; position: absolute; top: -100%; width: 1in;'></div>
</body>
</html>