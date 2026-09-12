<?php 
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, accept');

   require_once('../modelos/conexion.php');
   require_once('../modelos/marca.php');

   $control = $_GET['control'];
   $marca = new Marca($conexion);

   switch ($control){
       case 'consulta':
           $vec = $marca->consulta();
        break;
        case 'insertar':
           $json = file_get_contents('php://input');
           $params = json_decode($json);

           $vec = $marca->insertar($params);
        break;
        case 'editar':
           $json = file_get_contents('php://input');
           $id = $_GET['id'];;
           $params = json_decode($json);

           $vec = $marca->editar($id, $params);
        break;
        case 'eliminar':
           $id = $_GET['id'];

           $vec = $marca->eliminar($id);
        break;
   }

   $datos = json_encode($vec);
   echo $datos;
   header('Content-Type: application/json');
?>