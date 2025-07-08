<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/base.php';

class BaseTest extends TestCase
{
    protected $base;
    protected $pdo;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->base = new Base();
        $this->base->setDb($this->pdo); 
    }
    public function testObtenerBaseXDni()
    {
        $resultadoEsperado = [
            ['id' => 1, 'dni' => '12345678', 'nombres' => 'Juan Pérez']
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn($resultadoEsperado);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->base->obtener_base_x_dni('12345678');
        $this->assertCount(1, $resultado);
        $this->assertEquals('Juan Pérez', $resultado[0]['nombres']);
    }
    public function testObtenerBaseXId()
    {
        $resultadoEsperado = [
            ['id' => 1, 'dni' => '12345678', 'nombres' => 'Juan Pérez']
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn($resultadoEsperado);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->base->obtener_base_x_id(1);
        $this->assertEquals('Juan Pérez', $resultado[0]['nombres']);
    }
    public function testContarRegistros()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetch')->willReturn(['total' => 10]);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->base->contar_registros();
        $this->assertEquals(10, $resultado);
    }
    public function testObtenerRegistrosPaginados()
    {
        $esperado = [
            ['id' => 1, 'dni' => '12345678', 'nombres' => 'Juan Pérez']
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn($esperado);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->base->obtener_registros_paginados(10, 0);
        $this->assertCount(1, $resultado);
    }
    public function testBorrarBase()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->base->borrar_base();
        $this->assertEquals('success', $resultado['status']);
    }
}