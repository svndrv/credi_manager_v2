<?php

class metaventa extends Conectar {
    private $db;
    private $metaventa;

    public function __construct(){
        $this->db = Conectar::conexion();
        $this->metaventa = array();
    }

    public function listarMetas_Venta() {
    $sql = 
        "SELECT 
            m.id,
            (SELECT COUNT(*) FROM ventas v WHERE v.tipo_producto IN ('LD', 'LD/TC') AND v.estado = 'Desembolsado' AND v.id_usuario = m.id_usuario) AS ld_real_cantidad,
            m.ld_cantidad,
            (SELECT SUM(v.credito) FROM ventas v WHERE v.tipo_producto IN ('LD', 'LD/TC') AND v.estado = 'Desembolsado' AND v.id_usuario = m.id_usuario) AS ld_real_monto,
            m.ld_monto,
            (SELECT COUNT(*) FROM ventas v WHERE v.tipo_producto IN ('TC', 'LD/TC') AND v.estado = 'Desembolsado' AND v.id_usuario = m.id_usuario) AS tc_real_cantidad,
            m.tc_cantidad,
            CONCAT(u.nombres, ' ', u.apellidos) AS Usuario,
            m.cumplido 
        FROM 
            metas m
            JOIN usuario u ON m.id_usuario = u.id";
    
    $sql = $this->db->prepare($sql);
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}
}

?>
