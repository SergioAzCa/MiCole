<?php
include("../php/config.php");

if(isset($_POST['valorCapa'])) {
	$valorCapa = $_POST['valorCapa'];
	$query = "SELECT * FROM buscador_columnas WHERE id_capa=".$valorCapa;
	$columnas = pg_exec($query);
	$txtRellenar = "<option value='0'>Elige una columna</option>";
	while ($columna = pg_fetch_row($columnas)) {
	  $txtRellenar .= "<option value='".$columna[2]."'>".$columna[3]."</option>";
	}
	echo $txtRellenar;
} else {
  die("Solicitud no válida.");
}
?>