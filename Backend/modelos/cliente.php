<?php 
   class Cliente {
       //atributos
       private $conexion;

       public function __construct($conexion) {
           $this->conexion = $conexion;
        }

       //metodos
       public function consulta() {
           $sql = "SELECT * FROM cliente ORDER BY nombre";
           $res = mysqli_query($this->conexion, $sql) or die('no encontro la tabla cliente');
        
           $vec = [];

           while ($row = mysqli_fetch_array($res)) {
              $vec[] = $row;
            }

            return $vec;
        }

         public function consulta2($id_ciudad) {
           $sql = "SELECT * FROM cliente WHERE fo_ciudad = $id_ciudad ORDER BY nombre";
           $res = mysqli_query($this->conexion, $sql) or die('no encontro la tabla cliente');
        
           $vec = [];

           while ($row = mysqli_fetch_array($res)) {
              $vec[] = $row;
            }

            return $vec;
        }

        public function eliminar($id) {
            $referencias = mysqli_query($this->conexion, "SELECT COUNT(*) AS total FROM venta WHERE fo_cliente = $id");
            if ($referencias && mysqli_fetch_assoc($referencias)['total'] > 0) {
                return ['resultado' => 'ERROR', 'mensaje' => 'No se puede eliminar: el cliente tiene ventas relacionadas'];
            }

            $sql = "DELETE FROM cliente WHERE id_cliente = $id";
            if (!mysqli_query($this->conexion, $sql)) {
                return ['resultado' => 'ERROR', 'mensaje' => 'No se pudo eliminar el cliente'];
            }

            $vec = [];
            $vec ['resultado'] = "OK";
            $vec ['mensaje'] = "Registro eliminado correctamente";

            return $vec;
        }

        public function insertar($params) {
            $identificacion = mysqli_real_escape_string($this->conexion, $params->identificacion);
            $repetido = mysqli_query($this->conexion, "SELECT id_cliente FROM cliente WHERE identificacion = '$identificacion' LIMIT 1");
            if ($repetido && mysqli_num_rows($repetido) > 0) {
                return ['resultado' => 'ERROR', 'mensaje' => 'Ya existe un cliente con esa identificación'];
            }

            $sql = "INSERT INTO cliente ( identificacion, nombre, direccion, celular, email, fo_ciudad) VALUES ('$params->identificacion', '$params->nombre', '$params->direccion', '$params->celular', '$params->email', $params->fo_ciudad)";
            if (!mysqli_query($this->conexion, $sql)) {
                return ['resultado' => 'ERROR', 'mensaje' => 'No se pudo insertar el cliente'];
            }

            $vec = [];
            $vec ['resultado'] = "OK";
            $vec ['mensaje'] = "Registro insertado correctamente";

            return $vec;
        }

         public function editar($id, $params) {
            $identificacion = mysqli_real_escape_string($this->conexion, $params->identificacion);
            $repetido = mysqli_query($this->conexion, "SELECT id_cliente FROM cliente WHERE identificacion = '$identificacion' AND id_cliente <> $id LIMIT 1");
            if ($repetido && mysqli_num_rows($repetido) > 0) {
                return ['resultado' => 'ERROR', 'mensaje' => 'Ya existe otro cliente con esa identificación'];
            }

            $sql = "UPDATE cliente SET  identificacion= '$params->identificacion', nombre = '$params->nombre', direccion = '$params->direccion', celular = '$params->celular', email = '$params->email', fo_ciudad = $params->fo_ciudad WHERE id_cliente = $id";
            if (!mysqli_query($this->conexion, $sql)) {
                return ['resultado' => 'ERROR', 'mensaje' => 'No se pudo editar el cliente'];
            }

            $vec = [];
            $vec ['resultado'] = "OK";
            $vec ['mensaje'] = "Registro editado correctamente";

            return $vec;
        }

    }
?>