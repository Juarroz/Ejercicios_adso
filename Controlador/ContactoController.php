<?php
require_once __DIR__ . '/../Modelo/Experienciausuarios/ContactoService.php';

class ContactoController {
    private $service;

    public function __construct() {
        $this->service = new ContactoService();
    }

    public function manejarPeticion() {
        $mensaje = "";
        $accion = $_POST["accion"] ?? null;

        if ($_SERVER["REQUEST_METHOD"] === "POST" && $accion) {
            switch ($accion) {
                case "crear":
                    $datos = [
                        "nombre"   => trim($_POST["nombre"] ?? ""),
                        "correo"   => trim($_POST["correo"] ?? ""),
                        "telefono" => trim($_POST["telefono"] ?? ""),
                        "mensaje"  => trim($_POST["mensaje"] ?? ""),
                        "terminos" => true
                    ];
                    $resultado = $this->service->crearContacto($datos);
                    $mensaje = $resultado["success"] 
                        ? "<p style='color:green;'>Contacto creado exitosamente.</p>" 
                        : "<p style='color:red;'>Error: {$resultado["error"]}</p>";
                    break;

                case "eliminar":
                    $id = $_POST["id"] ?? null;
                    if ($id && $this->service->eliminarContacto($id)) {
                        $mensaje = "<p style='color:green;'>Contacto eliminado.</p>";
                    } else {
                        $mensaje = "<p style='color:red;'>Error al eliminar.</p>";
                    }
                    break;

                case "actualizar":
                    $id = $_POST["id"] ?? null;
                    $datos = [
                        "estado" => $_POST["estado"] ?? "pendiente",
                        "notas"  => $_POST["notas"] ?? ""
                    ];
                    if ($id && $this->service->actualizarContacto($id, $datos)) {
                        $mensaje = "<p style='color:green;'>Contacto actualizado.</p>";
                    } else {
                        $mensaje = "<p style='color:red;'>Error al actualizar.</p>";
                    }
                    break;
            }
        }

        $contactos = $this->service->listarContactos();

        require __DIR__ . '/../vista/contacto_index.php';
    }
}
