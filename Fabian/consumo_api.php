<?php
$url = "http://localhost:8080/usuarios";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio.");
}

$usuarios = json_decode($consumo, true);

foreach ($usuarios as $usuario) {
    echo "<li>" . $usuario['usu_id'] . " - " . $usuario['usuNombre'] . " - " . $usuario['usuCorreo'] . "<li>" . "\n";
}
?>