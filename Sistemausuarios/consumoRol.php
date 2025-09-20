<?php

require_once 'config/urls.php';

$clave = "admin321";
$claveIngreso = readline("Ingresa tu contraseña: \n");

if ($clave == $claveIngreso) {
    echo "Su clave de ingreso es correcta.\n\n";

    echo "Seleccione la opción que desea:\n";
    echo "1. Ver lista de roles\n";
    echo "2. Agregar un rol nuevo\n";
    echo "3. Actualizar un rol existente\n";
    echo "4. Eliminar un rol\n";
    $opcion = readline("Digite su opción (1, 2, 3 o 4): ");

    if ($opcion == "1") {
        $consumo = file_get_contents($URL_ROLES);

        if ($consumo === false) { die("Error: no se puede consumir el servicio."); }
        $roles = json_decode($consumo);
        if ($roles === null) { die("Error: no se pudo decodificar la respuesta JSON."); }
        if (empty($roles)) { die("No se encontraron roles."); }

        echo "\n--- Lista de Roles ---\n";
        foreach ($roles as $role) {
        echo "ID: " . $role->rol_id . " - Nombre: " . $role->rolNombre . "\n";
        }

    } elseif ($opcion == "2") {
        $nuevoRol = readline("Ingrese el nombre del nuevo rol: ");
        $datos = array('rolNombre' => $nuevoRol);
        $data_json = json_encode($datos);
        
        $proceso = curl_init($URL_ROLES);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json)));

        $respuestaServidor = curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);
        curl_close($proceso);

        if ($http_code == 201 || $http_code == 200) {
            echo "Rol guardado correctamente (Respuesta: $http_code).\n";
        } else {
            echo "Error en el servidor (Respuesta: $http_code).\n";
        }

    } elseif ($opcion == "3") {
        $rolId = readline("Ingrese el ID del rol que desea actualizar: ");
        $nuevoNombre = readline("Ingrese el nuevo nombre para el rol: ");

        $url = $URL_ROLES . '/' . $rolId;  
        $datos = array('rolNombre' => $nuevoNombre);
        $data_json = json_encode($datos);

        $proceso = curl_init($url);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json)));

        curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);
        curl_close($proceso);

        if ($http_code == 200) {
            echo "Rol actualizado correctamente (Respuesta: $http_code).\n";
        } else {
            echo "Error al actualizar. Verifique el ID (Respuesta: $http_code).\n";
        }

    } elseif ($opcion == "4") {
        $rolId = readline("Ingrese el ID del rol que desea eliminar: ");
        $url = $URL_ROLES . '/' . $rolId;  

        $proceso = curl_init($url);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);

        curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);
        curl_close($proceso);

        if ($http_code == 204 || $http_code == 200) {
            echo "Rol eliminado correctamente (Respuesta: $http_code).\n";
        } else {
            echo "Error al eliminar. Verifique el ID (Respuesta: $http_code).\n";
        }

    } else {
        echo "Opción no válida.\n";
    }

} else {
    die("Clave incorrecta. Acceso denegado.");
}

?>