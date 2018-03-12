<?php header("Content-type: text/html; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Content-Type: application/json; charset=UTF-8");
header('Content-Type: text/html; charset=ISO-8859-1');
/* Copyright ɠ2016 Sergio Aznar Cabotᠦ Rodrigo Diaz & Cristina Ses額artz
   EMPRESA : GEOMODEL (info@geomodel.es) */

   
// Fichero que realiza la consulta en la base de datos y devuelve los resultados
	include("php/config.php");
	$campo2=$_POST["campo"];
	$campo1=utf8_decode($campo2);
	$encuentra   = "'";
	$encuentra2  = ".";

	// N󴥳e el uso de ===. Puesto que == simple no funcionarᡣomo se espera
	// porque la posici󮠤e 'a' estᡥn el 1Р(primer) caracter.
	if(strpos($campo1, $encuentra))
    {
		$campo = str_replace( "'","/",$campo1);
		echo "ENTRA 1";
	}else{
		$campo = $campo2;
	}
	if(strpos($campo1, $encuentra2))
    {
		$campo = str_replace( ".","*",$campo1);
	}else{
		$campo = $campo2;
	}
  // Conectamos con la base de datos
//    $conn = pg_connect("dbname=pucol user=postgres host=localhost password=postgres port=5433") or die ("Fallo en la conexi󮢩; 
 
  //$busqueda=pg_exec("SELECT * FROM rustica");
  //echo $busqueda;
  

 
  if ($campo != "") {
		$resultados=pg_exec("SELECT nombre_cen FROM centros WHERE nombre_cen ILIKE '%$campo%'");
		$campo2=$campo;
		//echo $resultados;
	}
	
	$numresultados = pg_numrows($resultados);
	//echo $numresultados;
    // echo "N򭥲o de resultados: $numresultados";
    // echo "<BR>\n";
  
  // Creo el documento donde se obtendran las coordenadas para el ZoomExten
  
		
  for ($i=0; $i<$numresultados; $i++) {
    $dato = pg_fetch_row($resultados,$i);
	
	$ref_1=$dato[0];
	echo $i;
	

	
    $input=$ref_1;
	echo $input;
	if(strpos($ref_1,$encuentra))
    {
		$campo_fin = str_replace( "/","'",$dato[0]);
		echo "entra";
		
	}else{
		$campo_fin = $dato[0];
		
	}
	if(strpos($ref_1, $encuentra2))
    {
		$campo_fin = str_replace( "*",".",$dato[0]);
		
		
	}else{
		$campo_fin = $dato[0];
		
	}
	$extension= pg_exec("SELECT   ST_X(ST_intersection(geom, geom)), ST_Y(ST_intersection(geom, geom)) FROM (SELECT the_geom as geom FROM centros WHERE nombre_cen = '$ref_1')AS a");
	$extension2 = pg_fetch_row($extension);
	
	//SELECT ST_AsText(the_geom) as points FROM portales

	
	$x=$extension2[0];
	$y=$extension2[1];

	
	echo "<a class='prueba' href=\"javascript:selectItem('$input','$campo_fin','$x','$y')\">$campo_fin</a>";
		
	
	 
  }
  
 
pg_close($conn);
?>
