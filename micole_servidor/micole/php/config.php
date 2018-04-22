<?php
	$puerto = '5432';
	$usuario = 'postgres';
	$contrasenya = 'micole2018';
	$host = 'localhost';
	$bbdd = 'mi_cole';
	
	$conn = pg_connect("dbname=".$bbdd." user=".$usuario." host=".$host." password=".$contrasenya." port=".$puerto) or die ("Fallo en la conexión");
	//Vbles paginacion
	$regPorPag = 20;
	$respuestasPorPag = 15;

	//Carpetas imagenes
	//perfiles de usuarios de BO

	$fotoPerfilBO = 'img/perfil/';
?>
