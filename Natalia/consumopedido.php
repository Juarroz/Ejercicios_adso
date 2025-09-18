<?php
include 'Config/url.php';

$url =  $URL_PEDIDOS;

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
        die("Error al consumir el servicio web.");
}

$pedidos = json_decode($consumo);

$nombreUsuario = readline("Ingrese su nombre: ");
$contra = readline("Ingrese la contraseña del administrador: ");

    if ($contra !== "admin123") {
        echo "Contraseña incorrecta.\n";
    exit;
}

$estadoDeseado = readline("Ingrese el ID del estado de los pedidos que desea ver(1 a 5): ");

$encontrado = false;

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
}

//post

$respuesta = readline ("¿Desea agregar un nuevo pedido? (s) para si y (n) para no: ");
 
if ($respuesta === 's') {
    $nuevocodigo = readline("Ingrese el codigo del pedido: ");
    $nuevocomentario = readline("Ingrese el nuevo comentario: ");
    $nuevoestado = readline("Ingrese el estado de su pedido (1:diseño, 2:tallado, 3:engaste, 4:pulido, 5:finalizado): ");
    $nuevapersonalizacion = readline("Ingrese el id de su personalizacion: ");
    $nuevousu = readline("Ingrese el id del usuario relacionado: ");

    $fechaActual = date('Y-m-d\TH:i:s');

    $datos = array(
        'pedCodigo' => $nuevocodigo,
        'pedComentarios' => $nuevocomentario,
        'pedFechaCreacion' => $fechaActual,
        'estId' => $nuevoestado,
        'perId' => $nuevapersonalizacion,
        'usuId' => $nuevousu
    );
    

    $datos_json = json_encode($datos);

    $proceso = curl_init($url);

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $datos_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($proceso, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($datos_json))
    );

    $respuestapet = curl_exec($proceso);

    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if(curl_errno($proceso)) {
        die('Error en la petición: ' . curl_error($proceso));
    }

    curl_close($proceso);

    if($http_code == 200) {
        echo "Pedido agregado exitosamente.\n";
    } else {
        echo "Error al agregar el pedido. Código de respuesta HTTP: " . $http_code . "\n";
    }
}  

//put


?>
