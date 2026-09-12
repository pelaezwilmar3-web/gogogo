<?php

   class Pais {
        //atributos
       private $conexion;

       public function __construct($conexion) {
           $this->conexion = $conexion;
        }

        //metodos

       public function consulta() {
           $sql = "SELECT * FROM pais";
           $res = mysqli_query($this->conexion, $sql) or die('no encontro la tabla pais');
        
           $vec = [];

           while ($row = mysqli_fetch_array($res)) {
              $vec[] = $row;
            }

            return $vec;
        }

        public function eliminar($id) {
            $sql = "DELETE FROM pais WHERE id_pais = $id";
            mysqli_query($this->conexion, $sql) or die('no elimino el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro eliminado correctamente";

            return $vec;
        }

        public function insertar($params) {
            $sql = "INSERT INTO pais (nombre) VALUES ('$params-> nombre')";
            mysqli_query($this->conexion, $sql) or die('no inserto el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro insertado correctamente";

            return $vec;
        }

         public function editar($id, $params) {
            $sql = "UPDATE pais SET nombre = '$params->nombre' WHERE id_pais = $id";
            mysqli_query($this->conexion, $sql) or die('no edito el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro editado correctamente";

            return $vec;
        }

    } 

?>