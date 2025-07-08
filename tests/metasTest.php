<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/metas.php';

class MetasTest extends TestCase
{
    protected $metas;
    protected $pdo;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->metas = new Metas();
        $this->metas->setDb($this->pdo);
    }
    public function testObtenerMetas()
    {
        $result = [
            [
                'id' => 1,
                'ld_cantidad' => 2,
                'tc_cantidad' => 1,
                'ld_monto' => 4000	,
                'usuario_nombre' => 'Camilo Ochoa',
                'mes' => 'Enero',
                'cumplido' => 'Si',
                'created_at' => '2024-07-01 00:00:00',
                'updated_at' => '2024-07-02 00:00:00'
            ]
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn($result);

        $this->pdo->method('prepare')->willReturn($stmt);

        $metas = $this->metas->obtener_metas();
        $this->assertGreaterThan(0, count($metas));
        $this->assertEquals('Camilo Ochoa', $metas[0]['usuario_nombre']);
    }
    public function testActualizarMeta()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        $this->pdo->method('prepare')->willReturn($stmt);

        $res = $this->metas->actualizar_meta(1, 3, 500, 1, 1, 'Julio', 'Sí');
        $this->assertEquals('success', $res['status']);
        $this->assertEquals('Meta editada correctamente.', $res['message']);
    }
    public function testAgregarMeta()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        $this->pdo->method('prepare')->willReturn($stmt);

        $res = $this->metas->agregar_meta(3, 500, 2, 1, 'Julio', 'Sí');
        $this->assertEquals('success', $res['status']);
        $this->assertEquals('Meta creada exitosamente.', $res['message']);
    }
    public function testEliminarMeta()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        $this->pdo->method('prepare')->willReturn($stmt);

        $res = $this->metas->eliminar_meta(1);
        $this->assertEquals('success', $res['status']);
        $this->assertEquals('Eliminada exitosamente.', $res['message']);
    }
}
