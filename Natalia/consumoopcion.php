<?php

$url = "http://localhost:8080/opciones-personalizacion";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio web.");
}

$opcionpers = json_decode($consumo);

 foreach ($opcionpers as $opcionper) {
    echo "ID: " . $opcionper->opc_id . "\n";
    echo "Nombre Opción: " . $opcionper->opcNombre . "\n";
    echo "-------------------------\n";
}

//POST

$respuesta = readline ("¿Desea agregar una nueva opción? (s) para si y (n) para no: ");
 
if ($respuesta === 's') {
    $nuevaopcion = readline("Ingrese el nombre de la nueva opción: ");

    $datos = array(
        'opcNombre' => $nuevaopcion
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
        echo "Opcion agregada exitosamente.\n";
    } else {
        echo "Error al agregar la opcion. Código de respuesta HTTP: " . $http_code . "\n";
    }
}   

?>