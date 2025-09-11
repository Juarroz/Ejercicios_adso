<?php
$url = "http://localhost:8080/usuarios";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio.");
}

echo $consumo;
?>