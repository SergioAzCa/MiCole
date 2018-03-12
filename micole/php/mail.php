<?php 

// Global Configuration start: From here you can change the email-id of receiver, cc, from email-id & subject;
$to = "info@geomodel.es";
/*$from = "attornettemplate@theemon.com";
$cc = "alok@sparxitsolutions.com";*/
$subject = "Contacto Visor TELEAKUSTIK Sagunto";
// Global configuration end
$errmasg = "";

 $name = htmlentities(trim($_POST['nombre']));
 $apellidos = htmlentities(trim($_POST['apellidos']));
 $email = htmlentities(trim($_POST['email']));
 $mensaje = htmlentities(trim(nl2br($_POST['mensaje'])));
 
if($email){
$message = "<table border='0' cellpadding='2' cellspacing='2' width='600'>
<tr><td><strong>Nombre:</strong> ".$name." </td></tr>
<tr><td><strong>Apellidos:</strong> ".$apellidos." </td></tr>
<tr><td><strong>E-mail:</strong> ".$email."</td></tr>
<tr><td><strong>Mensaje:</strong> ".$mensaje."</td></tr>
</table>";
 
 } else{
 	
$errmasg = "No Data";	
 }
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'De:'.$email . "\r\n";


if($errmasg == ""){
	if(mail($to,$subject,$message,$headers)){
		header("Location:../index.php?mensaje=enviado");   
	}else{
		header("Location:../index.php?mensaje=incorrecto");
	}
}else{
    echo $errmasg;
}
?>