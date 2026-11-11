<?php

$servidor = "localhost";
$usuario = "root"; 
$password = "";    
$base_de_datos = "parcial_web"; 


$conexion = mysqli_connect($servidor, $usuario, $password, $base_de_datos);

if (!$conexion) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}


mysqli_set_charset($conexion, "utf8");
?>