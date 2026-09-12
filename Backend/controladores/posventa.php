<?php 
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, accept');
   header('Content-Type: application/json');

   require_once('../modelos/conexion.php');
   require_once('../modelos/posventa.php');

   $control = $_GET['control'];
   $posventa = new Posventa($conexion);

   switch ($control){
       case 'consulta':
           $vec = $posventa->consulta();
        break;
        case 'insertar':
           $json = file_get_contents('php://input');
           $params = json_decode($json);

           $vec = $posventa->insertar($params);
        break;
        case 'editar':
           $json = file_get_contents('php://input');
           $id = $_GET['id'];;
           $params = json_decode($json);

           $vec = $posventa->editar($id, $params);
        break;
        case 'eliminar':
           $id = $_GET['id'];

           $vec = $posventa->eliminar($id);
        break;
   }

   $datos = json_encode($vec);
   echo $datos;
   
?>