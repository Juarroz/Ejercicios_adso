<?php


$correo = readline("Ingrese su correo: ");
$urlUsuarios = "http://localhost:8080/usuarios";
$usuariosJson = @file_get_contents($urlUsuarios);

if ($usuariosJson === FALSE) {
    die("Error al consumir el servicio de usuarios.\n");
}

$usuarios = json_decode($usuariosJson, true);

// Buscar usuario por correo
$usuario = null;
foreach ($usuarios as $u) {
    if ($u['usuCorreo'] == $correo) {
        $usuario = $u;
        break;
    }
}

if (!$usuario) {
    die("Usuario no encontrado.\n");
}

// Validamos rol administrador
if ($usuario['rol']['rolNombre'] != "administrador") {
    die("Acceso denegado. Solo los administradores pueden registrar formularios.\n");
}

echo "Bienvenido administrador {$usuario['usuNombre']}.\n";


$respuesta = readline("¿Desea agregar un nuevo formulario? Coloca s para (SI) n para (NO): ");

if ($respuesta === "s") {
    $nombre   = readline("Ingrese nombre: ");
    $email    = readline("Ingrese email: ");
    $telefono = readline("Ingrese teléfono: ");
    $mensaje  = readline("Ingrese mensaje: ");
    $via      = readline("Ingrese vía (formulario/whatsapp): ");

    // arreglo asociativo
    $datos = array(
        "conNombre"   => $nombre,
        "conEmail"    => $email,
        "conTelefono" => $telefono,
        "conMensaje"  => $mensaje,
        "conVia"      => $via,
        "conTerminos" => true
    );

    // Convertir a JSON
    $data_json = json_encode($datos);

    
    $url = "http://localhost:8080/contacto";

    $proceso = curl_init($url);

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($proceso, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_json))
    );

    $respuestapost = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if (curl_errno($proceso)) {
        die("Error en la petición POST: " . curl_error($proceso) . "\n");
    }

    curl_close($proceso);

    if ($http_code === 200 || $http_code === 201) {
        echo "Formulario guardado correctamente. Respuesta del servidor:\n";
        echo $respuestapost . "\n";
    } else {
        echo "Error en el servidor, código de respuesta: $http_code\n";
        echo $respuestapost . "\n";
    }
} else {
    echo "No se registró ningún formulario.\n";
}
?>
