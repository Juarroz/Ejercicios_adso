<?php
include 'funciones_contacto.php';

echo "=== Menú de Formularios ===\n";
echo "1. Crear formulario\n";
echo "2. Consultar formulario\n";
echo "3. Actualizar formulario\n";
echo "4. Eliminar formulario\n";

$opcion = readline("Seleccione una opción: ");

switch ($opcion) {
    case 1:
        $nombre   = readline("Nombre: ");
        $email    = readline("Email: ");
        $telefono = readline("Teléfono: ");
        $mensaje  = readline("Mensaje: ");
        $via      = readline("Vía (formulario/whatsapp): ");

        $datos = [
            "conNombre"   => $nombre,
            "conEmail"    => $email,
            "conTelefono" => $telefono,
            "conMensaje"  => $mensaje,
            "conVia"      => $via,
            "conTerminos" => true
        ];

        $resultado = crearFormulario($datos);
        echo "Código: {$resultado['codigo']}\n";
        echo "Respuesta: {$resultado['respuesta']}\n";
        break;

    case 2:
        $id = readline("ID del formulario: ");
        echo obtenerFormulario($id) . "\n";
        break;

    case 3:
        $id = readline("ID del formulario: ");
        $nuevoMensaje = readline("Nuevo mensaje: ");
        $nuevoTelefono = readline("Nuevo teléfono: ");
        $resultado = actualizarFormulario($id, [
            "conMensaje"  => $nuevoMensaje,
            "conTelefono" => $nuevoTelefono
        ]);
        echo "Código: {$resultado['codigo']}\n";
        echo "Respuesta: {$resultado['respuesta']}\n";
        break;

    case 4:
        $id = readline("ID del formulario: ");
        $resultado = eliminarFormulario($id);
        echo "Código: {$resultado['codigo']}\n";
        echo "Respuesta: {$resultado['respuesta']}\n";
        break;

    default:
        echo "Opción no válida\n";
}
?>
