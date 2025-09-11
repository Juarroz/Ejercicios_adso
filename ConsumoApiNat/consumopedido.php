<?php

$url = "http://localhost:8080/pedidos";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio web.");
}

$pedidos = json_decode($consumo);

$contra = readline("Ingrese la contraseña para ver los pedidos: ");

if ($contra === "usuario123") {
    foreach ($pedidos as $pedido) {
        echo "ID: " . $pedido->ped_id . "\n";
        echo "Código: " . $pedido->pedCodigo . "\n";
        echo "Fecha: " . $pedido->pedFechaCreacion . "\n";
        echo "Comentarios: " . $pedido->pedComentarios . "\n";
        echo "Estado: " . $pedido->estId . "\n";
        echo "Personalización: " . $pedido->perId . "\n";
        echo "Usuario: " . $pedido->usuId . "\n";
        echo "-------------------------\n";
    }
} else {
    echo "Acceso denegado. No puede ver los pedidos.\n";
}
?>
