<?php 

session_start();

require "../config/conexion.php";
require "../model/cartera.php";

$cartera = new Cartera();

$id = '';
$nombres = '';
$dni = '';
$celular = '';
$id_usuario = '';

$option = isset($_POST['option']) ? $_POST['option'] : '';
$pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 1;

if(isset($_POST['option'])){ $option = $_POST['option']; }else{ $option = "";};
if(isset($_POST['id'])){ $id = $_POST['id']; }else{ $id = "";};
if(isset($_POST['nombres'])){ $nombres = $_POST['nombres']; }else{ $nombres = "";};
if(isset($_POST['dni'])){ $dni = $_POST['dni']; }else{ $dni = "";};
if(isset($_POST['celular'])){ $celular = $_POST['celular']; }else{ $celular = "";};
if(isset($_POST['id_usuario'])){ $id_usuario = $_POST['id_usuario']; }else{ $id_usuario = "";};

switch($option){

    case 'listar_pcartera':
        $por_pagina = 11;
        $offset = ($pagina - 1) * $por_pagina;
        $pcartera = $cartera->obtener_cartera_paginados($por_pagina, $offset, $_SESSION['id']);
        echo json_encode($pcartera);
    break;
    case 'contar_pcartera':
        $total_cartera = $cartera->contar_cartera($_SESSION['id']);
        echo json_encode(['total' => $total_cartera]);
    break;
    case "filtro_cartera":
        $por_pagina = 11;
        $offset = ($pagina - 1) * $por_pagina;
        $cartera = $cartera->obtener_carteras_paginadas_x_dni($_SESSION['id'], $dni,$por_pagina, $offset);
        echo json_encode($cartera);
    break;
        case 'contar_cartera_filtro':
        $total = $cartera->contar_cartera_filtro($_SESSION['id'], $dni);
        echo json_encode(['total' => $total]);
    break;
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
    default:
        echo json_encode(['error' => 'Opción no válida']);
    break;
}


   

?>