<?php
	include("../php/seguridad.php");
  include("../php/config.php");
  include("../php/funciones.php");
	
	if(isset($_POST['carga']) && $_POST['carga'] == 'modalidades'){
		$id_nivel = $_POST['nivel'];
    //Veo si este usuario tiene alguna modalidad 
    //activa para ese nivel, si no la tiene, pinchó en una inactiva
		$curso = devuelveCurso();
		$selModUser = pg_exec("SELECT *
													FROM usuarios_a_tipos
													INNER JOIN tipos_educativos
													ON (usuarios_a_tipos.id_tipo_educativo = tipos_educativos.id_tipo AND 
													usuarios_a_tipos.id_idioma = tipos_educativos.id_idioma)
												  WHERE tipos_educativos.id_nivel=".$id_nivel."
													and usuarios_a_tipos.id_usuario=".$_SESSION['user_id']."
													and usuarios_a_tipos.curso=".$curso."");
    $numResultados = pg_numrows($selModUser);
    $elementos = array();
    if($numResultados > 0){
    	//Selecciono todas las modalidades
    	$selTodasMod = pg_exec("select distinct te.id_tipo, te.imagen, te.nombre
																from tipos_educativos AS te
																WHERE te.id_nivel=".$id_nivel."
																AND te.id_estado=37");
	    //Para cada modalidad, veo si este usuario tiene disponibilidad
			while($modalidad = pg_fetch_row($selTodasMod)){
	        $mod = array();
	        $mod['id_mod']=$modalidad[0];
	        $mod['img']=$modalidad[1];
	        $mod['nombre']=$modalidad[2];
	        $selDispMod = pg_exec("select *
																from usuarios_a_tipos
																where curso=".$curso."
																and id_usuario=".$_SESSION['user_id']."
																and id_tipo_educativo=".$modalidad[0]);
	        $numResultados = pg_numrows($selDispMod);
	        if($numResultados > 0){
	        	$mod['disponible']=true;
	        }else{
	        	$mod['disponible']=false;
	        }
	        array_push($elementos, $mod);
	    }
    }
    echo json_encode($elementos);
    exit();
  }
  if(isset($_POST['carga']) && $_POST['carga'] == 'idiomas'){
		$id_mod = $_POST['modalidad'];
    //Veo si este usuario tiene algun idioma
    //activo para esa modalidad, si no tiene, pinchó en uno inactivo
		$curso = devuelveCurso();
		$selIdiomaUser = pg_exec("SELECT *
														FROM usuarios_a_tipos
														WHERE id_tipo_educativo=".$id_mod."
														and usuarios_a_tipos.id_usuario=".$_SESSION['user_id']."
														and curso=".$curso.";
														");
    $numResultados = pg_numrows($selIdiomaUser);
    $elementos = array();
    if($numResultados > 0){
    	//Selecciono todos los lenguajes
    	$selTodosIdiomas = pg_exec("select distinct idiomas.id_idioma, idiomas.imagen, idiomas.nombre
																from tipos_educativos AS te
																INNER JOIN idiomas
																ON te.id_idioma = idiomas.id_idioma
																WHERE te.id_tipo=".$id_mod."
																AND te.id_estado=37
																ORDER BY idiomas.id_idioma ASC");
	    //Para cada idioma, veo si este usuario tiene disponibilidad
			while($idiomaSel = pg_fetch_row($selTodosIdiomas)){
	        $idioma = array();
	        $idioma['id_idioma']=$idiomaSel[0];
	        $idioma['img']=$idiomaSel[1];
	        $idioma['nombre']=$idiomaSel[2];
	        $selDispIdioma = pg_exec("select *
																from usuarios_a_tipos
																where curso=".$curso."
																and id_usuario=".$_SESSION['user_id']."
																and id_tipo_educativo=".$id_mod."
																and id_idioma=".$idiomaSel[0]);
	        $numResultados = pg_numrows($selDispIdioma);
	        if($numResultados > 0){
	        	$idioma['disponible']=true;
	        }else{
	        	$idioma['disponible']=false;
	        }
	        array_push($elementos, $idioma);
	    }
    }
    echo json_encode($elementos);
    exit();
  }
	if(isset($_POST['comprueba']) && $_POST['comprueba'] == 'seleccion'){
		$id_nvl = $_POST['nivel'];
		$id_mod = $_POST['modalidad'];
		$id_lng = $_POST['idioma'];
		$curso = devuelveCurso();	
		$selValidacion = pg_exec("SELECT *
														FROM usuarios_a_tipos AS ut
														INNER JOIN tipos_educativos AS te
														ON (ut.id_tipo_educativo = te.id_tipo AND 
														ut.id_idioma = te.id_idioma)
														WHERE ut.id_tipo_educativo=".$id_mod."
														and ut.id_usuario=".$_SESSION['user_id']."
														and ut.curso=".$curso."
														and ut.id_idioma=".$id_lng."
														and te.id_nivel=".$id_nvl);
		$numResultados = pg_numrows($selValidacion);
    if($numResultados > 0){
    	echo "T";
    }else{
    	echo "F";
    }
    exit();
	}
?>