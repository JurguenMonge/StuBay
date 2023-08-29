<?php

include_once 'data.php';
include '../domain/clienteTelefono.php';

class ClienteTelefonoData extends Data
{

    public function insertTBClienteTelefono($clienteTelefono)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        //get the last id in the database
        $queryGetLastId = "SELECT MAX(tbclientetelefonoid) AS tbclientetelefonoid FROM tbclientetelefono";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = trim($row[0]) + 1;
        }

        //insert into database
        $stmt = $conn->prepare("INSERT INTO tbclientetelefono
        (tbclientetelefonoid,
        tbclienteid,
        tbclientetelefononumero,
        tbclientetelefonodescripcion,
        tbclientetelefonoactivo)
        VALUES (?,?,?,?,?)");

        $stmt->bind_param(
            "issss",
            $nextId,
            $clienteTelefono->getClienteId(),
            $clienteTelefono->getClienteTelefonoNumero(),
            $clienteTelefono->getClienteTelefonoDescripcion(),
            $clienteTelefono->getClienteTelefonoActivo()
        );

        $result = $stmt->execute();
        $stmt->close();
        mysqli_close($conn);
        return $result;
    }

    public function getAllTBClienteTelefono()
    {
        // Conexión a la base de datos
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8'); // Establecer el conjunto de caracteres en utf8

        // Consulta a la base de datos
        $querySelect = "SELECT * FROM tbclientetelefono WHERE tbclientetelefonoactivo = 1;";

        // Preparar la consulta
        $stmt = mysqli_prepare($conn, $querySelect);

        if ($stmt) {

            // Ejecutar la consulta
            mysqli_stmt_execute($stmt);

            // Vincular las columnas del resultado con variables
            mysqli_stmt_bind_result(
                $stmt, 
                $clienteTelefonoId, 
                $clienteId, 
                $clienteTelefonoNumero, 
                $clienteTelefonoDescripcion, 
                $clienteTelefonoActivo
            );

            $array = array(); // Definir un array para guardar los datos del resultado

            // Recorrer el resultado fila por fila y guardar los datos en el array
            while (mysqli_stmt_fetch($stmt)) {
                $currentClienteTelefono = new ClienteTelefono(
                    $clienteTelefonoId, 
                    $clienteId, 
                    $clienteTelefonoNumero, 
                    $clienteTelefonoDescripcion, 
                    $clienteTelefonoActivo
                );
                array_push($array, $currentClienteTelefono);
            }
             
        }else{
            $array = array();// Definir un array vacío en caso de que no se pueda ejecutar la consulta
        }

        mysqli_stmt_close($stmt); // Cerrar la consulta

        return $array; // Devolver el array
    }
}
