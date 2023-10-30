<?php

include_once 'data.php';
include '../domain/eventoArticulo.php';

class EventoArticuloData extends Data{

    public function insertarTBEventoArticulo($eventoArticulo)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryGetLastId = "SELECT MAX(id) AS id FROM tbeventoarticulo";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = isset($row[0]) ? intval($row[0]) + 1 : 1;
        }

        $queryInsert = "INSERT INTO tbeventoarticulo VALUES (" . $nextId . ",'" .
            $eventoArticulo->getTbarticuloid() . "'," .
            $eventoArticulo->getTbclienteid() . ");";

        $result = mysqli_query($conn, $queryInsert);
        mysqli_close($conn);
        return $result;
    }

}