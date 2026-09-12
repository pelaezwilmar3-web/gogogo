<?php 
   class Vehiculo {
        //atributos
       private $conexion;

       public function __construct($conexion) {
           $this->conexion = $conexion;
        }

        //metodos

       public function consulta(){
           $sql = "SELECT veh.*, ma.nombre AS marca, mo.nombre AS modelo FROM vehiculo veh
                   INNER JOIN marca ma ON veh.fo_marca = ma.id_marca
                   INNER JOIN modelo mo ON veh.fo_modelo = mo.id_modelo
                   ORDER BY veh.fecha_ingreso";
           $res = mysqli_query($this->conexion, $sql) or die('no encontro la tabla vehiculo');
        
           $vec = [];

           while ($row = mysqli_fetch_array($res)) {
              $vec[] = $row;
            }

            return $vec;
        }

       

        public function eliminar($id){
                $venta = mysqli_query($this->conexion, "SELECT COUNT(*) AS total FROM venta WHERE fo_vehiculo = $id");
                $compra = mysqli_query($this->conexion, "SELECT COUNT(*) AS total FROM compra WHERE fo_vehiculo = $id");
                if (($venta && mysqli_fetch_assoc($venta)['total'] > 0) || ($compra && mysqli_fetch_assoc($compra)['total'] > 0)) {
                    return ['resultado' => 'ERROR', 'mensaje' => 'No se puede eliminar: el vehículo tiene compras o ventas relacionadas'];
                }

            $sql = "DELETE FROM vehiculo WHERE id_vehiculo = $id";
                if (!mysqli_query($this->conexion, $sql)) {
                    return ['resultado' => 'ERROR', 'mensaje' => 'No se pudo eliminar el vehículo'];
                }

            $vec = [];
            $vec ['resultado'] = "OK";
            $vec ['mensaje'] = "Registro eliminado correctamente";

            return $vec;
        }

        public function insertar($params){
            $serial = mysqli_real_escape_string($this->conexion, $params->serial);
            $repetido = mysqli_query($this->conexion, "SELECT id_vehiculo FROM vehiculo WHERE serial = '$serial' LIMIT 1");
            if ($repetido && mysqli_num_rows($repetido) > 0) {
                return ['resultado' => 'ERROR', 'mensaje' => 'Ya existe un vehículo con ese serial'];
            }

            $sql = "INSERT INTO vehiculo (serial, año, color, precio, fecha_ingreso, fo_marca, fo_modelo) VALUES ('$params->serial', $params->año, '$params->color', $params->precio, '$params->fecha_ingreso', $params->fo_marca, $params->fo_modelo)";
            if (!mysqli_query($this->conexion, $sql)) {
                return ['resultado' => 'ERROR', 'mensaje' => 'No se pudo insertar el vehículo'];
            }

            $vec = [];
            $vec ['resultado'] = "OK";
            $vec ['mensaje'] = "Registro insertado correctamente";

            return $vec;
        }

         public function editar($id, $params){
            $modelosRenault = [1, 3, 4, 6, 7, 8];
            $modelosVolkswagen = [2, 5, 9, 10, 11, 12];
            $modelosValidos = ((int) $params->fo_marca === 1) ? $modelosVolkswagen : (((int) $params->fo_marca === 2) ? $modelosRenault : []);
            if (!in_array((int) $params->fo_modelo, $modelosValidos, true)) {
                return ['resultado' => 'ERROR', 'mensaje' => 'El modelo no pertenece a la marca seleccionada'];
            }

            $sql = "UPDATE vehiculo SET serial = '$params->serial', año = $params->año, color = '$params->color', precio = $params->precio, fecha_ingreso = '$params->fecha_ingreso', fo_marca = $params->fo_marca, fo_modelo = $params->fo_modelo WHERE id_vehiculo = $id";
            if (!mysqli_query($this->conexion, $sql)) {
                return ['resultado' => 'ERROR', 'mensaje' => 'No se pudo editar el vehículo'];
            }

            $vec = [];
            $vec ['resultado'] = "OK";
            $vec ['mensaje'] = "Registro editado correctamente";

            return $vec;
        }

    } 
?>