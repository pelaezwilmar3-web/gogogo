<?php 
   class Proveedor {
        //atributos
       private $conexion;

       public function __construct($conexion) {
           $this->conexion = $conexion;
        }

        //metodos

       public function consulta() {
           $sql = "SELECT * FROM proveedor ORDER BY contacto";
           $res = mysqli_query($this->conexion, $sql) or die('no encontro la tabla proveedor');
        
           $vec = [];

           while ($row = mysqli_fetch_array($res)) {
              $vec[] = $row;
            }

            return $vec;
        }

        public function eliminar($id) {
            $sql = "DELETE FROM proveedor WHERE id_proveedor = $id";
            mysqli_query($this->conexion, $sql) or die('no elimino el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro eliminado correctamente";

            return $vec;
        }

        public function insertar($params) {
            $sql = "INSERT INTO proveedor (nit, razon_social, direccion, celular, email, fecha_registro, contacto) VALUES ('$params->nit', '$params->razon_social', '$params->direccion', '$params->celular', '$params->email', '$params->fecha_registro', '$params->contacto')";
            mysqli_query($this->conexion, $sql) or die('no inserto el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro insertado correctamente";

            return $vec;
        }

         public function editar($id, $params) {
            $sql = "UPDATE proveedor SET nit = '$params->nit', razon_social = '$params->razon_social', direccion = '$params->direccion', celular = '$params->celular', email = '$params->email', fecha_registro = '$params->fecha_registro', contacto = '$params->contacto' WHERE id_proveedor = $id";
            mysqli_query($this->conexion, $sql) or die('no edito el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro editado correctamente";

            return $vec;
        }

    }
?>