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
        $queryGetLastId = "SELECT MAX(tbsubastaseguidorid) AS tbsubastaseguidorid FROM tbpujaseguidor";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = trim($row[0]) + 1;
        }

        // Insert the follower auction in the database
        $queryInsert = "INSERT INTO tbpujaseguidor VALUES (" . $nextId . ", " . $seguirSubasta->getClienteId() . ", " . $seguirSubasta->getSubastaId() . ", " . $seguirSubasta->getSeguirSubastaActivo() . ");";
        $result = mysqli_query($conn, $queryInsert);
        mysqli_close($conn);
        return $result;
    }

    public function updateTBSeguirSubasta($seguirSubasta)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        //update the auction follower in the database
        $updateStmt = $conn->prepare("UPDATE tbpujaseguidor 
        SET tbclienteid = ?, 
        tbsubastaid = ?, 
        tbsubastaseguidoractivo = ? 
        WHERE tbsubastaseguidorid = ?");

        $updateStmt->bind_param(
            "iiii",
            $seguirSubasta->getClienteId(),
            $seguirSubasta->getSubastaId(),
            $seguirSubasta->getSeguirSubastaActivo(),
            $seguirSubasta->getSeguirSubastaId()
        );

        $result = $updateStmt->execute();

        $updateStmt->close();
        mysqli_close($conn);
        return $result;
    }

    public function deleteTBSeguirSubasta($seguirSubastaId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        // update value to active for 0
        $update = "UPDATE tbpujaseguidor 
        SET tbsubastaseguidoractivo = 0 
        WHERE tbsubastaseguidorid = " . $seguirSubastaId . ";";

        $result = mysqli_query($conn, $update);
        mysqli_close($conn);
        return $result;
    }

    public function getAllTBSeguirSubasta()
    {
        // Conexión a la base de datos
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8'); // Establecer el conjunto de caracteres en utf8

        // Consulta SQL para seleccionar todos los registros de la tabla tbcliente donde clienteactivo sea 1
        $querySelect = "SELECT * FROM tbpujaseguidor WHERE tbsubastaseguidoractivo = 1;";

        // Preparar la consulta
        $stmt = mysqli_prepare($conn, $querySelect);

        if ($stmt) {
            // Ejecutar la consulta preparada
            mysqli_stmt_execute($stmt);

            // Vincular las columnas de resultado a las variables correspondientes
            mysqli_stmt_bind_result(
                $stmt,
                $seguirSubastaId,
                $clienteId,
                $subastaId,
                $seguirSubastaActivo
            );

            $array = array(); // Crear un array para almacenar los resultados de la consulta preparada del mysqli_stmt_fetch

            // Recorrer el conjunto de resultados y extraer los datos en las variables
            while (mysqli_stmt_fetch($stmt)) {
                // Crear una instancia de Cliente con los datos extraídos
                $currentSeguirSubasta = new SeguirSubasta(
                    $seguirSubastaId,
                    $clienteId,
                    $subastaId,
                    $seguirSubastaActivo
                );
                // Agregar la instancia al array
                array_push($array, $currentSeguirSubasta);
            }

            // Cerrar la consulta preparada
            mysqli_stmt_close($stmt);
        } else {
            // Manejar el error si la preparación de la consulta falla
            $array = array();
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($conn);

        // Devolver el array con los resultados
        return $array;
    }
    

    
}