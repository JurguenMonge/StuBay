<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once 'data.php';
include '../domain/criterio.php';

class CriterioData extends Data
{
    public function insertarTBCriterio($criterio)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $getLastId = "SELECT MAX(tbcriterioid) FROM tbcriterio";
        $idCont = mysqli_query($conn, $getLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = trim($row[0]) + 1;
        }

        $queryInsert = "INSERT INTO tbcriterio (tbcriterioid, tbcriterionombre, tbcriteriovalor, tbcriterioestado) VALUES ('" . $nextId . "','" .
            $criterio->getNombre() . "'," .
            $criterio->getValor() . "," .
            $criterio->getEstado() . ");";



        $result = mysqli_query($conn, $queryInsert);
        mysqli_close($conn);
        return $result;
    }

    public function actualizarTBCriterio($criterio)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8');
        $queryUpdate = "UPDATE tbcriterio SET tbcriterionombre = '" . $criterio->getNombre() .
            "', tbcriteriovalor = '" . $criterio->getValor() .
            "', tbcriterioestado = " . $criterio->getEstado() .
            " WHERE tbcriterioid = " . $criterio->getIdCriterio() . ";";

        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);

        return $result;
    }

    public function eliminarTBCriterio($criterioId)
    { // este metodo actualiza el estado del cliente para no perder el registro del mismo solo de desactiva.
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        // actualizar el valor de active a 0
        $queryUpdate = "UPDATE tbcriterio SET tbcriterioestado = 0 WHERE tbcriterioid = " . $criterioId . ";";

        $result = mysqli_query($conn, $queryUpdate); // ejecutar la consulta y obtener el resultado
        mysqli_close($conn); // cerrar la conexión
        return $result;
    }

    public function getAllTBCriterio()
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        $querySelect = "SELECT * FROM tbcriterio WHERE tbcriterioestado = 1;";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $array = array(); // declarar el array

        // recorrer el resultado y llenar el array
        while ($row = mysqli_fetch_array($result)) {
            $currentClienteClase = new Criterio($row['tbcriterioid'], $row['tbcriteriovalor'], $row['tbcriterionombre'], $row['tbcriterioestado']);
            array_push($array, $currentClienteClase);
        }

        mysqli_close($conn); 
        return $array; 
    }

    public function getCriterioIdByCriterio($criterio)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $query = "SELECT tbcriterioid FROM tbcriterio WHERE tbcriterionombre = ? AND tbcriterioestado = 1;";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $criterio);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $clienteCriterioId = $row['tbcriterioid'];
        } else {
            $clienteCriterioId = null;
        }

        $stmt->close();
        mysqli_close($conn);

        return $clienteCriterioId;
    }

    public function getTBCriterioById($id)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        // obtener el estudiante con el id especificado de la base de datos y guardarlos en un objeto estudiante
        $querySelect = "SELECT * FROM tbcriterio WHERE tbcriterioid = " . $id . ";";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $clienteClase = null;

        // si se obtuvo un resultado, llenar el objeto estudiante
        if ($row = mysqli_fetch_array($result)) {
            $clienteClase = new Criterio($row['tbcriterioid'], $row['tbcriterionombre'], $row['tbcriteriovalor'], $row['tbcriterioestado']);
        }

        mysqli_close($conn); // cerrar la conexión
        return $clienteClase;
    }

}
