<?php

class MisVentas extends Conectar
{
    private $db;
    private $misventas;

    public function __construct()
    {
        $this->db = Conectar::conexion();
        $this->misventas = array();
    }

    public function obtener_misventas_paginados($id, $limit, $offset)
    {
        $sql = "SELECT 
            v.id,
            v.nombres, 
            v.dni, 
            v.celular, 
            v.credito, 
            v.linea, 
            v.plazo, 
            v.tem,
            v.documento, 
            CONCAT(u.nombres, ' ', u.apellidos) AS nombre_completo, 
            v.tipo_producto, 
            v.estado 
        FROM 
            ventas v 
        INNER JOIN 
            usuario u 
        ON 
            v.id_usuario = u.id WHERE v.id_usuario = :id LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        public function contar_misventas($id)
    {
        $sql = "SELECT COUNT(*) as total FROM ventas WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

}