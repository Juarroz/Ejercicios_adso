<?php

require_once 'Config/url.php';

$claveSecreta = "admin123";
$claveIngresada = readline("Por favor, ingrese la clave para continuar: ");

if ($claveIngresada == $claveSecreta) {

    echo "Clave correcta. Acceso concedido.\n\n";

    echo "Seleccione la opción que desea ejecutar:\n";
    echo "1. Listar Usuarios\n";
    echo "2. Agregar Nuevo Usuario\n";
    echo "3. Actualizar Usuario Existente\n";
    echo "4. Eliminar Usuario\n";
    echo "5. Listar Roles\n";
    echo "6. Listar Tipos de Documento\n";
    $opcion = readline("Digite su opción: ");

    if ($opcion == "1") {
        $consumo = file_get_contents($URL_USUARIOS);

        if ($consumo === FALSE) { die("Error al consumir el servicio de usuarios."); }
        $usuarios = json_decode($consumo);
        if ($usuarios === null) { die("Error al decodificar la respuesta JSON de usuarios."); }
        if (empty($usuarios)) { die("No se encontraron usuarios."); }

        echo "\n--- Lista de Usuarios Actuales --- \n";
        foreach ($usuarios as $usuario) {
            echo "ID: " . $usuario->usu_id . " - Nombre: " . $usuario->usuNombre . " (Rol: " . $usuario->rol->rolNombre . ")\n";
        }
    
    } elseif ($opcion == "2") {
        echo "\n--- Creación de Nuevo Usuario ---\n";
        $nombre = readline("Ingrese Nombre Completo: ");
        $correo = readline("Ingrese Correo Electrónico: ");
        $password = readline("Ingrese Contraseña: ");
        $rolId = readline("Ingrese el ID del Rol: ");
        $tipoDocId = readline("Ingrese el ID del Tipo de Documento: ");

        $datos = array(
            'usuNombre' => $nombre,
            'usuCorreo' => $correo,
            'usuPassword' => $password,
            'usuOrigen' => 'registro',
            'usuActivo' => true,
            'rol' => array('rolId' => (int)$rolId),
            'tipoDeDocumento' => array('tipdocId' => (int)$tipoDocId)
        );

        $data_json = json_encode($datos);
        $proceso = curl_init($URL_USUARIOS);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json)));
        $respuestaServidor = curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);
        curl_close($proceso);

        if ($http_code == 201 || $http_code == 200) {
            echo "Usuario guardado correctamente (Respuesta: $http_code).\n";
        } else {
            echo "Error en el servidor (Respuesta: $http_code).\n";
            echo "Mensaje del servidor: " . $respuestaServidor . "\n";
        }

    } elseif ($opcion == "3") {
        $usuarioId = readline("Ingrese el ID del usuario que desea actualizar: ");

        echo "\n--- Ingrese los Nuevos Datos para el Usuario ID: $usuarioId ---\n";
        $nombre = readline("Ingrese Nuevo Nombre Completo: ");
        $correo = readline("Ingrese Nuevo Correo Electrónico: ");
        $password = readline("Ingrese Nueva Contraseña (dejar en blanco para no cambiar): ");
        $rolId = readline("Ingrese el Nuevo ID del Rol: ");
        $tipoDocId = readline("Ingrese el Nuevo ID del Tipo de Documento: ");

        $datos = array(
            'usuNombre' => $nombre,
            'usuCorreo' => $correo,
            'usuOrigen' => 'registro',
            'usuActivo' => true,
            'rol' => array('rolId' => (int)$rolId),
            'tipoDeDocumento' => array('tipdocId' => (int)$tipoDocId)
        );
        if (!empty($password)) {
            $datos['usuPassword'] = $password;
        }

        $data_json = json_encode($datos);
        $url = $URL_USUARIOS . '/' . $usuarioId; 
        $proceso = curl_init($url);

        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json)));
        curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);
        curl_close($proceso);

        if ($http_code == 200) {
            echo "Usuario actualizado correctamente (Respuesta: $http_code).\n";
        } else {
            echo "Error al actualizar. Verifique el ID (Respuesta: $http_code).\n";
        }

    } elseif ($opcion == "4") {
        $usuarioId = readline("Ingrese el ID del usuario que desea eliminar: ");
        $url = $URL_USUARIOS . '/' . $usuarioId;  

        $proceso = curl_init($url);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);
        curl_close($proceso);

        if ($http_code == 204 || $http_code == 200) {
            echo "Usuario eliminado correctamente (Respuesta: $http_code).\n";
        } else {
            echo "Error al eliminar. Verifique el ID (Respuesta: $http_code).\n";
        }

    } elseif ($opcion == "5") {
        $consumo = file_get_contents($URL_ROLES);

        if ($consumo === false) { die("Error: no se puede consumir el servicio de roles"); }
        $roles = json_decode($consumo);
        if ($roles === null) { die("Error: no se pudo decodificar la respuesta JSON de roles"); }
        if (empty($roles)) { die("No se encontraron roles."); }

        echo "\n--- Lista de Roles ---\n";
        foreach ($roles as $role) {
            echo "ID: " . $role->rol_id . " - Nombre: " . $role->rolNombre . "\n";
        }

    } elseif ($opcion == "6") {
        $consumo = file_get_contents($URL_TIPO_DOCUMENTO);

        if ($consumo === FALSE) { die("Error al consumir el servicio de tipos de documento."); }
        $tiposDocumento = json_decode($consumo);
        if ($tiposDocumento === null) { die("Error al decodificar la respuesta JSON de tipos de documento."); }
        if (empty($tiposDocumento)) { die("No se encontraron tipos de documento."); }

        echo "\n--- Lista de Tipos de Documento --- \n";
        foreach ($tiposDocumento as $tipo) {
            echo "ID: " . $tipo->tipdocId . " - Nombre: " . $tipo->tipdocNombre . "\n";
        }

    } else {
        echo "Opción no válida.\n";
    }

} else {
    die("Clave incorrecta. Acceso denegado.");
}

?>