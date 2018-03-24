<?php header("Content-type: text/html; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Content-Type: application/json; charset=UTF-8");
header('Content-Type: text/html; charset=ISO-8859-1');
/* Copyright � 2016 Sergio Aznar Cabot� & Rodrigo Diaz & Cristina Ses� Mart�nez
   EMPRESA : GEOMODEL (info@geomodel.es) */


// Fichero que realiza la consulta en la base de datos y devuelve los resultados
	include("php/config.php");
	$campo2=$_POST["campo"];
	$campo1=utf8_decode($campo2);
	$encuentra   = "'";

	// N�tese el uso de ===. Puesto que == simple no funcionar� como se espera
	// porque la posici�n de 'a' est� en el 1� (primer) caracter.
	if(strpos($campo1, $encuentra))
    {
		$campo = str_replace( "'","/",$campo1);
	}else{
		$campo = $campo2;
	}

  // Conectamos con la base de datos
//    $conn = pg_connect("dbname=pucol user=postgres host=localhost password=postgres port=5433") or die ("Fallo en la conexi�n");

  //$busqueda=pg_exec("SELECT * FROM rustica");
  //echo $busqueda;



  if ($campo != "") {
		$resultados=pg_exec("SELECT first_nom_ FROM viales WHERE nom_via_1 ILIKE '%$campo%'");
		$campo2=$campo;
		//echo $resultados;
	}

	$numresultados = pg_numrows($resultados);
	//echo $numresultados;
    // echo "N�mero de resultados: $numresultados";
    // echo "<BR>\n";

  // Creo el documento donde se obtendran las coordenadas para el ZoomExten


  for ($i=0; $i<$numresultados; $i++) {
    $dato = pg_fetch_row($resultados,$i);

	$ref_1=$dato[0];




    $input=$ref_1;

	if(strpos($campo1, $encuentra))
    {
		$campo_fin = str_replace( "/","'",$dato[0]);


	}else{
		$campo_fin = $dato[0];

	}
	echo "<a class='prueba' href=\"javascript:selectItem('$input','$ref_1')\">$campo_fin</a>";



  }


pg_close($conn);
?>
