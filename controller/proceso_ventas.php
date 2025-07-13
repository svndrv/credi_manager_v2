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
$created_at = isset($_POST['created_at']) ? $_POST['created_at'] : '';
$documento = isset($_POST['documento']) ? $_POST['documento'] : '';

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
    case "filtro_procesoventas":
        $por_pagina = 7;
        $offset = ($pagina - 1) * $por_pagina;
        $proceso_ventas = $proceso_ventas->obtener_procesoventas_filtro($_SESSION['id'],
        $dni, $estado, $tipo_producto, $created_at, $por_pagina, $offset);
        echo json_encode($proceso_ventas);
    break;
    case 'contar_procesoventas_filtro':
        $total = $proceso_ventas->contar_procesoventas_filtro($_SESSION['id'], $dni, $estado, $tipo_producto, $created_at);
        echo json_encode(['total' => $total]);
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
    case 'trasladar_to_ventas':
        echo json_encode(
            $proceso_ventas->proceso_to_desembolsado(
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
                $documento
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
        $total_procesoventas = $proceso_ventas->contar_procesoventas($_SESSION['id']);
        echo json_encode(['total' => $total_procesoventas]);
    break;
}