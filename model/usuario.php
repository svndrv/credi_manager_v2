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

        // Agregar condiciones según los parámetros recibidos
        if ($rol) {
            $sql .= " AND rol = :rol";
        }
        if ($estado) {
            $sql .= " AND estado = :estado";
        }

        // Preparar la consulta
        $stmt = $this->db->prepare($sql);

        // Asignar valores a los parámetros según estén definidos
        if ($rol) {
            $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
        }
        if ($estado) {
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        }

        // Ejecutar la consulta
        $stmt->execute();

        // Devolver todos los resultados como un array asociativo
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
        if (empty($usuario) || empty($contrasena) || empty($nombres) || 
        empty($apellidos) || empty($rol) || empty($estado))
            return [
                "status" => "error",
                "message" => "Verificar los campos vacios."
            ];
        $validar = "SELECT * FROM usuario WHERE usuario = ?";
        $validar = $this->db->prepare($validar);
        $validar->bindValue(1, $usuario);
        $validar->execute();
        if ($validar->rowCount() > 0)
            return ["status" => "error", "message" => "El usuario ya existe."];
        
        $sql = "INSERT INTO usuario (usuario, contrasena, nombres, apellidos, rol, 
        estado, foto,created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, now(), now())";
        $sql = $this->db->prepare($sql);
        $contrasenaEncriptada = password_hash($contrasena, PASSWORD_DEFAULT);


        if (empty($foto)){
            $nombreFoto = 'user.png';
            $ruta = "../img/fotos/" . $nombreFoto;
            move_uploaded_file($_FILES["foto"]['tmp_name'], $ruta);
        }else{
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
        $sql->execute();
        $response = [
            "status" => "success",
            "message" => "Se ha creado con exito."
        ];
        return $response;
    }

    public function obtener_ventas_por_emp()
    {
        $sql = "SELECT mu.ld_cantidad, mu.tc_cantidad, mu.ld_monto, u.nombres, u.apellidos FROM ventas_por_usuario mu INNER JOIN usuario u ON mu.id = u.id WHERE u.id = :id LIMIT 1";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
