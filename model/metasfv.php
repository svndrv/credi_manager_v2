<?php
class Metasfv extends Conectar {
    private $db;
    private $metasfv;
    public function __construct(){
        $this->db = Conectar::conexion();
        $this->metasfv = array();
    }

    public function obtener_metasfv() {
        $sql = "SELECT * FROM metasfv";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function agregar_metafv($ld_cantidad, $ld_monto, $tc_cantidad, $sede, $mes, $cumplido)
{
    if (empty($ld_cantidad) || empty($ld_monto) || empty($tc_cantidad) || empty($sede) ||empty($cumplido)) {
        return [
            "status" => "error",
            "message" => "Verificar los campos vacíos."
        ];
    }

    $sql = "INSERT INTO metasfv (ld_cantidad, ld_monto, tc_cantidad, sede, mes, cumplido, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?,now(), now())";
    $sql = $this->db->prepare($sql);
    $sql->bindValue(1, $ld_cantidad);
    $sql->bindValue(2, $ld_monto);
    $sql->bindValue(3, $tc_cantidad);
    $sql->bindValue(4, $sede);
    $sql->bindValue(5, $mes);
    $sql->bindValue(6, $cumplido);
    $sql->execute();

    $response = [
        "status" => "success",
        "message" => "Meta creada exitosamente."
    ];

    return $response;
}
    public function actualizar_metafv($id, $ld_cantidad, $tc_cantidad, $ld_monto, $sede, $mes, $cumplido) {
        
        if (empty($ld_cantidad) || empty($tc_cantidad) || empty($ld_monto) || empty($sede)|| empty($mes) || empty($cumplido)) {
            return [
                "status" => "error",
                "message" => "Verifique los campos vacíos."
            ];
        } else {
            $sql = "UPDATE metasfv SET ld_cantidad = ?, tc_cantidad = ?, ld_monto = ?, sede = ?, mes = ?, cumplido = ?, updated_at = now() WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $ld_cantidad);
            $sql->bindValue(2, $tc_cantidad);
            $sql->bindValue(3, $ld_monto);
            $sql->bindValue(4, $sede);
            $sql->bindValue(5, $mes);
            $sql->bindValue(6, $cumplido);
            $sql->bindValue(7, $id);
            $sql->execute();

            return [
                "status" => "success",
                "message" => "Meta editada correctamente."
            ];
        }
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
        $sql = "SELECT * FROM metasfv WHERE 1=1";
    
        // Agregar condiciones según los parámetros recibidos
        if ($mes) {
            $sql .= " AND mes = :mes";
        }
        if ($cumplido) {
            $sql .= " AND cumplido = :cumplido";
        }
    
        // Preparar la consulta
        $stmt = $this->db->prepare($sql);
    
        // Asignar valores a los parámetros según estén definidos
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
    
    public function obtener_meta_x_id($id) {
        $sql = "SELECT id, ld_cantidad, tc_cantidad, ld_monto, sede, mes, cumplido, created_at, updated_at 
                FROM metasfv 
                WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_ultimo_registro(){
        $sql = "SELECT * FROM metasfv ORDER BY created_at DESC LIMIT 1";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    


}