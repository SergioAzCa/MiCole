<?php
	session_start();  
	$_SESSION['usuario'] = 'publico';
	header("Location: ../principal.php");  
?>