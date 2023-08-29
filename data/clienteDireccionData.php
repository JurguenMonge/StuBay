<?php

include_once 'data.php';
include '../domain/clienteDireccion.php';

class ClienteDireccionData extends Data
{

    public function insertTBClienteDireccion($clienteDireccion)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        

        //get the last id in the database
        $queryGetLastId = "SELECT MAX(tbclientedireccionid) AS tbclientedireccionid FROM tbclientedireccion";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = trim($row[0]) + 1;
        }

        //insert into database
        $stmt = $conn->prepare("INSERT INTO tbclientedireccion 
        (tbclientedireccionid, 
        tbclienteid, 
        tbclientedireccionbarrio, 
        tbclientedireccioncoordenadagps,
        tbclientedireccionactivo)
        VALUES (?,?,?,?,?)");

        $stmt->bind_param(
            "iisss",
            $nextId,
            $clienteDireccion->getClienteId(),
            $clienteDireccion->getClienteDireccionBarrio(),
            $clienteDireccion->getClienteDireccionCoordenadaGps(),
            $clienteDireccion->getClienteDireccionActivo()
        );

        $result = $stmt->execute();
        $stmt->close();
        mysqli_close($conn);
        return $result;
    }

    public function updateTBClienteDireccion($clienteDireccion)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');


        // Update the record
        $updateStmt = $conn->prepare("UPDATE tbclientedireccion 
        SET tbclienteid = ?, 
        tbclientedireccionbarrio = ?, 
        tbclientedireccioncoordenadagps = ?, 
        tbclientedireccionactivo = ? 
        WHERE tbclientedireccionid = ?");
        $updateStmt->bind_param(
            "isssi",
            $clienteDireccion->getClienteId(),
            $clienteDireccion->getClienteDireccionBarrio(),
            $clienteDireccion->getClienteDireccionCoordenadaGps(),
            $clienteDireccion->getClienteDireccionActivo(),
            $clienteDireccion->getClienteDireccionId()
        );


        $result = $updateStmt->execute();

        $updateStmt->close();
        mysqli_close($conn);

        return $result;
    }

    public function deleteTBClienteDireccion($clienteDireccionId){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        // update value to active for 0
        $queryUpdate = "UPDATE tbclientedireccion 
        SET tbclientedireccionactivo = 0 
        WHERE tbclientedireccionid = " . $clienteDireccionId . ";";

        $result = mysqli_query($conn, $queryUpdate); // ejecutar la consulta y obtener el resultado
        mysqli_close($conn); // cerrar la conexión
        return $result; // devolver el resultado
    }

    public function getAllTBClienteDireccion(){
        // Conexión a la base de datos
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8'); // Establecer el conjunto de caracteres en utf8

        // Consulta a la base de datos
        $querySelect = "SELECT * FROM tbclientedireccion WHERE tbclientedireccionactivo = 1;";

        // Preparar la consulta
        $stmt = mysqli_prepare($conn, $querySelect);

        if($stmt){
            // Ejecutar la consulta y obtener el resultado
            mysqli_stmt_execute($stmt);

            // Vincular las columnas del resultado con variables
            mysqli_stmt_bind_result(
                $stmt, 
                $clienteDireccionId, 
                $clienteId, 
                $clienteDireccionBarrio, 
                $clienteDireccionCoordenadaGps, 
                $clienteDireccionActivo
            );

            $array = array(); // Definir un array para guardar los datos del resultado

            // Recorrer el resultado fila por fila y guardar los datos en el array
            while(mysqli_stmt_fetch($stmt)){
                $currentClienteDireccion = new ClienteDireccion(
                    $clienteDireccionId, 
                    $clienteId, 
                    $clienteDireccionBarrio, 
                    $clienteDireccionCoordenadaGps, 
                    $clienteDireccionActivo
                );
                array_push($array, $currentClienteDireccion);// Agregar el objeto al array de objetos 
            }
        }else{
            $array = array();// Definir un array vacío en caso de que no se pueda ejecutar la consulta
        }

        mysqli_stmt_close($stmt); // Cerrar la consulta

        return $array; // Devolver el array
    }
}