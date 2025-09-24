<?php
// 1. Definimos una ruta base absoluta para evitar problemas al incluir archivos.
define('ROOT_PATH', __DIR__);

// 2. Leemos un parámetro 'page' de la URL para saber qué módulo cargar.
// Si no se especifica, cargará 'contactos' o lo que definas por defecto.
$pagina = $_GET['page'] ?? 'default'; // Puedes cambiar 'default' por 'contactos'

switch ($pagina) {
    case 'usuarios':
        // Si la URL es ?page=usuarios, carga el controlador de usuarios.
        require_once ROOT_PATH . '/Controlador/Sistemausuarios/UsuarioController.php';
        $controller = new UsuarioController();
        $controller->manejarPeticion();
        break;

    // Puedes agregar más casos para tus compañeros aquí
    // case 'productos':
    //     require_once ROOT_PATH . '/Controlador/Productos/ProductoController.php';
    //     $controller = new ProductoController();
    //     $controller->manejarPeticion();
    //     break;

    default:
        // Si no se especifica una página válida, puedes mostrar una página de inicio o un error.
        echo "<h1>Bienvenido a la aplicación</h1><p>Selecciona un módulo para continuar.</p>";
        break;
}