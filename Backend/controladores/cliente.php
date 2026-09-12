<?php 
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, accept');
   header('Content-Type: application/json');

   require_once('../modelos/conexion.php');
   require_once('../modelos/cliente.php');

   $control = $_GET['control'];
   $cliente = new Cliente($conexion);

   switch ($control){
       case 'consulta':
           $vec = $cliente->consulta();
        break;
        case 'insertar':
           $json = file_get_contents('php://input');
           $params = json_decode($json);

            if (!$params || empty($params->identificacion) || empty($params->nombre) || empty($params->direccion) || empty($params->celular) || empty($params->email) || empty($params->fo_ciudad)) {
               http_response_code(400);
               echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Todos los campos del cliente son obligatorios']);
               exit;
            }

           $vec = $cliente->insertar($params);
        break;
        case 'editar':
           $json = file_get_contents('php://input');
           $id = (int) $_GET['id'];
           $params = json_decode($json);

         if (!$params || empty($params->identificacion) || empty($params->nombre) || empty($params->direccion) || empty($params->celular) || empty($params->email) || empty($params->fo_ciudad)) {
            http_response_code(400);
            echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Todos los campos del cliente son obligatorios']);
            exit;
         }

           $vec = $cliente->editar($id, $params);
        break;
        case 'eliminar':
           $id = (int) $_GET['id'];

           $vec = $cliente->eliminar($id);
        break;
   }

      if (isset($vec['resultado']) && $vec['resultado'] === 'ERROR') {
         http_response_code(409);
      }

      $datos = json_encode($vec);
   echo $datos;
   
?>