<?php
class Dashboard {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
        mysqli_query($this->conexion, "CREATE TABLE IF NOT EXISTS test_drive (
            id_test_drive INT NOT NULL AUTO_INCREMENT,
            fecha DATETIME NOT NULL,
            observaciones VARCHAR(255) NOT NULL DEFAULT '',
            fo_cliente INT NOT NULL,
            fo_modelo INT NOT NULL,
            fo_usuario INT NOT NULL,
            PRIMARY KEY (id_test_drive),
            KEY fo_cliente (fo_cliente),
            KEY fo_modelo (fo_modelo),
            KEY fo_usuario (fo_usuario)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

        $columnaAnterior = mysqli_query($this->conexion, "SHOW COLUMNS FROM test_drive LIKE 'fo_vehiculo'");
        if ($columnaAnterior && mysqli_num_rows($columnaAnterior) > 0) {
            mysqli_query($this->conexion, "ALTER TABLE test_drive CHANGE fo_vehiculo fo_modelo INT NOT NULL");
        }
    }

    public function resumen() {
        $stock = mysqli_query($this->conexion, "SELECT COUNT(*) AS total FROM vehiculo");
        $ventasMes = mysqli_query($this->conexion, "SELECT COALESCE(SUM(cantidad), 0) AS total FROM venta
            WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = MONTH(CURDATE())");
        $clientes = mysqli_query($this->conexion, "SELECT COUNT(*) AS total FROM cliente");
        $testDrives = mysqli_query($this->conexion, "SELECT COUNT(*) AS total FROM test_drive
            WHERE DATE(fecha) = CURDATE()");

        return [
            'stock' => (int) mysqli_fetch_assoc($stock)['total'],
            'ventas_mes' => (int) mysqli_fetch_assoc($ventasMes)['total'],
            'clientes' => (int) mysqli_fetch_assoc($clientes)['total'],
            'test_drives_hoy' => (int) mysqli_fetch_assoc($testDrives)['total'],
        ];
    }

    public function ventasPorMes() {
        $res = mysqli_query($this->conexion, "SELECT DATE_FORMAT(fecha, '%Y-%m') AS periodo,
            COALESCE(SUM(cantidad), 0) AS ventas FROM venta
                GROUP BY YEAR(fecha), MONTH(fecha) ORDER BY YEAR(fecha), MONTH(fecha)");
        $ventas = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $ventas[] = [
                'periodo' => $row['periodo'],
                'ventas' => (int) $row['ventas'],
            ];
        }
        return $ventas;
    }

    public function testDrives() {
        $res = mysqli_query($this->conexion, "SELECT td.*, cli.nombre AS cliente,
            mo.nombre AS modelo, u.nombre AS usuario
                FROM test_drive td
                INNER JOIN cliente cli ON td.fo_cliente = cli.id_cliente
                INNER JOIN modelo mo ON td.fo_modelo = mo.id_modelo
                INNER JOIN usuario u ON td.fo_usuario = u.id_usuario
                ORDER BY td.fecha DESC LIMIT 10");
        $registros = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $registros[] = $row;
        }
        return $registros;
    }

    public function insertarTestDrive($params) {
        if (!$params || empty($params->fecha) || empty($params->fo_cliente)
            || empty($params->fo_modelo) || empty($params->fo_usuario)) {
            return ['resultado' => 'ERROR', 'mensaje' => 'Completa cliente, vehículo, fecha y vendedor'];
        }

        $fecha = mysqli_real_escape_string($this->conexion, $params->fecha);
        $observaciones = mysqli_real_escape_string($this->conexion, $params->observaciones ?? '');
        $cliente = (int) $params->fo_cliente;
        $modelo = (int) $params->fo_modelo;
        $usuario = (int) $params->fo_usuario;

        $sql = "INSERT INTO test_drive (fecha, observaciones, fo_cliente, fo_modelo, fo_usuario)
            VALUES ('$fecha', '$observaciones', $cliente, $modelo, $usuario)";
        if (!mysqli_query($this->conexion, $sql)) {
            return ['resultado' => 'ERROR', 'mensaje' => 'No se pudo registrar el test drive'];
        }

        return ['resultado' => 'OK', 'mensaje' => 'Test drive registrado correctamente'];
    }
}
?>
