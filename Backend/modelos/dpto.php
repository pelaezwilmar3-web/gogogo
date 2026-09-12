<?php
   
   class Dpto {
        //atributos
       private $conexion;

       public function __construct($conexion) {
           $this->conexion = $conexion;
        }

        //metodos

       public function consulta() {
           $sql = "SELECT * FROM dpto ORDER BY nombre";
           $res = mysqli_query($this->conexion, $sql) or die('no encontro la tabla dpto');
        
           $vec = [];

           while ($row = mysqli_fetch_array($res)) {
              $vec[] = $row;
            }

            return $vec;
        }

        public function eliminar($id) {
            $sql = "DELETE FROM dpto WHERE id_dpto = $id";
            mysqli_query($this->conexion, $sql) or die('no elimino el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro eliminado correctamente";

            return $vec;
        }

        public function insertar($params) {
            $sql = "INSERT INTO dpto (nombre, fo_pais) VALUES ('$params-> nombre', $params->pais)";
            mysqli_query($this->conexion, $sql) or die('no inserto el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro insertado correctamente";

            return $vec;
        }

         public function editar($id, $params) {
            $sql = "UPDATE dpto SET nombre = '$params->nombre', fo_pais = $params->pais WHERE id_dpto = $id";
            mysqli_query($this->conexion, $sql) or die('no edito el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro editado correctamente";

            return $vec;
        }

    } 
        
?>