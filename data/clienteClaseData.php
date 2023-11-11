<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once 'data.php';
include '../domain/clienteClase.php';

class ClienteClaseData extends Data
{

    public function insertarTBClienteClase($clienteclase)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryGetLastId = "SELECT MAX(tbclienteclaseid) AS tbclienteclaseid FROM tbclienteclase";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = isset($row[0]) ? intval($row[0]) + 1 : 1;
        }


        $queryInsert = "INSERT INTO tbclienteclase VALUES (" .
            $clienteclase->getNombre() . "','" .
            $clienteclase->getValor() . "'," .
            $clienteclase->getEstado() . ");";

        $result = mysqli_query($conn, $queryInsert);
        mysqli_close($conn);
        return $result;
    }

    public function actualizarTBClienteClase($clienteclase)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8');
        $queryUpdate = "UPDATE tbclienteclase SET tbclienteclasenombre = '" . $clienteclase->getNombre() .
            "', tbclienteclasevalor = '" . $clienteclase->getValor() .
            "', tbclienteclaseestado = " . $clienteclase->getEstado() .
            " WHERE tbclienteclaseid = " . $clienteclase->getIdClase() . ";";

        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);

        return $result;
    }

    public function eliminarTBClienteClase($clienteclaseid)
    { // este metodo actualiza el estado del cliente para no perder el registro del mismo solo de desactiva.
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        // actualizar el valor de active a 0
        $queryUpdate = "UPDATE tbclienteclase SET tbclienteclaseestado = 0 WHERE tbclienteclaseid = " . $clienteclaseid . ";";

        $result = mysqli_query($conn, $queryUpdate); // ejecutar la consulta y obtener el resultado
        mysqli_close($conn); // cerrar la conexión
        return $result; 
    }

    public function getAllTBClienteClase()
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        $querySelect = "SELECT * FROM tbclienteclase WHERE tbclienteclaseestado = 1;";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $array = array(); // declarar el array

        // recorrer el resultado y llenar el array
        while ($row = mysqli_fetch_array($result)) {
            $currentClienteClase = new ClienteClase($row['tbclienteclaseid'], $row['tbclienteclasenombre'], $row['tbclienteclasevalor'], $row['tbclienteclaseestado']);
            array_push($array, $currentClienteClase);
        }

        mysqli_close($conn); // cerrar la conexión
        return $array; // devolver el array
    }

    public function getTBClienteClaseById($id)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        // obtener el estudiante con el id especificado de la base de datos y guardarlos en un objeto estudiante
        $querySelect = "SELECT * FROM tbclienteclase WHERE tbclienteclaseid = " . $id . ";";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $clienteClase = null;

        // si se obtuvo un resultado, llenar el objeto estudiante
        if ($row = mysqli_fetch_array($result)) {
            $clienteClase = new ClienteClase($row['tbclienteclaseid'], $row['tbclienteclasenombre'], $row['tbclienteclasevalor'], $row['tbclienteclaseestado']);
        }

        mysqli_close($conn); // cerrar la conexión
        return $clienteClase;
    }
}
