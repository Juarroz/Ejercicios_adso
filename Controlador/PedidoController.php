<?php
require_once __DIR__ . '/../modelo/sistemapedidos/PedidoService.php';

class PedidoController {
    private $service;

    public function __construct() {
        $this->service = new PedidoService();
    }

    public function manejarPeticion() {
        $mensaje = "";
        $accion = $_POST["accion"] ?? null;

        if ($_SERVER["REQUEST_METHOD"] === "POST" && $accion) {
            switch ($accion) {
                case "crear":
                    $datos = [
                        "pedCodigo"      => trim($_POST["pedCodigo"] ?? ""),
                        "pedComentarios" => trim($_POST["pedComentarios"] ?? ""),
                        "estId"          => intval($_POST["estId"] ?? 0),
                        "perId"          => intval($_POST["perId"] ?? 0),
                        "usuId"          => intval($_POST["usuId"] ?? 0)
                    ];
                    $resultado = $this->service->crearPedido($datos);
                    $mensaje = $resultado["success"] 
                        ? "<p style='color:green;'>Pedido creado exitosamente.</p>" 
                        : "<p style='color:red;'>Error: {$resultado["error"]}</p>";
                    break;

                case "eliminar":
                    $id = $_POST["id"] ?? null;
                    if ($id && $this->service->eliminarPedido($id)) {
                        $mensaje = "<p style='color:green;'>Pedido eliminado.</p>";
                    } else {
                        $mensaje = "<p style='color:red;'>Error al eliminar.</p>";
                    }
                    break;

                case "actualizar":
                    $id = $_POST["id"] ?? null;
                    $datos = [
                        "pedComentarios" => trim($_POST["pedComentarios"] ?? ""),
                        "estId"          => intval($_POST["estId"] ?? 0)
                    ];
                    if ($id && $this->service->actualizarPedido($id, $datos)) {
                        $mensaje = "<p style='color:green;'>Pedido actualizado.</p>";
                    } else {
                        $mensaje = "<p style='color:red;'>Error al actualizar.</p>";
                    }
                    break;
            }
        }

        // Obtener pedidos de la API
        $pedidos = $this->service->listarPedidos();

        require __DIR__ . '/../vista/pedido_index.php';
    }
}
