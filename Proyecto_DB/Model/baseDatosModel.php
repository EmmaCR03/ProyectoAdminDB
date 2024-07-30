<?php include_once '../Conn/conexion.php';

function crearConexion()
{
    $config = ConexionBaseDatos();
    $dsn = $config['database']['connection_string'];
    $username = $config['database']['username']; 
    $password = $config['database']['password']; 

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Conexión exitosa a la base de datos.";
        return $conn;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        exit;
    }
}

// Llamar a la función para probar la conexión
crearConexion();
?>