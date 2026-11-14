<?php
$esLocal = ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1');

if ($esLocal) {
    
define('BASE_URL', '/repoGithub');

$servidor = "127.0.0.1";
$usuario = "root"; 
$password = "";    
$baseDatos = "parcial_web"; 

} else {

define('BASE_URL', '');

$servidor = "sql101.infinityfree.com";
$usuario = "if0_43435096"; 
$password = "qDyj9iWR55DE";    
$baseDatos = "if0_43435096_coolswag"; 
}

?>

