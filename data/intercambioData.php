<?php
include_once 'data.php';
include '../domain/intercambio.php';

class IntercambioData extends Data {

    public function insertarTBIntercambio($intercambio){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryGetLastId = "SELECT MAX(tbintercambioid) AS tbintercambioid FROM tbintercambio";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = isset($row[0]) ? intval($row[0]) + 1 : 1;
        }

        $queryInsert = "INSERT INTO tbintercambio VALUES (" . $nextId . ",'" .
            $intercambio->getArticulo() . "','" .
            $intercambio->getVendedor() . "','" .
            $intercambio->getComprador() . "','" .
            $intercambio->getSubasta() . "'," .
            $intercambio->getCompradorActivo() . "'," .
            $intercambio->getVendedorActivo() . ");";

        $result = mysqli_query($conn, $queryInsert);
        mysqli_close($conn);
        return $result;
    }

}
