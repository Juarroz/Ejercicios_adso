<?php
include 'urls.php';

<<<<<<< HEAD
// Crear formulario
function crearFormulario($datos) {
    global $URL_CONTACTO;

    $data_json = json_encode($datos);
    $proceso = curl_init($URL_CONTACTO);
=======
function crearContacto($datos) {
    global $URL_CONTACTOS;

    $data_json = json_encode($datos);
    $proceso = curl_init($URL_CONTACTOS);
>>>>>>> 44d1488224d3af43aebe81c7d7cee23efa224279

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
<<<<<<< HEAD
    curl_setopt($proceso, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_json))
    );

    $respuesta = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);
    curl_close($proceso);

    return array("codigo" => $http_code, "respuesta" => $respuesta);
}

// Consultar formulario
function obtenerFormulario($id) {
    global $URL_CONTACTO_ID;
    return file_get_contents($URL_CONTACTO_ID . $id);
}

// Actualizar formulario
function actualizarFormulario($id, $datos) {
    global $URL_CONTACTO_ID;

    $data_json = json_encode($datos);
    $proceso = curl_init($URL_CONTACTO_ID . $id);
=======
    curl_setopt($proceso, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_json)
    ]);

    $respuesta = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if (curl_errno($proceso)) {
        die("Error en la petición POST: " . curl_error($proceso) . "\n");
    }
    
    curl_close($proceso);

    if ($http_code >= 200 && $http_code < 300) {
        return "Operación exitosa, código de respuesta: $http_code\n$respuesta\n";
    } else {
        return "Operación fallida, código de respuesta: $http_code\n$respuesta\n";
    }
}


function listarContactos($query = "") {
    global $URL_CONTACTOS;

    $proceso = curl_init($URL_CONTACTOS . $query);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);

    $respuesta = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if (curl_errno($proceso)) {
        die("Error en la petición GET: " . curl_error($proceso) . "\n");
    }
    
    curl_close($proceso);

    if ($http_code >= 200 && $http_code < 300) {
        return "Operación exitosa, código de respuesta: $http_code\n$respuesta\n";
    } else {
        return "Operación fallida, código de respuesta: $http_code\n$respuesta\n";
    }
}


function obtenerContacto($id) {
    global $URL_CONTACTOS;

    $proceso = curl_init($URL_CONTACTOS . "/" . $id);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);

    $respuesta = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if (curl_errno($proceso)) {
        die("Error en la petición GET: " . curl_error($proceso) . "\n");
    }

    curl_close($proceso);

    if ($http_code >= 200 && $http_code < 300) {
        return "Operación exitosa, código de respuesta: $http_code\n$respuesta\n";
    } else {
        return "Operación fallida, código de respuesta: $http_code\n$respuesta\n";
    }
}


function actualizarContacto($id, $datos) {
    global $URL_CONTACTOS;

    $data_json = json_encode($datos);
    $proceso = curl_init($URL_CONTACTOS . "/" . $id);
>>>>>>> 44d1488224d3af43aebe81c7d7cee23efa224279

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
<<<<<<< HEAD
    curl_setopt($proceso, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_json))
    );

    $respuesta = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);
    curl_close($proceso);

    return array("codigo" => $http_code, "respuesta" => $respuesta);
}

// Eliminar formulario
function eliminarFormulario($id) {
    global $URL_CONTACTO_ID;

    $proceso = curl_init($URL_CONTACTO_ID . $id);
=======
    curl_setopt($proceso, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_json)
    ]);

    $respuesta = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if (curl_errno($proceso)) {
        die("Error en la petición PUT: " . curl_error($proceso) . "\n");
    }

    curl_close($proceso);

    if ($http_code >= 200 && $http_code < 300) {
        return "Operación exitosa, código de respuesta: $http_code\n$respuesta\n";
    } else {
        return "Operación fallida, código de respuesta: $http_code\n$respuesta\n";
    }
}


function eliminarContacto($id) {
    global $URL_CONTACTOS;

    $proceso = curl_init($URL_CONTACTOS . "/" . $id);
>>>>>>> 44d1488224d3af43aebe81c7d7cee23efa224279
    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);

    $respuesta = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);
<<<<<<< HEAD
    curl_close($proceso);

    return array("codigo" => $http_code, "respuesta" => $respuesta);
=======

    if (curl_errno($proceso)) {
        die("Error en la petición DELETE: " . curl_error($proceso) . "\n");
    }


    curl_close($proceso);

    if ($http_code >= 200 && $http_code < 300) {
        return "Operación exitosa, código de respuesta: $http_code\n$respuesta\n";
    } else {
        return "Operación fallida, código de respuesta: $http_code\n$respuesta\n";
    }
>>>>>>> 44d1488224d3af43aebe81c7d7cee23efa224279
}
?>
