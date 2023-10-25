<?php

include_once 'data.php';
include '../domain/calificacionComprador.php';

class CalificacionCompradorData extends Data
{

    public function insertTBCalificacionComprador($calificacionComprador)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        // Obtener el próximo ID
        $queryGetLastId = "SELECT MAX(tbcalificacioncompradorid) AS tbcalificacioncompradorid FROM tbcalificacioncomprador";
        $stmt = $conn->prepare($queryGetLastId);
        $stmt->execute();
        $stmt->bind_result($nextId);
        $stmt->fetch();
        $nextId = $nextId !== null ? $nextId + 1 : 1;

        $stmt->close(); // Cierra la consulta preparada anterior

        $stmt = $conn->prepare("INSERT INTO tbcalificacioncomprador VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "iiiisi", //defino el tipo de dato de cada parametro
            $nextId,
            $calificacionComprador->getSubastaId(),
            $calificacionComprador->getClienteId(),
            $calificacionComprador->getCalificacionCompradorPuntos(),
            $calificacionComprador->getCalificacionCompradorComentarios(),
            $calificacionComprador->getCalificacionCompradorActivo()
        );
        $result = $stmt->execute();
        $stmt->close(); // Cierra la consulta preparada actual

        mysqli_close($conn);
        return $result;
    }
}
