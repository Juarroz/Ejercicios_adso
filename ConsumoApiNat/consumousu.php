<?php

$url = "http://localhost:8080/usuarios";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio web.");
}

$usuarios = json_decode($consumo);

 foreach ($usuarios as $usuario) {
        if ($usuario->tipoDeDocumento->tipdocNombre === "Cédula de ciudadanía"){
    echo "ID: " . $usuario->usu_id . "\n";
    echo "Nombre: " . $usuario->usuNombre . "\n";
    echo "Correo: " . $usuario->usuCorreo . "\n";
    echo "Rol: " . $usuario->rol->rolNombre . "\n";
    echo "Documento: " . $usuario->tipoDeDocumento->tipdocNombre . "\n";
    echo "-------------------------\n";

    }
}