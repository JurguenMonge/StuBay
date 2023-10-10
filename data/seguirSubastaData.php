<?php

include_once 'data.php';
include '../domain/seguirSubasta.php';


class SeguirSubastaData extends Data
{
    public function insertTBSeguirSubasta($seguirSubasta)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        //get the last id in the database
        $queryGetLastId = "SELECT MAX(tbpujaseguidorid) AS tbpujaseguidorid FROM tbpujaseguidor";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = trim($row[0]) + 1;
        }

        $stmt = $conn->prepare("INSERT INTO tbpujaseguidor VALUES (?,?,?)");
        $stmt->bind_param(
            "iii", 
            $nextId, 
            $seguirSubasta->getClienteId(), 
            $seguirSubasta->getPujaId()
        );

        $result = mysqli_query($conn, $stmt);
        $stmt->close();
        mysqli_close($conn);
        return $result;
    }

    public function updateTBSeguirSubasta($seguirSubasta)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');
        $stmt = $conn->prepare("UPDATE tbpujaseguidor SET clienteid=?, pujaid=? WHERE tbpujaseguidorid=?");
        $stmt->bind_param(
            "iii",
            $seguirSubasta->getClienteId(),
            $seguirSubasta->getPujaId(),
            $seguirSubasta->getSeguirSubastaId()
        );

        $result = mysqli_query($conn, $stmt);
        $stmt->close();
        mysqli_close($conn);
        return $result;
    }

    public function deleteTBSeguirSubasta($seguirSubasta)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');
        $stmt = $conn->prepare("DELETE FROM tbpujaseguidor WHERE tbpujaseguidorid=?");
        $stmt->bind_param("i", $seguirSubasta->getSeguirSubastaId());

        $result = mysqli_query($conn, $stmt);
        $stmt->close();
        mysqli_close($conn);
        return $result;
    }

    public function getAllTBSeguirSubasta()
    {
        $seguirSubastaList = array();
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $query = "SELECT * FROM tbpujaseguidor";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_array($result)) {
            $currentSeguirSubasta = new SeguirSubasta(
                $row['tbpujaseguidorid'],
                $row['clienteid'],
                $row['pujaid']
            );
            array_push($seguirSubastaList, $currentSeguirSubasta);
        }
        mysqli_close($conn);
        return $seguirSubastaList;
    }
}