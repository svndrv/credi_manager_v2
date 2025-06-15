<?php 

class ArchivadoVentas extends Conectar {
    private $db;
    private $archivadoventas;

    public function __construct(){
        $this->db = Conectar::conexion();
        $this->archivadoventas = array();
    }

    public function obtener_archivadoventas_paginados($limit, $offset, $id) {
        $sql = "SELECT
        a.id AS id_archivado,
        p.id AS id_proceso,
        a.id_procesoventas,
        p.nombres,
        p.dni, 
        a.descripcion,
        DATE(a.created_at) AS created_at
        FROM archivado_ventas a
        JOIN proceso_ventas p ON a.id_procesoventas = p.id WHERE p.id_usuario = :id LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function contar_archivadoventas($id) {
        $sql = "SELECT COUNT(*) as total FROM archivado_ventas a 
        JOIN proceso_ventas p ON a.id_procesoventas = p.id WHERE p.id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    public function agregar_archivadoventas($id_procesoventas, $descripcion, $created_at)
    {
        if (empty($id_procesoventas) || empty($descripcion) || empty($created_at)) {
            return [
                "status" => "error",
                "message" => "Verifica los campos vacíos."
            ];
        }

        $sql = "INSERT INTO archivado_ventas (id_procesoventas, descripcion, created_at)
         VALUES (?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $id_procesoventas);
        $stmt->bindValue(2, $descripcion);
        $stmt->bindValue(3, $created_at);
        $stmt->execute();

        $sql_update = "UPDATE proceso_ventas SET estado = 'Archivado' WHERE id = ?";
        $stmt_update = $this->db->prepare($sql_update);
        $stmt_update->bindValue(1, $id_procesoventas);
        $stmt_update->execute();

        return [
            "status" => "success",
            "message" => "Se archivo correctamente."
        ];
    }
    public function obtener_archivados_x_id($id){
    $sql = "SELECT 
            a.id AS id_archivado,
            p.id AS id_proceso,
            a.id_procesoventas,
            a.descripcion,
            p.nombres,
            p.dni,
            p.celular,
            p.credito,
            p.linea,
            p.plazo,
            p.tem,
            p.id_usuario,
            p.tipo_producto,
            p.estado,
            p.documento
        FROM archivado_ventas a
        JOIN proceso_ventas p ON a.id_procesoventas = p.id
        WHERE a.id = ?;";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
    public function desarchivar_venta($id_archivado, $id_proceso)
    {
        if (empty($id_archivado) || empty($id_proceso)) {
            return [
                "status" => "error",
                "message" => "Verifica los campos vacíos."
            ];
        }

        $sql = "DELETE FROM archivado_ventas WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $id_archivado);
        $stmt->execute();

        $sql_update = "UPDATE proceso_ventas SET estado = 'Pendiente' WHERE id = ?";
        $stmt_update = $this->db->prepare($sql_update);
        $stmt_update->bindValue(1, $id_proceso);
        $stmt_update->execute();

        return [
            "status" => "success",
            "message" => "Se desarchivo la venta."
        ];
    }



}