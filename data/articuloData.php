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
            $articulo->getNombre()     . "','" .
            $articulo->getCategoriaId() . "','" .
            $articulo->getSubCategoriaId() . "','" .
            $articulo->getMarca() . "','" .
            $articulo->getModelo() . "'," .
            $articulo->getSerie() . "'," .
            $articulo->getActivo() . ");";


        $result = mysqli_query($conn, $queryInsert); 
        mysqli_close($conn);
        return $result;
    }
}

?>