<?php
// Inicia o reanuda la sesión de PHP para manejar el token
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Usamos la constante ROOT_PATH para una ruta segura
require_once ROOT_PATH . '/Modelo/Sistemausuarios/UsuarioService.php';

class UsuarioController {
    private $usuarioService;

    public function __construct() {
        $this->usuarioService = new UsuarioService();
    }

    public function manejarPeticion() {
        // Inicializamos variables para la vista
        $mensajeLogin = '';
        $mensajeRegistro = '';
        $usuarios = [];

        // Lógica de Logout
        if (isset($_GET['accion']) && $_GET['accion'] == 'logout') {
            session_destroy();
            header("Location: index.php?page=usuarios");
            exit();
        }

        // Lógica para procesar formularios (cuando se envían por POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';

            // Acción para iniciar sesión
            if ($accion === 'login') {
                $resultado = $this->usuarioService->login($_POST['email'], $_POST['password']);
                if ($resultado['success']) {
                    $_SESSION['jwt_token'] = $resultado['token'];
                } else {
                    $mensajeLogin = "<p style='color:red;'>" . htmlspecialchars($resultado['error']) . "</p>";
                }
            } 
            // Acción para registrar un usuario
            elseif ($accion === 'registrar') {
                $userData = [
                    "nombre" => $_POST['nombre'],
                    "correo" => $_POST['correo'],
                    "password" => $_POST['password'],
                    "rolId" => 2, // Por defecto, rol de usuario normal
                    "activo" => true
                ];
                $resultado = $this->usuarioService->registrarUsuario($userData);
                if ($resultado['success']) {
                    $mensajeRegistro = "<p style='color:green;'>Usuario registrado correctamente.</p>";
                } else {
                    $mensajeRegistro = "<p style='color:red;'>" . htmlspecialchars($resultado['error']) . "</p>";
                }
            }
        }

        // Si existe un token en la sesión, obtenemos la lista de usuarios
        if (isset($_SESSION['jwt_token'])) {
            $listaUsuarios = $this->usuarioService->obtenerUsuarios($_SESSION['jwt_token']);
            if ($listaUsuarios !== false) {
                $usuarios = $listaUsuarios;
            } else {
                // Si el token es inválido, lo borramos y mostramos un mensaje
                unset($_SESSION['jwt_token']);
                $mensajeLogin = "<p style='color:red;'>Tu sesión ha expirado. Inicia sesión de nuevo.</p>";
            }
        }
        
        // Al final, siempre cargamos la vista y le pasamos las variables
        require ROOT_PATH . '/Vista/Sistemausuarios/VistaUsuario.php';
    }
}