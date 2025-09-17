<?php

$url = "http://localhost:8080/opciones-personalizacion";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio web.");
}

$opcionpers = json_decode($consumo);

 foreach ($opcionpers as $opcionper) {
    echo "ID: " . $opcionper->opc_id . "\n";
    echo "Nombre Opción: " . $opcionper->opcNombre . "\n";
    echo "-------------------------\n";
}

?>