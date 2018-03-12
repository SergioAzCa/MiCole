<?php header("Content-type: text/html; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Content-Type: application/json; charset=UTF-8");
header('Content-Type: text/html; charset=ISO-8859-1');
/* Copyright ɠ2016 Sergio Aznar Cabotᠦ Rodrigo Diaz & Cristina Ses額artz
   EMPRESA : GEOMODEL (info@geomodel.es) */

   
// Fichero que realiza la consulta en la base de datos y devuelve los resultados
	include("php/config.php");
	$campo2=$_POST["vial"];
	$portal=$_POST["portal"];
	$campo=utf8_decode($campo2);

 
  if ($campo != "") {
		$resultados=pg_exec("SELECT nom_via_1 FROM portales WHERE nom_via_1 = '$campo'");
		
	}
	
	$numresultados = pg_numrows($resultados);
	
  
		
  for ($i=0; $i<$numresultados; $i++) {
    $dato = pg_fetch_row($resultados,$i);
	
	$ref_1=$dato[0];
	
	
	 //CONSULTA PARA EL EXTENT DE LA PARCELA DE BUSQUEDA
	
	$extension= pg_exec("SELECT   ST_X(ST_intersection(geom, geom)), ST_Y(ST_intersection(geom, geom)) FROM (SELECT geom as geom FROM portales WHERE num_por = '$portal' AND nom_via_1 = '$ref_1')AS a");
	$extension2 = pg_fetch_row($extension);
	
	//SELECT ST_AsText(the_geom) as points FROM portales

	
	$x=$extension2[0];
	$y=$extension2[1];

	
		
	
	 
  }
  
	$arrayResultado = array($x,$y);
	echo json_encode($arrayResultado);
 
pg_close($conn);
?>
