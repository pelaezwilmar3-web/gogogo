<?php

   class Login {
        //atributos
       public $conexion;

       public function __construct($conexion) {
           $this->conexion = $conexion;
        }

        //metodos
        public function consulta($email, $clave){
           $vec = [];

           $con = "SELECT u.id_usuario, u.nombre, u.celular, u.email, u.clave, u.fo_rol, r.nombre AS rol
                   FROM usuario u
                   INNER JOIN rol r ON r.id_rol = u.fo_rol
                   WHERE u.email = ?";
           $stmt = mysqli_prepare($this->conexion, $con);

           if ($stmt) {
              mysqli_stmt_bind_param($stmt, 's', $email);
              mysqli_stmt_execute($stmt);
              $res = mysqli_stmt_get_result($stmt);

              $row = mysqli_fetch_assoc($res);

              if (!$row) {
                 $vec[] = array("validar" => "usuario_no_existe");
              } elseif ($row['clave'] !== $clave) {
                 $vec[] = array("validar" => "clave_incorrecta");
              } else {
                 unset($row['clave']);
                 $row['validar'] = 'valida';
                 $vec[] = $row;
              }

              mysqli_stmt_close($stmt);
           }

            if ($vec == []) {
               $vec[] = array("validar" => "error_consulta");
            }

            return $vec;
        }

    } 
    

?>