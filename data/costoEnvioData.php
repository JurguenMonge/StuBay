<?php

include_once 'data.php';
include '../domain/costoEnvio.php';

class CostoEnvioData extends Data{

    public function insertarTBCostoEnvio($costoEnvio){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $getLastId = "SELECT MAX(tbcostoenvioid) FROM tbcostoenvio";
        $idCont = mysqli_query($conn, $getLastId); 
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) { 
            $nextId = trim($row[0]) + 1;            
        }

        $queryInsert = "INSERT INTO tbcostoenvio VALUES (" . $nextId . ",'" .
            $costoEnvio->getCostoPorKM() . "','" .
            $costoEnvio->getTbclienteid() . "'," .
            $costoEnvio->getCostoEnvioEstado() . ");";

        $result = mysqli_query($conn, $queryInsert); 
        mysqli_close($conn);
        echo $costoEnvio->getCostoPorKM();
        echo $costoEnvio->getTbclienteid();
        echo $costoEnvio->getCostoEnvioEstado();
        return $result;
    }

    public function updateTBCostoEnvio($costoEnvio){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryUpdate = "UPDATE tbcostoenvio SET tbcostoenviokm ='" . $costoEnvio->getCostoPorKM() .
        "', tbclienteid='" . $costoEnvio->getTbclienteid() .
        "', tbcostoenvioestado=" . $costoEnvio->getCostoEnvioEstado() .
        " WHERE tbcostoenvioid =" . $costoEnvio->getCostoEnvioId() . ";";

        $result = mysqli_query($conn, $queryUpdate); 
        mysqli_close($conn); 
        return $result;  
    }

    public function deleteTBCostoEnvio($costoEnvio) {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');
        
        $queryUpdate = "UPDATE tbcostoenvio SET tbcostoenviokm ='" . $costoEnvio->getCostoPorKM() .
        "', tbclienteid='" . $costoEnvio->getTbclienteid() .
        "', tbcostoenvioestado=" . $costoEnvio->getCostoEnvioEstado() .
        " WHERE tbcostoenvioid =" . $costoEnvio->getCostoEnvioId() . ";";
        
        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);
        return $result;
    }

    public function getAllTBCostoEnvio(){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbcostoenvio WHERE tbcostoenvioestado = 1;";
        $result = mysqli_query($conn, $querySelect);

        $array = array();

        while ($row = mysqli_fetch_array($result)) {
            $currentCostoEnvio = new CostoEnvio($row['tbcostoenvioid'],$row['tbcostoenviokm'],$row['tbclienteid'],$row['tbcostoenvioestado']);
            array_push($array,$currentCostoEnvio);
        }

        mysqli_close($conn);
        return $array;
    }

   

}