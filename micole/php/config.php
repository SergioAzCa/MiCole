<?php
	/*header('Content-Type: text/html; charset=utf-8');*/
	$usuario = 'postgres';
	$contrasenya = 'GmPW#37mzf';
	$bbdd = 'micole';
	$puerto = '5432';
	$host = 'localhost';
	
	$conn = pg_connect("dbname=".$bbdd." user=".$usuario." host=".$host." password=".$contrasenya." port=".$puerto) or die ("Fallo en la conexión");
?>
