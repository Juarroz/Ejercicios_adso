<?php

$url = "http://localhost:8080/usuarios";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio.");
}

$usuarios = json_decode($consumo);

//Tiene que ingresar un correo y contraseña que esten registrados en la bd
    $correoIngresado = readline("Ingrese su correo: ");
    $passwordIngresado = readline("Ingrese su contraseña: ");


    $autenticado = false;

foreach ($usuarios as $usuario) {
    if ($usuario->usuCorreo === $correoIngresado && $usuario->usuPassword === $passwordIngresado) {
        $autenticado = true;
        echo "Bienvenid@, " . $usuario->usuNombre . "\n";
        echo "-------------------------\n";

        
        foreach ($usuarios as $u) {
            if ($u->tipoDeDocumento->tipdocNombre === "Cédula de ciudadanía") {
                echo "ID: " . $u->usu_id . "\n";
                echo "Nombre: " . $u->usuNombre . "\n";
                echo "Correo: " . $u->usuCorreo . "\n";
                echo "Rol: " . $u->rol->rolNombre . "\n";
                echo "Documento: " . $u->tipoDeDocumento->tipdocNombre . "\n";
                echo "-------------------------\n";
            }
        }

    }
}

if (!$autenticado) {
    echo "Correo o contraseña incorrectos.\n";
}

?>
