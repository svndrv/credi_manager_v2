<?php 
class Cartera extends Conectar {
    private $db;
    private $cartera;

    public function __construct(){
        $this->db = Conectar::conexion();
        $this->cartera = array();
    }
    public function setDb($pdo)
    {
        $this->db = $pdo;
    }
    public function obtener_cartera($id){
        $sql = "SELECT * FROM cartera WHERE id_usuario = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtener_cartera_x_id($id){
        $sql = "SELECT * FROM cartera WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function agregar_cartera($nombres, $dni, $celular, $id_usuario){

        if(empty($nombres) || empty($dni) || empty($celular)){
            return [
                "status" => "error",
                "message" => "Verifica los campos vacíos."
            ];
        }
        
        $sql = "INSERT INTO cartera (nombres, dni, celular, id_usuario, created_at , updated_at) VALUES(?, ?, ?, ?, now(), now())";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $nombres);
        $sql->bindValue(2, $dni);
        $sql->bindValue(3, $celular);
        $sql->bindValue(4, $id_usuario);
        $sql->execute();

        $response = [
            "status" => "success",
            "message" => "Se agrego correctamente."
        ];
        return $response;

    }
    public function eliminar_cartera($id){
        $sql = "DELETE FROM cartera WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        $response = [
            "status" => "success",
            "message" => "Se elimino correctamente."
        ];
        return $response;
    }
    public function actualizar_cartera($id, $nombres, $dni, $celular){

       if(empty($nombres) || empty($dni) || empty($celular)){
        
        return [
            "status" => "error",
            "message" => "Verifique los campos vacíos."
        ];
       }
       
       $sql = "UPDATE cartera SET nombres = ?, dni = ?, celular = ?, updated_at = now() WHERE id = ?";
       $sql = $this->db->prepare($sql);
       $sql->bindValue(1, $nombres);
       $sql->bindValue(2, $dni);
       $sql->bindValue(3, $celular);
       $sql->bindValue(4, $id);
       $sql->execute();

       return [
        "status" => "success",
        "message" => "Se edito correctamente."
        ];
    }
    public function obtener_cartera_x_dni($dni){
        $sql = "SELECT * FROM cartera WHERE dni = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $dni);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    // Paginado x ID_USUARIO
    public function obtener_cartera_paginados($limit, $offset, $id) {
        $sql = "SELECT * FROM cartera WHERE id_usuario = :id LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 
    public function contar_cartera($id) {
        $sql = "SELECT COUNT(*) as total FROM cartera WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    public function obtener_carteras_paginadas_x_dni($id, $dni, $limit, $offset) {
        $sql = "SELECT * FROM cartera WHERE id_usuario = :id";
        $params = [];

        if (!empty($dni)) {
            $sql .= " AND dni = :dni";
            $params[':dni'] = $dni;
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
    public function contar_cartera_filtro($id, $dni) {
        $sql = "SELECT COUNT(*) as total FROM cartera WHERE id_usuario = :id";
        if ($dni) {
            $sql .= " AND dni = :dni";
        }

        $stmt = $this->db->prepare($sql);
        if ($dni) {
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
        }

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC); // <-- CAMBIA AQUÍ
        return (int)$resultado['total']; // <-- DEVUELVE SOLO EL NÚMERO
    }
}
?>