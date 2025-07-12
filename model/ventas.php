<?php

class Ventas extends Conectar
{
    private $db;
    private $ventas;

    public function __construct()
    {
        $this->db = Conectar::conexion();
        $this->ventas = array();
    }

    public function setDb($dbh)
    {
        $this->db = $dbh;
    }
    public function obtener_ventas_x_usuario($id_usuario, $mes)
    {
        $sql = "SELECT ld_cantidad, tc_cantidad, ld_monto FROM ventas_por_usuario WHERE id_usuario = ? AND mes = ?;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id_usuario);
        $sql->bindValue(2, $mes);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtener_ventas()
    {
        $sql = "SELECT * FROM ventas";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtener_ventas_inner()
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
    CONCAT(u.nombres, ' ', u.apellidos) AS nombre_completo, 
    v.tipo_producto, 
    v.estado 
FROM 
    ventas v 
INNER JOIN 
    usuario u 
ON 
    v.id_usuario = u.id WHERE v.estado != 'Cancelado'";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function agregar_ventas($nombres, $dni, $celular, $credito, $linea, $plazo, $tem, $id_usuario, $tipo_producto, $estado)
    {

        if (empty($nombres) || empty($dni) || empty($celular) || empty($credito) || empty($tem) || empty($id_usuario) || empty($tipo_producto) || empty($estado))
            return [
                "status" => "error",
                "message" => "Verifique los espacios vacios."
            ];

        $sql = "INSERT INTO ventas (nombres, dni, celular, credito, linea,plazo, tem, id_usuario, tipo_producto, estado, created_at, updated_at) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, now(), now())";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $nombres);
        $sql->bindValue(2, $dni);
        $sql->bindValue(3, $celular);
        $sql->bindValue(4, $credito);
        $sql->bindValue(5, $linea);
        $sql->bindValue(6, $plazo);
        $sql->bindValue(7, $tem);
        $sql->bindValue(8, $id_usuario);
        $sql->bindValue(9, $tipo_producto);
        $sql->bindValue(10, $estado);
        $sql->execute();

        $response = [
            "status" => "success",
            "message" => "Se translado la venta con éxito."
        ];

        return $response;
    }
    public function contar_ld()
    {
        $sql = "SELECT COUNT(*) AS cantidad_ld FROM ventas WHERE tipo_producto IN ('LD', 'LD/TC') AND estado = 'Desembolsado'";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function contar_tc()
    {
        $sql = "SELECT COUNT(*) AS cantidad_tc FROM ventas WHERE tipo_producto IN ('TC', 'LD/TC') AND estado = 'Desembolsado'";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function contar_ld_monto()
    {
        $sql = "SELECT SUM(credito) AS ld_monto FROM ventas WHERE estado = 'Desembolsado'";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtener_venta_x_id($id)
    {
        $sql = "SELECT v.id,v.nombres,v.dni, v.celular, v.credito, v.linea, v.plazo, v.tem, CONCAT(u.nombres, ' ', u.apellidos) AS nombre_completo, v.tipo_producto, v.estado FROM 
        ventas v INNER JOIN usuario u ON v.id_usuario = u.id WHERE v.id = ?;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function eliminar_venta($id)
    {
        $sql = "UPDATE ventas SET estado = ? WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, "Cancelado");
        $sql->bindValue(2, $id);
        $sql->execute();

        return [
            "status" => "success",
            "message" => "Se ha eliminado con exito."
        ];
    }
    public function venta_x_dni_estado_producto($dni, $estado, $tipo_producto)
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
    CONCAT(u.nombres, ' ', u.apellidos) AS nombre_completo, 
    v.estado, 
    v.tipo_producto 
FROM 
    ventas v 
INNER JOIN 
    usuario u 
ON 
    v.id_usuario = u.id WHERE v.estado != 'Cancelado'";

        if ($dni) {
            $sql .= " AND v.dni = :dni";
        }

        if ($estado) {
            $sql .= " AND v.estado = :estado";
        }
        if ($tipo_producto) {
            $sql .= " AND v.tipo_producto = :tipo_producto";
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



        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function actualizar_venta($id, $nombres, $dni, $celular, $credito, $linea, $plazo, $tem, $tipo_producto, $estado)
    {
        if (empty($nombres) || empty($dni) || empty($celular) || empty($credito) || empty($linea) || empty($tem) || empty($tipo_producto) || empty($estado)) {
            return [
                "status" => "error",
                "message" => "Verfifique los campos vacios."
            ];
        } else {
            $sql = "UPDATE ventas SET nombres = ?, dni = ?, celular = ?, credito = ?, linea = ?, plazo = ?, tem = ?, tipo_producto = ?, estado = ?, updated_at = now() WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $nombres);
            $sql->bindValue(2, $dni);
            $sql->bindValue(3, $celular);
            $sql->bindValue(4, $credito);
            $sql->bindValue(5, $linea);
            $sql->bindValue(6, $plazo);
            $sql->bindValue(7, $tem);
            $sql->bindValue(8, $tipo_producto);
            $sql->bindValue(9, $estado);
            $sql->bindValue(10, $id);
            $sql->execute();

            return [
                "status" => "success",
                "message" => "Venta editada correctamente."
            ];
        }
    }
    public function contar_ld_por_id($id_usuario)
    {
        $sql = "SELECT COUNT(*) AS cantidad_ld FROM ventas WHERE tipo_producto IN ('LD', 'LD/TC') AND estado = 'Desembolsado' AND id_usuario = ? LIMIT 1";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id_usuario);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function contar_tc_por_id($id_usuario)
    {
        $sql = "SELECT COUNT(*) AS cantidad_tc FROM ventas WHERE tipo_producto IN ('TC', 'LD/TC') AND estado = 'Desembolsado' AND id_usuario = ? LIMIT 1";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id_usuario);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function contar_ld_monto_por_id($id_usuario)
    {
        $sql = "SELECT SUM(credito) AS ld_monto FROM ventas WHERE estado = 'Desembolsado' AND id_usuario = ? LIMIT 1 ";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id_usuario, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtener_ventas_paginados($limit, $offset)
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
            v.id_usuario,
            u.foto, 
            DATE(v.created_at) AS created_at,
            CONCAT(u.nombres, ' ', u.apellidos) AS nombre_completo, 
            v.tipo_producto, 
            v.estado,
            u.rol 
        FROM 
            ventas v 
        INNER JOIN 
            usuario u 
        ON 
            v.id_usuario = u.id WHERE v.estado = 'Desembolsado' ORDER BY v.id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function contar_ventas()
    {
        $sql = "SELECT COUNT(*) as total FROM ventas WHERE estado = 'Desembolsado'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    public function obtener_ventas_filtro($id, $id_usuario, $dni, $tipo_producto, $created_at, $limit, $offset) {
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
            v.id_usuario,
            u.foto, 
            DATE(v.created_at) AS created_at,
            CONCAT(u.nombres, ' ', u.apellidos) AS nombre_completo, 
            v.tipo_producto, 
            v.estado
        FROM 
            ventas v 
        INNER JOIN 
            usuario u 
        ON 
            v.id_usuario = u.id WHERE v.estado = 'Desembolsado'";
        $params = [];

        if (!empty($id)) {
            $sql .= " AND v.id = :id";
            $params[':id'] = $id;
        }

        if (!empty($dni)) {
            $sql .= " AND v.dni = :dni";
            $params[':dni'] = $dni;
        }

        if (!empty($id_usuario)) {
            $sql .= " AND v.id_usuario = :id_usuario";
            $params[':id_usuario'] = $id_usuario;
        }

        if (!empty($tipo_producto)) {
            $sql .= " AND v.tipo_producto = :tipo_producto";
            $params[':tipo_producto'] = $tipo_producto;
        }

        if (!empty($created_at)) {
            $sql .= " AND DATE(v.created_at) = :created_at";
            $params[':created_at'] = $created_at;
        }

        $sql .= " ORDER BY v.id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function contar_ventas_filtro($id, $id_usuario, $dni, $tipo_producto, $created_at) {
        $sql = "SELECT COUNT(*) AS total
            FROM ventas WHERE estado = 'Desembolsado'";

        if ($id) {
            $sql .= " AND id = :id";
        }
        if ($dni) {
            $sql .= " AND dni = :dni";
        }
        if ($id_usuario) {
            $sql .= " AND id_usuario = :id_usuario";
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
        if ($id_usuario) {
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
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
