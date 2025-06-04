<?php 
class Consultas extends Conectar {
    private $db;
    private $consultas;

    public function __construct(){
        $this->db = Conectar::conexion();
        $this->consultas = array();
    }
    public function setDb($db) {
        $this->db = $db;
    }
    public function obtener_consultas(){
        $sql = "SELECT * FROM consultas";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function crear_consulta($dni,$celular, $descripcion, $campana){
        $sql = "INSERT INTO consultas(dni,celular,descripcion,campana,created_at,updated_at) VALUES(?,?,?,?,now(),now())";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,$dni);
        $sql->bindValue(2,$celular);
        $sql->bindValue(3,$descripcion);
        $sql->bindValue(4,$campana);
        $sql->execute();
        echo 'ok';
    }
    public function eliminar_consulta($id){
        $sql = "DELETE FROM consultas WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,$id);
        $sql->execute();

        $response = [
            "status" => "success",
            "message" => "Consulta eliminado exitosamente."
        ];
        return $response;
    }
    public function obtener_x_dni_campana($dni, $campana, $limit, $offset) {
    $sql = "SELECT * FROM consultas WHERE 1=1";
    $params = [];

    if (!empty($dni)) {
        $sql .= " AND dni = :dni";
        $params[':dni'] = $dni;
    }

    if (!empty($campana)) {
        $sql .= " AND campana = :campana";
        $params[':campana'] = $campana;
    }

    $sql .= " LIMIT :limit OFFSET :offset";

    $stmt = $this->db->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function contar_consultas_filtro($dni, $campana) {
    $sql = "SELECT COUNT(*) as total FROM consultas WHERE 1=1";
    if ($dni) {
        $sql .= " AND dni = :dni";
    }
    if ($campana) {
        $sql .= " AND campana = :campana";
    }
    $stmt = $this->db->prepare($sql);
    if ($dni) {
        $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
    }
    if ($campana) {
        $stmt->bindParam(':campana', $campana, PDO::PARAM_STR);
    }
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC); // <-- CAMBIA AQUÍ
    return (int)$resultado['total']; // <-- DEVUELVE SOLO EL NÚMERO
}

    public function obtener_consulta_x_id($id){
        $sql = "SELECT * FROM consultas WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function actualizar_consulta($id, $dni, $celular, $descripcion, $campana){
        $sql = "UPDATE consultas SET dni = ?, celular = ?, descripcion = ?, campana = ?, updated_at = now() WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $dni);
        $sql->bindValue(2, $celular);
        $sql->bindValue(3, $descripcion);
        $sql->bindValue(4, $campana);
        $sql->bindValue(5, $id);
        $sql->execute();
        echo "ok";

    }


    public function obtener_consultas_paginados($limit, $offset) {
        $sql = "SELECT * FROM consultas LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 
    public function contar_consultas() {
        $sql = "SELECT COUNT(*) as total FROM consultas";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

}
?>