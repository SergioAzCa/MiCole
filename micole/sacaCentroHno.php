<?php 
include("php/config.php");
	$centro1 = $_POST['centro'];
	$hermano = $_POST['hermano'];
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
	$txtConsulta = "SELECT id, dlibre, codigo FROM centros WHERE dlibre ILIKE '%$centro%'";
	$resultados = pg_exec($txtConsulta);
	$numresultados = intval(pg_numrows($resultados));
	if($numresultados > 0){
		while ($resultado = pg_fetch_row($resultados)) {
			$nombreCentro = $resultado[1];
			$idCentro = $resultado[0];
			$codigo = $resultado[2];
			$almacenaContenido .="<div class='centroResultado' id='".$codigo."'>".$nombreCentro."</div>";
		}
	}
	
	$resultadoTotal = "
			<div class='input-group'>
				<span id='basic-addon1' class='input-group-addon'>Sugerencias</span>
					<div class='grupoResultados' elemento='".$hermano."'>
		";
	if($numresultados == 0 && $numresultadosUrb == 0){
		$resultadoTotal.= "<div class='noSugerencias'>No se han encontrado sugerencias</div>";
	}else{
		
		
		$resultadoTotal.= $almacenaContenido;
	}
	$resultadoTotal .="</div></div>";
	echo $resultadoTotal;
?>
