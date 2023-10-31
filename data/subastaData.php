<?php

include_once 'data.php';
include '../domain/subasta.php';

class SubastaData extends Data
{

    public function insertarTBSubasta($subasta)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $getLastId = "SELECT MAX(tbsubastaid) AS tbsubastaid FROM tbsubasta";
        $idCont = mysqli_query($conn, $getLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = trim($row[0]) + 1;
        }

        $queryInsert = "INSERT INTO tbsubasta VALUES (" . $nextId . ",'" .
            $subasta->getSubastaFechaHoraInicio() . "','" .
            $subasta->getSubastaFechaHoraFinal() . "','" .
            $subasta->getSubastaPrecioInicial() . "','" .
            $subasta->getSubastaEstadoArticulo() . "','" .
            $subasta->getSubastaDiasUsoArticulo() . "','" .
            $subasta->getSubastaActivo() . "','" .
            $subasta->getSubastaArticuloId() . "'," .
            $subasta->getSubastaVendedorId() . ");";

        $result = mysqli_query($conn, $queryInsert);
        mysqli_close($conn);
        return $result;
    }

    public function updateTBSubasta($subasta)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryUpdate = "UPDATE tbsubasta SET 
            tbsubastafechahorainicio='" . $subasta->getSubastaFechaHoraInicio() . "',
            tbsubastafechahorafinal='" . $subasta->getSubastaFechaHoraFinal() . "',
            tbsubastaprecio='" . $subasta->getSubastaPrecioInicial() . "',
            tbsubastaestadoarticulo='" . $subasta->getSubastaEstadoArticulo() . "',
            tbsubastaarticulodiasuso='" . $subasta->getSubastaDiasUsoArticulo() . "',
            tbsubastaactivo='" . $subasta->getSubastaActivo() . "',
            tbarticuloid=" . $subasta->getSubastaArticuloId() . ",
            tbclienteid=" . $subasta->getSubastaVendedorId() . "
            WHERE tbsubastaid=" . $subasta->getSubastaId() . ";";

        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);
        return $result;
    }

    public function deleteTBSubasta($subasta)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryUpdate = "UPDATE tbsubasta SET 
            tbsubastafechahorainicio='" . $subasta->getSubastaFechaHoraInicio() . "',
            tbsubastafechahorafinal='" . $subasta->getSubastaFechaHoraFinal() . "',
            tbsubastaprecio='" . $subasta->getSubastaPrecioInicial() . "',
            tbsubastaestadoarticulo='" . $subasta->getSubastaEstadoArticulo() . "',
            tbsubastaarticulodiasuso='" . $subasta->getSubastaDiasUsoArticulo() . "',
            tbsubastaactivo='" . $subasta->getSubastaActivo() . "',
            tbarticuloid=" . $subasta->getSubastaArticuloId() . ",
            tbclienteid=" . $subasta->getSubastaVendedorId() . "
            WHERE tbsubastaid=" . $subasta->getSubastaId() . ";";



        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);
        return $result;
    }

    public function getAllTBSubasta()
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbsubasta WHERE tbsubastaactivo = 1;";
        $result = mysqli_query($conn, $querySelect);

        $array = array();

        while ($row = mysqli_fetch_array($result)) {
            $currentSubasta = new Subasta(
                $row['tbsubastaid'],
                $row['tbsubastafechahorainicio'],
                $row['tbsubastafechahorafinal'],
                $row['tbsubastaprecio'],
                $row['tbsubastaestadoarticulo'],
                $row['tbsubastaarticulodiasuso'],
                $row['tbsubastaactivo'],
                $row['tbarticuloid'],
                $row['tbclienteid']
            );
            array_push($array, $currentSubasta);
        }

        mysqli_close($conn);
        return $array;
    }

    public function getAllTBSubastasTerminadas($fechaActual, $clienteId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        // Validación y limpieza del valor de entrada
        $clienteId = mysqli_real_escape_string($conn, $clienteId);

        // Preparar la consulta SQL usando una sentencia preparada
        $querySelect = "SELECT * FROM tbsubasta WHERE tbsubastaactivo = 1 AND tbclienteid=? AND tbsubastafechahorafinal<?";

        $stmt = mysqli_prepare($conn, $querySelect);

        if ($stmt) {
            // Vincular los parámetros a la consulta
            mysqli_stmt_bind_param($stmt, 'is', $clienteId, $fechaActual);

            // Ejecutar la consulta
            mysqli_stmt_execute($stmt);

            // Obtener los resultados
            $result = mysqli_stmt_get_result($stmt);

            $array = array();

            while ($row = mysqli_fetch_array($result)) {
                $currentSubasta = new Subasta(
                    $row['tbsubastaid'],
                    $row['tbsubastafechahorainicio'],
                    $row['tbsubastafechahorafinal'],
                    $row['tbsubastaprecio'],
                    $row['tbsubastaestadoarticulo'],
                    $row['tbsubastaarticulodiasuso'],
                    $row['tbsubastaactivo'],
                    $row['tbarticuloid'],
                    $row['tbclienteid']
                );
                array_push($array, $currentSubasta);
            }

            mysqli_stmt_close($stmt);
        } else {
            // Manejar errores de consulta
            $array = array();
        }

        mysqli_close($conn);
        return $array;
    }


    public function getTBSubastaById($subastaId)
    {//aca se retorna un objeto de tipo subasta
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbsubasta WHERE tbsubastaactivo = 1 && tbsubastaid=$subastaId;";
        $result = mysqli_query($conn, $querySelect);

        $subasta = null;

        while ($row = mysqli_fetch_array($result)) {
            $subasta = new Subasta(
                $row['tbsubastaid'],
                $row['tbsubastafechahorainicio'],
                $row['tbsubastafechahorafinal'],
                $row['tbsubastaprecio'],
                $row['tbsubastaestadoarticulo'],
                $row['tbsubastaarticulodiasuso'],
                $row['tbsubastaactivo'],
                $row['tbarticuloid'],
                $row['tbclienteid']
            );
        }

        mysqli_close($conn);
        return $subasta;
    }

    public function getSubastaByClienteId($clienteId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbsubasta WHERE tbsubastaactivo = 1 && tbclienteid=$clienteId;";
        $result = mysqli_query($conn, $querySelect);

        $subasta = null;

        while ($row = mysqli_fetch_array($result)) {
            $subasta = new Subasta(
                $row['tbsubastaid'],
                $row['tbsubastafechahorainicio'],
                $row['tbsubastafechahorafinal'],
                $row['tbsubastaprecio'],
                $row['tbsubastaestadoarticulo'],
                $row['tbsubastaarticulodiasuso'],
                $row['tbsubastaactivo'],
                $row['tbarticuloid'],
                $row['tbclienteid']
            );
        }

        mysqli_close($conn);
        return $subasta;
    }

    public function getSubastaByArticuloId($articuloid)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbsubasta WHERE tbsubastaactivo = 1 && tbarticuloid=$articuloid;";
        $result = mysqli_query($conn, $querySelect);

        $subasta = null;

        while ($row = mysqli_fetch_array($result)) {
            $subasta = new Subasta(
                $row['tbsubastaid'],
                $row['tbsubastafechahorainicio'],
                $row['tbsubastafechahorafinal'],
                $row['tbsubastaprecio'],
                $row['tbsubastaestadoarticulo'],
                $row['tbsubastaarticulodiasuso'],
                $row['tbsubastaactivo'],
                $row['tbarticuloid'],
                $row['tbclienteid']
            );
        }

        mysqli_close($conn);
        return $subasta;
    }

    public function getTBSubastaByClienteId($clienteId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        // Consulta SQL con sentencia preparada
        $querySelect = "SELECT * FROM tbsubasta WHERE tbclienteid = ? AND tbsubastaactivo = 1";

        // Preparar la consulta
        $stmt = $conn->prepare($querySelect);
        $stmt->bind_param("i", $clienteId); // Enlazar el ID del cliente como un entero

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        $array = array();

        while ($row = $result->fetch_assoc()) {
            $currentSubasta = new Subasta(
                $row['tbsubastaid'],
                $row['tbsubastafechahorainicio'],
                $row['tbsubastafechahorafinal'],
                $row['tbsubastaprecio'],
                $row['tbsubastaestadoarticulo'],
                $row['tbsubastaarticulodiasuso'],
                $row['tbsubastaactivo'],
                $row['tbarticuloid'],
                $row['tbclienteid']
            );
            array_push($array, $currentSubasta);
        }

        // Cerrar la conexión y el stmt
        $stmt->close();
        mysqli_close($conn);

        return $array;
    }


    public function checkSubasta($clienteId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $clienteId = mysqli_real_escape_string($conn, $clienteId); //avoid sql injection

        $query = "SELECT COUNT(*) FROM tbsubasta WHERE tbclienteid = ? AND tbsubastaactivo = 1;"; //query to check if the user exists in the database 

        $stmt = mysqli_prepare($conn, $query); //prepare the query to avoid sql injection attacks 
        mysqli_stmt_bind_param($stmt, 'i', $clienteId); //bind the parameters to the query 
        mysqli_stmt_execute($stmt); //execute the statement 
        mysqli_stmt_bind_result($stmt, $count); //bind the result to the statement
        mysqli_stmt_fetch($stmt); //fetch the data
        mysqli_stmt_close($stmt); //close the statement
        mysqli_close($conn); //close the connection
        // echo 'clienteId: '.$count.'<br>';
        // exit();
        return ($count > 0); //return true if the user exists, false otherwise

    }

    public function checkSubastaArticulo($articuloId)
    {
        $booleano = false;
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $articuloId = mysqli_real_escape_string($conn, $articuloId);

        $query = "SELECT COUNT(*) FROM tbsubasta WHERE tbarticuloid = ? AND tbsubastaactivo = 1;";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $articuloId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        if ($count > 0) {
            $booleano = true;
        }
        return $booleano;
    }

    public function getAllTBSubastaNoActivas()
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbsubasta";
        $result = mysqli_query($conn, $querySelect);

        $array = array();

        while ($row = mysqli_fetch_array($result)) {
            $currentSubasta = new Subasta(
                $row['tbsubastaid'],
                $row['tbsubastafechahorainicio'],
                $row['tbsubastafechahorafinal'],
                $row['tbsubastaprecio'],
                $row['tbsubastaestadoarticulo'],
                $row['tbsubastaarticulodiasuso'],
                $row['tbsubastaactivo'],
                $row['tbarticuloid'],
                $row['tbclienteid']
            );
            array_push($array, $currentSubasta);
        }

        mysqli_close($conn);
        return $array;
    }
}
