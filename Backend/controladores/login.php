<?php 
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, accept');
   header('Content-Type: application/json');

   require_once('../modelos/conexion.php');
   require_once('../modelos/login.php');

   $email = $_GET['email'] ?? '';
   $clave = $_GET['clave'] ?? '';

   $login = new Login($conexion);

   $vec = $login->consulta($email, $clave);

   $datos = json_encode($vec);
   echo $datos;

?>