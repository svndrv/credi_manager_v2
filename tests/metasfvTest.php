<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/metasfv.php';

class MetasfvTest extends TestCase
{
    protected $metasfv;
    protected $pdo;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->metasfv = new Metasfv();
        $this->metasfv->setDb($this->pdo);
    }

    public function testObtenerMetasFv()
    {
        $resultadoEsperado = [
            ['id' => 1, 'ld_cantidad' => 10, 'tc_cantidad' => 5, 'ld_monto' => 1000, 'sede' => 'Lima', 'mes' => '2025-07', 'cumplido' => 'no']
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn($resultadoEsperado);

        $this->pdo->method('prepare')->willReturn($stmt);

        $metas = $this->metasfv->obtener_metasfv();

        $this->assertCount(1, $metas);
        $this->assertEquals('Lima', $metas[0]['sede']);
        $this->assertEquals('2025-07', $metas[0]['mes']);
    }
    public function testAgregarMetafv()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->metasfv->agregar_metafv(10, 1000, 5, 'Lima', '2025-07', 'no');

        $this->assertEquals('success', $resultado['status']);
        $this->assertEquals('Meta creada exitosamente.', $resultado['message']);
    }
    public function testActualizarMetafv()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->metasfv->actualizar_metafv(1, 15, 7, 1200, 'Arequipa', '2025-08', 'sí');

        $this->assertEquals('success', $resultado['status']);
        $this->assertEquals('Meta editada correctamente.', $resultado['message']);
    }
    public function testEliminarMetafv()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        $this->pdo->method('prepare')->willReturn($stmt);

        $resultado = $this->metasfv->eliminar_metafv(1);

        $this->assertEquals('success', $resultado['status']);
        $this->assertEquals('Eliminada exitosamente.', $resultado['message']);
    }
    public function testObtenerMetaXId()
    {
        $resultadoEsperado = [
            [
                'id' => 1,
                'ld_cantidad' => 10,
                'tc_cantidad' => 5,
                'ld_monto' => 1000,
                'sede' => 'Lima',
                'mes' => '2025-07',
                'cumplido' => 'no'
            ]
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn($resultadoEsperado);

        $this->pdo->method('prepare')->willReturn($stmt);

        $meta = $this->metasfv->obtener_meta_x_id(1);

        $this->assertCount(1, $meta);
        $this->assertEquals('Lima', $meta[0]['sede']);
    }
}
?>
