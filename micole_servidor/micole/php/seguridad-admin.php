<?php
 	session_start(); 
    //Si entra a esta web sin un identificador de usuario en la bd lo tira fuera
    if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] == '' || $_SESSION['user_tipo'] !== 'admin'){
        $serv = $_SERVER['HTTP_HOST'];
        $carpeta = "/micole/backoffice/";
        $file = "index.php";
        //Modificar esta ruta cuando tengamos el servidor en marcha
        header("Location: //".$serv.$carpeta.$file);
        exit();
    }
?>