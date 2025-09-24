<?php

define('RUTA_URL_API', 'http://localhost:8080');

require_once __DIR__ . '/controlador/gestionpedidos/PedidoController.php';

$controller = new PedidoController();
$controller->manejarPeticion();
