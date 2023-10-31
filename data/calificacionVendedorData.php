<?php

include_once 'data.php';
include_once '../domain/calificacionVendedor.php';

class CalificacionVendedorData extends Data
{

    public function insertTBCalificacionVendedor($calificacionVendedor)
    {   
        
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        // Obtener el próximo ID
        $queryGetLastId = "SELECT MAX(tbcalificacionvendedorid) AS tbcalificacionvendedorid FROM tbcalificacionvendedor";
        $stmt = $conn->prepare($queryGetLastId);
        $stmt->execute();
        $stmt->bind_result($nextId);
        $stmt->fetch();
        $nextId = $nextId !== null ? $nextId + 1 : 1;

        $stmt->close(); // Cierra la consulta preparada anterior

        $stmt = $conn->prepare("INSERT INTO tbcalificacionvendedor VALUES (?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "iiiiis", //defino el tipo de dato de cada parametro
            $nextId,
            $calificacionVendedor->getSubastaId(),
            $calificacionVendedor->getClienteId(),
            $calificacionVendedor->getCalificacionVendedorClienteId(),
            $calificacionVendedor->getCalificacionVendedorPuntos(),
            $calificacionVendedor->getCalificacionVendedorComentarios()
        );
        $result = $stmt->execute();
        $stmt->close(); // Cierra la consulta preparada actual

        mysqli_close($conn);
        return $result;
    }

    public function updateTBCalificacionVendedor($calificacionVendedor)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');
        $stmt = $conn->prepare("UPDATE tbcalificacionvendedor SET tbsubastaid = ?,
         tbclienteid = ?, 
         tbcalificacionvendedorclienteid = ?, 
         tbcalificacionvendedorpuntos = ?, 
         tbcalificacionvendedorcomentarios = ? 
         WHERE tbcalificacionvendedorid = ?");
        $stmt->bind_param(
            "iiiisi", //defino el tipo de dato de cada parametro
            $calificacionVendedor->getSubastaId(),
            $calificacionVendedor->getClienteId(),
            $calificacionVendedor->getCalificacionVendedorClienteId(),
            $calificacionVendedor->getCalificacionVendedorPuntos(),
            $calificacionVendedor->getCalificacionVendedorComentarios(),
            $calificacionVendedor->getCalificacionVendedorId()
        );
        $result = $stmt->execute();
        $stmt->close(); // Cierra la consulta preparada actual

        mysqli_close($conn);
        return $result;
    }

    public function deleteTBCalificacionVendedor($calificacionVendedorId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8'); //set the charset to utf8 to support spanish characters

        $updateStmt = $conn->prepare("UPDATE tbcalificacionvendedor WHERE tbcalificacionvendedorid = ?");
        $updateStmt->bind_param("i", $calificacionVendedorId);
        $result = $updateStmt->execute();
        $updateStmt->close();
        mysqli_close($conn);
        return $result;
    }

    public function getAllTBCalificacionVendedor()
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8'); //set the charset to utf8 to support spanish characters

        $querySelect = "SELECT * FROM tbcalificacionvendedor WHERE tbcalificacionvendedoractivo = 1";

        $stmt = mysqli_prepare($conn, $querySelect);

        if ($stmt) {
            // Ejecutar la consulta preparada
            mysqli_stmt_execute($stmt);

            mysqli_stmt_bind_result(
                $stmt,
                $calificacionVendedorId,
                $subastaId,
                $clienteId,
                $calificacionVendedorPuntos,
                $calificacionVendedorComentarios,
                $calificacionVendedorActivo
            );

            $array = array(); //creamos un array vacio para guardar los datos

            //llenar el array con los datos
            while (mysqli_stmt_fetch($stmt)) {
                $calificacionVendedor = new CalificacionVendedor(
                    $calificacionVendedorId,
                    $subastaId,
                    $clienteId,
                    $calificacionVendedorPuntos,
                    $calificacionVendedorComentarios,
                    $calificacionVendedorActivo
                );
                array_push($array, $calificacionVendedor);
            }
        } else {
            //Manejar el error si la consulta falla
            $array = array();
        }

        mysqli_stmt_close($stmt);

        mysqli_close($conn);

        return $array;
    }

    public function getClienteById($clienteId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8'); //set the charset to utf8 to support spanish characters

        $querySelect = "SELECT * FROM tbcalificacionvendedor WHERE tbcalificacionvendedorid = ?";
        $stmt = $conn->prepare($querySelect);

        $stmt->bind_param("i", $clienteId);

        $stmt->execute();

        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $calificacion = new CalificacionVendedor(
                $row['tbcalificacionvendedorid'],
                $row['tbsubastaid'],
                $row['tbclienteid'],
                $row['tbcalificacionvendedorclienteid'],
                $row['tbcalificacionvendedorpuntos'],
                $row['tbcalificacionvendedorcomentarios']
            );
            $califiaciones[] = $calificacion;
        }

        $stmt->close();
        mysqli_close($conn);

        return $califiaciones;
    }

    public function getCalificacionVendedorClienteById($clienteId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8'); //set the charset to utf8 to support spanish characters

        $querySelect = "SELECT * FROM tbcalificacionvendedor WHERE tbclienteid = ?";
        $stmt = $conn->prepare($querySelect);

        $stmt->bind_param("i", $clienteId);

        $stmt->execute();

        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $calificacion =
                new CalificacionVendedor(
                    $row['tbcalificacionvendedorid'],
                    $row['tbsubastaid'],
                    $row['tbclienteid'],
                    $row['tbcalificacionvendedorclienteid'],
                    $row['tbcalificacionvendedorpuntos'],
                    $row['tbcalificacionvendedorcomentarios']
                );
            $calificaciones[] = $calificacion;
        }

        $stmt->close();
        mysqli_close($conn);

        return $calificaciones;
    }
}
