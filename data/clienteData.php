<?php

include_once 'data.php';
include '../domain/cliente.php';

class ClienteData extends Data
{

    public function insertTBCliente($cliente)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        //get the last id in the database
        $queryGetLastId = "SELECT MAX(clienteid) AS clienteid FROM tbcliente";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = trim($row[0]) + 1;
        }

        $clienteCorreo = $cliente->getClienteCorreo();
        $stmt = $conn->prepare("SELECT * FROM tbcliente WHERE clientecorreo = ?"); //verify if the email is already in the database, the stmt is to avoid sql injection 
        $stmt->bind_param("s", $clienteCorreo); //to pass the parameter to the stmt and that "s" is to say that it is a string
        $stmt->execute(); //execute the statement
        $verifyClienteCorreo = $stmt->get_result(); //get the result of the statement 

        if (mysqli_num_rows($verifyClienteCorreo) > 0) {
            $stmt->close(); //cierra el stmt
            mysqli_close($conn);
            return 0;
        }
        // Insert the new cliente in the database
        $stmt = $conn->prepare("INSERT INTO tbcliente VALUES (?, ?, ?, ?, ?, ?, ?, ?)"); //in this case the stmt is to avoid sql injection
        $stmt->bind_param(
            "issssssi", //this is to say that the first one is an integer and the rest are strings
            $nextId,
            $cliente->getClienteNombre(),
            $cliente->getClientePrimerApellido(),
            $cliente->getClienteSegundoApellido(),
            $cliente->getClienteCorreo(),
            $cliente->getClientePassword(),
            $cliente->getClienteFechaIngreso(),
            $cliente->getClienteActivo()
        ); //to pass the parameters to the stmt and that "isssssi" is to say that the first one is an integer and the rest are strings
        $result = $stmt->execute(); //execute the statement
        $stmt->close(); //close the stmt
        mysqli_close($conn); //close the connection
        return $result; //return the result
    }


    public function updateTBCliente($cliente)
    {

        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $stmt = $conn->prepare("UPDATE tbcliente SET clientenombre = ?,
         clienteprimerapellido = ?, 
         clientesegundoapellido = ?,
         clientecorreo = ?, 
         clientepassword = ?, 
         clientefechaingreso = ?, 
         clienteactivo = ? 
         WHERE clienteid = ?"); //in this case the stmt is to avoid sql injection
        $stmt->bind_param(
            "ssssssii", //this is to say that the first one is an integer and the rest are strings
            $cliente->getClienteNombre(),
            $cliente->getClientePrimerApellido(),
            $cliente->getClienteSegundoApellido(),
            $cliente->getClienteCorreo(),
            $cliente->getClientePassword(),
            $cliente->getClienteFechaIngreso(),
            $cliente->getClienteActivo(),
            $cliente->getClienteId()
        ); //to pass the parameters to the stmt and that "isssssi" is to say that the first one is an integer and the rest are strings
        $result = $stmt->execute(); //execute the statement
        $stmt->close(); //close the stmt
        mysqli_close($conn); //close the connection
        return $result; //return the result
    }

    public function deleteTBCliente($cliente)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8'); //set the charset to utf8
        $queryUpdate = "UPDATE tbcliente SET clientenombre = '" . $cliente->getClienteNombre() .
            "', clienteprimerapellido = '" . $cliente->getClientePrimerApellido() .
            "', clientesegundoapellido = '" . $cliente->getClienteSegundoApellido() .
            "', clientecorreo = '" . $cliente->getClienteCorreo() .
            "', clientepassword = '" . $cliente->getClientePassword() .
            "', clientefechaingreso = '" . $cliente->getClienteFechaIngreso() .
            "', clienteactivo = " . $cliente->getClienteActivo() .
            " WHERE clienteid = " . $cliente->getClienteId() . ";";

        $result = mysqli_query($conn, $queryUpdate); //execute the query and get the result
        mysqli_close($conn); //close the connection

        return $result; //return the result
    }

    // public function deleteTBClient($clientId)
    // { // este metodo actualiza el estado del cliente para no perder el registro del mismo solo de desactiva.
    //     $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
    //     $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

    //     // actualizar el valor de active a 0
    //     $queryUpdate = "UPDATE tbclient SET clientactive = 0 WHERE clientid = " . $clientId . ";";

    //     $result = mysqli_query($conn, $queryUpdate); // ejecutar la consulta y obtener el resultado
    //     mysqli_close($conn); // cerrar la conexión
    //     return $result; // devolver el resultado
    // }

    // public function getAllTBCliente()
    // {
    //     $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
    //     $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

    //     // obtener todos los clientes activos (active = 1) de la base de datos y guardarlos en un array de estudiantes 
    //     $querySelect = "SELECT * FROM tbcliente WHERE clienteactivo = 1;";

    //     $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

    //     $array = array(); // declarar el array

    //     // recorrer el resultado y llenar el array
    //     while ($row = mysqli_fetch_array($result)) {
    //         $currentCliente = new Cliente(
    //             $row['clienteid'],
    //             $row['clientenombre'],
    //             $row['clienteprimerapellido'],
    //             $row['clientesegundoapellido'],
    //             $row['clientecorreo'],
    //             $row['clientepassword'],
    //             $row['clientefechaingreso'],
    //             $row['clienteactivo']
    //         );
    //         array_push($array, $currentCliente);
    //     }

    //     mysqli_close($conn); // cerrar la conexión
    //     return $array; // devolver el array
    // }
    public function getAllTBCliente()
    {
        // Conexión a la base de datos
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8'); // Establecer el conjunto de caracteres en utf8

        // Consulta SQL para seleccionar todos los registros de la tabla tbcliente donde clienteactivo sea 1
        $querySelect = "SELECT * FROM tbcliente WHERE clienteactivo = 1;";

        // Preparar la consulta
        $stmt = mysqli_prepare($conn, $querySelect);

        if ($stmt) {
            // Ejecutar la consulta preparada
            mysqli_stmt_execute($stmt);

            // Vincular las columnas de resultado a las variables correspondientes
            mysqli_stmt_bind_result($stmt, $clienteid, $clientenombre, 
            $clienteprimerapellido, $clientesegundoapellido, 
            $clientecorreo, $clientepassword, $clientefechaingreso, $clienteactivo);

            $array = array();// Crear un array para almacenar los resultados de la consulta preparada del mysqli_stmt_fetch

            // Recorrer el conjunto de resultados y extraer los datos en las variables
            while (mysqli_stmt_fetch($stmt)) {
                // Crear una instancia de Cliente con los datos extraídos
                $currentCliente = new Cliente(
                    $clienteid,
                    $clientenombre,
                    $clienteprimerapellido,
                    $clientesegundoapellido,
                    $clientecorreo,
                    $clientepassword,
                    $clientefechaingreso,
                    $clienteactivo
                );
                // Agregar la instancia al array
                array_push($array, $currentCliente);
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


    public function getTBClienteById($clienteId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        // obtener el client con el id especificado de la base de datos y guardarlos en un objeto client
        $querySelect = "SELECT * FROM tbcliente WHERE clienteid = " . $clienteId . ";";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $cliente = null; // declarar el objeto client

        // si se obtuvo un resultado, llenar el objeto client
        if ($row = mysqli_fetch_array($result)) {
            $client = new Cliente(
                $row['clienteid'],
                $row['clientenombre'],
                $row['clienteprimerapellido'],
                $row['clientesegundoapellido'],
                $row['clientecorreo'],
                $row['clientepassword'],
                $row['clientefechaingreso'],
                $row['clienteactivo']
            );
        }

        mysqli_close($conn); // cerrar la conexión
        return $client; // devolver el objeto client
    }
}
