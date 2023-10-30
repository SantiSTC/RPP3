<?php
require_once "clases/IParte1.php";
require_once "clases/AccesoPDO.php";
require_once "clases/ciudad.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;
    $poblacion = isset($_POST["poblacion"]) ? $_POST["poblacion"] : null;
    $pais = isset($_POST["pais"]) ? $_POST["pais"] : null;
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : null;

    $ciudad = new Ciudad(0, $nombre, $poblacion, $pais);

    $retorno = $ciudad->existe(Ciudad::traer());

    $obj = new stdClass();
    $obj->exito = false;
    $obj->mensaje = "Error al agregar.";

    if($retorno){
        $obj->exito = true;
        $obj->mensaje = "La ciudad ya existe en la base de datos.";
    } else {
        if($foto){
            $nombreFoto = $nombre . "." . $pais . "." . date("His") . ".jpg";
            $pathFoto = "./ciudades/fotos/" . $nombreFoto;
            move_uploaded_file($foto["tmp_name"], $pathFoto);
            $ciudad->pathFoto = $nombreFoto;
        }

        $ciudad->agregar();

        $obj->exito = true;
        $obj->mensaje = "Ciudad agregada con exito.";
    }

    echo json_encode($obj);
}

?>