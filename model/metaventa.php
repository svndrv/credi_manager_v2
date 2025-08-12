<?php

class metaventa extends Conectar {
    private $db;
    private $metaventa;

    public function __construct(){
        $this->db = Conectar::conexion();
        $this->metaventa = array();
    }

    public function listarMetas_Venta() {
        $sql = "
            SELECT 
                m.id,
                SUM(CASE WHEN v.tipo_producto IN ('LD', 'LD/TC') AND v.estado = 'Desembolsado' THEN 1 ELSE 0 END) AS ld_real_cantidad,
                m.ld_cantidad,
                SUM(CASE WHEN v.tipo_producto IN ('LD', 'LD/TC') AND v.estado = 'Desembolsado' THEN v.credito ELSE 0 END) AS ld_real_monto,
                m.ld_monto,
                SUM(CASE WHEN v.tipo_producto IN ('TC', 'LD/TC') AND v.estado = 'Desembolsado' THEN 1 ELSE 0 END) AS tc_real_cantidad,
                m.tc_cantidad,
                CONCAT(u.nombres, ' ', u.apellidos) AS Usuario,
                m.cumplido
            FROM 
                metas m
                INNER JOIN usuario u ON m.id_usuario = u.id
                LEFT JOIN ventas v ON v.id_usuario = m.id_usuario
            WHERE 
                YEAR(m.mes) = YEAR(CURDATE())
                AND MONTH(m.mes) = MONTH(CURDATE())
            GROUP BY 
                m.id, m.ld_cantidad, m.ld_monto, m.tc_cantidad, Usuario, m.cumplido
            ORDER BY 
                m.id DESC
        ";
        
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
}

}

?>
