<?php 
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, accept');
   header('Content-Type: application/json');

   require_once('../modelos/conexion.php');
   require_once('../modelos/vehiculo.php');

   $control = $_GET['control'] ?? null;
   $vec = [];

   $vehiculo = new Vehiculo($conexion);

   switch ($control){
       case 'consulta':
           $vec = $vehiculo->consulta();
        break;
        case 'insertar':
           $json = file_get_contents('php://input');
           $params = json_decode($json);

            if (!$params || empty($params->serial) || empty($params->{'año'}) || empty($params->color) || empty($params->precio) || empty($params->fecha_ingreso) || empty($params->fo_marca) || empty($params->fo_modelo)) {
               http_response_code(400);
               echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Todos los campos del vehículo son obligatorios']);
               exit;
            }

           $vec = $vehiculo->insertar($params);
        break;
        case 'editar':
           $json = file_get_contents('php://input');
           $id = $_GET['id'];;
           $params = json_decode($json);

           $vec = $vehiculo->editar($id, $params);
        break;
        case 'eliminar':
           $id = $_GET['id'];

           $vec = $vehiculo->eliminar($id);
        break;
   }

   $datos = json_encode($vec);
      if (isset($vec['resultado']) && $vec['resultado'] === 'ERROR') {
         http_response_code(409);
      }
   echo json_encode($vec);
?>