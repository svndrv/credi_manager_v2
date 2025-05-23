<?php 
class Bono extends Conectar {
    private $db;
    private $bono;

    public function __construct(){
        $this->db = Conectar::conexion();
        $this->bono = array();
    }

    public function setDb($dbh)
    {
        $this->dbh = $dbh;
    }
    public function obtener_bono(){
        $sql = "SELECT * FROM bono";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_bono_x_id($id){
        $sql = "SELECT * FROM bono WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizar_bono($id, $descripcion, $estado) {
        if (empty($descripcion) || empty($estado)) {
            return [
                "status" => "error",
                "message" => "Verifique los campos vacíos."
            ];
        }
    
        try {
            $sql = "UPDATE bono SET descripcion = ?, estado = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(1, $descripcion);
            $stmt->bindValue(2, $estado);
            $stmt->bindValue(3, $id);
    
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    return [
                        "status" => "success",
                        "message" => "Bono actualizado correctamente."
                    ];
                } else {
                    return [
                        "status" => "error",
                        "message" => "No se encontró el bono con ese ID o no hubo cambios en los datos."
                    ];
                }
            } else {
                return [
                    "status" => "error",
                    "message" => "Error al ejecutar la consulta. Por favor, inténtelo de nuevo."
                ];
            }
        } catch (Exception $e) {
            return [
                "status" => "error",
                "message" => "Ocurrió un error: " . $e->getMessage()
            ];
        }
    }
}
?>