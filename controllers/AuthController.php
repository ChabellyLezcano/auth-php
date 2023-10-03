<?php

class AuthController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function showLogin()
    {
        // Aquí puedes realizar cualquier lógica adicional necesaria antes de mostrar el formulario de inicio de sesión
        // Por ejemplo, verificar si el usuario ya está autenticado y redirigirlo si es necesario.

        // Obtener la ruta absoluta al directorio 'views'
    $viewsDir = __DIR__ . '/../views/';

    // Incluir la vista del formulario de inicio de sesión utilizando la ruta absoluta
    include($viewsDir . 'login.php'); // Ajusta la ruta según tu estructura de carpetas
    }

    public function showRegister()
    {
        $viewsDir = __DIR__ . '/../views/';
    include($viewsDir . 'register.php');
    }

    public function register()
    {
        // Obtener datos del formulario de registro (debes validar y asegurarte de que los datos sean seguros)
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Hashear la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Comprobar si el usuario ya existe en la base de datos
        $query = "SELECT * FROM usuarios WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // El usuario ya existe
            $response = [
                "message" => "El usuario ya existe.",
            ];
        } else {
            // Insertar el nuevo usuario en la base de datos
            $insertQuery = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
            $stmt = $this->conn->prepare($insertQuery);
            $stmt->bind_param("ss", $username, $hashedPassword);

            if ($stmt->execute()) {
                // Usuario registrado con éxito
                $response = [
                    "message" => "Bienvenido, tu usuario ha sido registrado correctamente.",
                ];
            } else {
                // Error al registrar el usuario
                $response = [
                    "message" => "Error al registrar el usuario: " . $stmt->error,
                ];
            }
        }

        // Devolver una respuesta JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Otros métodos de autenticación (login, logout, etc.) pueden agregarse aquí
}
