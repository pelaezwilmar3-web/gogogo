<?php 
       class Venta{
          //atributos
         private $conexion;

        public function __construct($conexion){
           $this->conexion = $conexion;
          }

         //metodos

        public function consulta(){
           $sql = "SELECT ven.*, cli.nombre AS cliente, mo.nombre AS  vehiculo, u.nombre AS usuario FROM venta ven
                   INNER JOIN cliente cli ON ven.fo_cliente = cli.id_cliente
                   INNER JOIN vehiculo veh ON ven.fo_vehiculo = veh.id_vehiculo
                   INNER JOIN modelo mo ON veh.fo_modelo = mo.id_modelo
                   INNER JOIN usuario u ON ven.fo_usuario = u.id_usuario
                   ORDER BY fecha";
           $res = mysqli_query($this->conexion, $sql) or die('no encontro la tabla venta');
        
           $vec = [];

           while ($row = mysqli_fetch_array($res)) {
              $vec[] = $row;
            }

            return $vec;
        }

        public function insertar($params){
            $sql = "INSERT INTO venta (fecha, cantidad, precio, subtotales, subtotal_final, iva, total, fo_cliente, fo_usuario, fo_vehiculo) 
                    VALUES ('$params->fecha', $params->cantidad, $params->precio, $params->subtotales, $params->subtotal_final, $params->iva, $params->total, $params->fo_cliente, $params->fo_usuario, $params->fo_vehiculo)";
             
            mysqli_query($this->conexion, $sql) or die('no inserto el registro');

            $vec = [];
            $vec ['resultado'] = "OK";
            $vec ['mensaje'] = "Registro insertado correctamente";

            return $vec;
        }

        public function eliminar($id){
            $sql = "DELETE FROM venta WHERE id_venta = $id";
            mysqli_query($this->conexion, $sql) or die('no elimino el registro');

            $vec = [];
            $vec ['resultado'] = "OK";
            $vec ['mensaje'] = "Registro eliminado correctamente";

            return $vec;
        }

        public function editar($id, $params){
            $sql = "UPDATE venta SET fecha = '$params->fecha', cantidad = $params->cantidad, precio = $params->precio, 
                    subtotales = $params->subtotales, subtotal_final = $params->subtotal_final, iva = $params->iva, 
                    total = $params->total, fo_cliente = $params->fo_cliente, fo_usuario = $params->fo_usuario, 
                    fo_vehiculo = $params->fo_vehiculo WHERE id_venta = $id";

            mysqli_query($this->conexion, $sql) or die('no edito el registro');

            $vec = [];
            $vec ['resultado'] = "OK";
            $vec ['mensaje'] = "Registro editado correctamente";

            return $vec;
        }

    } 
 ?>