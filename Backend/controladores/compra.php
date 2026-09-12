<?php 
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, accept');
   header('Content-Type: application/json');

   require_once('../modelos/conexion.php');
   require_once('../modelos/compra.php');

   $control = $_GET['control'];
   $compra = new Compra($conexion);

   switch ($control){
       case 'consulta':
           $vec = $compra->consulta();
        break;
        case 'insertar':
           $json = file_get_contents('php://input');
           $params = json_decode($json);

         if (!$params || empty($params->fecha) || empty($params->cantidad) || empty($params->subtotal) || empty($params->total) || empty($params->impuesto) || empty($params->fo_usuario) || empty($params->fo_proveedor) || empty($params->fo_vehiculo)) {
            http_response_code(400);
            echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Todos los campos de la compra son obligatorios']);
            exit;
         }

           $vec = $compra->insertar($params);
        break;
        case 'editar':
           $json = file_get_contents('php://input');
           $id = $_GET['id'];;
           $params = json_decode($json);

           $vec = $compra->editar($id, $params);
        break;
        case 'eliminar':
           $id = $_GET['id'];

           $vec = $compra->eliminar($id);
        break;
   }

   $datos = json_encode($vec);
   echo $datos;
   
?>