<?php
	include("php/config.php");
	$calle = $_POST['calle'];
	$totalResultados = 0;
	$txtConsulta = "SELECT nom_via_1, id_vial FROM viales WHERE nom_via_1 ILIKE '%$calle%'";
	$resultados = pg_exec($txtConsulta);
	$numresultados = intval(pg_numrows($resultados));
	if($numresultados > 0){
		while ($resultado = pg_fetch_row($resultados)) {
			$nombreCalle = $resultado[0];
			$idCalle = $resultado[1];
			$almacenaContenido .="<div class='elemResultado' idCalle='".$idCalle."'>".$nombreCalle."</div>";
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