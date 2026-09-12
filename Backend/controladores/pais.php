<?php 
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, accept');

   require_once('../modelos/conexion.php');
   require_once('../modelos/pais.php');

   $control = $_GET['control'];
   $pais = new Pais($conexion);

   switch ($control){
       case 'consulta':
           $vec = $pais->consulta();
        break;
        case 'insertar':
           $json = file_get_contents('php://input');
           $params = json_decode($json);

           $vec = $pais->insertar($params);
        break;
        case 'editar':
           $json = file_get_contents('php://input');
           $id = $_GET['id'];;
           $params = json_decode($json);

           $vec = $pais->editar($id, $params);
        break;
        case 'eliminar':
           $id = $_GET['id'];

           $vec = $pais->eliminar($id);
        break;
   }

   $datos = json_encode($vec);
   echo $datos;
   header('Content-Type: application/json');
?>