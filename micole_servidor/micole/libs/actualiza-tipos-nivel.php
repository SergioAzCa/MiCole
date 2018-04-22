<?php

//Esta página se encarga de actualizar el estado de un pedido o de un mapa

include('../php/config.php');
include('../php/seguridad-admin.php');


//Actualiza un nivel
if(isset ($_POST['nivel']) && $_POST['nivel']!=''){
	$nombre = $_POST['nombre'];
	$descripcion = $_POST['descripcion'];
	$estado = $_POST['estado'];

	if($_POST['nivel'] == 'inserta'){
		$selMax = pg_exec("SELECT MAX(id_nivel) FROM niveles");
        $max = pg_fetch_row($selMax);
        $max = $max[0] + 1;

		pg_exec("INSERT INTO niveles (id_nivel, nombre, descripcion, id_estado) VALUES('$max', '$nombre', '$descripcion', '$estado')");
		header("Location: ../niveles.php?n=ins");
	}else{
		pg_exec("UPDATE niveles SET nombre='$nombre', descripcion='$descripcion', id_estado='$estado' WHERE id_nivel='".$_POST['nivel']."'");
		header("Location: ../niveles.php?n=act");
	}
	exit();
}
//Actualiza modalidad
if(isset ($_POST['modalidad']) && $_POST['modalidad']!=''){
	$nombre = $_POST['nombre'];
	$descripcion = $_POST['descripcion'];
	$nivel = $_POST['tipo_nivel'];
	$estado = $_POST['estado'];
	$idioma = $_POST['idioma'];

	if($_POST['modalidad'] == 'inserta'){
		$selMax = pg_exec("SELECT MAX(id_tipo) FROM tipos_educativos");
        $max = pg_fetch_row($selMax);
        $max = $max[0] + 1;

		pg_exec("INSERT INTO tipos_educativos (id_tipo, nombre, descripcion, id_nivel, id_estado, id_idioma) VALUES('$max', '$nombre', '$descripcion', '$nivel', '$estado', '$idioma')");
		header("Location: ../tipos-educativos.php?t=ins");
	}else{
		pg_exec("UPDATE tipos_educativos SET nombre='$nombre', descripcion='$descripcion', id_estado='$estado', id_nivel='$nivel', id_idioma='$idioma' WHERE id_tipo='".$_POST['modalidad']."'");
		header("Location: ../tipos-educativos.php?t=act");
	}
	exit();
}
//

if(isset ($_GET['elimina']) && $_GET['elimina']!=''){
	switch ($_GET['elimina']) {
		case 'nivel':
			$nivel = $_GET['valor'];
			pg_exec("UPDATE niveles SET id_estado = 6 WHERE id_nivel='$nivel'");	
			pg_exec("UPDATE tipos_educativos SET id_estado = 6 WHERE id_nivel='$nivel'");
			header("Location: ../niveles.php?n=elim");
			break;
		case 'modalidad':
			$modalidad = $_GET['valor'];
			pg_exec("UPDATE tipos_educativos SET id_estado = 6 WHERE id_tipo='$modalidad'");
			header("Location: ../tipos-educativos.php?t=elim");
			break;
	}
}
?>