<?php
require_once "clases/IParte1.php";
require_once "clases/AccesoPDO.php";
require_once "clases/ciudad.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $ciudades = Ciudad::traer();

    if(isset($_GET["tabla"]) && $_GET["tabla"] == "mostrar"){
        echo "<h1>Listado de Ciudades</h1>
        <table border='1'>
        <thead>
        <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Poblacion</th>
        <th>Pais</th>
        <th>Foto</th>
        </tr>
        </thead>
        <tbody>";

foreach ($ciudades as $ciudad):
echo "<tr>
        <td>{$ciudad->id}</td>
        <td>{$ciudad->nombre}</td>
        <td>{$ciudad->poblacion}</td>
        <td>{$ciudad->pais}</td>
        <td>{$ciudad->pathFoto}</td>
        </tr>";
endforeach;
echo "</tbody>
        </table>";
    } else {
        echo json_encode($ciudades);
    }

}


?>


