<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/cartera.php';

class CarteraTest extends TestCase
{
    protected $cartera;
    protected $pdo;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->cartera = new Cartera();
        $this->cartera->setDb($this->pdo);
    }
    public function testObtenerCartera()
    {
        $esperado = [
            ['id' => 1, 'nombres' => 'Ana', 'dni' => '12345678']
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn($esperado);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->cartera->obtener_cartera(1);
        $this->assertCount(1, $resultado);
        $this->assertEquals('Ana', $resultado[0]['nombres']);
    }
    public function testAgregarCartera()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->cartera->agregar_cartera('Ana', '12345678', '987654321', 1);
        $this->assertEquals('success', $resultado['status']);
    }
    public function testAgregarCarteraCamposVacios()
    {
        $resultado = $this->cartera->agregar_cartera('', '', '', 1);
        $this->assertEquals('error', $resultado['status']);
    }
    public function testEliminarCartera()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->cartera->eliminar_cartera(1);
        $this->assertEquals('success', $resultado['status']);
    }
    public function testActualizarCartera()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->cartera->actualizar_cartera(1, 'Ana', '12345678', '987654321');
        $this->assertEquals('success', $resultado['status']);
    }
    public function testActualizarCarteraCamposVacios()
    {
        $resultado = $this->cartera->actualizar_cartera(1, '', '', '');
        $this->assertEquals('error', $resultado['status']);
    }
    public function testContarCartera()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetch')->willReturn(['total' => 4]);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->cartera->contar_cartera(1);
        $this->assertEquals(4, $resultado);
    }

    public function testObtenerCarteraPaginados()
    {
        $esperado = [
            ['id' => 1, 'nombres' => 'Ana', 'dni' => '12345678']
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn($esperado);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->cartera->obtener_cartera_paginados(5, 0, 1);
        $this->assertCount(1, $resultado);
    }
    public function testContarCarteraFiltroConDni()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetch')->willReturn(['total' => 2]);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->cartera->contar_cartera_filtro(1, '12345678');
        $this->assertEquals(2, $resultado);
    }
    public function testContarCarteraFiltroSinDni()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetch')->willReturn(['total' => 5]);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->cartera->contar_cartera_filtro(1, '');
        $this->assertEquals(5, $resultado);
    }
    public function testObtenerCarterasPaginadasXDniConFiltro()
    {
        $esperado = [
            ['id' => 1, 'dni' => '12345678', 'nombres' => 'Ana']
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn($esperado);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->cartera->obtener_carteras_paginadas_x_dni(1, '12345678', 10, 0);
        $this->assertCount(1, $resultado);
        $this->assertEquals('Ana', $resultado[0]['nombres']);
    }
    public function testObtenerCarterasPaginadasXDniSinFiltro()
    {
        $esperado = [
            ['id' => 1, 'dni' => '12345678', 'nombres' => 'Ana'],
            ['id' => 2, 'dni' => '87654321', 'nombres' => 'Luis']
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn($esperado);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->cartera->obtener_carteras_paginadas_x_dni(1, '', 10, 0);
        $this->assertCount(2, $resultado);
    }
}