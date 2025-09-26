<?php
// index.php (Front Controller)

// -------------------------------
// 1. Captura de ruta amigable
// -------------------------------
$url = $_GET['url'] ?? '';
$segmentos = explode('/', trim($url, '/'));

// Prioridad: ruta limpia > query string > valor por defecto
$controlador = $segmentos[0] 
    ?: ($_GET['controlador'] ?? 'contacto'); 
$accion = $segmentos[1] ?? null;

// -------------------------------
// 2. Router simple
// -------------------------------
switch (strtolower($controlador)) {
    case 'contacto':
    
        require_once __DIR__ . '/controlador/experienciausuarios/ContactoController.php';

        $controller = new ContactoController();
        break;

    case 'usuario':
        require_once __DIR__ . '/controlador/sistemausuarios/UsuarioController.php';
        $controller = new UsuarioController();
        break;

    case 'pedido':
        require_once __DIR__ . '/controlador/gestionpedidos/PedidoController.php';
        $controller = new PedidoController();
        break;

    default:
        http_response_code(404);
        die("Página no encontrada: " . htmlspecialchars($controlador));
}

// -------------------------------
// 3. Ejecuta el controlador
// -------------------------------
$controller->manejarPeticion();