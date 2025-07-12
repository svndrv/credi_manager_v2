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
    public function setDb($dbh)
    {
        $this->db = $dbh;
    }

    public function obtener_misventas_paginados($id, $limit, $offset)
    {
        $sql = "SELECT id, nombres, dni, celular, credito, linea, plazo, tem,
                    documento, tipo_producto, estado, DATE(created_at) AS created_at 
                FROM ventas 
                WHERE id_usuario = :id AND estado = 'Desembolsado'
                ORDER BY id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function contar_misventas($id)
    {
        $sql = "SELECT COUNT(*) as total FROM ventas WHERE id_usuario = ? AND estado = 'Desembolsado'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function obtener_misventas_filtro($id, $id_usuario, $dni, $tipo_producto, $created_at, $limit, $offset) {
       $sql = "SELECT * FROM ventas WHERE id_usuario = :id_usuario AND estado = 'Desembolsado'";
        $params = [];

        if (!empty($id)) {
            $sql .= " AND id = :id";
            $params[':id'] = $id;
        }

        if (!empty($dni)) {
            $sql .= " AND dni = :dni";
            $params[':dni'] = $dni;
        }

        if (!empty($estado)) {
            $sql .= " AND estado = :estado";
            $params[':estado'] = $estado;
        }

        if (!empty($tipo_producto)) {
            $sql .= " AND tipo_producto = :tipo_producto";
            $params[':tipo_producto'] = $tipo_producto;
        }

        if (!empty($created_at)) {
            $sql .= " AND DATE(created_at) = :created_at";
            $params[':created_at'] = $created_at;
        }

        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contar_misventas_filtro($id, $id_usuario, $dni, $tipo_producto, $created_at) {
        $sql = "SELECT COUNT(*) AS total
            FROM ventas WHERE id_usuario = :id_usuario AND estado = 'Desembolsado'";

        if ($id) {
            $sql .= " AND id = :id";
        }
        if ($dni) {
            $sql .= " AND dni = :dni";
        }
        if ($tipo_producto) {
            $sql .= " AND tipo_producto = :tipo_producto";
        }
        if ($created_at) {
            $sql .= " AND DATE(created_at) = :created_at";
        }

        $stmt = $this->db->prepare($sql);

        if ($id) {
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        }
        if ($dni) {
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
        }
        if ($tipo_producto) {
            $stmt->bindParam(':tipo_producto', $tipo_producto, PDO::PARAM_STR);
        }
        if ($created_at) {
            $stmt->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        }
        
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC); 
        return (int)$resultado['total']; 
    }

}