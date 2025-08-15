<?php
class Metasfv extends Conectar {
    private $db;
    private $metasfv;
    public function __construct(){
        $this->db = Conectar::conexion();
        $this->metasfv = array();
    }

    public function setDb($dbh)
{
    $this->db = $dbh;
}
    
    public function obtener_metasfv() {
        $sql = "SELECT * FROM metasfv ORDER BY mes DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function agregar_metafv($ld_cantidad, $ld_monto, $tc_cantidad, $sede, $mes, $cumplido){
        if (empty($ld_cantidad) || empty($ld_monto) || empty($tc_cantidad) || empty($sede) || empty($cumplido)) {
            return [
                "status" => "error",
                "message" => "Verificar los campos vacíos."
            ];
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $mes)) {
            return [
                "status" => "error",
                "message" => "Formato de mes inválido. Usa YYYY-MM-DD."
            ];
        }

        $sql_check = "SELECT COUNT(*) AS total FROM metasfv WHERE mes = ?";
        $stmt_check = $this->db->prepare($sql_check);
        $stmt_check->bindValue(1, $mes);
        $stmt_check->execute();
        $row = $stmt_check->fetch();

        if ($row['total'] > 0) {
            return [
                "status" => "error",
                "message" => "Ya existe una meta para esta fecha."
            ];
        }

        $sql = "INSERT INTO metasfv (ld_cantidad, ld_monto, tc_cantidad, sede, mes, cumplido, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $ld_cantidad);
        $stmt->bindValue(2, $ld_monto);
        $stmt->bindValue(3, $tc_cantidad);
        $stmt->bindValue(4, $sede);
        $stmt->bindValue(5, $mes); 
        $stmt->bindValue(6, $cumplido);
        $stmt->execute();

        return [
            "status" => "success",
            "message" => "Meta creada exitosamente."
        ];
    }
    public function actualizar_metafv($id, $ld_cantidad, $tc_cantidad, $ld_monto, $sede, $mes, $cumplido)
    { 
        // Validar campos vacíos
        if (empty($ld_cantidad) || empty($tc_cantidad) || empty($ld_monto) || empty($sede) || empty($mes) || empty($cumplido)) {
            return [
                "status" => "error",
                "message" => "Verifique los campos vacíos."
            ];
        }

        // Validar formato de mes (YYYY-MM)
        if (!preg_match('/^\d{4}-\d{2}$/', $mes)) {
            return [
                "status" => "error",
                "message" => "Formato de mes inválido. Usa YYYY-MM."
            ];
        }

        $mes = $mes . '-01';

        // 🔍 Verificar si ya existe una meta para ese mes en otra fila
        $sql_check = "SELECT COUNT(*) AS total 
                    FROM metasfv 
                    WHERE mes = ? 
                    AND id != ?";
        $stmt_check = $this->db->prepare($sql_check);
        $stmt_check->bindValue(1, $mes);
        $stmt_check->bindValue(2, $id);
        $stmt_check->execute();
        $existe = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($existe['total'] > 0) {
            return [
                "status" => "error",
                "message" => "Ya existe una meta registrada para este mes."
            ];
        }
        $sql = "UPDATE metasfv 
                SET ld_cantidad = ?, tc_cantidad = ?, ld_monto = ?, sede = ?, mes = ?, cumplido = ?, updated_at = NOW() 
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $ld_cantidad);
        $stmt->bindValue(2, $tc_cantidad);
        $stmt->bindValue(3, $ld_monto);
        $stmt->bindValue(4, $sede);
        $stmt->bindValue(5, $mes);
        $stmt->bindValue(6, $cumplido);
        $stmt->bindValue(7, $id);
        $stmt->execute();

        return [
            "status" => "success",
            "message" => "Meta editada correctamente."
        ];
    }
    public function eliminar_metafv($id){
            $sql = "DELETE FROM metasfv WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1,$id);
            $sql->execute();
            
            $response = [
                "status" => "success",
                "message" => "Eliminada exitosamente."
            ];
            return $response;
    }
    public function obtener_metas_por_mes_y_cumplido($mes, $cumplido) { 
        $sql = "SELECT 
                id, ld_cantidad, ld_monto, tc_cantidad, sede, 
                DATE_FORMAT(mes, '%Y-%m') AS mes, 
                cumplido, created_at, updated_at 
            FROM metasfv 
            WHERE 1=1";

        $params = [];

        if (!empty($mes)) {
            $sql .= " AND DATE_FORMAT(mes, '%Y-%m') = :mes";
            $params[':mes'] = $mes;  
        }

        if (!empty($cumplido)) {
            $sql .= " AND cumplido = :cumplido";
            $params[':cumplido'] = $cumplido;
        }

        $sql .= " ORDER BY mes DESC, created_at DESC";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtener_meta_x_id($id) {
        $sql = "SELECT 
                    id, 
                    ld_cantidad, 
                    tc_cantidad, 
                    ld_monto, 
                    sede, 
                    DATE_FORMAT(mes, '%Y-%m') AS mes, 
                    cumplido, 
                    created_at, 
                    updated_at 
                FROM metasfv 
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtener_ultimo_registro(){
        $sql = "SELECT ld_cantidad, tc_cantidad, ld_monto
            FROM metasfv
            WHERE YEAR(mes) = YEAR(CURRENT_DATE())
              AND MONTH(mes) = MONTH(CURRENT_DATE())
            ORDER BY mes DESC
            LIMIT 1";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        return [$resultado]; 
    } else {
        return [[
            'ld_cantidad' => 'No hay datos este mes',
            'tc_cantidad' => 'No hay datos este mes',
            'ld_monto'    => 'No hay datos este mes'
        ]];
    }
    }

    public function obtener_porcentajes_servicios(){
    
        // 📌 Totales solo del mes y año actual
    $sqlVentas = "SELECT
            SUM(CASE 
                    WHEN tipo_producto = 'TC' THEN 1
                    WHEN tipo_producto = 'LD/TC' THEN 1
                    ELSE 0
                END) AS total_tc,
            SUM(CASE 
                    WHEN tipo_producto = 'LD' THEN 1
                    WHEN tipo_producto = 'LD/TC' THEN 1
                    ELSE 0
                END) AS total_ld,
            SUM(credito) AS total_credito
        FROM ventas
        WHERE estado = 'Desembolsado'
          AND YEAR(created_at) = YEAR(CURDATE())
          AND MONTH(created_at) = MONTH(CURDATE())";

    $stmtVentas = $this->db->prepare($sqlVentas);
    $stmtVentas->execute();
    $totales = $stmtVentas->fetch(PDO::FETCH_ASSOC);

    $sqlMeta = "SELECT ld_cantidad, tc_cantidad, ld_monto 
                FROM metasfv
                WHERE YEAR(mes) = YEAR(CURDATE())
                  AND MONTH(mes) = MONTH(CURDATE())
                ORDER BY mes DESC
                LIMIT 1";
    $stmtMeta = $this->db->prepare($sqlMeta);
    $stmtMeta->execute();
    $meta = $stmtMeta->fetch(PDO::FETCH_ASSOC);

    if (!$meta) {
        return [[
            'tc' => "No hay datos este mes",
            'ld' => "No hay datos este mes",
            'credito' => "No hay datos este mes"
        ]];
    }

    return [[
        'tc' => ($meta['tc_cantidad'] > 0) 
            ? round(($totales['total_tc'] / $meta['tc_cantidad']) * 100, 2) 
            : 0,
        'ld' => ($meta['ld_cantidad'] > 0) 
            ? round(($totales['total_ld'] / $meta['ld_cantidad']) * 100, 2) 
            : 0,
        'credito' => ($meta['ld_monto'] > 0) 
            ? round(($totales['total_credito'] / $meta['ld_monto']) * 100, 2) 
            : 0
    ]];
}
    


}