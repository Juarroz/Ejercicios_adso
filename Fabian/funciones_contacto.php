<?php
include 'urls.php';

// Crear formulario
function crearFormulario($datos) {
    global $URL_CONTACTO;

    $data_json = json_encode($datos);
    $proceso = curl_init($URL_CONTACTO);

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
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

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
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
    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);

    $respuesta = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);
    curl_close($proceso);

    return array("codigo" => $http_code, "respuesta" => $respuesta);
}
?>
