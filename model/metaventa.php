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
                CONCAT(
                    COALESCE((SELECT COUNT(*) FROM ventas v WHERE v.tipo_producto IN ('LD', 'LD/TC') AND v.estado = 'Desembolsado' AND v.id_usuario = m.id_usuario), 0), 
                    '  /  ', 
                    COALESCE(m.ld_cantidad, 0)
                ) AS `LDCantidad`,
                CONCAT(
                    COALESCE((SELECT SUM(v.credito) FROM ventas v WHERE v.tipo_producto IN ('LD', 'LD/TC') AND v.estado = 'Desembolsado' AND v.id_usuario = m.id_usuario), 0.000), 
                    '  /  ', 
                    COALESCE(m.ld_monto, 0.000)
                ) AS `LDMonto`,
                CONCAT(
                    COALESCE((SELECT COUNT(*) FROM ventas v WHERE v.tipo_producto IN ('TC', 'LD/TC') AND v.estado = 'Desembolsado' AND v.id_usuario = m.id_usuario), 0), 
                    '  /  ', 
                    COALESCE(m.tc_cantidad, 0)
                ) AS `TCCantidad`,
                CONCAT(u.nombres, ' ', u.apellidos) AS `Usuario`,
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
