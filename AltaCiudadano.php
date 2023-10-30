<?php
require_once "clases/ciudadano.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $ciudad = isset($_POST["ciudad"]) ? $_POST["ciudad"] : null;
    $email = isset($_POST["email"]) ? $_POST["email"] : null;
    $clave = isset($_POST["clave"]) ? $_POST["clave"] : null;

    $ciudadano = new Ciudadano($email, $clave, $ciudad);

    $resultado = $ciudadano->guardarEnArchivo("./archivos/ciudadanos.json");

    echo json_decode($resultado)->mensaje;
}

?>