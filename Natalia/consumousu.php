<?php

$url = "http://localhost:8081/usuarios";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die ("Error al consumir el servicio.");
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


//metodo POST
$respuesta = readline ("¿Desea agregar un nuevo usuario? (s) para si y (n) para no: ");
 
if ($respuesta === 's') {
    $nuevonombre = readline("Ingrese el nombre del nuevo usuario: ");
    $nuevocorreo = readline("Ingrese el correo del nuevo usuario: ");
    $nuevotelefono = readline("Ingrese el teléfono del nuevo usuario: ");
    $nuevopassword = readline("Ingrese la contraseña del nuevo usuario: ");
    $nuevotipdoc = readline("Ingrese el tipo de documento del nuevo usuario (1: Cédula de ciudadanía, 2: Cédula de extranjería, 3: Pasaportte): ");
    $nuevodoc = readline("Ingrese el número de documento del nuevo usuario: ");
    
    $datos = array(
        'usuNombre' => $nuevonombre,
        'usuCorreo' => $nuevocorreo,
        'usuTelefono' => $nuevotelefono,
        'usuPassword' => $nuevopassword,
        'usuDocnum' => $nuevodoc,
        'tipoDeDocumento' => array(
        'tipdoc_id' => (int) $nuevotipodoc
          ),
        'usuOrigen' => 'LOCAL',
        'usuActivo' => true
    );

    $datos_json = json_encode($datos);

    $proceso = curl_init($url);

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $datos_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($proceso, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($datos_json))
    );

    $respuestapet = curl_exec($proceso);

    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if(curl_errno($proceso)) {
        die('Error en la petición: ' . curl_error($proceso));
    }

    curl_close($proceso);

    if($http_code == 200) {
        echo "Usuario agregado exitosamente.\n";
    } else {
        echo "Error al agregar el usuario. Código de respuesta HTTP: " . $http_code . "\n";
    }
}   

?>