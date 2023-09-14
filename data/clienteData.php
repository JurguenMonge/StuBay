<?php

include_once 'data.php';
include '../domain/cliente.php';

class ClienteData extends Data
{

    public function insertTBCliente($cliente)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $clienteCorreo = $cliente->getClienteCorreo();
        $stmt = $conn->prepare("SELECT * FROM tbcliente WHERE tbclientecorreo = ?"); //verify if the email is already in the database, the stmt is to avoid sql injection 
        $stmt->bind_param("s", $clienteCorreo); //to pass the parameter to the stmt and that "s" is to say that it is a string
        $stmt->execute(); //execute the statement
        $verifyClienteCorreo = $stmt->get_result(); //get the result of the statement 

        if (mysqli_num_rows($verifyClienteCorreo) > 0) {
            $stmt->close(); //cierra el stmt
            mysqli_close($conn);
            return 2;
        }

        //get the last id in the database
        $queryGetLastId = "SELECT MAX(tbclienteid) AS tbclienteid FROM tbcliente";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = trim($row[0]) + 1;
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


    /*public function updateTBCliente($cliente)
    {

        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $stmt = $conn->prepare("UPDATE tbcliente SET tbclientenombre = ?,
         tbclienteprimerapellido = ?, 
         tbclientesegundoapellido = ?,
         tbclientecorreo = ?, 
         tbclientepassword = ?, 
         tbclientefechaingreso = ?, 
         tbclienteactivo = ? 
         WHERE tbclienteid = ?"); //in this case the stmt is to avoid sql injection
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
    }*/

    public function updateTBCliente($cliente)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        // Check if the email is already registered in other records (excluding the current one)
        $checkStmt = $conn->prepare("SELECT tbclienteid FROM tbcliente WHERE tbclientecorreo = ? AND tbclienteid != ?");
        $checkStmt->bind_param("si", $cliente->getClienteCorreo(), $cliente->getClienteId());
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // The email is already registered in another record, handle this situation here
            $checkStmt->close();
            mysqli_close($conn);
            return 2; // You can return a special value or display an error message
        }

        // The email is not registered in other records, proceed with the update
        $updateStmt = $conn->prepare("UPDATE tbcliente SET tbclientenombre = ?,
         tbclienteprimerapellido = ?, 
         tbclientesegundoapellido = ?,
         tbclientecorreo = ?, 
         tbclientepassword = ?, 
         tbclientefechaingreso = ?, 
         tbclienteactivo = ? 
         WHERE tbclienteid = ?");
        $updateStmt->bind_param(
            "ssssssii", // This specifies the data type of each parameter
            $cliente->getClienteNombre(),
            $cliente->getClientePrimerApellido(),
            $cliente->getClienteSegundoApellido(),
            $cliente->getClienteCorreo(),
            $cliente->getClientePassword(),
            $cliente->getClienteFechaIngreso(),
            $cliente->getClienteActivo(),
            $cliente->getClienteId()
        );

        $result = $updateStmt->execute();

        $updateStmt->close();
        mysqli_close($conn);

        return $result;
    }



    /*public function deleteTBCliente($cliente)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8'); //set the charset to utf8
        $queryUpdate = "UPDATE tbcliente SET tbclientenombre = '" . $cliente->getClienteNombre() .
            "', tbclienteprimerapellido = '" . $cliente->getClientePrimerApellido() .
            "', tbclientesegundoapellido = '" . $cliente->getClienteSegundoApellido() .
            "', tbclientecorreo = '" . $cliente->getClienteCorreo() .
            "', tbclientepassword = '" . $cliente->getClientePassword() .
            "', tbclientefechaingreso = '" . $cliente->getClienteFechaIngreso() .
            "', tbclienteactivo = " . $cliente->getClienteActivo() .
            " WHERE tbclienteid = " . $cliente->getClienteId() . ";";

        $result = mysqli_query($conn, $queryUpdate); //execute the query and get the result
        mysqli_close($conn); //close the connection

        return $result; //return the result
    }*/

    public function deleteTBCliente($clientId)
    { // este metodo actualiza el estado del cliente para no perder el registro del mismo solo de desactiva.
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        // actualizar el valor de active a 0
        $queryUpdate = "UPDATE tbcliente SET tbclienteactivo = 0 WHERE tbclienteid = " . $clientId . ";";

        $result = mysqli_query($conn, $queryUpdate); // ejecutar la consulta y obtener el resultado
        mysqli_close($conn); // cerrar la conexión
        return $result; // devolver el resultado
    }

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
        $querySelect = "SELECT * FROM tbcliente WHERE tbclienteactivo = 1;";

        // Preparar la consulta
        $stmt = mysqli_prepare($conn, $querySelect);

        if ($stmt) {
            // Ejecutar la consulta preparada
            mysqli_stmt_execute($stmt);

            // Vincular las columnas de resultado a las variables correspondientes
            mysqli_stmt_bind_result(
                $stmt,
                $clienteid,
                $clientenombre,
                $clienteprimerapellido,
                $clientesegundoapellido,
                $clientecorreo,
                $clientepassword,
                $clientefechaingreso,
                $clienteactivo
            );

            $array = array(); // Crear un array para almacenar los resultados de la consulta preparada del mysqli_stmt_fetch

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


    public function clienteLogin($clienteCorreo, $password)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        // obtener el cliente con el correo y contraseña especificados de la base de datos y guardarlos en un objeto cliente
        $querySelect = "SELECT * FROM tbcliente WHERE (tbclientecorreo='$clienteCorreo');";
        $result = mysqli_query($conn, $querySelect); //execute the query and get the result
        mysqli_close($conn); //close the connection

        $sesion = 0; //variable para saber si el usuario esta activo o no

        while ($row = mysqli_fetch_array($result)) { //iterar todas las filas del resultado mientras haya usuarios en la base de datos
            $passcliente = $row['tbclientepassword']; //obtener la contraseña del usuario en la base de datos

            if (password_verify($password, $passcliente)) { // verificar si la contraseña ingresada es igual a la contraseña de la base de datos
                session_Start();
                $_SESSION['nombre'] = $row['tbclientenombre']; //crear una sesion con el nombre del usuario
                $_SESSION['id'] = $row['tbclienteprimerapellido']; // Almacenar el nombre de usuario en otra variable de sesión
                $_SESSION["idCliente"] = $row['tbclienteid'];// Almacenar el id de usuario en otra variable de sesión
                $sesion = 1;
            } else {
                $sesion = 0;
            }
            return $sesion;
        }
    }


    public function clienteById($clienteCorreo)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        $querySelect = "SELECT tbclienteid FROM tbcliente WHERE (tbclientecorreo='$clienteCorreo');";
        $result = mysqli_query($conn, $querySelect);
        mysqli_close($conn);

        while ($row = mysqli_fetch_array($result)) {

            return $row['tbclienteid'];
        }

        return null; // Si no se encuentra coincidencia, se retorna null
    }
}
