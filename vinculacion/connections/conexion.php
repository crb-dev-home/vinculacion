<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexion = "localhost";
$database_conexion = "vinculacion";
$username_conexion = "root";
#$password_conexion = "Ns086b4jngG775j";
$password_conexion = "";

$conexion = @mysqli_connect($hostname_conexion, $username_conexion, $password_conexion, $database_conexion) OR DIE("Servidor no disponible, intente mas tarde..."); 

?>