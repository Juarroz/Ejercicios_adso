<?php

$claveSecreta = "admin123";
$claveIngresada = readline("Por favor, ingrese la clave para continuar: ");

if ($claveIngresada == $claveSecreta) {

    echo "Clave correcta. Acceso concedido.\n\n";
//menu
    echo "Seleccione la información que desea consultar:\n";
    echo "1. Lista de Usuarios\n";
    echo "2. Lista de Roles\n";
    echo "3. Lista de Tipos de Documento\n";
    $opcion = readline("Digite su opcion (1, 2 o 3): ");

//opcion1
    if ($opcion === "1") {

        $url = "http://localhost:8080/usuarios";
        $consumo = file_get_contents($url);

        if ($consumo === FALSE){
            die(" al consumir el servicio de usuarios.");
        }

        $usuarios = json_decode($consumo);

        if ($usuarios === null){
            die("al decodificar la respuesta JSON de usuarios.");
        }

        if (empty($usuarios)){
            die("No se encontraron usuarios.");
        }

        echo "\n Lista de Usuarios  \n";
        foreach ($usuarios as $usuario){
            echo $usuario->usuNombre . "\n";
        }

//opcion2
    } elseif ($opcion == "2") {

        $url = "http://localhost:8080/roles";

        $consumo = file_get_contents($url);

        if ($consumo === false){
            die("no se puede consumir el servicio de roles");
        }

        $roles = json_decode($consumo);

        if ($roles === null) {
            die("no se pudo decodificar la respuesta JSON de roles");
        }

        if (empty($roles)){
            die("No se encontraron roles.");
        }

        echo "\n Lista de roles \n";
        foreach ($roles as $role) {
            echo $role->rolNombre . "\n";
        }

//opcion3
    } elseif ($opcion == "3") {

        $url = "http://localhost:8080/tipos-documento";

        $consumo = file_get_contents($url);

        if ($consumo === FALSE){
            die("Error al consumir el servicio");
        }

        $tiposDocumento = json_decode($consumo);

        if ($tiposDocumento === null){
            die("Error al decodificar");
        }
        if (empty($tiposDocumento)){ die("No se encontraron tipos de documento.");
        }

        echo "\n Lista de Tipos de Documento \n";
        foreach ($tiposDocumento as $tipo) {
            echo $tipo->tipdocNombre . "\n";
        }

//contrase_mal
    } else {
        echo "Opción no valida \n";
    }

} else {
    die("Clave incorrecta");
}

?>