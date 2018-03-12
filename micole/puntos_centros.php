<?php header("Content-type: text/html; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Content-Type: application/json; charset=UTF-8");
header("Content-Type: application/json");
header('Content-Type: text/html; charset=ISO-8859-1');
/* Copyright ɠ2016 Sergio Aznar Cabotᠦ Rodrigo Diaz & Cristina Ses額artz
   EMPRESA : GEOMODEL (info@geomodel.es) */
   include("php/config.php");
   $tipo=$_POST["tipo"];
   $usuario=$_POST["usuario"];
// Fichero que realiza la consulta en la base de datos y devuelve los resultados
	 if($tipo==1){
		$extension= pg_exec("SELECT geom,codigo FROM  centros_infantil");
	}if($tipo==2){
		$extension= pg_exec("SELECT geom,codigo FROM  centros_primaria");
	}if($tipo==3){
		$extension= pg_exec("SELECT geom,codigo FROM  centros_eso");
	}if($tipo==4){
		$extension= pg_exec("SELECT geom,codigo FROM  centros_bachiller");
	} 
  	//$extension= pg_exec("SELECT geom,id FROM  centros");
	$extension_com = pg_fetch_row($extension);
	$numresultados2 = pg_numrows($extension);
				$total=[];
				$total_puntos=[];
				for ($i=0; $i<$numresultados2; $i++) {
					$extension_com = pg_fetch_row($extension,$i);
					$geom=$extension_com[0];
					$geometria=pg_exec(" SELECT ST_AsText('".$geom."') ");
					$coord=pg_fetch_row($geometria);
					$array = explode("(", $coord[0]);
					$array1 = explode(")", $array[1]);
					$array2 = explode(" ", $array1[0]);
					$x=$array2[0];
					$y=$array2[1];
					
					$id=$extension_com[1];
					$extension1= pg_exec("SELECT puntos FROM  alumnos_a_centros WHERE codigo = '".$id."' AND id_alumno = '".$usuario."' ");
					$extension_com1 = pg_fetch_row($extension1);
					$puntos=$extension_com1[0];
					$puntos_bu=floatval($puntos);
					$totalcoord= $x.",".$y.",".$puntos_bu;
					
					// AQUI CALCULO DE LA X,Y PLAZA MIN CON LA X2 Y2 PARA OBTENER EL LUGAR MAS CERCANO
					array_push($total,$totalcoord);	
			}
			echo  json_encode($total);
			
pg_close($conn); 
?>