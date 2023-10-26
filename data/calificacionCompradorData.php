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
            "iiiiis", //defino el tipo de dato de cada parametro
            $nextId,
            $calificacionComprador->getSubastaId(),
            $calificacionComprador->getClienteId(),
            $calificacionComprador->getCalificacionCompradorClienteId(),
            $calificacionComprador->getCalificacionCompradorPuntos(),
            $calificacionComprador->getCalificacionCompradorComentarios()
        );
        $result = $stmt->execute();
        $stmt->close(); // Cierra la consulta preparada actual

        mysqli_close($conn);
        return $result;
    }

    public function updateTBCalificacionComprador($calificacionComprador)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');
        $stmt = $conn->prepare("UPDATE tbcalificacioncomprador SET tbsubastaid = ?,
         tbclienteid = ?, 
         tbcalificacioncompradorclienteid = ?, 
         tbcalificacioncompradorpuntos = ?, 
         tbcalificacioncompradorcomentarios = ? 
         WHERE tbcalificacioncompradorid = ?");
        $stmt->bind_param(
            "iiiisi", //defino el tipo de dato de cada parametro
            $calificacionComprador->getSubastaId(),
            $calificacionComprador->getClienteId(),
            $calificacionComprador->getCalificacionCompradorClienteId(),
            $calificacionComprador->getCalificacionCompradorPuntos(),
            $calificacionComprador->getCalificacionCompradorComentarios(),
            $calificacionComprador->getCalificacionCompradorId()
        );
        $result = $stmt->execute();
        $stmt->close(); // Cierra la consulta preparada actual

        mysqli_close($conn);
        return $result;
    }

    public function getTBAllCalificacionComprador()
    {
        $calificacionCompradorList = array();

        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $query = "SELECT * FROM tbcalificacioncomprador";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_array($result)) {
            $calificacionComprador = new CalificacionComprador(
                $row['tbcalificacioncompradorid'],
                $row['tbsubastaid'],
                $row['tbclienteid'],
                $row['tbcalificacioncompradorpuntos'],
                $row['tbcalificacioncompradorcomentarios'],
                $row['tbcalificacioncompradoractivo']
            );
            array_push($calificacionCompradorList, $calificacionComprador);
        }

        mysqli_close($conn);
        return $calificacionCompradorList;
    }

    public function deleteTBCalificacionComprador($id)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset("utf8");

        $query = "DELETE FROM tbcalificacioncomprador WHERE tbcalificacioncompradorid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        mysqli_close($conn);
        return $result;
    }

    public function getCalificacionCompradorByClienteId($clienteId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $query = "SELECT * FROM tbcalificacioncomprador WHERE tbclienteid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $clienteId);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $calificacionComprador =
                new CalificacionComprador(
                    $row['tbcalificacioncompradorid'],
                    $row['tbsubastaid'],
                    $row['tbclienteid'],
                    $row['tbcalificacioncompradorclienteid'],
                    $row['tbcalificacioncompradorpuntos'],
                    $row['tbcalificacioncompradorcomentarios'],
                );
            $calificacionCompradores[] = $calificacionComprador;
        }

        $stmt->close();
        mysqli_close($conn);
        return $calificacionCompradores;
    }
}
