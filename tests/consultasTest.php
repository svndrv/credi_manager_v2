<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/consultas.php';

class ConsultasTest extends TestCase
{
    protected $consultas;
    protected $pdo;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->consultas = new Consultas();
        $this->consultas->setDb($this->pdo);
    }
    public function testObtenerConsultas()
    {
        $resultadoEsperado = [
            ['id' => 1, 'dni' => '12345678', 'celular' => '987654321']
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn($resultadoEsperado);
        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->consultas->obtener_consultas();
        $this->assertEquals($resultadoEsperado, $resultado);
    }
    public function testEliminarConsulta()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->consultas->eliminar_consulta(1);
        $this->assertEquals('success', $resultado['status']);
        $this->assertEquals('Consulta eliminado exitosamente.', $resultado['message']);
    }
    public function testContarConsultasFiltroConParametros()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetch')->willReturn(['total' => 3]);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->consultas->contar_consultas_filtro('12345678', 'Campaña X');
        $this->assertEquals(3, $resultado);
    }
    public function testContarConsultasFiltroSinParametros()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetch')->willReturn(['total' => 5]);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->consultas->contar_consultas_filtro('', '');
        $this->assertEquals(5, $resultado);
    }
    public function testObtenerConsultaPorDniCampana()
    {
        $resultadoEsperado = [
            ['id' => 1, 'dni' => '12345678', 'campana' => 'Campaña X']
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn($resultadoEsperado);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->consultas->obtener_x_dni_campana('12345678', 'Campaña X', 10, 0);
        $this->assertEquals($resultadoEsperado, $resultado);
    }
}
