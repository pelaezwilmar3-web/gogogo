<?php 
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, accept');
   header('Content-Type: application/json');

   require_once('../modelos/conexion.php');
   require_once('../modelos/usuario.php');

   $control = $_GET['control'];
   $usuario = new Usuario($conexion);

   switch ($control){
       case 'consulta':
           $vec = $usuario->consulta();
        break;
        case 'insertar':
           $json = file_get_contents('php://input');
           $params = json_decode($json);

           $vec = $usuario->insertar($params);
        break;
        case 'registrar':
           $json = file_get_contents('php://input');
           $params = json_decode($json);

           $vec = $usuario->registrar($params);
        break;
        case 'editar':
           $json = file_get_contents('php://input');
           $id = $_GET['id'];;
           $params = json_decode($json);

           $vec = $usuario->editar($id, $params);
        break;
        case 'eliminar':
           $id = $_GET['id'];

           $vec = $usuario->eliminar($id);
        break;
   }

   $datos = json_encode($vec);
   echo $datos;
   
?>