<?php
include("php/config.php");
/*Conecta a la bd*/
/*$conn = pg_connect("dbname=pucol user=postgres host=localhost password=postgres port=5432") or die ("Fallo en la conexión");*/

/**/

	$id =$_POST['id'];
	$query = "SELECT * FROM buffer WHERE codigo='".$id."' ";
	$resultados = pg_exec($query);
	$numresultados = pg_numrows($resultados);
	for ($i=0; $i<$numresultados; $i++) {
			$dato = pg_fetch_row($resultados,$i);
			
			$nombre= $dato[28];
			$encuentra   = "/";

			if(strpos($nombre, $encuentra))
			{
				$campo_fin = str_replace( "/","'",$nombre);
				
				
			}else{
				$campo_fin = $nombre;
				
			}
			$telefono= utf8_decode(rtrim($dato[15]));
			$tipo= utf8_decode(rtrim($dato[20]));
			$nivel= utf8_decode(rtrim($dato[27]));
			$nivel2= $dato[29];
			$area= $dato[32];
			$distrito= $dato[33];
	}
	$arrayResultado = array($campo_fin,$telefono,$tipo,$nivel,$nivel2,$area,$distrito);
	echo json_encode($arrayResultado);

?>