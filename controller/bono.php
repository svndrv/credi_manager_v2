<?php 

require "../config/conexion.php";
require "../model/bono.php";

$bonos = new Bono();

$option = '';
$id = '';
$descripcion = '';
$estado = '';


if(isset($_POST['option'])){ $option = $_POST['option']; }else{ $option = "";};
if(isset($_POST['id'])){ $id = $_POST['id']; }else{ $id = "";};
if(isset($_POST['descripcion'])){ $descripcion = $_POST['descripcion']; }else{ $descripcion = "";};
if(isset($_POST['estado'])){ $estado = $_POST['estado']; }else{ $estado = "";};

switch($option){
    case 'actualizar_bono':
        echo json_encode($bonos->actualizar_bono($id, $descripcion, $estado));
    break;
    case "obtener_x_id":
        echo json_encode($bonos->obtener_bono_x_id($id));
    break;
    default:
        echo json_encode($bonos->obtener_bono());
    break; 
}
?>
