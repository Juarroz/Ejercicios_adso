<?php
$url = "http://localhost:8080/tipos-documento";

$consumo = @file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio de tipos de documento.");
}

$tipos = json_decode($consumo, true);

foreach ($tipos as $tipo) {
    echo "<li>" . $tipo['tipdoc_id'] . " - " . $tipo['tipdocNombre'] . "</li>";
}
?>