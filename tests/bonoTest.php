<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/bono.php';

class BonoTest extends TestCase
{
    protected $bono;
    protected $pdo;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->bono = new Bono();
        $this->bono->setDb($this->pdo);
    }
    public function testObtenerBono()
    {
        $result = [
            ['id' => 1, 'descripcion' => 'Bono Actualizado', 'estado' => 'activo', 'created_at' => '2024-07-28 20:27:31', 'updated_at' => '2024-08-13 22:42:02']
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn($result);

        $this->pdo->method('prepare')->willReturn($stmt);

        $bonos = $this->bono->obtener_bono();
        $this->assertCount(1, $bonos);
        $this->assertEquals('Bono Actualizado', $bonos[0]['descripcion']);
        $this->assertEquals('activo', $bonos[0]['estado']);
    }
    public function testObtenerBonoXId()
    {
        $result = ['id' => 1, 'descripcion' => 'Bono Actualizado', 'estado' => 'activo', 'created_at' => '2024-07-28 20:27:31', 'updated_at' => '2024-08-13 22:42:02'];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn([$result]);

        $this->pdo->method('prepare')->willReturn($stmt);

        $bono = $this->bono->obtener_bono_x_id(1);
        $this->assertCount(1, $bono);
        $this->assertEquals('Bono Actualizado', $bono[0]['descripcion']);
        $this->assertEquals('activo', $bono[0]['estado']);
    }
    public function testActualizarBono()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('rowCount')->willReturn(1);

        $this->pdo->method('prepare')->willReturn($stmt);

        $result = $this->bono->actualizar_bono(1, 'Bono Actualizado', 'activo');
        $this->assertEquals('success', $result['status']);
        $this->assertEquals('Bono actualizado correctamente.', $result['message']);
    }
}
?>