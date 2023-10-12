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

    public function updateTBClienteTelefono($clienteTelefono)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');


        // Update the record
        $updateStmt = $conn->prepare("UPDATE tbclientetelefono 
        SET tbclienteid = ?,
        tbclientetelefononumero = ?,
        tbclientetelefonodescripcion = ?,
        tbclientetelefonoactivo = ?
        WHERE tbclientetelefonoid = ?;");

        $updateStmt->bind_param(
            "ssssi",
            $clienteTelefono->getClienteId(),
            $clienteTelefono->getClienteTelefonoNumero(),
            $clienteTelefono->getClienteTelefonoDescripcion(),
            $clienteTelefono->getClienteTelefonoActivo(),
            $clienteTelefono->getClienteTelefonoId()
        );

        $result = $updateStmt->execute();

        $updateStmt->close();
        mysqli_close($conn);

        return $result;
    }

    public function deleteTBClienteTelefono($clienteTelefonoId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        // update value to active for 0
        $queryUpdate = "UPDATE tbclientetelefono 
        SET tbclientetelefonoactivo = 0 
        WHERE tbclientetelefonoid = " . $clienteTelefonoId . ";";

        $result = mysqli_query($conn, $queryUpdate); // ejecutar la consulta y obtener el resultado
        mysqli_close($conn); // cerrar la conexión
        return $result; // devolver el resultado
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

            $array = array(); // Definir un array para guardar los datos adel resultado

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
        } else {
            $array = array(); // Definir un array vacío en caso de que no se pueda ejecutar la consulta
        }

        mysqli_stmt_close($stmt); // Cerrar la consulta

        return $array; // Devolver el array
    }

    public function getClienteTelefonosByClienteId($clienteId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $query = "SELECT * FROM tbclientetelefono WHERE tbclienteid = ? AND tbclientetelefonoactivo = 1";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $clienteId);
        $stmt->execute();

        $result = $stmt->get_result();

        $telefonos = array();

        while ($row = $result->fetch_assoc()) {
            $telefono = new ClienteTelefono(
                $row['tbclientetelefonoid'],
                $row['tbclienteid'],
                $row['tbclientetelefononumero'],
                $row['tbclientetelefonodescripcion'],
                $row['tbclientetelefonoactivo']
            );
            $telefonos[] = $telefono;
        }

        $stmt->close();
        mysqli_close($conn);

        return $telefonos;
    }
}
