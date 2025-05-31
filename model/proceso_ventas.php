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





    private function encryptFile($source, $destination, $key) {
        $cipher = "aes-256-cbc";
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
        
        $input = file_get_contents($source);
        $encrypted = openssl_encrypt($input, $cipher, $key, 0, $iv);
        
        $result = $iv . $encrypted;
        file_put_contents($destination, $result);
    }
    private function decryptFile($source, $destination, $key) {
        $cipher = "aes-256-cbc";
        $ivLength = openssl_cipher_iv_length($cipher);
    
        $data = file_get_contents($source);
        $iv = substr($data, 0, $ivLength);
        $encryptedData = substr($data, $ivLength);
    
        $decrypted = openssl_decrypt($encryptedData, $cipher, $key, 0, $iv);
        file_put_contents($destination, $decrypted);
    }
    public function procesoventas_x_id($id){
        $sql = "SELECT * FROM proceso_ventas WHERE id_usuario = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtener_procesoventas_paginados($limit, $offset) {
        $sql = "SELECT * FROM proceso_ventas LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function contar_procesoventas() {
        $sql = "SELECT COUNT(*) as total FROM proceso_ventas";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }


    public function agregar_procesoventas($nombres, $dni, $celular, $credito, $linea, $plazo, $tem, $id_usuario, $tipo_producto, $estado, $documento){

        if(empty($nombres) || empty($dni) || empty($celular) || empty($credito) || empty($linea) || empty($plazo) || empty($tem) || empty($id_usuario) || empty($tipo_producto) || empty($estado) || empty($documento)){
            return [
                "status" => "error",
                "message" => "Verifica los campos vacíos."
            ];
        }

        $sql = "INSERT INTO proceso_ventas (nombres, dni, celular, credito, linea, plazo, tem, id_usuario, tipo_producto, estado, documento, created_at , updated_at) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), now())";

        $key = "12345678901234567890123456789012";
        $source = $_FILES["documento"]['tmp_name'];
        $nombreDocumento = uniqid() . "-" . $_FILES["documento"]['name'];
        $destination = "../pdf/documents/" . $nombreDocumento;
        $this->encryptFile($source, $destination, $key);


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
        $sql->bindValue(11, $nombreDocumento);
        $sql->execute();

        $response = [
            "status" => "success",
            "message" => "Se agrego correctamente."
        ];
        return $response;
    }
    public function obtener_documento($id)
    {
        $sql = "SELECT documento FROM proceso_ventas WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        $data = $sql->fetch(PDO::FETCH_ASSOC);
        $key = "12345678901234567890123456789012";
        $source = "../pdf/documents/" . $data['documento'];
        $destination = "../pdf/documents/decrypted-" . $data['documento'];

        $this->decryptFile($source,$destination,$key);

        $response = [
            "status" => "success",
            "message" => "Documento obtenido con exito",
            "nameDocument" => "decrypted-" . $data['documento'],
            "destination" => $destination
        ];

        return $response;

    }
    public function restore($destination){
        unlink($destination);
    }

}