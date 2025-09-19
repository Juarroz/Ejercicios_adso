<?php
include 'funciones_contacto.php';

<<<<<<< HEAD
echo "=== Menú de Formularios ===\n";
echo "1. Crear formulario\n";
echo "2. Consultar formulario\n";
echo "3. Actualizar formulario\n";
echo "4. Eliminar formulario\n";
=======
echo "=== Menú Contacto Formulario ===\n";
echo "1. Crear contacto\n";
echo "2. Listar contactos\n";
echo "3. Obtener contacto por ID\n";
echo "4. Actualizar contacto\n";
echo "5. Eliminar contacto\n";
>>>>>>> 44d1488224d3af43aebe81c7d7cee23efa224279

$opcion = readline("Seleccione una opción: ");

switch ($opcion) {
    case 1:
        $nombre   = readline("Nombre: ");
<<<<<<< HEAD
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
=======
        $correo   = readline("Correo: ");
        $telefono = readline("Teléfono: ");
        $mensaje  = readline("Mensaje: ");

        $datos = [
            "nombre"   => $nombre,
            "correo"   => $correo,
            "telefono" => $telefono,
            "mensaje"  => $mensaje,
            "terminos" => true
        ];

        $resultado = crearContacto($datos);
        echo $resultado;
        break;

    case 2:
        $resultado = listarContactos();
        echo $resultado;
        break;

    case 3:
        $id = readline("ID del contacto: ");
        $resultado = obtenerContacto($id);
        echo $resultado;
        break;

    case 4:
        $id     = readline("ID del contacto a actualizar: ");
        $notas  = readline("Notas: ");
        $estado = readline("Nuevo estado (ej. pendiente, atendido): ");

        $datos = [
            "notas"  => $notas,
            "estado" => $estado
        ];

        $resultado = actualizarContacto($id, $datos);
        echo $resultado;
        break;

    case 5:
        $id = readline("ID del contacto a eliminar: ");
        $resultado = eliminarContacto($id);
        echo $resultado;
>>>>>>> 44d1488224d3af43aebe81c7d7cee23efa224279
        break;

    default:
        echo "Opción no válida\n";
}
?>
