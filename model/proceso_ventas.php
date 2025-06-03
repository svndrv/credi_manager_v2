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
        $sql = "SELECT * FROM proceso_ventas WHERE id_usuario = :id LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function contar_procesoventas($id) {
        $sql = "SELECT COUNT(*) as total FROM proceso_ventas WHERE id_usuario = ?";
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

}