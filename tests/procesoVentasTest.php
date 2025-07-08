<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/proceso_ventas.php';

class ProcesoVentasTest extends TestCase
{
    private $procesoVentas;
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Crear tabla temporal similar a proceso_ventas
        $this->pdo->exec("
            CREATE TABLE proceso_ventas (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nombres TEXT,
                dni TEXT,
                celular TEXT,
                credito REAL,
                linea TEXT,
                plazo TEXT,
                tem REAL,
                id_usuario INTEGER,
                tipo_producto TEXT,
                estado TEXT,
                documento TEXT,
                created_at TEXT,
                updated_at TEXT
            )
        ");

        $this->procesoVentas = new ProcesoVentas();
        $this->procesoVentas->setDb($this->pdo);
    }
    public function testObtenerProcesoventasPorId()
    {
        $this->pdo->exec("
            INSERT INTO proceso_ventas (nombres, dni, celular, credito, linea, plazo, tem, id_usuario, tipo_producto, estado, documento, created_at, updated_at)
            VALUES ('Juan Pérez', '12345678', '987654321', 5000, 'Línea A', '12 meses', 2.5, 1, 'Crédito', 'Pendiente', 'doc1.pdf', datetime('now'), datetime('now'))
        ");

        $result = $this->procesoVentas->obtener_procesoventas_x_id(1);
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals('Juan Pérez', $result[0]['nombres']);
    }
    public function testContarProcesoventas()
    {
        $this->pdo->exec("
            INSERT INTO proceso_ventas (nombres, dni, celular, credito, linea, plazo, tem, id_usuario, tipo_producto, estado, documento, created_at, updated_at)
            VALUES 
            ('A', '11111111', '999999999', 1000, 'A', '6', 1.0, 5, 'T1', 'Activo', 'a.pdf', datetime('now'), datetime('now')),
            ('B', '22222222', '999999998', 2000, 'B', '12', 2.0, 5, 'T2', 'Activo', 'b.pdf', datetime('now'), datetime('now'))
        ");

        $total = $this->procesoVentas->contar_procesoventas(5);
        $this->assertEquals(2, $total);
    }
    public function testObtenerProcesoventasPaginados()
    {
        for ($i = 1; $i <= 5; $i++) {
            $this->pdo->exec("
                INSERT INTO proceso_ventas (nombres, dni, celular, credito, linea, plazo, tem, id_usuario, tipo_producto, estado, documento, created_at, updated_at)
                VALUES ('User $i', 'DNI$i', 'CEL$i', 1000, 'Línea', '6 meses', 2.5, 10, 'TP', 'Pendiente', 'doc$i.pdf', datetime('now'), datetime('now'))
            ");
        }

        $result = $this->procesoVentas->obtener_procesoventas_paginados(3, 0, 10);
        $this->assertCount(3, $result);
        $this->assertEquals('User 1', $result[0]['nombres']);
    }
    public function testObtenerProcesoventasFiltro()
    {
        $this->pdo->exec("
            INSERT INTO proceso_ventas (nombres, dni, celular, credito, linea, plazo, tem, id_usuario, tipo_producto, estado, documento, created_at, updated_at)
            VALUES ('Nombre', '87654321', '987654321', 7000, 'Línea B', '24 meses', 3.5, 99, 'Tipo A', 'Pendiente', 'docfile.pdf', datetime('now'), datetime('now'))
        ");

        $result = $this->procesoVentas->obtener_procesoventas_filtro(99, '87654321', 'Pendiente', 'Tipo A', null, 10, 0);
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals('87654321', $result[0]['dni']);
    }
}
