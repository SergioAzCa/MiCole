<?php

//Esta página se encarga de actualizar el estado de un pedido o de un mapa

include('../php/config.php');
include('../php/seguridad.php');


if(isset ($_POST['pedido']) && $_POST['pedido']!=''){
	$pedido = $_POST['pedido'];
	$nuevo_estado = $_POST['estado_pedido'];

	pg_exec("UPDATE pedidos SET estado_pedido='$nuevo_estado' WHERE id_pedido='$pedido'");
	header("Location: ../detalles-pedido.php?p=".$pedido."&est=act");
	exit();
}

if(isset ($_POST['mapa']) && $_POST['mapa']!=''){
	$mapa = $_POST['mapa'];
	$nuevo_estado = $_POST['estado_pedido'];

	pg_exec("UPDATE mapas SET estado_mapa='$nuevo_estado' WHERE id_mapa='$mapa'");
	header("Location: ../detalles-mapa.php?m=".$mapa."&mapa=act");
	exit();
}

?>