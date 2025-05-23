<?php 

class Ventas extends Conectar {
    private $db;
    private $usuarios;

    public function __construct(){
        $this->db = Conectar::conexion();
        $this->usuarios = array();
    }
    public function obtener_ventas_x_usuario($id_usuario, $mes){
        $sql = "SELECT ld_cantidad, tc_cantidad, ld_monto FROM ventas_por_usuario WHERE id_usuario = ? AND mes = ?;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,$id_usuario);
        $sql->bindValue(2,$mes);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtener_ventas(){
        $sql = "SELECT * FROM ventas";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtener_ventas_inner(){
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
    public function agregar_ventas($nombres, $dni, $celular, $credito, $linea, $plazo, $tem, $id_usuario, $tipo_producto, $estado){

        if(empty($nombres) || empty($dni) || empty($celular) || empty($credito) || empty($tem) || empty($id_usuario) || empty($tipo_producto) || empty($estado))
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
    public function contar_ld(){
        $sql = "SELECT COUNT(*) AS cantidad_ld FROM ventas WHERE tipo_producto IN ('LD', 'LD/TC') AND estado = 'Desembolsado'";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contar_tc(){
        $sql = "SELECT COUNT(*) AS cantidad_tc FROM ventas WHERE tipo_producto IN ('TC', 'LD/TC') AND estado = 'Desembolsado'";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contar_ld_monto(){
        $sql = "SELECT SUM(credito) AS ld_monto FROM ventas WHERE estado = 'Desembolsado'";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_venta_x_id($id){
        $sql = "SELECT v.id,v.nombres,v.dni, v.celular, v.credito, v.linea, v.plazo, v.tem, CONCAT(u.nombres, ' ', u.apellidos) AS nombre_completo, v.tipo_producto, v.estado FROM 
        ventas v INNER JOIN usuario u ON v.id_usuario = u.id WHERE v.id = ?;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminar_venta($id){
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

    public function venta_x_dni_estado_producto($dni, $estado, $tipo_producto){

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

        if($dni){
            $sql .= " AND v.dni = :dni";
        }

        if($estado){
            $sql .= " AND v.estado = :estado";
        }
        if($tipo_producto){
            $sql .= " AND v.tipo_producto = :tipo_producto";
        }

        
        
        $stmt = $this->db->prepare($sql);

        if($dni){
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
        }

        if($estado){
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        }
        if($tipo_producto){
            $stmt->bindParam(':tipo_producto', $tipo_producto, PDO::PARAM_STR);
        }

      

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function actualizar_venta($id, $nombres, $dni, $celular, $credito, $linea, $plazo, $tem, $tipo_producto, $estado){
        if (empty($nombres) || empty($dni) || empty($celular) || empty($credito) || empty($linea) || empty($tem) || empty($tipo_producto) || empty($estado)){
             return [
                "status" => "error",
                "message" => "Verfifique los campos vacios."
             ];

        }else{
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
    public function contar_ld_por_id($id_usuario){
        $sql = "SELECT COUNT(*) AS cantidad_ld FROM ventas WHERE tipo_producto IN ('LD', 'LD/TC') AND estado = 'Desembolsado' AND id_usuario = ? LIMIT 1";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,$id_usuario);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function contar_tc_por_id($id_usuario){
        $sql = "SELECT COUNT(*) AS cantidad_tc FROM ventas WHERE tipo_producto IN ('TC', 'LD/TC') AND estado = 'Desembolsado' AND id_usuario = ? LIMIT 1";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,$id_usuario);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function contar_ld_monto_por_id($id_usuario){
        $sql = "SELECT SUM(credito) AS ld_monto FROM ventas WHERE estado = 'Desembolsado' AND id_usuario = ? LIMIT 1 ";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,$id_usuario, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    

}

?>