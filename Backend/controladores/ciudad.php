<?php 
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, accept');
   header('Content-Type: application/json');
   
   require_once('../modelos/conexion.php');
   require_once('../modelos/ciudad.php');

   $control = $_GET['control'];
   $ciudad = new Ciudad($conexion);

   switch ($control){
       case 'consulta':
           $vec = $ciudad->consulta();
        break;
        case 'insertar':
           $json = file_get_contents('php://input');
           $params = json_decode($json);

           $vec = $ciudad->insertar($params);
        break;
        case 'editar':
           $json = file_get_contents('php://input');
           $id = $_GET['id'];;
           $params = json_decode($json);

           $vec = $ciudad->editar($id, $params);
        break;
        case 'eliminar':
           $id = $_GET['id'];

           $vec = $ciudad->eliminar($id);
        break;
   }

   $datos = json_encode($vec);
   echo $datos;
   
?>