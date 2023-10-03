<?php

// Cargar variables de entorno desde el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Configuración de la base de datos
$host = $_ENV['DB_HOST'];
$usuario = $_ENV['DB_USER'];
$contrasena = $_ENV['DB_PASSWORD'];
$base_de_datos = $_ENV['DB_DATABASE'];

// Crear una conexión a la base de datos
$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    // Agrega el mensaje de éxito al registro de errores del servidor
    error_log("Conexión exitosa a la base de datos.", 0);
}

// Establecer el conjunto de caracteres a UTF-8 (opcional)
$conn->set_charset("utf8");


?>
