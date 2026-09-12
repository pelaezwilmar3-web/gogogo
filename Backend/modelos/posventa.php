<?php 
       class Posventa{
          //atributos
         private $conexion;

        public function __construct($conexion){
           $this->conexion = $conexion;
          }

         //metodos

        public function consulta(){
           $sql = "SELECT pos.*, cli.nombre AS cliente, mo.nombre AS  vehiculo, u.nombre AS usuario, se.nombre AS servicio FROM posventa pos
                   INNER JOIN cliente cli ON pos.fo_cliente = cli.id_cliente
                   INNER JOIN vehiculo veh ON pos.fo_vehiculo = veh.id_vehiculo
                   INNER JOIN modelo mo ON veh.fo_modelo = mo.id_modelo
                   INNER JOIN usuario u ON pos.fo_usuario = u.id_usuario
                   INNER JOIN servicio se ON pos.fo_servicio = se.id_servicio
                   ORDER BY fecha_programada";
           $res = mysqli_query($this->conexion, $sql) or die('no encontro la tabla posventa');
        
           $vec = [];

           while ($row = mysqli_fetch_array($res)) {
              $vec[] = $row;
            }

            return $vec;
        }

        public function eliminar($id){
            $sql = "DELETE FROM posventa WHERE id_posventa = $id";
            mysqli_query($this->conexion, $sql) or die('no elimino el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro eliminado correctamente";

            return $vec;
        }

        public function insertar($params){
            $sql = "INSERT INTO posventa (fecha_solicitud, fecha_programada, estado_servicio, costo_estimado, costo_final, 
                    fo_servicio, fo_cliente, fo_vehiculo, fo_usuario) 
                    VALUES ('$params->fecha_solicitud', '$params->fecha_programada', '$params->estado_servicio', 
                    $params->costo_estimado, $params->costo_final, $params->fo_servicio, $params->fo_cliente, 
                    $params->fo_vehiculo, $params->fo_usuario)";
             
            mysqli_query($this->conexion, $sql) or die('no inserto el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro insertado correctamente";

            return $vec;
        }

        public function editar($id, $params){
            $sql = "UPDATE posventa SET fecha_solicitud = '$params->fecha_solicitud', 
                    fecha_programada = '$params->fecha_programada', estado_servicio = '$params->estado_servicio', 
                    costo_estimado = $params->costo_estimado, costo_final = $params->costo_final, 
                    fo_servicio = $params->fo_servicio, fo_cliente = $params->fo_cliente, 
                    fo_vehiculo = $params->fo_vehiculo, fo_usuario = $params->fo_usuario WHERE id_posventa = $id";

            mysqli_query($this->conexion, $sql) or die('no edito el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro editado correctamente";

            return $vec;
        }

    } 
 ?>