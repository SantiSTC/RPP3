<?php
require_once "clases/IParte2.php";
require_once "clases/AccesoPDO.php";
require_once "clases/ciudad.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $ciudad_json = isset($_POST["ciudad_json"]) ? $_POST["ciudad_json"] : null;
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"]["name"] : null;

    foreach(Ciudad::traer() as $ciudad){
        if($ciudad->id == json_decode($ciudad_json)->id){
            $viejoPath = $ciudad->pathFoto;
            break;
        }
    }

    $obj = new stdClass();
    $obj->exito =  false;
    $obj->mensaje = "Error al modificar la ciudad.";

    if (isset($viejoPath)) {
        $nuevoPath = json_decode($ciudad_json)->id . ".modificado." . date("His") . ".jpg";

        $ciudad = new Ciudad(json_decode($ciudad_json)->id, json_decode($ciudad_json)->nombre, json_decode($ciudad_json)->poblacion, json_decode($ciudad_json)->pais, $nuevoPath);

        $resultado = $ciudad->modificar();

        if($resultado){
            if(rename("./ciudades/fotos/" . $viejoPath, "./ciudades/modificadas/" . $nuevoPath)){
                $obj->exito =  true;
                $obj->mensaje = "Ciudad modificada con exito.";
            }
        }      
    } else {
        $obj->exito = false;
        $obj->mensaje = "El ciudad no se encuentra en la base de datos";
    }

    $resultado = $ciudad->modificar();

    echo json_encode($obj);
}
?>