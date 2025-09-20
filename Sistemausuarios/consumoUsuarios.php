<?php

$claveSecreta = "admin123";
$claveIngresada = readline("Por favor, ingrese la clave para continuar: ");

if ($claveIngresada == $claveSecreta) {

    echo "Clave correcta. Acceso concedido.\n\n";

     echo "Seleccione la opción que desea ejecutar:\n";
    echo "1. Listar Usuarios\n";
    echo "2. Agregar Nuevo Usuario\n";
    echo "3. Listar Roles\n";
    echo "4. Listar Tipos de Documento\n";
    $opcion = readline("Digite su opción (1, 2, 3 o 4): ");

      if ($opcion == "1") {

        $url = "http://localhost:8080/usuarios";
        $consumo = file_get_contents($url);

        if ($consumo === FALSE){
            die("Error al consumir el servicio de usuarios.");
        }

        $usuarios = json_decode($consumo);

        if ($usuarios === null){
            die("Error al decodificar la respuesta JSON de usuarios.");
        }

        if (empty($usuarios)){
            die("No se encontraron usuarios.");
        }

        echo "\n--- Lista de Usuarios Actuales --- \n";
        foreach ($usuarios as $usuario) {
            echo $usuario->usuNombre . " (Rol: " . $usuario->rol->rolNombre . ")\n";
        }

     } elseif ($opcion == "2") {

        $url = "http://localhost:8080/usuarios";

         echo "\n--- Creación de Nuevo Usuario ---\n";
        $nombre = readline("Ingrese Nombre Completo: ");
        $correo = readline("Ingrese Correo Electrónico: ");
        $password = readline("Ingrese Contraseña: ");
 
         $datos = array(
            'usuNombre' => $nombre,
            'usuCorreo' => $correo,
            'usuPassword' => $password,
             'usuOrigen' => 'registro',
            'usuActivo' => true,
         );

         $data_json = json_encode($datos);
        $proceso = curl_init($url);
        
        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($proceso, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json)));

        $respuestaServidor = curl_exec($proceso);
        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

        if (curl_errno($proceso)) { die("Error en la petición Post: " . curl_error($proceso) . "\n"); }
        curl_close($proceso);

         if ($http_code == 201) {  
            echo "Usuario guardado correctamente (Respuesta: 201).\n";
        } else {
            echo "Error en el servidor (Respuesta: $http_code).\n";
            echo "Mensaje del servidor: " . $respuestaServidor . "\n";
        }

     } elseif ($opcion == "3") {
 
     } elseif ($opcion == "4") {
 
     } else {
        echo "Opción no válida. Por favor, ejecute el script de nuevo.\n";
    }

} else {
    die("Clave incorrecta. Acceso denegado.");
}

?>