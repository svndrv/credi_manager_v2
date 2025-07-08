<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/ventas.php';

class VentasTest extends TestCase
{
    protected $ventas;
    protected $pdo;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->ventas = new Ventas();
        $this->ventas->setDb($this->pdo);
    }
    public function testObtenerVentas()
    {
        $result = [
            [
                'id' => 1,
                'nombres' => 'Juan Pérez',
                'dni' => '12345678',
                'celular' => '987654321',
                'credito' => 5000,
                'linea' => 'Línea 1',
                'plazo' => '12',
                'tem' => '2.5',
                'id_usuario' => 1,
                'tipo_producto' => 'LD',
                'estado' => 'Desembolsado',
                'created_at' => '2024-07-07 10:00:00',
                'updated_at' => '2024-07-07 10:00:00'
            ]
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn($result);

        $this->pdo->method('prepare')->willReturn($stmt);

        $ventas = $this->ventas->obtener_ventas();

        $this->assertCount(1, $ventas);
        $this->assertEquals('Juan Pérez', $ventas[0]['nombres']);
        $this->assertEquals('LD', $ventas[0]['tipo_producto']);
    }
    public function testContarLd()
    {
        $result = [['cantidad_ld' => 3]];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn($result);

        $this->pdo->method('prepare')->willReturn($stmt);

        $cantidad = $this->ventas->contar_ld();

        $this->assertEquals(3, $cantidad[0]['cantidad_ld']);
    }
    public function testContarTc()
    {
        $result = [['cantidad_tc' => 2]];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn($result);

        $this->pdo->method('prepare')->willReturn($stmt);

        $cantidad = $this->ventas->contar_tc();

        $this->assertEquals(2, $cantidad[0]['cantidad_tc']);
    }
    public function testContarLdMonto()
    {
        $result = [['ld_monto' => 15000]];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn($result);

        $this->pdo->method('prepare')->willReturn($stmt);

        $monto = $this->ventas->contar_ld_monto();

        $this->assertEquals(15000, $monto[0]['ld_monto']);
    }
    public function testEliminarVenta()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        $this->pdo->method('prepare')->willReturn($stmt);

        $response = $this->ventas->eliminar_venta(1);

        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Se ha eliminado con exito.', $response['message']);
    }
}
