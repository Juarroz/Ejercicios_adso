<?php
// index.php

// Captura la ruta amigable desde .htaccess
$url = $_GET['url'] ?? '';
$segmentos = explode('/', trim($url, '/'));

$controlador = $segmentos[0] ?? 'contacto'; // por defecto: contacto
$accion      = $segmentos[1] ?? null;

// Router simple
switch ($controlador) {
    case 'contacto':
        require_once _DIR_ . '/controlador/experienciausuarios/ContactoController.php';
        $controller = new ContactoController();
        break;

    case 'usuario':
        require_once _DIR_ . '/controlador/sistemausuarios/UsuarioController.php';
        $controller = new UsuarioController();
        break;

    case 'pedido':
        require_once _DIR_ . '/controlador/gestionpedidos/PedidoController.php';
        $controller = new PedidoController();
        break;

    default:
        http_response_code(404);
        die("Página no encontrada: " . htmlspecialchars($controlador));
}

$controller->manejarPeticion($accion);