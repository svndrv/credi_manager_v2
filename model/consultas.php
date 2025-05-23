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
    public function obtener_x_dni_campana($dni, $campana){
        $sql = "SELECT * FROM consultas WHERE 1=1";

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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
}
?>