<?php
class Metas extends Conectar
{
    private $db;
    private $metas;

    public function __construct()
    {
        $this->db = Conectar::conexion();
        $this->metas = array();
    }
    public function obtener_metas()
    {
        $sql = "SELECT m.id, m.ld_cantidad, m.tc_cantidad, m.ld_monto, CONCAT(u.nombres, ' ', u.apellidos) AS usuario_nombre, m.mes, m.cumplido, m.created_at, m.updated_at FROM metas m JOIN usuario u ON m.id_usuario = u.id";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_metas_por_usuario($id_usuario, $mes, $cumplido)
    {
        $sql = "SELECT * FROM metas WHERE 1=1";

        // Agregar condiciones según los parámetros recibidos
        if ($id_usuario) {
            $sql .= " AND id_usuario = :id_usuario";
        }
        if ($mes) {
            $sql .= " AND mes = :mes";
        }
        if ($cumplido) {
            $sql .= " AND cumplido = :cumplido";
        }

        // Preparar la consulta
        $stmt = $this->db->prepare($sql);

        // Asignar valores a los parámetros según estén definidos
        if ($id_usuario) {
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        }
        if ($mes) {
            $stmt->bindParam(':mes', $mes, PDO::PARAM_STR);
        }
        if ($cumplido) {
            $stmt->bindParam(':cumplido', $cumplido, PDO::PARAM_STR);
        }

        // Ejecutar la consulta
        $stmt->execute();

        // Devolver todos los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function eliminar_meta($id)
    {
        $sql = "DELETE FROM metas WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        $response = [
            "status" => "success",
            "message" => "Eliminada exitosamente."
        ];
        return $response;
    }
    public function actualizar_meta($id, $ld_cantidad, $ld_monto, $tc_cantidad, $id_usuario, $mes, $cumplido)
    {

        if (empty($ld_cantidad) || empty($tc_cantidad) || empty($ld_monto) || empty($id_usuario) || empty($mes) || empty($cumplido)) {
            return [
                "status" => "error",
                "message" => "Verifique los campos vacíos."
            ];
        } else {
            $sql = "UPDATE metas
            SET ld_cantidad = ?, ld_monto = ?, tc_cantidad = ?, id_usuario = ?, mes = ?, cumplido = ?, updated_at = now() 
            WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(1, $ld_cantidad, PDO::PARAM_INT);
            $stmt->bindValue(2, $ld_monto, PDO::PARAM_INT);
            $stmt->bindValue(3, $tc_cantidad, PDO::PARAM_INT);
            $stmt->bindValue(4, $id_usuario, PDO::PARAM_INT);
            $stmt->bindValue(5, $mes, PDO::PARAM_STR);
            $stmt->bindValue(6, $cumplido, PDO::PARAM_STR);
            $stmt->bindValue(7, $id, PDO::PARAM_INT);
            $stmt->execute();
            return [
                "status" => "success",
                "message" => "Meta editada correctamente."
            ];
        }
    }

    public function obtener_meta_x_id($id)
    {
        $sql = "SELECT m.id, m.ld_cantidad, m.tc_cantidad, m.ld_monto, CONCAT(u.nombres, ' ', u.apellidos) AS usuario_nombre, m.mes, m.cumplido, m.created_at, m.updated_at FROM metas m JOIN usuario u ON m.id_usuario = u.id WHERE m.id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregar_meta($ld_cantidad, $ld_monto, $tc_cantidad, $id_usuario, $mes, $cumplido)
    {
        if (empty($ld_cantidad) || empty($ld_monto) || empty($tc_cantidad) || empty($id_usuario) || empty($id_usuario) || empty($cumplido)) {
            return [
                "status" => "error",
                "message" => "Verificar los campos vacíos."
            ];
        }

        $sql = "INSERT INTO metas (ld_cantidad, ld_monto, tc_cantidad, id_usuario, mes, cumplido, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?,now(), now())";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $ld_cantidad);
        $sql->bindValue(2, $ld_monto);
        $sql->bindValue(3, $tc_cantidad);
        $sql->bindValue(4, $id_usuario);
        $sql->bindValue(5, $mes);
        $sql->bindValue(6, $cumplido);
        $sql->execute();

        $response = [
            "status" => "success",
            "message" => "Meta creada exitosamente."
        ];

        return $response;
    }
    public function metas_x_usuario_mes_cumplido($id_usuario, $mes, $cumplido)
    {
        $sql = "SELECT 
        m.id,
        m.ld_cantidad,
        m.tc_cantidad,
        m.ld_monto,
        m.id_usuario,
        CONCAT(u.nombres, ' ', u.apellidos) AS nombre_completo,
        m.mes,
        m.cumplido
    FROM 
        metas m 
    INNER JOIN 
        usuario u 
    ON 
        m.id_usuario = u.id
    WHERE 1=1";

        if ($id_usuario) {
            $sql .= " AND m.id_usuario = :id_usuario";
        }

        if ($mes) {
            $sql .= " AND m.mes = :mes";
        }

        if ($cumplido) {
            $sql .= " AND m.cumplido = :cumplido";
        }

        $stmt = $this->db->prepare($sql);

        if ($id_usuario) {
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        }

        if ($mes) {
            $stmt->bindParam(':mes', $mes, PDO::PARAM_STR);
        }

        if ($cumplido) {
            $stmt->bindParam(':cumplido', $cumplido, PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
