<?php 
	include("php/seguridad.php");
    include("php/config.php");
	session_destroy();
	header('Location:index.php');
?>