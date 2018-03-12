<?php 
include("php/config.php");
	$centro1 = $_POST['centro'];
	$encuentra   = "'";

	// N󴥳e el uso de ===. Puesto que == simple no funcionarᡣomo se espera
	// porque la posici󮠤e 'a' estᡥn el 1Р(primer) caracter.
	if(strpos($centro1, $encuentra))
    {
		$centro = str_replace( "'","/",$centro1);
		echo $centro;
	}else{
		$centro = $centro1;
		
	}
	$totalResultados = 0;
	$txtConsulta = "SELECT nombre_cen FROM centros WHERE nombre_cen ILIKE '%$centro%'";
	$resultados = pg_exec($txtConsulta);
	$numresultados = intval(pg_numrows($resultados));
	if($numresultados > 0){
		while ($resultado = pg_fetch_row($resultados)) {
			$nombreCentro = $resultado[0];
			
			/*Proceso para sacar coord X e Y y los guardas como $coordX y $coordY*/
			/*Ejemplo*/
			$extension= pg_exec("SELECT   ST_X(ST_intersection(geom, geom)), ST_Y(ST_intersection(geom, geom)) FROM (SELECT geom as geom FROM centros WHERE  nombre_cen = '$nombreCentro')AS a");
			$extension2 = pg_fetch_row($extension);
			
			//SELECT ST_AsText(the_geom) as points FROM portales

			
			
			$coordX =$extension2[0];
			$coordY = $extension2[1];
						
			$almacenaContenido .="<div class='elemResultado' x='".$coordX."' y='".$coordY."'>".$nombreCentro."</div>";
		}
	}
	
	$resultadoTotal = "
			<div class='input-group'>
				<span id='basic-addon2' class='input-group-addon'>Sugerencias</span>
					<div class='grupoResultados'>
		";
	if($numresultados == 0 && $numresultadosUrb == 0){
		$resultadoTotal.= "<div class='noSugerencias'>No se han encontrado sugerencias</div>";
	}else{
		
		
		$resultadoTotal.= $almacenaContenido;
	}
	$resultadoTotal .="</div></div>";
	echo $resultadoTotal;
?>
