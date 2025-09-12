<?php

$url = "http://localhost:8080/pedidos";

$consumo = file_get_contents($url);

    if ($consumo === FALSE) {
<<<<<<< HEAD
        die("Error al consumir el servicio.");
}

$pedidos = json_decode($consumo);
//El administrador tiene que ingresar su nombre y la contraseña "admin123" para ver los pedidos de algun estado
    $nombreUsuario = readline("Ingrese su nombre: ");
    $contra = readline("Ingrese la contraseña del administrador: ");
=======
        die("Error al consumir el servicio web.");
}

$pedidos = json_decode($consumo);

$nombreUsuario = readline("Ingrese su nombre: ");
$contra = readline("Ingrese la contraseña del administrador: ");
>>>>>>> d1b3710bafd7a2a737abd808290c737b5787858c

    if ($contra !== "admin123") {
        echo "Contraseña incorrecta.\n";
    exit;
}

$estadoDeseado = readline("Ingrese el ID del estado de los pedidos que desea ver(1 a 5): ");

$encontrado = false;

<<<<<<< HEAD
    foreach ($pedidos as $pedido) {
        if ($pedido->estId == $estadoDeseado) {
        $encontrado = true;
            echo "ID: " . $pedido->ped_id . "\n";
            echo "Código: " . $pedido->pedCodigo . "\n";
            echo "Fecha: " . $pedido->pedFechaCreacion . "\n";
            echo "Comentarios: " . $pedido->pedComentarios . "\n";
            echo "Estado: " . $pedido->estId . "\n";
            echo "Personalización: " . $pedido->perId . "\n";
            echo "Usuario: " . $pedido->usuId . "\n";
            echo "-------------------------\n";
    }
}

    if (!$encontrado) {
        echo "No se encontraron pedidos con el estado ingresado.\n";
=======
foreach ($pedidos as $pedido) {
    if ($pedido->estId == $estadoDeseado) {
        $encontrado = true;
        echo "ID: " . $pedido->ped_id . "\n";
        echo "Código: " . $pedido->pedCodigo . "\n";
        echo "Fecha: " . $pedido->pedFechaCreacion . "\n";
        echo "Comentarios: " . $pedido->pedComentarios . "\n";
        echo "Estado: " . $pedido->estId . "\n";
        echo "Personalización: " . $pedido->perId . "\n";
        echo "Usuario: " . $pedido->usuId . "\n";
        echo "-------------------------\n";
    }
}

if (!$encontrado) {
    echo "No se encontraron pedidos con el estado ingresado.\n";
>>>>>>> d1b3710bafd7a2a737abd808290c737b5787858c
}
