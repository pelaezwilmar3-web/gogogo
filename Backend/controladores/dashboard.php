<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, accept');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Content-Type: application/json');

require_once('../modelos/conexion.php');
require_once('../modelos/dashboard.php');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$dashboard = new Dashboard($conexion);
$control = $_GET['control'] ?? 'resumen';

switch ($control) {
    case 'resumen':
        echo json_encode($dashboard->resumen());
        break;
    case 'ventas-mes':
        echo json_encode($dashboard->ventasPorMes());
        break;
    case 'test-drives':
        echo json_encode($dashboard->testDrives());
        break;
    case 'insertar-test-drive':
        $params = json_decode(file_get_contents('php://input'));
        echo json_encode($dashboard->insertarTestDrive($params));
        break;
    default:
        http_response_code(400);
        echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Control no válido']);
}
?>
