<?php

$url = "http://localhost:8080/roles";

$consumo = file_get_contents($url);

if($consumo === false){
    die ("Error: no se puede consumir el servicio");
}

$roles = json_decode($consumo);

if ($roles === null){
    die ("Error: no se pudo decodificar la respuesta JSON");
}

echo "--- Lista de roles ---\n";

foreach ($roles as $role){
    echo $role->rolNombre . "\n";
}

?>