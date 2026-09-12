<?php

   class Ciudad {
        //atributos
       private $conexion;

       public function __construct($conexion) {
           $this->conexion = $conexion;
        }

        //metodos

       public function consulta() {
           $sql = "SELECT * FROM ciudad ORDER BY nombre";
           $res = mysqli_query($this->conexion, $sql) or die('no encontro la tabla ciudad');
        
           $vec = [];

           while ($row = mysqli_fetch_array($res)) {
              $vec[] = $row;
            }

            return $vec;
        }

        public function consulta2($id_dpto) {
           $sql = "SELECT * FROM ciudad WHERE fo_dpto = $id_dpto ORDER BY nombre";
           $res = mysqli_query($this->conexion, $sql) or die('no encontro la tabla ciudad');
        
           $vec = [];

           while ($row = mysqli_fetch_array($res)) {
              $vec[] = $row;
            }

            return $vec;
        }

        public function eliminar($id) {
            $sql = "DELETE FROM ciudad WHERE id_ciudad = $id";
            mysqli_query($this->conexion, $sql) or die('no elimino el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro eliminado correctamente";

            return $vec;
        }

        public function insertar($params) {
            $sql = "INSERT INTO ciudad (nombre, fo_dpto) VALUES ('$params-> nombre', $params->dpto)";
            mysqli_query($this->conexion, $sql) or die('no inserto el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro insertado correctamente";

            return $vec;
        }

         public function editar($id, $params) {
            $sql = "UPDATE ciudad SET nombre = '$params->nombre', fo_dpto = $params->dpto WHERE id_ciudad = $id";
            mysqli_query($this->conexion, $sql) or die('no edito el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro editado correctamente";

            return $vec;
        }

    } 
        
?>