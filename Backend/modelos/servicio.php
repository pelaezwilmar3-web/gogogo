<?php 
   class Servicio {
       //atributos
       private $conexion;

       public function __construct($conexion) {
           $this->conexion = $conexion;
        }

       //metodos
       public function consulta() {
           $sql = "SELECT * FROM servicio ORDER BY nombre";
           $res = mysqli_query($this->conexion, $sql) or die('no encontro la tabla servicio');
        
           $vec = [];

           while ($row = mysqli_fetch_array($res)) {
              $vec[] = $row;
            }

            return $vec;
        }

        public function eliminar($id) {
            $sql = "DELETE FROM servicio WHERE id_servicio = $id";
            mysqli_query($this->conexion, $sql) or die('no elimino el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro eliminado correctamente";

            return $vec;
        }

        public function insertar($params) {
            $sql = "INSERT INTO servicio (nombre, tipo) VALUES ('$params-> nombre', '$params->tipo')";
            mysqli_query($this->conexion, $sql) or die('no inserto el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro insertado correctamente";

            return $vec;
        }

         public function editar($id, $params) {
            $sql = "UPDATE servicio SET nombre = '$params->nombre', tipo = '$params->tipo' WHERE id_servicio = $id";
            mysqli_query($this->conexion, $sql) or die('no edito el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro editado correctamente";

            return $vec;
        }

    } 
?>