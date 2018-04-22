<?php
	include("../php/seguridad.php");
  include("../php/config.php");
  include("../php/funciones.php");

	if(isset($_POST['mapa']) && $_POST['mapa'] == 'informacion'){
		$id_centro = $_SESSION['user_id'];
		$selDatos = pg_exec("SELECT id_vial, num_policia
													FROM usuarios
												  WHERE id=".$_SESSION['user_id']);
    $datos = array();
		$direccion = pg_fetch_row($selDatos);
		$mod = array();
		$mod['id_vial']=$direccion[0];
		$mod['num_poli']=$direccion[1];
		$selCoords = pg_exec("SELECT ST_ASTEXT(ST_TRANSFORM((
			SELECT geom FROM portales WHERE id_vial = ".$mod['id_vial']." and num_policia = ".$mod['num_poli']."),4326))");
		$coords = pg_fetch_row($selCoords);
		$txtCoord = explode("(", $coords[0]);
		$txtCoord1 = explode(")", $txtCoord[1]);
		$txtCoord2 = explode(" ", $txtCoord1[0]);
		$mod['latitud']=$txtCoord2[1];
		$mod['longitud']=$txtCoord2[0];
		array_push($datos, $mod);
    echo json_encode($datos);
    exit();
  }
	if(isset($_POST['mapa']) && $_POST['mapa'] == 'alumno'){
		//Mapa de alumno cuando entra a meter un nuevo alumno
		if(isset($_POST['modo']) && $_POST['modo'] == 'inicio'){
			$id_centro = $_SESSION['user_id'];
			$selDatos = pg_exec("SELECT id_vial, num_policia
														FROM usuarios
													  WHERE id=".$_SESSION['user_id']);
	    $datos = array();
			$direccion = pg_fetch_row($selDatos);
			$mod = array();
			$mod['id_vial']=$direccion[0];
			$mod['num_poli']=$direccion[1];
			$selCoords = pg_exec("SELECT ST_ASTEXT(ST_TRANSFORM((
				SELECT geom FROM portales WHERE id_vial = ".$mod['id_vial']." and num_policia = ".$mod['num_poli']."),4326))");
			$coords = pg_fetch_row($selCoords);
			$txtCoord = explode("(", $coords[0]);
			$txtCoord1 = explode(")", $txtCoord[1]);
			$txtCoord2 = explode(" ", $txtCoord1[0]);
			$mod['latitud']=$txtCoord2[1];
			$mod['longitud']=$txtCoord2[0];
			$mod['id_centro']=$_SESSION['user_id'];
			array_push($datos, $mod);
	    echo json_encode($datos);
	    exit();
		}
		//Cuando se mete una direccion de alumno
		if(isset($_POST['modo']) && $_POST['modo'] == 'recarga'){
			$id_centro = $_SESSION['user_id'];
			$nivel = $_POST['nivel'];
			$vial = $_POST['vial'];
			$num_poli = $_POST['num_poli'];

			$selDatos = pg_exec("SELECT id_vial, num_policia
														FROM usuarios
													  WHERE id=".$_SESSION['user_id']);
	    $datos = array();
			$direccion = pg_fetch_row($selDatos);
			$mod = array();
			$mod['id_vial']=$direccion[0];
			$mod['num_poli']=$direccion[1];
			$selCoords = pg_exec("SELECT ST_ASTEXT(ST_TRANSFORM((
				SELECT geom FROM portales WHERE id_vial = ".$mod['id_vial']." and num_policia = ".$mod['num_poli']."),4326))");
			$coords = pg_fetch_row($selCoords);
			$txtCoord = explode("(", $coords[0]);
			$txtCoord1 = explode(")", $txtCoord[1]);
			$txtCoord2 = explode(" ", $txtCoord1[0]);
			$mod['latitud']=$txtCoord2[1];
			$mod['longitud']=$txtCoord2[0];
			$mod['id_centro']=$_SESSION['user_id'];
			array_push($datos, $mod);
	    echo json_encode($datos);
	    exit();
		}
  }
?>
