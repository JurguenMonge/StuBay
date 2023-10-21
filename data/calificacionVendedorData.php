<?php

include_once 'data.php';
include_once '../domain/calificacionvendedor.php';

class CalificacionVendedorData extends Data
{

    public function insertTBCalificacionVendedor($calificacionVendedor)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        //get the last id in the database
        $queryGetLastId = "SELECT MAX(tbcalificacionvendedorid) AS tbcalificacionvendedorid FROM tbcalificacionvendedor";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = trim($row[0]) + 1;
        }

        $stmt = $conn->prepare("INSERT INTO tbcalificacionvendedor VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "iiidsi", //defino el tipo de dato de cada parametro
            $nextId,
            $calificacionVendedor->getSubastaId(),
            $calificacionVendedor->getClienteId(),
            $calificacionVendedor->getCalificacionVendedorPuntos(),
            $calificacionVendedor->getCalificacionVendedorComentarios(),
            $calificacionVendedor->getCalificacionVendedorActivo()
        );
        $result = $stmt->execute();
        $stmt->close();
        mysqli_close($conn);
        return $result;
    }

    public function updateTBCalificacionVendedor($calificacionVendedor)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');
        $updatestmt = $conn->prepare("UPDATE tbcalificacionvendedorid SET tbsubastaid = ?,
         tbclienteid = ?,
         tbcalificacionvendedorpuntos = ?,
         tbcalificacionvendedorcomentarios = ?,
         tbcalificacionvendedoractivo = ?
         WHERE tbcalificacionvendedorid = ?");
        $updatestmt->bind_param(
            "iiidsi", //defino el tipo de dato de cada parametro
            $calificacionVendedor->getSubastaId(),
            $calificacionVendedor->getClienteId(),
            $calificacionVendedor->getCalificacionVendedorPuntos(),
            $calificacionVendedor->getCalificacionVendedorComentarios(),
            $calificacionVendedor->getCalificacionVendedorActivo(),
            $calificacionVendedor->getCalificacionVendedorId()
        );

        $result = $updatestmt->execute();

        $updatestmt->close();
        mysqli_close($conn);

        return $result;
    }

    public function deleteTBCalificacionVendedor($calificacionVendedorId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8'); //set the charset to utf8 to support spanish characters

        $deletestmt = $conn->prepare("UPDATE tbcalificacionvendedori SET tbcalificacionvendedoractivo = 0 WHERE tbcalificacionvendedorid = ?");
        $deletestmt->bind_param("i", $calificacionVendedorId);
        $result = $deletestmt->execute();
        $deletestmt->close();
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

            $array = array();//creamos un array vacio para guardar los datos

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

        $querySelect = "SELECT * FROM tbcalificacionvendedor WHERE tbcalificacionvendedoractivo = 1 AND tbcalificacionvendedorid = ?";
        $stmt = $conn->prepare($querySelect);

        $stmt->bind_param("i", $clienteId);

        $stmt->execute();

        $result = $stmt->get_result();

        while($row = $result->fetch_assoc())
        {
            $calificacion = new CalificacionVendedor(
                $row['tbcalificacionvendedorid'],
                $row['tbsubastaid'],
                $row['tbclienteid'],
                $row['tbcalificacionvendedorpuntos'],
                $row['tbcalificacionvendedorcomentarios'],
                $row['tbcalificacionvendedoractivo']
            );
            $califiaciones[] = $calificacion;
        }

        $stmt->close();
        mysqli_close($conn);

        return $califiaciones;
    }
}
