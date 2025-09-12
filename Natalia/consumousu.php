<?php

$url = "http://localhost:8080/usuarios";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
<<<<<<< HEAD
    die("Error al consumir el servicio.");
=======
    die("Error al consumir el servicio web.");
>>>>>>> d1b3710bafd7a2a737abd808290c737b5787858c
}

$usuarios = json_decode($consumo);

<<<<<<< HEAD
//Tiene que ingresar un correo y contraseña que esten registrados en la bd
=======
//Tiene que ingresar un correo y contraseña que esten registrados
>>>>>>> d1b3710bafd7a2a737abd808290c737b5787858c
    $correoIngresado = readline("Ingrese su correo: ");
    $passwordIngresado = readline("Ingrese su contraseña: ");


    $autenticado = false;

foreach ($usuarios as $usuario) {
    if ($usuario->usuCorreo === $correoIngresado && $usuario->usuPassword === $passwordIngresado) {
        $autenticado = true;
<<<<<<< HEAD
        echo "Bienvenid@, " . $usuario->usuNombre . "\n";
=======
        echo "Bienvenido, " . $usuario->usuNombre . "\n";
>>>>>>> d1b3710bafd7a2a737abd808290c737b5787858c
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
<<<<<<< HEAD
    echo "Correo o contraseña incorrectos.\n";
=======
    echo "Correo o contraseña incorrectos. Acceso denegado.\n";
>>>>>>> d1b3710bafd7a2a737abd808290c737b5787858c
}

?>
