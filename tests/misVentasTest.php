<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/misventas.php';

class MisVentasTest extends TestCase
{
    private $pdo;
    private $misVentas;

    protected function setUp(): void
    {
        // Simulación de base de datos con SQLite en memoria
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec("
            CREATE TABLE ventas (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nombres TEXT,
                dni TEXT,
                celular TEXT,
                credito TEXT,
                linea TEXT,
                plazo TEXT,
                tem TEXT,
                documento TEXT,
                tipo_producto TEXT,
                estado TEXT,
                created_at TEXT,
                id_usuario INTEGER
            )
        ");

        // Insertar datos de prueba
        $this->pdo->exec("
            INSERT INTO ventas (nombres, dni, celular, credito, linea, plazo, tem, documento, tipo_producto, estado, created_at, id_usuario)
            VALUES ('Juan Pérez', '12345678', '987654321', '5000', 'Línea 1', '12', '1.5%', 'Doc', 'Personal', 'Activo', '2024-07-01', 1)
        ");

        $this->misVentas = new MisVentas();
        $this->misVentas->setDb($this->pdo);
    }
    public function testObtenerMisVentasPaginados()
    {
        $result = $this->misVentas->obtener_misventas_paginados(1, 10, 0);
        $this->assertCount(1, $result);
        $this->assertEquals('Juan Pérez', $result[0]['nombres']);
    }
    public function testContarMisVentas()
    {
        $total = $this->misVentas->contar_misventas(1);
        $this->assertEquals(1, $total);
    }
    public function testObtenerMisVentasFiltro()
    {
        $result = $this->misVentas->obtener_misventas_filtro(null, 1, '12345678', 'Personal', '2024-07-01', 10, 0);
        $this->assertCount(1, $result);
        $this->assertEquals('12345678', $result[0]['dni']);
    }
    public function testContarMisVentasFiltro()
    {
        $total = $this->misVentas->contar_misventas_filtro(null, 1, '12345678', 'Personal', '2024-07-01');
        $this->assertEquals(1, $total);
    }
}
