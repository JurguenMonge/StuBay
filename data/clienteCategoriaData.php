<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once 'data.php';
include '../domain/clienteCategoria.php';

class ClienteCategoriaData extends Data
{

    public function insertarTBClienteCategoria($clienteCategoria)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryInsert = "INSERT INTO tbclientecategoria(tbclienteid, tbclaseid) VALUES ('" .
            $clienteCategoria->getIdCliente() . "'," .
            $clienteCategoria->getIdClase() . ");";

        $result = mysqli_query($conn, $queryInsert);
        mysqli_close($conn);
        return $result;
    }


    public function getAllTBClienteCategorias()
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        $querySelect = "SELECT * FROM tbclientecategoria;";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $array = array(); // declarar el array

        // recorrer el resultado y llenar el array
        while ($row = mysqli_fetch_array($result)) {
            $currentClienteCategoria = new ClienteCategoria($row['tbclienteid'], $row['tbclaseid']);
            array_push($array, $currentClienteCategoria);
        }

        mysqli_close($conn); // cerrar la conexión
        return $array; // devolver el array
    }

    public function getClienteCategoriaByIdCliente($idCliente)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbclientecategoria WHERE tbclienteid = ? LIMIT 1;";

        $stmt = $conn->prepare($querySelect);
        $stmt->bind_param("i", $idCliente);
        $stmt->execute();

        $result = $stmt->get_result();

        $clienteCategoria = null;

        if ($row = mysqli_fetch_array($result)) {
            $clienteCategoria = new ClienteCategoria($row['tbclienteid'], $row['tbclaseid']);
        }

        $stmt->close();
        mysqli_close($conn);

        return $clienteCategoria;
    }

    public function getClienteCategoriaByClaseId($claseId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $query = "SELECT * FROM tbclientecategoria WHERE tbclaseid = ?;";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $claseId);
        $stmt->execute();

        $result = $stmt->get_result();

        $exists = $result->num_rows > 0;

        $stmt->close();
        mysqli_close($conn);

        return $exists;
    }
}
