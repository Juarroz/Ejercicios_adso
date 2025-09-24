<?php

class PedidoService{
    private $apiUrl = "http://localhost:8080/api/pedidos";

//gets
    public function listarPedidos() {
    $respuesta = @file_get_contents($this->apiUrl);
        if ($respuesta === FALSE) return false;

        return json_decode($respuesta, true);
    }


    public function obtenerPedido($id) {
    $respuesta = @file_get_contents($this->apiUrl . "/" . $id);
        if ($respuesta === FALSE) return false;

        return json_decode($respuesta, true);
    }

//post
    public function crearPedido($datos) {
    $data_json = json_encode($datos);

    $proceso = curl_init($this->apiUrl);
    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($proceso, CURLOPT_HTTPHEADER,[
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_json)
    ]);

    $respuesta = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if (curl_errno($proceso)) {
        $error = curl_error($proceso);
        curl_close($proceso);
        return ["success" => false, "error" => $error];
    }

    curl_close($proceso);

    if ($http_code >= 200 && $http_code < 300) {
        return ["success" => true, "data" => json_decode($respuesta, true)];
    } else {
        return ["success" => false, "error" => "HTTP $http_code", "data" => $respuesta];
    }
}

// put
    public function actualizarPedido($id, $datos) {
    $datos_json = json_encode($datos);
    $proceso = curl_init($this->apiUrl . "/" . $id);

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $datos_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($proceso, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($datos_json))
    );

    $respuesta = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

        if (curl_errno($proceso)) {
            $error = curl_error($proceso);
            curl_close($proceso);
            return ["success" => false, "error" => $error];
        }

    curl_close($proceso);

    return $http_code >= 200 && $http_code < 300;
    }


public function eliminarPedido($id) {
    $proceso = curl_init($this->apiUrl . "/" . $id);

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);

    $respuesta = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if (curl_errno($proceso)) {
        $error = curl_error($proceso);
        curl_close($proceso);
        return ["success" => false, "error" => $error];
    }

    curl_close($proceso);

    return $http_code >= 200 && $http_code < 300;
}   
}