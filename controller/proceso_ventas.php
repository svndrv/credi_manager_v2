<?php 
session_start();

require "../config/conexion.php";
require "../model/proceso_ventas.php";

$proceso_ventas = new ProcesoVentas();

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

switch ($option) {

    case 'listar_pventas':
        $por_pagina = 7;
        $offset = ($pagina - 1) * $por_pagina;
        $pventas = $proceso_ventas->obtener_procesoventas_paginados($por_pagina, $offset, $_SESSION['id']);
        echo json_encode($pventas);
        break;

    case 'procesoventas_x_id':
        echo json_encode($proceso_ventas->obtener_procesoventas_x_id($id));
        break;

    case 'contar_pventas':
        $total_procesoventas = $proceso_ventas->contar_procesoventas($_SESSION['id']);
        echo json_encode(['total' => $total_procesoventas]);
        break;

    case 'agregar_procesoventas':
        echo json_encode(
            $proceso_ventas->agregar_procesoventas(
                $nombres,
                $dni,
                $celular,
                $credito,
                $linea,
                $plazo,
                $tem,
                $id_usuario,
                $tipo_producto,
                $estado,
                $_FILES['documento']
            )
        );
        break;

    case 'actualizar_procesoventas':
        echo json_encode(
            $proceso_ventas->actualizar_procesoventa(
                $id,
                $nombres,
                $dni,
                $celular,
                $credito,
                $linea,
                $plazo,
                $tem,
                $id_usuario,
                $tipo_producto,
                $estado,
                $_FILES['documento'] ?? null
            )
        );
        break;

    default:
        echo json_encode(['error' => 'Opción no válida']);
        break;
}