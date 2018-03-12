<?php header("Content-type: text/html; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Content-Type: application/json; charset=UTF-8");
header('Content-Type: text/html; charset=ISO-8859-1');
/* Copyright ɠ2016 Sergio Aznar Cabotᠦ Rodrigo Diaz & Cristina Ses額artz
   EMPRESA : GEOMODEL (info@geomodel.es) */

   
// Fichero que realiza la consulta en la base de datos y devuelve los resultados
	include("php/config.php");
	$campo2="Bonrepos";//$_POST["calle"];
	$portal=76;//$_POST["portal"];
	$tipo=2;//$_POST["tipo"];
	$campo=utf8_decode($campo2);
	echo $tipo;
  	$extension= pg_exec("SELECT  ST_X(ST_intersection(geom, geom)), ST_Y(ST_intersection(geom, geom)) FROM (SELECT geom as geom FROM portales WHERE num_por = '$portal' AND nom_via_1 = '$campo')AS a");
	$extension_com = pg_fetch_row($extension);

	//SELECT ST_AsText(the_geom) as points FROM portales

	
	$x=$extension_com[0];
	echo $x;
	$y=$extension_com[1]; 
	echo $y;
	$punto= "POINT(".$x." ".$y.")";
	echo $punto;
	$extension2= pg_exec("select id  from (select * from distritos_prim  where ST_intersects(ST_GeomFromText('$punto',25830), distritos_prim.geom)) as t");
	$extension_com2 = pg_fetch_row($extension2);
	echo $extension_com2;
	//SELECT ST_AsText(the_geom) as points FROM portales

	
	$id=$extension_com2[0];
	echo $id;
	if($tipo==1){
	$extension3= pg_exec("SELECT ST_XMIN(extent) AS minx, ST_YMIN(extent) AS miny, ST_XMAX(extent) AS maxx, ST_YMAX(extent) AS maxy FROM (SELECT ST_Extent(geom) AS extent FROM distritos_prim WHERE id = '".$id."') AS a");
	}
	if($tipo==2){
	$extension3= pg_exec("SELECT ST_XMIN(extent) AS minx, ST_YMIN(extent) AS miny, ST_XMAX(extent) AS maxx, ST_YMAX(extent) AS maxy FROM (SELECT ST_Extent(geom) AS extent FROM distritos_prim WHERE id = '".$id."') AS a");
	}
	if($tipo==3){
	$extension3= pg_exec("SELECT ST_XMIN(extent) AS minx, ST_YMIN(extent) AS miny, ST_XMAX(extent) AS maxx, ST_YMAX(extent) AS maxy FROM (SELECT ST_Extent(geom) AS extent FROM areas_bach WHERE id = '".$id."') AS a");
	}
	if($tipo==4){
	$extension3= pg_exec("SELECT ST_XMIN(extent) AS minx, ST_YMIN(extent) AS miny, ST_XMAX(extent) AS maxx, ST_YMAX(extent) AS maxy FROM (SELECT ST_Extent(geom) AS extent FROM areas_bach WHERE id = '".$id."') AS a");
	}
	$extension_com3 = pg_fetch_row($extension3);
	$minx=$extension_com3[0];
	$miny=$extension_com3[1];
	$maxx=$extension_com3[2];
	$maxy=$extension_com3[3];

  $arrayResultado = array($minx,$miny,$maxx,$maxy);
  echo json_encode($arrayResultado);
 
pg_close($conn);
?>