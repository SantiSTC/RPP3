<?php
require_once "clases/IParte1.php";
require_once "clases/AccesoPDO.php";

class Ciudad implements IParte1, IParte2{
    public int $id;
    public string $nombre;
    public int $poblacion;
    public string $pais;
    public string $pathFoto;

    public function __construct(int $id = 0, string $nombre = "", int $poblacion = 0,  string $pais = "",  string $pathFoto = ""){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->poblacion = $poblacion;
        $this->pais = $pais;
        $this->pathFoto = $pathFoto;
    }

    public function toJSON(){
        $obj = new stdClass();

        $obj->id = $this->id;
        $obj->nombre = $this->nombre;
        $obj->poblacion = $this->poblacion;
        $obj->pais = $this->pais;
        $obj->pathFoto = $this->pathFoto;

        return json_encode($obj);
    }

    public function agregar(){
        try{
            $conexion = AccesoPDO::retornarUnObjetoAcceso();

            $sql = $conexion->retornarConsulta("INSERT INTO `ciudades`(`nombre`, `poblacion`, `pais`, `path_foto`) VALUES (:nombre,:poblacion,:pais,:pathFoto)");
            $sql->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $sql->bindParam(':poblacion', $this->poblacion, PDO::PARAM_INT);
            $sql->bindParam(':pais', $this->pais, PDO::PARAM_STR);
            $sql->bindParam(':pathFoto', $this->pathFoto, PDO::PARAM_STR);

            $resultado = $sql->execute();
        } catch (PDOException $e){
            echo "Error al agregar a la base de datos: " . $e->getMessage();
            $resultado = false;
        }

        return $resultado;
    }

    public static function traer(){
        $ciudades = array();

        try{
            $conexion = AccesoPDO::retornarUnObjetoAcceso();

            $sql = $conexion->retornarConsulta("SELECT * FROM `ciudades`");

            if($sql != false){
                $sql->execute();
                $contenido = $sql->fetchAll();

                foreach($contenido as $linea){
                    if($linea["path_foto"] != null){
                        $ciudad = new Ciudad($linea["id"], $linea["nombre"], $linea["poblacion"], $linea["pais"], $linea["path_foto"]);
                    } else {
                        $ciudad = new Ciudad($linea["id"], $linea["nombre"], $linea["poblacion"], $linea["pais"]);
                    }

                    $ciudades[] = $ciudad;
                }
            }
        } catch (PDOException $e){
            echo "Error al traer de la base de datos: " . $e->getMessage();
            $resultado = false;
        }

        return $ciudades;
    }

    public function existe($ciudades){
        $resultado = false;

        foreach($ciudades as $ciudad){
            if($ciudad->nombre == $this->nombre && $ciudad->pais == $this->pais){
                $resultado = true;
                break;
            }
        }

        return $resultado;
    }

    public function modificar(){
        try{
            $conexion = AccesoPDO::retornarUnObjetoAcceso();

            $sql = $conexion->retornarConsulta("UPDATE `ciudades` SET `nombre`=:nombre,`poblacion`=:poblacion,`pais`=:pais,`path_foto`=:pathFoto WHERE `id`=:id");
            $sql->bindParam(':id', $this->id, PDO::PARAM_INT);
            $sql->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $sql->bindParam(':poblacion', $this->poblacion, PDO::PARAM_INT);
            $sql->bindParam(':pais', $this->pais, PDO::PARAM_STR);
            $sql->bindParam(':pathFoto', $this->pathFoto, PDO::PARAM_STR);

            $resultado = $sql->execute();
        } catch(PDOException $e){
            echo "Error al modificar: " . $e->getMessage();
            $resultado = false;
        }

        return $resultado;
    }

    public function eliminar(){
        try{
            $conexion = AccesoPDO::retornarUnObjetoAcceso();

            $sql = $conexion->retornarConsulta("DELETE FROM `ciudades` WHERE `id`=:id");
            $sql->bindParam(':id', $this->id, PDO::PARAM_INT);

            $resultado = $sql->execute();
        } catch(PDOException $e){
            $resultado = false;
        }

        return $resultado;
    }

    public static function guardarEnArchivo(Ciudad $ciudad){

    }

}
?>