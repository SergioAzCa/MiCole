<?php
	include("../php/seguridad.php");
  include("../php/config.php");
  include("../php/funciones.php");

	if(isset($_POST['tipo']) && $_POST['tipo']=='calles'){
		$valor = $_POST['valor'];
		$resultados = pg_exec("SELECT id_vial, nombre_via
													FROM viales
													WHERE upper(nombre_via) 
													LIKE '%".strtoupper($valor)."%'");
		while($dato = pg_fetch_array($resultados)){
			$string .= "<div class='elemSugerido' valor='".$dato[0]."' nombre='".$dato[1]."'>".$dato[1]."</div>";
		}
		if($string == ''){
			echo "<div class='elemSinSug'>No hay sugerencias para ésta búsqueda</div>";
		}else{
			echo $string;
		}
	}
	if(isset($_POST['tipo']) && $_POST['tipo']=='numero'){
		$valor = $_POST['valor'];
		$numero = $_POST['numero'];
		$resultados = pg_exec("SELECT distinct num_policia, id_tramo
													FROM portales 
													WHERE id_vial= ".$valor."
													AND CONCAT('_', num_policia, '_') LIKE '%_".$numero."_%'
													ORDER BY num_policia ASC");
		while($dato = pg_fetch_array($resultados)){
			$str .= "<div class='elemSugerido' valor='".$dato[0]."' tramo='".$dato[1]."'>".$dato[0]."</div>";
		}
		if($str == ''){
			echo "<div class='elemSinSug'>No hay sugerencias para ésta búsqueda</div>";
		}else{
			echo $str;
		}
	}
pg_close($conn);
?>
