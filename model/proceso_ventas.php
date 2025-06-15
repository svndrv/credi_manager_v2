<?php 

class ProcesoVentas extends Conectar {
    private $db;
    private $procesoventas;

    public function __construct(){
        $this->db = Conectar::conexion();
        $this->procesoventas = array();
    }

    public function obtener_procesoventas_x_id($id){
        $sql = "SELECT * FROM proceso_ventas WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);

    }
    public function actualizar_procesoventa($id, $nombres, $dni, $celular, $credito, $linea, $plazo, $tem, $id_usuario, $tipo_producto, $estado, $documento = null)
    {
        if (
            empty($nombres) || empty($dni) || empty($celular) || empty($credito) ||
            empty($linea) || empty($plazo) || empty($tem) || empty($id_usuario) || empty($tipo_producto) || empty($estado)
        ) {
            return [
                "status" => "error",
                "message" => "Verifique los campos vacíos."
            ];
        }

        $sql = "UPDATE proceso_ventas 
                SET nombres = ?, dni = ?, celular = ?, credito = ?, linea = ?, plazo = ?, tem = ?, id_usuario = ?, tipo_producto = ?, estado = ?, updated_at = NOW()";

        $params = [
            $nombres, $dni, $celular, $credito, $linea, $plazo, $tem, $id_usuario, $tipo_producto, $estado
        ];

    if (!empty($documento["name"])) {
        $source = $documento['tmp_name'];
        $nombreDocumento = uniqid() . "-" . basename($documento['name']);
        $destination = "../pdf/documents/" . $nombreDocumento;

        if (!move_uploaded_file($source, $destination)) {
            return [
                "status" => "error",
                "message" => "Error al subir el nuevo documento."
            ];
        }

        $sql .= ", documento = ?";
        $params[] = $nombreDocumento;
    }

        $sql .= " WHERE id = ?";
        $params[] = $id;

        $stmt = $this->db->prepare($sql);

        foreach ($params as $i => $value) {
            $stmt->bindValue($i + 1, $value);
        }

        $stmt->execute();

        return [
            "status" => "success",
            "message" => "Proceso de venta actualizado correctamente."
        ];
    }
    public function procesoventas_x_id($id){
        $sql = "SELECT * FROM proceso_ventas WHERE id_usuario = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtener_procesoventas_paginados($limit, $offset, $id) {
        $sql = "SELECT * FROM proceso_ventas WHERE id_usuario = :id AND estado NOT IN ('Archivado', 'Desembolsado')  LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function contar_procesoventas($id) {
        $sql = "SELECT COUNT(*) as total FROM proceso_ventas WHERE id_usuario = ? AND estado != 'Archivado'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    public function agregar_procesoventas($nombres, $dni, $celular, $credito, $linea, $plazo, $tem, $id_usuario, $tipo_producto, $estado, $documento)
    {
        if (empty($nombres) || empty($dni) || empty($celular) || empty($credito) || empty($linea) || empty($plazo) || empty($tem) || empty($id_usuario) || empty($tipo_producto) || empty($estado) || empty($documento)) {
            return [
                "status" => "error",
                "message" => "Verifica los campos vacíos."
            ];
        }

        $source = $_FILES["documento"]['tmp_name'];
        $nombreDocumento = uniqid() . "-" . basename($_FILES["documento"]['name']);
        $destination = "../pdf/documents/" . $nombreDocumento;

        if (!move_uploaded_file($source, $destination)) {
            return [
                "status" => "error",
                "message" => "Error al subir el documento."
            ];
        }

        $sql = "INSERT INTO proceso_ventas (nombres, dni, celular, credito, linea, plazo, tem, id_usuario, tipo_producto, estado, documento, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), now())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $nombres);
        $stmt->bindValue(2, $dni);
        $stmt->bindValue(3, $celular);
        $stmt->bindValue(4, $credito);
        $stmt->bindValue(5, $linea);
        $stmt->bindValue(6, $plazo);
        $stmt->bindValue(7, $tem);
        $stmt->bindValue(8, $id_usuario);
        $stmt->bindValue(9, $tipo_producto);
        $stmt->bindValue(10, $estado);
        $stmt->bindValue(11, $nombreDocumento);
        $stmt->execute();

        return [
            "status" => "success",
            "message" => "Se agregó correctamente."
        ];
    }
    public function proceso_to_desembolsado($id, $nombres, $dni, $celular, $credito, $linea, $plazo, $tem, $id_usuario, $tipo_producto, $estado, $documento)
    {
        if (empty($nombres) || empty($dni) || empty($celular) || empty($credito) || empty($linea) || empty($plazo) || empty($tem) || empty($id_usuario) || empty($tipo_producto) || empty($estado) || empty($documento)) {
            return [
                "status" => "error",
                "message" => "Verifica los campos vacíos."
            ];
        }



        $sql = "INSERT INTO ventas (nombres, dni, celular, credito, linea, plazo, tem, id_usuario, tipo_producto, estado, documento, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), now())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $nombres);
        $stmt->bindValue(2, $dni);
        $stmt->bindValue(3, $celular);
        $stmt->bindValue(4, $credito);
        $stmt->bindValue(5, $linea);
        $stmt->bindValue(6, $plazo);
        $stmt->bindValue(7, $tem);
        $stmt->bindValue(8, $id_usuario);
        $stmt->bindValue(9, $tipo_producto);
        $stmt->bindValue(10, $estado);
        $stmt->bindValue(11, $documento);
        $stmt->execute();

        $sql_update = "UPDATE proceso_ventas SET estado = 'Desembolsado', updated_at = NOW() WHERE id = ?";
        $stmt_update = $this->db->prepare($sql_update);
        $stmt_update->bindValue(1, $id);
        $stmt_update->execute();

        return [
            "status" => "success",
            "message" => "Se agregó correctamente."
        ];
    }
    public function obtener_procesoventas_filtro($id, $dni, $estado, $tipo_producto, $created_at, $limit, $offset) {
        $sql = "SELECT * FROM proceso_ventas WHERE id_usuario = :id AND estado NOT IN ('Archivado', 'Desembolsado')";
        $params = [];

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

        $sql .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function contar_procesoventas_filtro($id, $dni, $estado, $tipo_producto, $created_at) {
        $sql = "SELECT COUNT(*) as total FROM proceso_ventas WHERE id_usuario = :id AND estado NOT IN ('Archivado', 'Desembolsado')";
        if ($dni) {
            $sql .= " AND dni = :dni";
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
        if ($estado) {
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        }
        if ($tipo_producto) {
            $stmt->bindParam(':tipo_producto', $tipo_producto, PDO::PARAM_STR);
        }
        if ($created_at) {
            $stmt->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        }
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC); 
        return (int)$resultado['total']; 
    }




}