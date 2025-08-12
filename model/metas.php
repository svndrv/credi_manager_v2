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

    public function setDb($dbh){
        $this->dbh = $dbh;
    }
    
    public function obtener_metas(){
        $sql = "SELECT m.id, m.ld_cantidad, m.tc_cantidad, m.ld_monto, 
                   CONCAT(u.nombres, ' ', u.apellidos) AS nombre_completo, 
                   m.mes, m.cumplido, m.created_at, m.updated_at, u.foto 
            FROM metas m 
            JOIN usuario u ON m.id_usuario = u.id
            ORDER BY m.mes DESC";  
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function eliminar_meta($id){
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
    public function actualizar_meta($id, $ld_cantidad, $ld_monto, $tc_cantidad, $id_usuario, $mes, $cumplido){ 
        if (empty($ld_cantidad) || empty($tc_cantidad) || empty($ld_monto) || empty($id_usuario) || empty($mes) || empty($cumplido)) {
            return [
                "status" => "error",
                "message" => "Verifique los campos vacíos."
            ];
        }

        if (!preg_match('/^\d{4}-\d{2}$/', $mes)) {
            return [
                "status" => "error",
                "message" => "Formato de mes inválido. Usa YYYY-MM."
            ];
        }

        $mes = $mes . '-01';

        $sql_check = "SELECT COUNT(*) AS total 
                    FROM metas 
                    WHERE id_usuario = ? AND mes = ? AND id != ?";
        $stmt_check = $this->db->prepare($sql_check);
        $stmt_check->bindValue(1, $id_usuario, PDO::PARAM_INT);
        $stmt_check->bindValue(2, $mes, PDO::PARAM_STR);
        $stmt_check->bindValue(3, $id, PDO::PARAM_INT);
        $stmt_check->execute();
        $row = $stmt_check->fetch();

            if ($row['total'] > 0) {
                return [
                    "status" => "error",
                    "message" => "Ya existe una meta asignada para este mes."
                ];
            }

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
    public function obtener_meta_x_id($id){
        $sql = "SELECT 
                    m.id, 
                    m.ld_cantidad, 
                    m.tc_cantidad, 
                    m.ld_monto, 
                    CONCAT(u.nombres, ' ', u.apellidos) AS usuario_nombre, 
                    DATE_FORMAT(m.mes, '%Y-%m') AS mes, 
                    m.cumplido, 
                    m.created_at, 
                    m.updated_at 
                FROM metas m 
                JOIN usuario u ON m.id_usuario = u.id 
                WHERE m.id = ?";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function agregar_meta($ld_cantidad, $ld_monto, $tc_cantidad, $id_usuario, $mes, $cumplido){
        if (empty($ld_cantidad) || empty($ld_monto) || empty($tc_cantidad) || empty($id_usuario) || empty($mes) || empty($cumplido)) {
        return [
            "status" => "error",
            "message" => "Verificar los campos vacíos."
        ];
        }

        if (!preg_match('/^\d{4}-\d{2}$/', $mes)) {
            return [
                "status" => "error",
                "message" => "Formato de mes inválido. Usa YYYY-MM."
            ];
        }

        $mes = $mes . '-01'; 

        $sql_check = "SELECT COUNT(*) AS total FROM metas WHERE id_usuario = ? AND mes = ?";
        $stmt_check = $this->db->prepare($sql_check);
        $stmt_check->bindValue(1, $id_usuario);
        $stmt_check->bindValue(2, $mes);
        $stmt_check->execute();
        $row = $stmt_check->fetch();

        if ($row['total'] > 0) {
            return [
                "status" => "error",
                "message" => "Ya existe una meta asignada para este mes."
            ];
        }

        $sql = "INSERT INTO metas (ld_cantidad, ld_monto, tc_cantidad, id_usuario, mes, cumplido, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, now(), now())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $ld_cantidad);
        $stmt->bindValue(2, $ld_monto);
        $stmt->bindValue(3, $tc_cantidad);
        $stmt->bindValue(4, $id_usuario);
        $stmt->bindValue(5, $mes); // 'YYYY-MM-01'
        $stmt->bindValue(6, $cumplido);
        $stmt->execute();

        return [
            "status" => "success",
            "message" => "Meta creada exitosamente."
        ];
    }
    public function metas_x_usuario_mes_cumplido($id_usuario, $mes, $cumplido){

            if (!empty($mes) && strlen($mes) === 7) {
        $mes .= '-01';
        }

        $sql = "SELECT 
                    m.id,
                    m.ld_cantidad,
                    m.tc_cantidad,
                    m.ld_monto,
                    m.id_usuario,
                    u.foto,
                    CONCAT(u.nombres, ' ', u.apellidos) AS nombre_completo,
                    m.mes,
                    m.cumplido
                FROM 
                    metas m 
                INNER JOIN 
                    usuario u 
                    ON m.id_usuario = u.id
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

        // Ordenar por fecha (mes) descendente
        $sql .= " ORDER BY m.mes DESC";

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
