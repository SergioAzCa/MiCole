<?php
	include("config.php");
	$user = $_POST["admin"];   
	$pass = $_POST["password_usuario"];
	
	$query = "SELECT * FROM usuarios WHERE nombre='".$user."' AND pass='".$pass."'";
	$resultados = pg_exec($query);
	$numresultados = pg_numrows($resultados);
	@$dato = pg_fetch_row($resultados,0);
	$tipo = utf8_decode(rtrim($dato[3]));
	if($numresultados == 0){
		?>
			<script languaje="javascript">
            location.href = "../index.php?accesoErroneo";
            </script>
        <?php          
	}else{
		session_start();  
	  	$_SESSION['usuario'] = $tipo;
	  	header("Location: ../principal.php");  
	}
?>