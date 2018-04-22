<?php
//Esta página se encarga de insertar o actualizar los datos de un alumno
include('../php/config.php');
include('../php/funciones.php');
include('../php/seguridad.php');

$curso = devuelveCurso();

if(isset($_GET['elimina']) && $_GET['elimina'] !== ''){
	//Comprueba que este centro puede eliminar ese alumno
	$selAlumno = pg_exec("SELECT * FROM alumnos_a_centros WHERE id_alumno = ".$_GET['elimina']." AND id_centro=".$_SESSION['user_id']);
  $numRegistros = pg_num_rows($selAlumno);
  if($numRegistros == 0){
      header("Location: ../alumnos.php?err=no");
      exit();
  }else{
		pg_exec("UPDATE alumnos SET estado = 6
  		,usuario_elimina=".$_SESSION['user_id']."
  		,fecha_elimina='".ahora()."'
			WHERE id_alumno=".$_GET['elimina']);
  		header('Location: ../alumnos.php?err=elim');
      exit();
  }
}else{
	//Inserta o edita
	if(isset($_POST['actualiza']) && $_POST['actualiza'] !== ''){
		//Actualiza
		//COMIENZO DE COMPROBACIONES
		//Comprobacion de modalidad
		if(isset($_POST['nivel']) && $_POST['nivel']!='' &&
			isset($_POST['modalidad']) && $_POST['modalidad']!='' &&
			isset($_POST['idioma']) && $_POST['idioma']!=''){
			$selModalidad = pg_exec("SELECT * FROM usuarios_a_tipos AS ut
															INNER JOIN tipos_educativos AS te
															ON (ut.id_idioma = te.id_idioma AND ut.id_tipo_educativo = te.id_tipo)
															WHERE te.id_nivel = '".$_POST['nivel']."'
															AND ut.id_tipo_educativo='".$_POST['modalidad']."'
															AND ut.id_idioma='".$_POST['idioma']."'
															AND ut.id_usuario='".$_SESSION['user_id']."'
															AND ut.curso='".$curso."'
															");
			$numRegistros = pg_num_rows($selModalidad);
			if($numRegistros == 0){
					header('Location: '.$_SERVER['HTTP_REFERER']."&err=mod");
		      exit();
		  }else{
		  	echo "OK - Modalidad<br/>";
		  }
		}else{
			header('Location: '.$_SERVER['HTTP_REFERER']."&err=mod");
		  exit();
		}
		//Comprobacion de datos
		if(isset($_POST['nombre']) && $_POST['nombre']!='' &&
			isset($_POST['apellidos']) && $_POST['apellidos']!='' &&
			isset($_POST['dni']) && $_POST['dni']!=''){
			echo "OK - Datos<br/>";
		}else{
			header('Location: '.$_SERVER['HTTP_REFERER']."&err=datos");
		  exit();
		}
		//Comprobacion de direccion
		if(isset($_POST['calle']) && $_POST['calle']!='' &&
			isset($_POST['id_calle']) && $_POST['id_calle']!='' &&
			isset($_POST['num_policia']) && $_POST['num_policia']!=''){
			$selPortal = pg_exec("SELECT * FROM portales
				WHERE id_vial = '".$_POST['id_calle']."' AND num_policia='".$_POST['num_policia']."'");
			$numRegistros = pg_num_rows($selPortal);
			if($numRegistros == 0){
				header('Location: '.$_SERVER['HTTP_REFERER']."&err=dir");
		    exit();
		  }else{
		  	echo "OK - Dirección<br/>";
		  }
		}else{
			header('Location: '.$_SERVER['HTTP_REFERER']."&err=dir");
		  exit();
		}
		//Comprobacion de nota de ESO
		if($_POST['nivel'] == 4 && isset($_POST['param_10']) && $_POST['param_10'] != ''){
			//Es bachiller y tiene nota
			echo "OK - Bachiller y nota<br/>";
		}else if($_POST['nivel'] != 4){
			echo "OK - No bachiller<br/>";
		}else{
			header('Location: '.$_SERVER['HTTP_REFERER']."&err=bach");
			exit();
		}
		//FIN DE COMPROBACIONES

		//Comprueba que este centro puede actualizar ese alumno
		$selAlumno = pg_exec("SELECT * FROM alumnos_a_centros WHERE id_alumno = ".$_POST['actualiza']." AND id_centro=".$_SESSION['user_id']);
	  $numRegistros = pg_num_rows($selAlumno);
	  if($numRegistros == 0){
				header("Location: ../alumnos.php&err=no");
	      exit();
	  }
		//Saco datos del centro
		$selCentro = pg_exec("SELECT id_vial, num_policia FROM usuarios WHERE id=".$_SESSION['user_id']);
		$datosCentro = pg_fetch_row($selCentro);
		$centro_id_vial = $datosCentro[0];
		$centro_num_poli = $datosCentro[1];

		$calc_ptos_zona = pg_exec("SELECT public.___mc_calcular_puntos_zonas(".$_POST['id_calle'].", ".$_POST['num_policia'].", ".$centro_id_vial.",".$centro_num_poli.",".$_POST['nivel'].")");
    $ptos_zona = pg_fetch_row($calc_ptos_zona);
		$ptos_zona = $ptos_zona[0];
		//Calculo de zona
		$calc_ptos_area = pg_exec("SELECT id_zona FROM areas_zonas_educativas
				where ST_INTERSECTS((SELECT ST_TRANSFORM((
						SELECT geom from portales
						WHERE id_vial = ".$_POST['id_calle']." and num_policia = ".$_POST['num_policia']."),4326)),the_geom) IS TRUE and id_nivel = ".$_POST['nivel']);
		$ptos_area = pg_fetch_row($calc_ptos_area);
		$ptos_area = $ptos_area[0];

		//Calculo de puntaje total
		//Calculo de puntaje total
		$puntaje_total = calculaPuntaje($ptos_zona, $_POST['param_2'], $_POST['param_3'], $_POST['param_4'],
																		$_POST['param_5'], $_POST['param_6'], $_POST['param_7'],
																		$_POST['param_8'], $_POST['param_9'], $_POST['nivel'], $_POST['param_10']);
																		
		if(isset($_POST['param_10']) && $_POST['param_10']!=''){
			$agregaBach = ",calc_media_eso_fp = '".$_POST['param_10']."'";
		}else{
			$agregaBach = "";
		}
		pg_exec("UPDATE alumnos SET
	  				nombre_alumno = '".$_POST['nombre']."'
	  				,apellidos_alumno = '".$_POST['apellidos']."'
	  				,dni_alumno = '".$_POST['dni']."'
						,id_nivel_educativo = '".$_POST['nivel']."'
	  				,id_tipo_educativo = '".$_POST['modalidad']."'
						,id_idioma = ".$_POST['idioma']."
						,calc_id_calle = '".$_POST['id_calle']."'
	  				,calc_id_num_poli = '".$_POST['num_policia']."'
	  				,calc_id_zona = '".$ptos_area."'
	  				,calc_id_direccion = '".$ptos_zona."'
	  				,calc_hermanos = '".$_POST['param_2']."'
	  				,calc_padres = '".$_POST['param_3']."'
	  				,calc_renta = '".$_POST['param_4']."'
	  				,calc_flia_numerosa = '".$_POST['param_5']."'
	  				,calc_flia_monoparental = '".$_POST['param_6']."'
	  				,calc_discapacidad = '".$_POST['param_7']."'
	  				,calc_disc_flia_33_65 = '".$_POST['param_8']."'
	  				,calc_disc_flia_65 = '".$_POST['param_9']."'
	  				".$agregaBach."
	  				,calc_total = ".$puntaje_total."
	  				,usuario_modificacion = ".$_SESSION['user_id']."
	  				,fecha_modificacion = '".ahora()."'
	  				WHERE id_alumno='".$_POST['actualiza']."'");
	  header("Location: ../alumnos.php?err=act");
		exit();
	}else{
		//Inserta
		//COMIENZO DE COMPROBACIONES
		//Comprobacion de modalidad
		if(isset($_POST['nivel']) && $_POST['nivel']!='' &&
			isset($_POST['modalidad']) && $_POST['modalidad']!='' &&
			isset($_POST['idioma']) && $_POST['idioma']!=''){
			$selModalidad = pg_exec("SELECT * FROM usuarios_a_tipos AS ut
															INNER JOIN tipos_educativos AS te
															ON (ut.id_idioma = te.id_idioma AND ut.id_tipo_educativo = te.id_tipo)
															WHERE te.id_nivel = '".$_POST['nivel']."'
															AND ut.id_tipo_educativo='".$_POST['modalidad']."'
															AND ut.id_idioma='".$_POST['idioma']."'
															AND ut.id_usuario='".$_SESSION['user_id']."'
															AND ut.curso='".$curso."'
															");
			$numRegistros = pg_num_rows($selModalidad);
			if($numRegistros == 0){
					header('Location: '.$_SERVER['HTTP_REFERER']."?err=mod");
		      exit();
		  }else{
		  	echo "OK - Modalidad<br/>";
		  }
		}else{
			header('Location: '.$_SERVER['HTTP_REFERER']."?err=mod");
		  exit();
		}
		//Comprobacion de datos
		if(isset($_POST['nombre']) && $_POST['nombre']!='' &&
			isset($_POST['apellidos']) && $_POST['apellidos']!='' &&
			isset($_POST['dni']) && $_POST['dni']!=''){
			echo "OK - Datos<br/>";
		}else{
			header('Location: '.$_SERVER['HTTP_REFERER']."?err=datos");
		  exit();
		}
		//Comprobacion de direccion
		if(isset($_POST['calle']) && $_POST['calle']!='' &&
			isset($_POST['id_calle']) && $_POST['id_calle']!='' &&
			isset($_POST['num_policia']) && $_POST['num_policia']!=''){
			$selPortal = pg_exec("SELECT * FROM portales
				WHERE id_vial = '".$_POST['id_calle']."' AND num_policia='".$_POST['num_policia']."'");
			$numRegistros = pg_num_rows($selPortal);
			if($numRegistros == 0){
				header('Location: '.$_SERVER['HTTP_REFERER']."?err=dir");
		    exit();
		  }else{
		  	echo "OK - Dirección<br/>";
		  }
		}else{
			header('Location: '.$_SERVER['HTTP_REFERER']."?err=dir");
		  exit();
		}
		//Comprobacion de nota de ESO
		if($_POST['nivel'] == 4 && isset($_POST['param_10']) && $_POST['param_10'] != ''){
			//Es bachiller y tiene nota
			echo "OK - Bachiller y nota<br/>";
		}else if($_POST['nivel'] != 4){
			echo "OK - No bachiller<br/>";
		}else{
			header('Location: '.$_SERVER['HTTP_REFERER']."?err=bach");
			exit();
		}
		//FIN DE COMPROBACIONES
		//Esta todo OK, insertamos el alumno
		$selMaxAlumno = pg_exec("SELECT MAX(id_alumno) FROM alumnos");
		$maxAlumno = pg_fetch_row($selMaxAlumno);
		$nvoId = $maxAlumno[0]+1;

		//Saco datos del centro
		$selCentro = pg_exec("SELECT id_vial, num_policia FROM usuarios WHERE id=".$_SESSION['user_id']);
		$datosCentro = pg_fetch_row($selCentro);
		$centro_id_vial = $datosCentro[0];
		$centro_num_poli = $datosCentro[1];

		$calc_ptos_zona = pg_exec("SELECT public.___mc_calcular_puntos_zonas(".$_POST['id_calle'].", ".$_POST['num_policia'].", ".$centro_id_vial.",".$centro_num_poli.",".$_POST['nivel'].")");
    $ptos_zona = pg_fetch_row($calc_ptos_zona);
		$ptos_zona = $ptos_zona[0];

		//Calculo de zona
		$calc_ptos_area = pg_exec("SELECT id_zona FROM areas_zonas_educativas
				where ST_INTERSECTS((SELECT ST_TRANSFORM((
						SELECT geom from portales
						WHERE id_vial = ".$_POST['id_calle']." and num_policia = ".$_POST['num_policia']."),4326)),the_geom) IS TRUE and id_nivel = ".$_POST['nivel']);
		$ptos_area = pg_fetch_row($calc_ptos_area);
		$ptos_area = $ptos_area[0];

		//Calculo de puntaje total
		$puntaje_total = calculaPuntaje($ptos_zona, $_POST['param_2'], $_POST['param_3'], $_POST['param_4'],
																		$_POST['param_5'], $_POST['param_6'], $_POST['param_7'],
																		$_POST['param_8'], $_POST['param_9'], $_POST['nivel'], $_POST['param_10']);

		//Si es nivel bachiller inserta en la bd la media
		if($_POST['nivel'] == 4){
			$notaESO = $_POST['param_10'];
		}else{
			$notaESO = 0;
		}


		//Inserto el alumno
		pg_exec("INSERT INTO alumnos (id_alumno, nombre_alumno, apellidos_alumno, dni_alumno, id_nivel_educativo,
		id_tipo_educativo, id_idioma, calc_id_calle, calc_id_num_poli, calc_id_zona,
		calc_id_direccion, calc_total, calc_hermanos,calc_padres, calc_renta,
		calc_flia_numerosa, calc_flia_monoparental, calc_discapacidad,
		calc_disc_flia_33_65, calc_disc_flia_65, calc_media_eso_fp,
		usuario_creacion, fecha_creacion, curso, estado)
		VALUES($nvoId, '".$_POST['nombre']."', '".$_POST['apellidos']."', '".$_POST['dni']."', ".$_POST['nivel']."
		, ".$_POST['modalidad'].", ".$_POST['idioma'].", ".$_POST['id_calle'].", ".$_POST['num_policia'].", ".$ptos_area."
		, ".$ptos_zona.", ".$puntaje_total.", ".$_POST['param_2'].", ".$_POST['param_3'].", ".$_POST['param_4']."
		, ".$_POST['param_5'].", ".$_POST['param_6'].", ".$_POST['param_7']."
	  , ".$_POST['param_8'].", ".$_POST['param_9'].", ".$notaESO."
		, ".$_SESSION['user_id'].", '".ahora()."', ".$curso.", 42)");

		//Inserto en alumnos_a_centros
		pg_exec("INSERT INTO alumnos_a_centros (id_alumno, id_centro) VALUES (".$nvoId.", ".$_SESSION['user_id'].")");

		//Muestra todas las vbles post pasadas

		header('Location: '.$_SERVER['HTTP_REFERER']."?err=ins");
		exit();
	}
}
?>
