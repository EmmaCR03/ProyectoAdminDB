<?php
class Conexion {
    protected static $pdo;

    public static function conectar() {
        if (self::$pdo === null) {
            $host = 'localhost'; // O la IP del servidor de base de datos
            $port = '1521'; // Puerto por defecto para Oracle
            $serviceName = 'XE'; // Nombre del servicio para Oracle XE
            $usuario = 'system'; // Reemplaza con tu nombre de usuario
            $contrasena = 'Jose131005'; // Reemplaza con tu contraseña

            // Construir el DSN para Oracle usando el nombre del servicio
            $dsn = "oci:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port))(CONNECT_DATA=(SERVICE_NAME=$serviceName)))";

            try {
                self::$pdo = new PDO($dsn, $usuario, $contrasena);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Error de conexión: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    public static function desconectar()
    {
        self::$pdo = null;
    }
}
?>
