<?php

$clave = "admin321";
$claveIngreso = readline("Ingresa tu contraseña: \n");

// 1. Se valida la contraseña
if ($clave == $claveIngreso) {
    echo "Su clave de ingreso es correcta.\n\n";
    echo "Seleccione la opción que desea:\n";
    echo "1. Ver lista de roles\n";
    echo "2. Agregar un rol nuevo\n";
    $opcion = readline("Digite su opción (1 o 2): ");

    // --- Opción 1: Listar Roles ---
    if ($opcion == "1") {
        $url = "http://localhost:8080/roles";
        $consumo = file_get_contents($url);

        if ($consumo === false) {
            die("Error: no se puede consumir el servicio.");
        }

        $roles = json_decode($consumo);

        if ($roles === null) {
            die("Error: no se pudo decodificar la respuesta JSON.");
        }

        if (empty($roles)) {
            die("No se encontraron roles.");
        }

        echo "\n--- Lista de Roles ---\n";
        foreach ($roles as $role) {
            echo $role->rolNombre . "\n";
        }

    } elseif ($opcion == "2") {
        
        $url = "http://localhost:8080/roles";
        $nuevoRol = readline("Ingrese el nombre del nuevo rol: ");

        $datos = array(
            'rolNombre' => $nuevoRol,
        );
        
        $data_json = json_encode($datos);
        
        $proceso = curl_init($url);
        
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_json)
        ));

        $respuestaServidor = curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);
        
        if (curl_errno($proceso)){
            die("Error en la petición Post: " . curl_error($proceso) . "\n");
        }
        curl_close($proceso);

        if ($http_code == 201 || $http_code == 200){
            echo "Rol guardado correctamente (Respuesta: $http_code).\n";
            
            echo "Datos guardados: " . $respuestaServidor . "\n";
        } else {
            echo "Error en el servidor (Respuesta: $http_code).\n";
            echo "Mensaje del servidor: " . $respuestaServidor . "\n";
        }
    
    } else {
        echo "Opción no válida.\n";
    }

} else {
    die("Clave incorrecta. Acceso denegado.");
}

?>