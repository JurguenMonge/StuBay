<?php

include_once 'data.php';
include '../domain/pujaCliente.php';

class PujaClienteData extends Data
{

    public function insertarTBPujaCliente($pujaCliente)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryGetLastId = "SELECT MAX(tbpujaclienteid) AS tbpujaclienteid FROM tbpujacliente";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = isset($row[0]) ? intval($row[0]) + 1 : 1;
        }

        $queryInsert = "INSERT INTO tbpujacliente VALUES (" . $nextId . ",'" .
            $pujaCliente->getClienteId() . "','" .
            $pujaCliente->getArticuloId() . "'," .
            $pujaCliente->getPujaClientePrecioActual() . ");";

        $result = mysqli_query($conn, $queryInsert);
        mysqli_close($conn);
        return $result;
    }

    public function actualizarTBPujaCliente($pujaCliente)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8');
        $queryUpdate = "UPDATE tbpujacliente SET tbclienteid = '" . $pujaCliente->getClienteId() .
            "', tbarticuloid = '" . $pujaCliente->getArticuloId() .
            "', tbpujaclienteprecioactual = " . $pujaCliente->getPujaClientePrecioActual() .
            " WHERE tbpujaclienteid = " . $pujaCliente->getPujaClienteId() . ";";

        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);

        return $result;
    }

    public function eliminarTBPujaCliente($pujaCliente)
    { 
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');
        $queryUpdate = "DELETE FROM tbpujacliente WHERE tbpujaclienteid=" . $pujaCliente->getPujaClienteId() . ";";
        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);

        return $result;
    }

    public function getAllTBPujaCliente()
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        $querySelect = "SELECT * FROM tbpujacliente;";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $array = array(); // declarar el array

        // recorrer el resultado y llenar el array
        while ($row = mysqli_fetch_array($result)) {
            $currentPujaCliente = new PujaCliente($row['tbpujaclienteid'], $row['tbclienteid'], $row['tbarticuloid'], $row['tbpujaclienteprecioactual']);
            array_push($array, $currentPujaCliente);
        }

        mysqli_close($conn); // cerrar la conexión
        return $array; // devolver el array
    }

    public function getTBPujaClienteById($id)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        $querySelect = "SELECT * FROM tbpujacliente WHERE tbpujaclienteid = " . $id . ";";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $pujaCliente = null;

        if ($row = mysqli_fetch_array($result)) {
            $pujaCliente = new PujaCliente($row['tbpujaclienteid'], $row['tbclienteid'], $row['tbarticuloid'], $row['tbsubastaid'], $row['tbpujaclienteprecioactual']);
        }

        mysqli_close($conn); // cerrar la conexión
        return $pujaCliente;
    }
}
