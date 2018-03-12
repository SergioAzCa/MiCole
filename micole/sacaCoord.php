<?php header("Content-type: text/html; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Content-Type: application/json; charset=UTF-8");
header('Content-Type: text/html; charset=ISO-8859-1');
/* Copyright ɠ2016 Sergio Aznar Cabotᠦ Rodrigo Diaz & Cristina Ses額artz
   EMPRESA : GEOMODEL (info@geomodel.es) */

   
// Fichero que realiza la consulta en la base de datos y devuelve los resultados
	include("php/config.php");
	$campo2=$_POST["calle"];
	$portal=$_POST["portal"];
	$campo=utf8_decode($campo2);

 
  	$extension= pg_exec("SELECT   ST_X(ST_intersection(geom, geom)), ST_Y(ST_intersection(geom, geom)) FROM (SELECT portales.geom FROM portales INNER JOIN viales ON viales.id_vial = portales.id_vial WHERE portales.num_por = '$portal' AND portales.id_vial = '$campo')AS a");
	$extension2 = pg_fetch_row($extension);
	
	//SELECT ST_AsText(the_geom) as points FROM portales

	
	$x=$extension2[0];
	$y=$extension2[1];

  $arrayResultado = array($x,$y);
  echo json_encode($arrayResultado);
 
pg_close($conn);
?>