<?php

include_once 'data.php';
include '../domain/articulo.php';

class ArticuloData extends Data{

    public function insertarTBArticulo($articulo){

        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $getLastId = "SELECT MAX(tbarticuloid) AS tbarticuloid FROM tbarticulo";
        $idCont = mysqli_query($conn, $getLastId); 
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) { 
            $nextId = trim($row[0]) + 1;            
        }

        $queryInsert = "INSERT INTO tbarticulo VALUES (" . $nextId . ",'" .
            $articulo->getArticuloNombre() . "','" .
            $articulo->getArticuloMarca() . "','" .
            $articulo->getArticuloModelo() . "','" .
            $articulo->getArticuloSerie(). "','" .
            $articulo->getArticuloActivo() . "','" .
            $articulo->getArticuloSubCategoriaId() . "' );";

            
        $result = mysqli_query($conn, $queryInsert); 
        mysqli_close($conn);
        return $result;
    }

    public function updateTBArticulo($articulo){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryUpdate = "UPDATE tbarticulo SET tbarticulonombre='" . $articulo->getArticuloNombre() .       
        "', tbarticulomarca='" . $articulo->getArticuloMarca() . 
        "', tbarticulomodelo='" . $articulo->getArticuloModelo() .
        "', tbarticuloserie='" . $articulo->getArticuloSerie() .
        "', tbarticuloactivo='" . $articulo->getArticuloActivo() .
        "', tbsubcategoriaid=" . $articulo->getArticuloSubCategoriaId() .
        " WHERE tbarticuloid=" . $articulo->getArticuloId() . ";";

        $result = mysqli_query($conn, $queryUpdate); 
        mysqli_close($conn); 
        return $result;  
    }

    public function deleteTBArticulo($articulo) {// este metodo actualiza el estado del cliente para no perder el registro del mismo solo de desactiva.
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');
        
        $queryUpdate = "UPDATE tbarticulo SET tbarticulonombre='" . $articulo->getArticuloNombre() .       
        "', tbarticulomarca='" . $articulo->getArticuloMarca() . 
        "', tbarticulomodelo='" . $articulo->getArticuloModelo() .
        "', tbarticuloserie='" . $articulo->getArticuloSerie() .
        "', tbarticuloactivo='" . $articulo->getArticuloActivo() .
        "', tbsubcategoriaid=" . $articulo->getArticuloSubCategoriaId() .
        " WHERE tbarticuloid=" . $articulo->getArticuloId() . ";";

        
        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);
        return $result;
    }

    public function getAllTBArticulo(){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbarticulo WHERE tbarticuloactivo = 1;";
        $result = mysqli_query($conn, $querySelect);

        $array = array();

        while ($row = mysqli_fetch_array($result)) {
            $currentArticulo = new Articulo($row['tbarticuloid'],$row['tbarticulonombre'],$row['tbarticulomarca'],$row['tbarticulomodelo']
            ,$row['tbarticuloserie'], $row['tbarticuloactivo'],$row['tbsubcategoriaid']);
            array_push($array,$currentArticulo);
        }

        mysqli_close($conn);
        return $array;
    }

    public function buscarNombres($nombre){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $nombreSeguro = mysqli_real_escape_string($conn, $nombre);
        $consulta = "SELECT tbarticulonombre FROM tbarticulo WHERE tbarticulonombre LIKE '%$nombreSeguro%' AND tbarticuloactivo = 1 LIMIT 10;";
        $resultados = $conn->query($consulta);

        $nombres = array();
        while ($fila = mysqli_fetch_array($resultados)) {
            $nombres[] = $fila['tbarticulonombre'];
        }

        mysqli_close($conn);
        return $nombres;
    }

    public function getAllTBArticuloSubastadp(){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbarticulo WHERE tbarticuloactivo = 1;";
        $result = mysqli_query($conn, $querySelect);

        $array = array();

        while ($row = mysqli_fetch_array($result)) {
            $currentArticulo = new Articulo($row['tbarticuloid'],$row['tbarticulonombre'],$row['tbarticulomarca'],$row['tbarticulomodelo']
            ,$row['tbarticuloserie'], $row['tbarticuloactivo'],$row['tbsubcategoriaid']);
            array_push($array,$currentArticulo);
        }

        mysqli_close($conn);
        return $array;
    }

    public function getArticulosBySubcategoriaId($subcategoriaId){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');
    
        $querySelect = "SELECT * FROM tbarticulo WHERE tbsubcategoriaid='$subcategoriaId' && tbarticuloactivo = 1;";
    
        $result = mysqli_query($conn, $querySelect);
    
        $array = array();
    
        while ($row = mysqli_fetch_array($result)) {
            $currentArticulo = new Articulo($row['tbarticuloid'],$row['tbarticulonombre'],$row['tbarticulomarca'],$row['tbarticulomodelo']
            ,$row['tbarticuloserie'], $row['tbarticuloactivo'],$row['tbsubcategoriaid']);
            array_push($array, $currentArticulo);
        }
        mysqli_close($conn);
        return $array;
    }

}

?>