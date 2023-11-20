<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once 'data.php';
include '../domain/clienteCriterio.php';

class ClienteCriterioData extends Data
{

    public function insertarTBClienteCriterio($clienteCriterio)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryInsert = "INSERT INTO tbclientecriterio(tbclienteid, tbcriterioid) VALUES ('" .
            $clienteCriterio->getIdCliente() . "'," .
            $clienteCriterio->getIdCriterio() . ");";

        $result = mysqli_query($conn, $queryInsert);
        mysqli_close($conn);
        return $result;
    }


    public function getAllTBClienteCriterios()
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        $querySelect = "SELECT * FROM tbclientecriterio;";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $array = array(); // declarar el array

        // recorrer el resultado y llenar el array
        while ($row = mysqli_fetch_array($result)) {
            $currentClienteCriterio = new ClienteCriterio($row['tbclienteid'], $row['tbcriterioid']);
            array_push($array, $currentClienteCriterio);
        }

        mysqli_close($conn); // cerrar la conexión
        return $array; // devolver el array
    }

    public function getClienteCriterioByIdCliente($idCliente)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbclientecriterio WHERE tbclienteid = ? LIMIT 1;";

        $stmt = $conn->prepare($querySelect);
        $stmt->bind_param("i", $idCliente);
        $stmt->execute();

        $result = $stmt->get_result();

        $clienteCriterio = null;

        if ($row = mysqli_fetch_array($result)) {
            $clienteCriterio = new ClienteCriterio($row['tbclienteid'], $row['tbcriterioid']);
        }

        $stmt->close();
        mysqli_close($conn);

        return $clienteCriterio;
    }

    public function getClienteCriterioByCriterioId($criterioId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $query = "SELECT * FROM tbclientecriterio WHERE tbcriterioid = ?;";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $criterioId);
        $stmt->execute();

        $result = $stmt->get_result();

        $exists = $result->num_rows > 0;

        $stmt->close();
        mysqli_close($conn);

        return $exists;
    }
}
