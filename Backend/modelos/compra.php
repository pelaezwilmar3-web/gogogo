 <?php 
       class Compra{
          //atributos
         private $conexion;

        public function __construct($conexion){
           $this->conexion = $conexion;
          }

         //metodos

        public function consulta(){
           $sql = "SELECT co.*, pr.contacto AS proveedor, veh.fo_modelo AS vehiculo, u.nombre AS usuario FROM compra co
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
            $sql = "INSERT INTO compra (fecha, cantidad, subtotal, total, impuesto, fo_usuario, fo_proveedor, fo_vehiculo) 
                    VALUES ('$params->fecha', $params->cantidad, $params->subtotal, $params->total, $params->impuesto, $params->fo_usuario,
                    $params->fo_proveedor, $params->fo_vehiculo)";
             
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