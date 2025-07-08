<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/archivado_ventas.php';

class ArchivadoVentasTest extends TestCase
{
    protected $archivadoVentas;
    protected $pdo;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->archivadoVentas = new ArchivadoVentas();
        $this->archivadoVentas->setDb($this->pdo); 
    }
    public function testObtenerArchivadoVentasPaginados()
    {
        $expected = [
            ['id_archivado' => 1, 'nombres' => 'Juan', 'dni' => '12345678', 'descripcion' => 'Test', 'created_at' => '2024-07-01']
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn($expected);
        $this->pdo->method('prepare')->willReturn($stmt);

        $result = $this->archivadoVentas->obtener_archivadoventas_paginados(10, 0, 1);

        $this->assertIsArray($result);
        $this->assertEquals('Juan', $result[0]['nombres']);
    }
    public function testContarArchivadoVentas()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetch')->willReturn(['total' => 5]);
        $this->pdo->method('prepare')->willReturn($stmt);

        $result = $this->archivadoVentas->contar_archivadoventas(1);

        $this->assertEquals(5, $result);
    }
    public function testAgregarArchivadoVentas()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        $this->pdo->method('prepare')->willReturn($stmt);

        $result = $this->archivadoVentas->agregar_archivadoventas(1, 'Test', '2024-07-07');

        $this->assertEquals('success', $result['status']);
        $this->assertEquals('Se archivo correctamente.', $result['message']);
    }
    public function testDesarchivarVenta()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        $this->pdo->method('prepare')->willReturn($stmt);

        $result = $this->archivadoVentas->desarchivar_venta(1, 1);

        $this->assertEquals('success', $result['status']);
        $this->assertEquals('Se desarchivo la venta.', $result['message']);
    }
    public function testAgregarArchivadoVentasCamposVacios()
    {
        $result = $this->archivadoVentas->agregar_archivadoventas('', '', '');
        $this->assertEquals('error', $result['status']);
        $this->assertEquals('Verifica los campos vacíos.', $result['message']);
    }
    public function testDesarchivarVentaCamposVacios()
    {
        $result = $this->archivadoVentas->desarchivar_venta('', '');
        $this->assertEquals('error', $result['status']);
        $this->assertEquals('Verifica los campos vacíos.', $result['message']);
    }
}