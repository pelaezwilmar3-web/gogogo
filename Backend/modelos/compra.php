 <?php 
       class Compra{
          //atributos
         private $conexion;

        public function __construct($conexion){
           $this->conexion = $conexion;
          }

         //metodos

        public function consulta(){
           $sql = "SELECT co.*, pr.contacto AS proveedor, veh.fo_modelo AS vehiculo,
               veh.serial, veh.`año`, veh.color, veh.precio, veh.fecha_ingreso,
               veh.fo_marca, veh.fo_modelo, u.nombre AS usuario FROM compra co
                   INNER JOIN proveedor pr ON co.fo_proveedor = pr.id_proveedor
                   INNER JOIN vehiculo veh ON co.fo_vehiculo = veh.id_vehiculo
                   INNER JOIN usuario u ON co.fo_usuario = u.id_usuario
                   ORDER BY fecha";
           $res = mysqli_query($this->conexion, $sql) or die('no encontro la tabla compra');
        
           $vec = [];

           while ($row = mysqli_fetch_array($res)) {
              $vec[] = $row;
            }

            return $vec;
        }

        public function eliminar($id){
            $sql = "DELETE FROM compra WHERE id_compra = $id";
            mysqli_query($this->conexion, $sql) or die('no elimino el registro');

            $vec = [];
            $vec ['resultado'] = "OK";
            $vec ['mensaje'] = "Registro eliminado correctamente";

            return $vec;
        }

        public function insertar($params){
            $serial = mysqli_real_escape_string($this->conexion, $params->serial);
            $color = mysqli_real_escape_string($this->conexion, $params->color);
            $fechaIngreso = mysqli_real_escape_string($this->conexion, $params->fecha_ingreso);
            $repetido = mysqli_query($this->conexion, "SELECT id_vehiculo FROM vehiculo WHERE serial = '$serial' LIMIT 1");
            if ($repetido && mysqli_num_rows($repetido) > 0) {
                return ['resultado' => 'ERROR', 'mensaje' => 'Ya existe un vehículo con ese serial'];
            }

            $crearVehiculo = "INSERT INTO vehiculo (serial, año, color, precio, fecha_ingreso, fo_marca, fo_modelo)
                              VALUES ('$serial', " . (int) $params->{'año'} . ", '$color', " . (float) $params->precio . ", '$fechaIngreso', " . (int) $params->fo_marca . ", " . (int) $params->fo_modelo . ")";
            if (!mysqli_query($this->conexion, $crearVehiculo)) {
                return ['resultado' => 'ERROR', 'mensaje' => 'No se pudo agregar el vehículo al stock'];
            }
            $idVehiculo = mysqli_insert_id($this->conexion);

            $sql = "INSERT INTO compra (fecha, cantidad, subtotal, total, impuesto, fo_usuario, fo_proveedor, fo_vehiculo) 
                    VALUES ('$params->fecha', $params->cantidad, $params->subtotal, $params->total, $params->impuesto, $params->fo_usuario,
                    $params->fo_proveedor, $idVehiculo)";
             
            mysqli_query($this->conexion, $sql) or die('no inserto el registro');

            $vec = [];
            $vec ['resultado'] = "OK";
            $vec ['mensaje'] = "Registro insertado correctamente";

            return $vec;
        }

        public function editar($id, $params){
            $sql = "UPDATE compra SET fecha = '$params->fecha', cantidad = $params->cantidad, subtotal = $params->subtotal, 
                    total = $params->total, impuesto = $params->impuesto, fo_usuario = $params->fo_usuario, 
                    fo_proveedor = $params->fo_proveedor, fo_vehiculo = $params->fo_vehiculo WHERE id_compra = $id";

            mysqli_query($this->conexion, $sql) or die('no edito el registro');

            $vec = [];
            $vec ['resultado'] = "OK";
            $vec ['mensaje'] = "Registro editado correctamente";

            return $vec;
        }

    } 
 ?>