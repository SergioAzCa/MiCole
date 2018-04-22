<?php
	include("config.php");
	$user = htmlspecialchars(stripcslashes(trim($_POST["usuario"])));
	$pass = htmlspecialchars(stripcslashes(trim($_POST["password"])));

	$query = "SELECT * FROM usuarios WHERE (usuario='".$user."' OR correo='".$user."') AND pass='".$pass."'";
	$resultados = pg_exec($query);
	$numResultados = pg_numrows($resultados);

	$dato = pg_fetch_row($resultados);
	if($numResultados == 0){
		header("Location: ../index.php?accesoErroneo");
	}else{
		session_start();
		$_SESSION['user_id']= rtrim($dato[0]);
		$_SESSION['user_tipo']= rtrim($dato[3]);
		//redirecciona a la home normal o la home del admin
		if($_SESSION['user_tipo'] == 'admin'){
			header("Location: ../admin-home.php");
		}else{
			header("Location: ../home.php");
		}

	}
?>
