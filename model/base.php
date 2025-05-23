<?php 

class Base extends Conectar{
    private $db;
    private $base;

    public function __construct(){
        $this->db = Conectar::conexion();
        $this->base = array();
    }

    public function setDb($pdo)
    {
        $this->db = $pdo;
    }

    public function verificar_dni_base($dni){
        $sql = "SELECT * FROM base WHERE dni = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,$dni);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        if($result){
            echo "1";
        }else{
            echo "2";
        }
    }

    public function eliminar_base($id){
        $sql = "DELETE FROM base WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,$id);
        $sql->execute();
        echo 'ok';
    }

    public function obtener_base_x_dni($dni){
        $sql = "SELECT * FROM base WHERE dni = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $dni);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_registros_paginados($limit, $offset) {
        $sql = "SELECT * FROM base LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contar_registros() {
        $sql = "SELECT COUNT(*) as total FROM base";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function obtener_base_x_id($id){
        $sql = "SELECT * FROM base WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);

    }

    public function insertData($data) {
        $stmt = $this->db->prepare("INSERT INTO base (dni, nombres, tipo_cliente, direccion, distrito, credito_max, linea_max, plazo_max, tem, celular_1, celular_2, celular_3, tipo_producto, combo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        foreach ($data as $row) {
            $stmt->bindValue(1, $row[0]);
            $stmt->bindValue(2, $row[1]);
            $stmt->bindValue(3, $row[2]);
            $stmt->bindValue(4, $row[3]);
            $stmt->bindValue(5, $row[4]);
            $stmt->bindValue(6, $row[5]);
            $stmt->bindValue(7, $row[6]);
            $stmt->bindValue(8, $row[7]);
            $stmt->bindValue(9, $row[8]);
            $stmt->bindValue(10, $row[9]);
            $stmt->bindValue(11, $row[10]);
            $stmt->bindValue(12, $row[11]);
            $stmt->bindValue(13, $row[12]);
            $stmt->bindValue(14, $row[13]);
            $stmt->execute();
        }
        $stmt = null; // Cierra la declaración
    }

    public function borrar_base(){
        $sql = "TRUNCATE TABLE base";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return [
            "status" => "success",
            "message" => "La base de elimino correctamente."
        ];
    }


}

?>