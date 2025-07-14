<?php 

class GestionVentas extends Conectar {
    private $db;
    private $gestionventas;

    public function __construct(){
        $this->db = Conectar::conexion();
        $this->gestionventas = array();
    }

    public function setDb($dbh)
    {
        $this->db = $dbh;
    }

    public function obtener_gestionventas_paginados($limit, $offset) {
        $sql = "SELECT 
                pv.id,
                pv.nombres,
                pv.dni,
                pv.celular,
                pv.created_at,
                pv.estado,
                pv.id_usuario,
                u.rol,
                u.foto,
                CONCAT(u.nombres, ' ', u.apellidos) AS nombre_completo
                FROM 
                proceso_ventas pv
                INNER JOIN 
                usuario u ON pv.id_usuario = u.id
                WHERE 
                pv.estado NOT IN ('Archivado', 'Desembolsado')
                ORDER BY 
                pv.id DESC
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function contar_gestionventas() {
        $sql = "SELECT COUNT(*) as total FROM proceso_ventas WHERE estado NOT IN ('Archivado', 'Desembolsado')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    public function obtener_gestionventas_filtro($id, $id_usuario, $dni, $estado, $tipo_producto, $created_at, $limit, $offset) {
    $sql = "SELECT 
              pv.id,
              pv.nombres,
              pv.dni,
              pv.celular,
              pv.credito,
              pv.linea,
              pv.plazo,
              pv.tem,
              pv.documento,
              pv.id_usuario,
              u.foto,
              pv.created_at,
              CONCAT(u.nombres, ' ', u.apellidos) AS nombre_completo,
              pv.tipo_producto,
              pv.estado,
              u.rol
            FROM 
              proceso_ventas pv
            INNER JOIN 
              usuario u ON pv.id_usuario = u.id
            WHERE 
              pv.estado NOT IN ('Archivado', 'Desembolsado')";

    $params = [];

    if (!empty($dni)) {
        $sql .= " AND pv.dni = :dni";
        $params[':dni'] = $dni;
    }

    if (!empty($id_usuario)) {
        $sql .= " AND pv.id_usuario = :id_usuario";
        $params[':id_usuario'] = $id_usuario;
    }

    if (!empty($estado)) {
        $sql .= " AND pv.estado = :estado";
        $params[':estado'] = $estado;
    }

    if (!empty($tipo_producto)) {
        $sql .= " AND pv.tipo_producto = :tipo_producto";
        $params[':tipo_producto'] = $tipo_producto;
    }

    if (!empty($created_at)) {
        $sql .= " AND DATE(pv.created_at) = :created_at";
        $params[':created_at'] = $created_at;
    }

    $sql .= " ORDER BY pv.id DESC LIMIT :limit OFFSET :offset";

    $stmt = $this->db->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function contar_procesoventas_filtro($id, $id_usuario, $dni, $estado, $tipo_producto, $created_at) {
        $sql = "SELECT COUNT(*) as total FROM proceso_ventas WHERE estado NOT IN ('Archivado', 'Desembolsado')";
        if ($dni) {
            $sql .= " AND dni = :dni";
        }
        if ($id_usuario) {
            $sql .= " AND id_usuario = :id_usuario";
        }
        if ($estado) {
            $sql .= " AND estado = :estado";
        }
        if ($tipo_producto) {
            $sql .= " AND tipo_producto = :tipo_producto";
        }
        if ($created_at) {
            $sql .= " AND DATE(created_at) = :created_at";
        }
        $stmt = $this->db->prepare($sql);
        if ($dni) {
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
        }
        if ($id_usuario) {
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
        }
        if ($estado) {
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        }
        if ($tipo_producto) {
            $stmt->bindParam(':tipo_producto', $tipo_producto, PDO::PARAM_STR);
        }
        if ($created_at) {
            $stmt->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        }
        

        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC); 
        return (int)$resultado['total']; 
    }



}