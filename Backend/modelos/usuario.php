<?php 
   class Usuario {
       //atributos
       private $conexion;

       public function __construct($conexion) {
           $this->conexion = $conexion;
        }

       //metodos
       public function consulta() {
           $sql = "SELECT * FROM usuario ORDER BY nombre";
           $res = mysqli_query($this->conexion, $sql) or die('no encontro la tabla usuario');
        
           $vec = [];

           while ($row = mysqli_fetch_array($res)) {
              $vec[] = $row;
            }

            return $vec;
        }

        public function consulta2($id_rol) {
           $sql = "SELECT * FROM usuario WHERE fo_rol = $id_rol ORDER BY nombre";
           $res = mysqli_query($this->conexion, $sql) or die('no encontro la tabla usuario');
        
           $vec = [];

           while ($row = mysqli_fetch_array($res)) {
              $vec[] = $row;
            }

            return $vec;
        }

        public function eliminar($id) {
            $sql = "DELETE FROM usuario WHERE id_usuario = $id";
            mysqli_query($this->conexion, $sql) or die('no elimino el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro eliminado correctamente";

            return $vec;
        }

        public function insertar($params) {
            $sql = "INSERT INTO usuario (nombre, clave, celular, email, fo_rol) VALUES ('$params-> nombre', '$params->clave', '$params->celular', '$params->email', $params->rol)";
            mysqli_query($this->conexion, $sql) or die('no inserto el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro insertado correctamente";

            return $vec;
        }

        public function registrar($params) {
            $nombre = trim($params->nombre ?? '');
            $email = trim($params->email ?? '');
            $clave = $params->clave ?? '';
            $celular = trim($params->celular ?? '');

            if ($nombre === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($clave) < 6) {
                return array('resultado' => 'ERROR', 'mensaje' => 'Los datos de registro no son válidos.');
            }

            $consulta = mysqli_prepare($this->conexion, "SELECT id_usuario FROM usuario WHERE email = ? LIMIT 1");
            mysqli_stmt_bind_param($consulta, 's', $email);
            mysqli_stmt_execute($consulta);
            mysqli_stmt_store_result($consulta);

            if (mysqli_stmt_num_rows($consulta) > 0) {
                mysqli_stmt_close($consulta);
                return array('resultado' => 'ERROR', 'mensaje' => 'El correo ya está registrado.');
            }

            mysqli_stmt_close($consulta);

            $rol = mysqli_query($this->conexion, "SELECT id_rol FROM rol WHERE LOWER(nombre) IN ('cliente', 'usuario') ORDER BY id_rol LIMIT 1");
            $rolEncontrado = mysqli_fetch_assoc($rol);

            if (!$rolEncontrado) {
                return array('resultado' => 'ERROR', 'mensaje' => 'No hay un rol público disponible para registrar usuarios.');
            }

            $idRol = (int) $rolEncontrado['id_rol'];
            $insertar = mysqli_prepare($this->conexion, "INSERT INTO usuario (nombre, clave, celular, email, fo_rol) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($insertar, 'ssssi', $nombre, $clave, $celular, $email, $idRol);

            if (!mysqli_stmt_execute($insertar)) {
                mysqli_stmt_close($insertar);
                return array('resultado' => 'ERROR', 'mensaje' => 'No se pudo crear el usuario.');
            }

            mysqli_stmt_close($insertar);
            return array('resultado' => 'OK', 'mensaje' => 'Registro creado correctamente.');
        }

         public function editar($id, $params) {
            $sql = "UPDATE usuario SET nombre = '$params->nombre', clave = '$params->clave', celular = '$params->celular', email = '$params->email', fo_rol = $params->rol WHERE id_usuario = $id";
            mysqli_query($this->conexion, $sql) or die('no edito el registro');

            $vec = [];
            $vec [resultado] = "OK";
            $vec [mensaje] = "Registro editado correctamente";

            return $vec;
        }

    } 
?>