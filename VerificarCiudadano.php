<?php
require_once "clases/ciudadano.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"] ? $_POST["email"] : null;
    $clave = $_POST["clave"] ? $_POST["clave"] : null;

    $ciudadano = new Ciudadano($email, $clave);

    $resultado = Ciudadano::verificarExistencia($ciudadano, "./archivos/ciudadanos.json");

    echo json_decode($resultado)->mensaje;
}
?>