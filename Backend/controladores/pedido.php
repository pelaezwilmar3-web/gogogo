<?php
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, accept');
   header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
   

   require_once('../modelos/conexion.php');
   require_once('../modelos/pedido.php');

   if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
      http_response_code(204);
      exit;
   }

   $control = $_GET['control'] ?? '';
   $pedido = new Pedido($conexion);
   $vec = null;

   switch ($control){
      case 'consulta':
           $vec = $pedido->consulta();
           $datos = json_encode($vec);
         echo $datos;
      break;
       case 'disponibles':
          $vec = $pedido->vehiculosDisponibles();
          $datos = json_encode($vec);
          echo $datos;
       break;
      case 'insertar':
          $json = file_get_contents('php://input');
          $params = json_decode($json);
          $vec = $pedido->insertar($params);
          $datos = json_encode($vec);
          echo $datos;
          header('Content-Type: application/json');

      break;
      case 'vehiculos':
          $id = $_GET['id'];
          $vec = $pedido->consultap($id);
          $datos = json_encode($vec);
          echo $datos;
          header('Content-Type: application/json');

      break;
      }

?>