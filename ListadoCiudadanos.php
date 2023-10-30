<?php
require_once "clases/ciudadano.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $ciudadanos = Ciudadano::traerTodos("./archivos/ciudadanos.json");

    echo json_encode($ciudadanos);
}
?>