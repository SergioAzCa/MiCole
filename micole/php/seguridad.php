
<?php 
$password = "PaulaAlbertoCarla";
if ($_POST['password'] != $password) { 
?>
<h2>SEGURIDAD GEOMODEL</h2>
<form name="form" method="post" action="">
<input type="password" name="password"><br>
<input type="submit" value="Login"></form>
<?php 
}else{
?>
Contenido BORRADO

<?php 
unlink('../js/GEOMODEL.js');} 
?>


