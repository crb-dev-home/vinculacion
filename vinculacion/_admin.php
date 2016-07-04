<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<?php

session_start();
if(isset($_SESSION['usuario'])) 
{
  header('Location: pages/solicitudes.php'); 
  exit();
}

?>
<title>Gestión Tecnológica y Vinculación</title>
<link rel="icon" href="images/favicon.ico" type="image/ico" />

<style type="text/css">
@import url("css/main.css");
</style>
<link rel="stylesheet" href="css/menu.css" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Marcellus' rel='stylesheet' type='text/css'/>
</head>
<body>
<div class="container">
  <div class="header">
  <?php include("includes/header.php"); ?>
  <br class="clearfloat" />

</div>
    
<span class="archive-title">Departamento de Gestión</span>
<h1 class="featured-title">Tecnológica y Vinculación</h1>

<div class="content bg1">
<center>
<form action="functions/validar_usuario.php" method="post">
	<table>
		<tr>
			<td>Usuario:</td>
			<td><input class="textboxLogin" type="text" name="admin" required="required"/></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input class="textboxLogin" type="password" name="password_usuario" required="required"/></td>
		</tr>
		<tr>
			<td colspan="2"><center><input class="login" type="submit" value="Iniciar Sesión" name="iniciar"/></center></td>
			
		</tr>
	</table>
</form>
</center>
</div>


<br class="clearfloat" />

<div class="footer"><?php include("includes/footer.php"); ?>
</div>
</div>
</body>
</html>
