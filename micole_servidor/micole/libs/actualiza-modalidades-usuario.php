<?php

//Esta página se encarga de actualizar las modalidades y plazas que oferta un centro

include('../php/config.php');
include('../php/funciones.php');
include('../php/seguridad.php');
$curso = devuelveCurso();
$usuario = $_SESSION['user_id'];

pg_exec("DELETE FROM usuarios_a_tipos WHERE id_usuario=".$usuario);
foreach($_POST['chbx_mod'] as $valor){
  $valor1 = explode('_', $valor);
  $valor_idmod = $valor1[0];
  $valor_ididioma = $valor1[1];

  pg_exec("INSERT INTO usuarios_a_tipos (id_usuario, id_tipo_educativo, curso, plazas, id_idioma)
  				VALUES (".$usuario.", ".$valor_idmod.", ".$curso.", ".$_POST['plz_'.$valor_idmod.'_'.$valor_ididioma].", ".$valor_ididioma.")");
}
header("Location: ../plazas.php?m=act");
exit();
?>
