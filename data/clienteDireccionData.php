<?php

include_once 'data.php';
include '../domain/clienteDireccion.php';

class ClienteDireccionData extends Data
{

    public function insertTBClienteDireccion($clienteDireccion)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $clienteId = $clienteDireccion->getClienteId();
        $stmt = $conn->prepare("SELECT * FROM tbclientedireccion WHERE tbclienteid = ?");
        $stmt->bind_param("i", $clienteId);
        $stmt->execute();
        $verifyClienteId = $stmt->get_result(); //get the mysqli result 

        if (mysqli_num_rows($verifyClienteId) > 0) {
            $stmt->close(); //cierra el stmt
            mysqli_close($conn);
            return 2;
        }

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
        tbclientedireccionlatitud,
        tbclientedireccionlongitud,
        tbclientedireccionactivo)
        VALUES (?,?,?,?,?,?)");

        $stmt->bind_param(
            "iissss",
            $nextId,
            $clienteDireccion->getClienteId(),
            $clienteDireccion->getClienteDireccionBarrio(),
            $clienteDireccion->getClienteDireccionLatitud(),
            $clienteDireccion->getClienteDireccionLongitud(),
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
        tbclientedireccionlatitud = ?,
        tbclientedireccionlongitud = ?, 
        tbclientedireccionactivo = ? 
        WHERE tbclientedireccionid = ?");
        $updateStmt->bind_param(
            "issssi",
            $clienteDireccion->getClienteId(),
            $clienteDireccion->getClienteDireccionBarrio(),
            $clienteDireccion->getClienteDireccionLatitud(),
            $clienteDireccion->getClienteDireccionLongitud(),
            $clienteDireccion->getClienteDireccionActivo(),
            $clienteDireccion->getClienteDireccionId()
        );


        $result = $updateStmt->execute();

        $updateStmt->close();
        mysqli_close($conn);

        return $result;
    }

    public function deleteTBClienteDireccion($clienteDireccionId)
    {
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

    public function getAllTBClienteDireccion()
    {
        // Conexión a la base de datos
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8'); // Establecer el conjunto de caracteres en utf8

        // Consulta a la base de datos
        $querySelect = "SELECT * FROM tbclientedireccion WHERE tbclientedireccionactivo = 1;";

        // Preparar la consulta
        $stmt = mysqli_prepare($conn, $querySelect);

        if ($stmt) {
            // Ejecutar la consulta y obtener el resultado
            mysqli_stmt_execute($stmt);

            // Vincular las columnas del resultado con variables
            mysqli_stmt_bind_result(
                $stmt,
                $clienteDireccionId,
                $clienteId,
                $clienteDireccionBarrio,
                $clienteDireccionLatitud,
                $clienteDireccionLongitud,
                $clienteDireccionActivo
            );

            $array = array(); // Definir un array para guardar los datos del resultado

            // Recorrer el resultado fila por fila y guardar los datos en el array
            while (mysqli_stmt_fetch($stmt)) {
                $currentClienteDireccion = new ClienteDireccion(
                    $clienteDireccionId,
                    $clienteId,
                    $clienteDireccionBarrio,
                    $clienteDireccionLatitud,
                    $clienteDireccionLongitud,
                    $clienteDireccionActivo
                );
                array_push($array, $currentClienteDireccion); // Agregar el objeto al array de objetos 
            }
        } else {
            $array = array(); // Definir un array vacío en caso de que no se pueda ejecutar la consulta
        }

        mysqli_stmt_close($stmt); // Cerrar la consulta

        return $array; // Devolver el array
    }

    public function getTBClienteDireccionByClienteId($clienteId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        // Consulta SQL para obtener las direcciones del cliente por su ID
        $query = "SELECT * FROM tbclientedireccion WHERE tbclienteid = ? AND tbclientedireccionactivo = 1";
        // Preparar la consulta
        $stmt = $conn->prepare($query);

        // Enlazar el ID del cliente como un entero
        $stmt->bind_param("i", $clienteId);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();


        // Recorrer los resultados y crear objetos de dirección del cliente
        while ($row = $result->fetch_assoc()) {
            $direccion =
                new ClienteDireccion(
                    $row['tbclientedireccionid'],
                    $row['tbclienteid'],
                    $row['tbclientedireccionbarrio'],
                    $row['tbclientedireccionlatitud'],
                    $row['tbclientedireccionlongitud'],
                    $row['tbclientedireccionactivo']
                );
        }

        // Cerrar la conexión y el stmt
        $stmt->close();
        mysqli_close($conn);

        return $direccion;
    }

    public function getArticuloByClienteId($clienteId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        // Consulta SQL con sentencia preparada
        $querySelect = "SELECT * FROM tbarticulo WHERE tbclienteid = ? AND tbarticuloactivo = 1";

        // Preparar la consulta
        $stmt = $conn->prepare($querySelect);
        $stmt->bind_param("i", $clienteId); // Enlazar el ID del cliente como un entero

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        $array = array();

        while ($row = $result->fetch_assoc()) {
            $currentArticulo = new Articulo(
                $row['tbarticuloid'],
                $row['tbarticulonombre'],
                $row['tbarticulomarca'],
                $row['tbarticulomodelo'],
                $row['tbarticuloserie'],
                $row['tbarticuloactivo'],
                $row['tbsubcategoriaid'],
                $row['tbclienteid']
            );
            array_push($array, $currentArticulo);
        }

        // Cerrar la conexión y el stmt
        $stmt->close();
        mysqli_close($conn);

        return $array;
    }
}
