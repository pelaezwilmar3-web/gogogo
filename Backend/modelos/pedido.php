<?php
       class Pedido{
          //atributos
         private $conexion;

        public function __construct($conexion){
           $this->conexion = $conexion;
          }

         //metodos

        public function consulta(){
           $sql = "SELECT ped.*, cli.nombre AS cliente, mo.nombre AS vehiculo, u.nombre AS usuario FROM venta ped
               LEFT JOIN cliente cli ON ped.fo_cliente = cli.id_cliente
               LEFT JOIN vehiculo veh ON ped.fo_vehiculo = veh.id_vehiculo
               LEFT JOIN modelo mo ON veh.fo_modelo = mo.id_modelo
               LEFT JOIN usuario u ON ped.fo_usuario = u.id_usuario
               ORDER BY ped.fecha DESC, ped.id_venta DESC";
           $res = mysqli_query($this->conexion, $sql) or die('no encontro la tabla venta');
        
           $vec = [];

           while ($row = mysqli_fetch_array($res)) {
              $vec[] = $row;
            }

            return $vec;
        }

        public function vehiculosDisponibles(){
            $sql = "SELECT veh.*, ma.nombre AS marca, mo.nombre AS modelo
                    FROM vehiculo veh
                    LEFT JOIN marca ma ON veh.fo_marca = ma.id_marca
                    LEFT JOIN modelo mo ON veh.fo_modelo = mo.id_modelo
                    ORDER BY veh.fecha_ingreso";
            $res = mysqli_query($this->conexion, $sql) or die('no encontro los vehiculos disponibles');
            $vec = [];

            while ($row = mysqli_fetch_array($res)) {
                $vec[] = $row;
            }

            return $vec;
        }

        public function insertar($params){
            if (!$params || empty($params->fecha) || empty($params->fo_cliente) || empty($params->fo_usuario) || empty($params->vehiculos)) {
                return ['resultado' => 'ERROR', 'mensaje' => 'El pedido necesita cliente, vendedor y al menos un vehículo'];
            }

            $fecha = mysqli_real_escape_string($this->conexion, $params->fecha);
            $cliente = (int) $params->fo_cliente;
            $usuario = (int) $params->fo_usuario;

            foreach ($params->vehiculos as $vehiculo) {
                $idVehiculo = (int) ($vehiculo->id_vehiculo ?? 0);
                $cantidad = (int) ($vehiculo->cantidad ?? 0);
                $precioVehiculo = mysqli_query($this->conexion, "SELECT precio FROM vehiculo WHERE id_vehiculo = $idVehiculo LIMIT 1");
                if (!$precioVehiculo || mysqli_num_rows($precioVehiculo) === 0) {
                    return ['resultado' => 'ERROR', 'mensaje' => 'El vehículo seleccionado no existe'];
                }
                $precioBase = (float) mysqli_fetch_assoc($precioVehiculo)['precio'];
                $precio = round($precioBase * 1.10, 2);
                $subtotal = $cantidad * $precio;

                if ($idVehiculo <= 0 || $cantidad <= 0 || $precio < 0) {
                    return ['resultado' => 'ERROR', 'mensaje' => 'Hay un vehículo o cantidad no válida'];
                }

                $sql = "INSERT INTO venta (fecha, cantidad, precio, subtotales, subtotal_final, iva, total, fo_cliente, fo_usuario, fo_vehiculo)
                    VALUES ('$fecha', $cantidad, $precio, $subtotal, $subtotal, ROUND($subtotal * 0.19, 2), ROUND($subtotal * 1.19, 2), $cliente, $usuario, $idVehiculo)";

                if (!mysqli_query($this->conexion, $sql)) {
                    return ['resultado' => 'ERROR', 'mensaje' => 'No se pudo insertar el pedido'];
                }
            }

            $vec = [];
            $vec ['resultado'] = "OK";
            $vec ['mensaje'] = "Registro insertado correctamente";

            return $vec;
        }

        public function consultap($id){
                 $con = "SELECT ven.fo_cliente, cli.identificacion, cli.nombre AS cliente,
                          ven.fo_vehiculo AS id_vehiculo, veh.fo_modelo AS id_modelo,
                   veh.serial, ma.nombre AS marca, mo.nombre AS modelo,
                   ven.precio, ven.cantidad, ven.subtotales AS subtotal,
                   ven.iva, ven.total
                    FROM venta ven
                      LEFT JOIN cliente cli ON ven.fo_cliente = cli.id_cliente
                LEFT JOIN vehiculo veh ON ven.fo_vehiculo = veh.id_vehiculo
                LEFT JOIN marca ma ON veh.fo_marca = ma.id_marca
                LEFT JOIN modelo mo ON veh.fo_modelo = mo.id_modelo
                    WHERE ven.id_venta = $id";
            $res = mysqli_query($this->conexion, $con);
            $vec = [];

            while ($row = mysqli_fetch_array($res)) {
                $vec[] = $row;
            }

            return $vec;
        }
    }
?>