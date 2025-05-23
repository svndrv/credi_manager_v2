<?php 

session_start();

require "../config/conexion.php";
require "../model/cartera.php";

$cartera = new Cartera();

$option = '';
$id = '';
$nombres = '';
$dni = '';
$celular = '';
$id_usuario = '';

if(isset($_POST['option'])){ $option = $_POST['option']; }else{ $option = "";};
if(isset($_POST['id'])){ $id = $_POST['id']; }else{ $id = "";};
if(isset($_POST['nombres'])){ $nombres = $_POST['nombres']; }else{ $nombres = "";};
if(isset($_POST['dni'])){ $dni = $_POST['dni']; }else{ $dni = "";};
if(isset($_POST['celular'])){ $celular = $_POST['celular']; }else{ $celular = "";};
if(isset($_POST['id_usuario'])){ $id_usuario = $_POST['id_usuario']; }else{ $id_usuario = "";};

switch($option){
    case "obtener_x_id":
        echo json_encode($cartera->obtener_cartera_x_id($id));
        break;
    case "actualizar_cartera":
        echo json_encode($cartera->actualizar_cartera($id, $nombres, $dni, $celular));
        break;
    case "agregar_cartera":
        echo json_encode($cartera->agregar_cartera($nombres, $dni, $celular, $id_usuario));
        break;
    case "eliminar_cartera":
        echo json_encode($cartera->eliminar_cartera($id));
        break;
    case "cartera_x_dni":
        echo json_encode($cartera->obtener_cartera_x_dni($dni));
        break;
    default:
        echo json_encode($cartera->obtener_cartera($_SESSION['id']));
    break;
}


   

?>