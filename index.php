<?php
// index.php
require_once __DIR__ . '/vendor/autoload.php';


require_once 'config/database.php';

// Obtener la URI actual
$uri = $_SERVER['REQUEST_URI'];

// Definir un arreglo de rutas
$routes = [
    '/' => 'showLogin',
    '/post-login' => 'postLogin',
];

// Verificar si la ruta está definida en el arreglo de rutas
if (array_key_exists($uri, $routes)) {
    // Obtener el nombre del método correspondiente a la ruta
    $methodName = $routes[$uri];

   // Incluir el controlador y crear una instancia de AuthController
require_once 'controllers/AuthController.php';

// Pasar la conexión de base de datos al constructor
$authController = new AuthController($conn);

    // Llamar al método correspondiente
    if (method_exists($authController, $methodName)) {
        $authController->$methodName();
    } else {
        // Manejar el caso en que el método no existe
        echo "Página no encontrada";
    }
} else {
    // Manejar el caso en que la ruta no está definida
    echo "Página no encontrada";
}
?>
