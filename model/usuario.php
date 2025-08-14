<?php

class Usuario extends Conectar
{
    private $db;
    private $usuarios;

    public function __construct()
    {
        $this->db = Conectar::conexion();
        $this->usuarios = array();
    }

    public function setDb($dbh)
    {
        $this->db = $dbh;
    }

    public function login($usuario, $contrasena)
    {
        $sql = "SELECT * FROM usuario WHERE usuario = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $usuario);
        $sql->execute();

        if ($sql->rowCount() === 0)
            return ["status" => "error", "message" => "El usuario no existe."];

        $data = $sql->fetch(PDO::FETCH_ASSOC);
        $contrasenaEncriptada = $data['contrasena'];

        if ($data['estado'] == 2 ) return ["status" => "error", "message" => "El usuario esta inactivo."];

        if (password_verify($contrasena, $contrasenaEncriptada) == false)
            return ["status" => "error", "message" => "Contraseña incorrecta."];

        $_SESSION['id'] = $data['id'];
        $_SESSION['usuario'] = $data['usuario'];
        $_SESSION['rol'] = $data['rol'];
        $_SESSION['nombres'] = $data['nombres'];
        $_SESSION['apellidos'] = $data['apellidos'];
        $_SESSION['estado'] = $data['estado'];

        return [
            "status" => "success",
            "url" => "dashboard.php?view=inicio"
        ];
    }

    public function obtener_perfil($id){
        $sql = "SELECT id,usuario,nombres,apellidos,rol,foto FROM usuario WHERE id = ? LIMIT 1";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,$id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function obtener_usuarios()
    {
        $sql = "SELECT * FROM usuario";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_asesor_admin()
    {
        $sql = "SELECT * FROM usuario where rol != 2";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_x_rol_estado($rol, $estado)
    {
        $sql = "SELECT * FROM usuario WHERE 1=1";

        if ($rol) {
            $sql .= " AND rol = :rol";
        }
        if ($estado) {
            $sql .= " AND estado = :estado";
        }

        $stmt = $this->db->prepare($sql);

        if ($rol) {
            $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
        }
        if ($estado) {
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_usuario_x_id($id)
    {
        $sql = "SELECT * FROM usuario WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminar_usuario($id)
    {
        $sql = "DELETE FROM usuario WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        $response = [
            "status" => "success",
            "message" => "Eliminación exitosa."
        ];
        return $response;
    }

    private function esContrasenaSegura($password) {
        // Al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
    }

    public function actualizar_usuario($id, $usuario, $contrasena, $nombres, $apellidos, $rol, $estado, $foto, $archivoFoto)
    {

        if (empty($usuario) ||empty($nombres) || empty($apellidos) || empty($rol) || empty($estado))
            return [
                "status" => "error",
                "message" => "Verfifique los campos vacios."
            ];

        if (empty($contrasena)) {
            $sql = "UPDATE usuario SET usuario = ?, nombres = ?, apellidos = ?, rol = ?, estado = ?, foto = ?, updated_at = now() WHERE id = ?";
            $sql = $this->db->prepare($sql);

            if (empty($foto)) {
                $nombreFoto = $archivoFoto;
            } else {
                $nombreFoto = uniqid() . "-" . $_FILES["foto"]['name'];
                $ruta = "../img/fotos/" . $nombreFoto;
                move_uploaded_file($_FILES["foto"]['tmp_name'], $ruta);
            }

            $sql->bindValue(1, $usuario);
            $sql->bindValue(2, $nombres);
            $sql->bindValue(3, $apellidos);
            $sql->bindValue(4, $rol);
            $sql->bindValue(5, $estado);
            $sql->bindValue(6, $nombreFoto);
            $sql->bindValue(7, $id);
            $sql->execute();

            return [
                "status" => "success",
                "message" => "Usuario editado correctamente."
            ];
        } else {

            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $contrasena)) {
            return [
                "status" => "error",
                "message" => "La contraseña es muy débil. Debe tener mínimo 8 caracteres, incluir mayúsculas, minúsculas, números y un carácter especial."
            ];
            }

            $sql = "UPDATE usuario SET usuario = ?, contrasena = ?, nombres = ?, apellidos = ?, rol = ?, estado = ?, foto = ?, updated_at = now() WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $contrasenaEncriptada = password_hash($contrasena, PASSWORD_DEFAULT);

            if (empty($foto)) {
                $nombreFoto = $archivoFoto;
            } else {
                $nombreFoto = uniqid() . "-" . $_FILES["foto"]['name'];
                $ruta = "../img/fotos/" . $nombreFoto;
                move_uploaded_file($_FILES["foto"]['tmp_name'], $ruta);
            }

            $sql->bindValue(1, $usuario);
            $sql->bindValue(2, $contrasenaEncriptada);
            $sql->bindValue(3, $nombres);
            $sql->bindValue(4, $apellidos);
            $sql->bindValue(5, $rol);
            $sql->bindValue(6, $estado);
            $sql->bindValue(7, $nombreFoto);
            $sql->bindValue(8, $id);
            $sql->execute();
            
            return [
                "status" => "success",
                "message" => "Usuario editado correctamente."
            ];
        }
    }

    public function agregar_usuario($usuario, $contrasena, $nombres, $apellidos, $rol, $estado, $foto)
{
    // 1. Validar campos vacíos
    if (empty($usuario) || empty($contrasena) || empty($nombres) || 
        empty($apellidos) || empty($rol) || empty($estado)) {
        return [
            "status" => "error",
            "message" => "Verificar los campos vacíos."
        ];
    }

    // 2. Validar que la contraseña sea semi-segura
    // - Mínimo 8 caracteres
    // - Al menos 1 mayúscula
    // - Al menos 1 minúscula
    // - Al menos 1 número
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $contrasena)) {
        return [
            "status" => "error",
            "message" => "La contraseña es demasiado débil. Debe tener mínimo 8 caracteres, con mayúsculas, minúsculas y números."
        ];
    }

    // 3. Verificar si el usuario ya existe
    $validar = $this->db->prepare("SELECT * FROM usuario WHERE usuario = ?");
    $validar->bindValue(1, $usuario);
    $validar->execute();
    if ($validar->rowCount() > 0) {
        return ["status" => "error", "message" => "El usuario ya existe."];
    }

    // 4. Preparar inserción
    $sql = "INSERT INTO usuario (usuario, contrasena, nombres, apellidos, rol, estado, foto, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, now(), now())";
    $sql = $this->db->prepare($sql);
    $contrasenaEncriptada = password_hash($contrasena, PASSWORD_DEFAULT);

    // 5. Manejo de foto
    if (empty($foto)) {
        $nombreFoto = 'user.png';
        $ruta = "../img/fotos/" . $nombreFoto;
        move_uploaded_file($_FILES["foto"]['tmp_name'], $ruta);
    } else {
        $nombreFoto = uniqid() . "-" . $_FILES["foto"]['name'];
        $ruta = "../img/fotos/" . $nombreFoto;
        move_uploaded_file($_FILES["foto"]['tmp_name'], $ruta);
    }

    // 6. Ejecutar inserción
    $sql->bindValue(1, $usuario);
    $sql->bindValue(2, $contrasenaEncriptada);
    $sql->bindValue(3, $nombres);
    $sql->bindValue(4, $apellidos);
    $sql->bindValue(5, $rol);
    $sql->bindValue(6, $estado);
    $sql->bindValue(7, $nombreFoto);
    $sql->execute();

    // 7. Respuesta final
    return [
        "status" => "success",
        "message" => "Se ha creado con éxito."
    ];
}

    public function obtener_ventas_por_emp()
    {
        $sql = "SELECT mu.ld_cantidad, mu.tc_cantidad, mu.ld_monto, u.nombres, u.apellidos FROM ventas_por_usuario mu INNER JOIN usuario u ON mu.id = u.id WHERE u.id = :id LIMIT 1";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
