<?php
	include("../php/seguridad.php");
    include("../php/config.php");
    include("../php/funciones.php");
	
	if(isset($_POST['carga']) && $_POST['carga'] == 'plazas'){
	    $curso = devuelveCurso();
	    $selElementos = pg_exec("SELECT * FROM usuarios_a_tipos WHERE id_usuario='".$_SESSION['user_id']."' AND curso=".$curso);
	    $elementos = array();
	    while($elementoSel = pg_fetch_row($selElementos)){
	        $elemento = array();
	        $elemento['id_tipo']=$elementoSel[1];
	        $elemento['plazas']=$elementoSel[2];
	        $elemento['id_idioma']=$elementoSel[4];
	        array_push($elementos, $elemento);
	    }
	    echo json_encode($elementos);
    }
?>