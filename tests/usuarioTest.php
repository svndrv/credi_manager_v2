<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/usuario.php';

class UsuarioTest extends TestCase
{
    private $pdo;
    private $usuario;

    protected function setUp(): void
    {
        // Crear base de datos en memoria SQLite
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Crear tabla `usuario` con DATETIME('now') en lugar de now()
        $this->pdo->exec("
            CREATE TABLE usuario (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                usuario TEXT,
                contrasena TEXT,
                nombres TEXT,
                apellidos TEXT,
                rol TEXT,
                estado TEXT,
                foto TEXT,
                created_at TEXT DEFAULT (DATETIME('now')),
                updated_at TEXT DEFAULT (DATETIME('now'))
            );
        ");

        $hashedPassword = password_hash('123456', PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO usuario (usuario, contrasena, nombres, apellidos, rol, estado, foto) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            'admin',            // usuario
            $hashedPassword,    // contrasena (encriptada)
            'Nombre',           // nombres
            'Apellido',         // apellidos
            'admin',            // rol
            '1',                // estado ACTIVO
            'user.png'          // foto
        ]);

        // Instanciar el modelo y asignar conexión SQLite
        $this->usuario = new Usuario();
        $this->usuario->setDb($this->pdo);
    }
    public function testLoginCorrecto()
    {
        $resultado = $this->usuario->login('admin', '123456');
        $this->assertEquals('error', $resultado['status']);
    }
    public function testLoginContrasenaIncorrecta()
    {
        $resultado = $this->usuario->login('admin', 'contramal');
        $this->assertEquals('error', $resultado['status']);
        $this->assertEquals('El usuario no existe.', $resultado['message']);
    }
    public function testObtenerUsuarios()
    {
        $usuarios = $this->usuario->obtener_usuarios();
        $this->assertIsArray($usuarios);
        $this->assertCount(1, $usuarios);
        $this->assertEquals('admin', $usuarios[0]['usuario']);
    }
    public function testObtenerUsuarioPorId()
    {
        $usuario = $this->usuario->obtener_usuario_x_id(1);
        $this->assertIsArray($usuario);
        $this->assertCount(1, $usuario);
        $this->assertEquals('admin', $usuario[0]['usuario']);
    }
    public function testEliminarUsuario()
    {
        $respuesta = $this->usuario->eliminar_usuario(1);
        $this->assertEquals('success', $respuesta['status']);

        $usuarios = $this->usuario->obtener_usuarios();
        $this->assertCount(0, $usuarios);
    }
}
