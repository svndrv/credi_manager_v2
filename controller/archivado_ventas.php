<?php 
session_start();

require "../config/conexion.php";
require "../model/archivado_ventas.php";

$archivado_ventas = new ArchivadoVentas();

$option = isset($_POST['option']) ? $_POST['option'] : '';
$pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 1;

$id = isset($_POST['id']) ? $_POST['id'] : '';
$id_procesoventas = isset($_POST['id_procesoventas']) ? $_POST['id_procesoventas'] : '';
$dni = isset($_POST['dni']) ? $_POST['dni'] : '';
$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
$created_at = isset($_POST['created_at']) ? $_POST['created_at'] : '';
$id_archivado = isset($_POST['id_archivado']) ? $_POST['id_archivado'] : '';
$id_proceso = isset($_POST['id_proceso']) ? $_POST['id_proceso'] : '';

switch ($option) {

    case 'listar_aventas':
        $por_pagina = 7;
        $offset = ($pagina - 1) * $por_pagina;
        $aventas = $archivado_ventas->obtener_archivadoventas_paginados($por_pagina, $offset, $_SESSION['id']);
        echo json_encode($aventas);    
    break;

    case 'contar_aventas':
        $total_archivadoventas = $archivado_ventas->contar_archivadoventas($_SESSION['id']);
        echo json_encode(['total' => $total_archivadoventas]);
    break;

    case 'agregar_archivadoventas':
        echo json_encode(
            $archivado_ventas->agregar_archivadoventas(
                $id_procesoventas,
                $descripcion,
                $created_at,
            ));
    break;

    case 'obtener_archivados_x_id':
        echo json_encode($archivado_ventas->obtener_archivados_x_id($id));
    break;

    case 'desarchivar_venta':
        echo json_encode($archivado_ventas->desarchivar_venta($id_archivado, $id_proceso));
    break;

    case "filtro_archivadoventas":
        $por_pagina = 3;
        $offset = ($pagina - 1) * $por_pagina;
        $archivado_ventas = $archivado_ventas->obtener_archivadoventas_filtro(
            $_SESSION['id'], 
            $dni,  
            $created_at, 
            $por_pagina, 
            $offset);
        echo json_encode($archivado_ventas);  
    break;
    case 'contar_archivados_filtro':
        $total = $archivado_ventas->contar_archivados_filtro($_SESSION['id'], $dni, $created_at);
        echo json_encode(['total' => $total]);
    break;
    default:
        echo json_encode(['error' => 'Opción no válida']); 
    break;
}