<?php

class ContactoService {
    private $apiUrl = "http://localhost:8080/api/contactos";

   
    public function crearContacto($datos) {
        $data_json = json_encode($datos);

        $proceso = curl_init($this->apiUrl);
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, [
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

   
    public function listarContactos() {
        $respuesta = @file_get_contents($this->apiUrl);
        if ($respuesta === FALSE) return false;

        return json_decode($respuesta, true);
    }

    
    public function obtenerContacto($id) {
        $respuesta = @file_get_contents($this->apiUrl . "/" . $id);
        if ($respuesta === FALSE) return false;

        return json_decode($respuesta, true);
    }

    
    public function actualizarContacto($id, $datos) {
        $data_json = json_encode($datos);
        $proceso = curl_init($this->apiUrl . "/" . $id);

        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, [
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

        return $http_code >= 200 && $http_code < 300;
    }

    
    public function eliminarContacto($id) {
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
