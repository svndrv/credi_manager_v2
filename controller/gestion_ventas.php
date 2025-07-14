<?php 
session_start();

require "../config/conexion.php";
require "../model/gestion_ventas.php";

$gestion_ventas = new GestionVentas();

$option = isset($_POST['option']) ? $_POST['option'] : '';
$pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 1;
$id = isset($_POST['id']) ? $_POST['id'] : '';
$nombres = isset($_POST['nombres']) ? $_POST['nombres'] : '';
$dni = isset($_POST['dni']) ? $_POST['dni'] : '';
$celular = isset($_POST['celular']) ? $_POST['celular'] : '';
$credito = isset($_POST['credito']) ? $_POST['credito'] : '';
$linea = isset($_POST['linea']) ? $_POST['linea'] : '';
$plazo = isset($_POST['plazo']) ? $_POST['plazo'] : '';
$tem = isset($_POST['tem']) ? $_POST['tem'] : '';
$id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : '';
$tipo_producto = isset($_POST['tipo_producto']) ? $_POST['tipo_producto'] : '';
$estado = isset($_POST['estado']) ? $_POST['estado'] : '';
$created_at = isset($_POST['created_at']) ? $_POST['created_at'] : '';
$documento = isset($_POST['documento']) ? $_POST['documento'] : '';

switch ($option) {

    case 'listar_gventas':
        $por_pagina = 7;
        $offset = ($pagina - 1) * $por_pagina;
        $gventas = $gestion_ventas->obtener_gestionventas_paginados($por_pagina, $offset);
        echo json_encode($gventas);
    break;

    case 'contar_gventas':
        $total_gestionventas = $gestion_ventas->contar_gestionventas();
        echo json_encode(['total' => $total_gestionventas]);
    break;

    case "filtro_gestionventas":
        $por_pagina = 7;
        $offset = ($pagina - 1) * $por_pagina;
        $gventas = $gestion_ventas->obtener_gestionventas_filtro(
            $id, $id_usuario, $dni, $estado, $tipo_producto, $created_at,
            $por_pagina, 
            $offset);
        echo json_encode($gventas);
    break;

    case 'contar_gventas_filtro':
        $total = $gestion_ventas->contar_procesoventas_filtro($id, $id_usuario, $dni, $estado, $tipo_producto, $created_at);
        echo json_encode(['total' => $total]);
    break;

    default:
        echo json_encode(['error' => 'Opción no válida']);                  
    break;
}