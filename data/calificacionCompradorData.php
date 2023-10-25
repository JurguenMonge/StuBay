<?php

include '../data/calificacionCompradorData.php';

class CalificacionCompradorData extends Data
{

    public function insertTBCalificacionComprador($calificacionComprador)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryGetLastId = "SELECT MAX(tbcalificacioncompradorid) AS tbcalificacioncompradorid FROM tbcalificacioncomprador";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = trim($row[0]) + 1;
        }

        $stmt = $conn->prepare("INSERT INTO tbcalificacioncomprador 
        VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "iiidsi", //defino el tipo de dato de cada parametro
            $nextId,
            $calificacionComprador->getSubastaId(),
            $calificacionComprador->getClienteId(),
            $calificacionComprador->getCalificacionCompradorPuntos(),
            $calificacionComprador->getCalificacionCompradorComentarios(),
            $calificacionComprador->getCalificacionCompradorActivo()
        );
        $result = $stmt->execute();
        $stmt->close();
        mysqli_close($conn);
        return $result;
    }
}
