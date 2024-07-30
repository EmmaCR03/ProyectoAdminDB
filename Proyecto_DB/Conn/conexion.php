<?php
// Configuración de conexión a Oracle
function ConexionBaseDatos()
{
    return [
        'database' => [
            'connection_string' => 'oci:dbname=//localhost:1521/xe',
            'username' => 'c###proyecto',
            'password' => 'admin',
        ],
    ];
}

// Crear la conexión a Oracle utilizando PDO

?>
