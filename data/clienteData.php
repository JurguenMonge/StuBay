<?php

include_once 'data.php';
include '../domain/cliente.php';
require_once '../business/subastaBusiness.php'; //this is to use the checkSubasta method

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

    public function deleteTBCliente($clienteId)
    { //este metodo actualiza el estado del cliente para no perder el registro del mismo, solo de desactiva.

        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8'); //set the charset to utf8 to support spanish characters

        $subastaBusiness = new SubastaBusiness();
        $subasta = $subastaBusiness->checkSubasta($clienteId);
        // var_dump($subasta);
        // exit();
        // echo 'subasta: '.$subasta.'<br>';
        // exit();
        if ($subasta == 1) {
            mysqli_close($conn); //close the connection
            return 2; //return 2 if the user has an active subasta
        } else {
            // update the value of active to 0
            $queryUpdate = "UPDATE tbcliente SET tbclienteactivo = 0 WHERE tbclienteid = " . $clienteId . ";";

            $result = mysqli_query($conn, $queryUpdate); // execute the query and get the result
            mysqli_close($conn); // close the connection
            return $result; // return the result
        }
    }

    /*public function deleteTBCliente($clientId) //FUNCIONA PERO NO ES OPTIMO
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $stmt = $conn->prepare("SELECT * FROM tbsubasta WHERE tbclienteid = ? AND tbsubastaActivo = 1;");
        $stmt->bind_param("i", $clientId); //to pass the parameter to the stmt and that "i" is to say that it is a string
        $stmt->execute(); //execute the statement
        $result = $stmt->get_result(); //get the result of the statement
        if (mysqli_num_rows($result) > 0) {
            $stmt->close(); //cierra el stmt
            mysqli_close($conn);
            return 2;
        } else {
            // actualizar el valor de active a 0
            $queryUpdate = "UPDATE tbcliente SET tbclienteactivo = 0 WHERE tbclienteid = " . $clientId . ";";

            $result = mysqli_query($conn, $queryUpdate); // ejecutar la consulta y obtener el resultado
            mysqli_close($conn); // cerrar la conexión
            return $result; // devolver el resultado
        }
    }*/

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
        // Conexión a la base de datos
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8'); // Establecer el conjunto de caracteres en utf8

        // Consulta preparada para obtener el cliente por correo
        $querySelect = "SELECT * FROM tbcliente WHERE tbclientecorreo = ?";

        // Prepara la consulta
        $stmt = $conn->prepare($querySelect);
        // Vincula los parámetros
        $stmt->bind_param("s", $clienteCorreo);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Obtiene el resultado
            $result = $stmt->get_result();

            // Inicializa el resultado a 0 (no encontrado)
            $resultStatus = 0;

            while ($row = $result->fetch_assoc()) {
                $passcliente = $row['tbclientepassword']; // Obtener la contraseña del cliente en la base de datos
                $clienteActivo = $row['tbclienteactivo']; // Obtener el estado del cliente

                if (password_verify($password, $passcliente)) {
                    if ($clienteActivo == 1) {
                        // El cliente está activo
                        session_start();
                        $_SESSION['nombre'] = $row['tbclientenombre'];
                        $_SESSION['apellido1'] = $row['tbclienteprimerapellido'];
                        $_SESSION['apellido2'] = $row['tbclientesegundoapellido'];
                        $_SESSION["id"] = $row['tbclienteid'];
                        $resultStatus = 1; // Éxito
                    } else {
                        // El cliente no está activo
                        $resultStatus = 3; // Cliente inactivo
                    }
                } else {
                    // Contraseña incorrecta
                    $resultStatus = 2; // Contraseña incorrecta
                }
            }

            $stmt->close();
        } else {
            // Manejar el error de ejecución de la consulta
            die("Error al ejecutar la consulta: " . $stmt->error);
        }

        $conn->close();

        return $resultStatus;
    }

    public function clienteByIdDelete($clienteId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT tbclienteid FROM tbcliente WHERE tbclienteid = ?";

        $stmt = $conn->prepare($querySelect);
        $stmt->bind_param("i", $clienteId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                // Se encontró una coincidencia, retornar el ID del cliente
                $row = $result->fetch_assoc();
                $clienteId = $row['tbclienteid'];
            } else {
                // No se encontró una coincidencia
                $clienteId = null;
            }
        } else {
            // Manejar el error de ejecución de la consulta
            $clienteId = null;
        }

        $stmt->close();
        mysqli_close($conn);

        return $clienteId;
    }


    public function clienteById($clienteCorreo) //obtener el id del cliente por medio del correo
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        $querySelect = "SELECT tbclienteid FROM tbcliente WHERE (tbclientecorreo='$clienteCorreo');"; //obtener el id del cliente por medio del correo especificado de la base de datos y guardarlo en un objeto cliente 
        $result = mysqli_query($conn, $querySelect);
        mysqli_close($conn);

        while ($row = mysqli_fetch_array($result)) {

            return $row['tbclienteid'];
        }

        return null; // Si no se encuentra coincidencia, se retorna null
    }


    public function nombreClienteById($clienteCorreo) //obtener el nombre del cliente por medio del correo
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        $querySelect = "SELECT tbclientenombre FROM tbcliente WHERE (tbclientecorreo='$clienteCorreo');"; //obtener el nombre del cliente por medio del correo especificado de la base de datos y guardarlo en un objeto cliente 
        $result = mysqli_query($conn, $querySelect);
        mysqli_close($conn);

        while ($row = mysqli_fetch_array($result)) {

            return $row['tbclientenombre'];
        }

        return null; // Si no se encuentra coincidencia, se retorna null
    }

    public function reactivarCuenta($clienteCorreo, $password)
    {
        // Conexión a la base de datos
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8'); // Establecer el conjunto de caracteres en utf8

        $resultStatus = 0;

        // Consulta preparada para obtener el cliente por correo
        $querySelect = "SELECT * FROM tbcliente WHERE tbclientecorreo = ?";

        // Prepara la consulta
        $stmt = $conn->prepare($querySelect);

        // Asigna el parámetro a la consulta preparada
        $stmt->bind_param("s", $clienteCorreo);

        // Ejecuta la consulta preparada
        if ($stmt->execute()) {
            // Obtiene el resultado
            $result = $stmt->get_result();

            // Verifica si se encontró un resultado
            if ($result->num_rows == 1) { //este result es el resultado de la consulta preparada del cliente por correo
                // Obtiene la fila del resultado
                $row = $result->fetch_assoc();

                // Verifica si el cliente está inactivo y la contraseña es válida
                if ($row['tbclienteactivo'] == 0 && password_verify($password, $row['tbclientepassword'])) {
                    // Actualiza el estado del cliente a activo
                    $queryUpdate = "UPDATE tbcliente SET tbclienteactivo = 1 WHERE tbclientecorreo = ?";
                    $stmtUpdate = $conn->prepare($queryUpdate);
                    $stmtUpdate->bind_param("s", $clienteCorreo);

                    // Ejecuta la consulta de actualización
                    if ($stmtUpdate->execute()) {
                        $resultStatus = 1; // Éxito: Cuenta reactivada
                        return $resultStatus;
                    }
                } else {
                    // La cuenta ya está activa o la contraseña es incorrecta
                    $resultStatus = 2; // Cuenta activa o contraseña incorrecta
                }
            } else {
                // No se encontró un resultado
                $resultStatus = 3; // Cuenta no encontrada
            }
        } else {
            // Manejar el error de ejecución de la consulta
            die("Error al ejecutar la consulta: " . $stmt->error);
        }

        // Cierra la conexión a la base de datos
        $conn->close();

        return $resultStatus;
    }



    public function getClientsById($clienteId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbcliente WHERE tbclienteid = ? AND tbclienteactivo = 1";

        $stmt = $conn->prepare($querySelect);
        $stmt->bind_param("i", $clienteId);

        $stmt->execute();
        $result = $stmt->get_result();

        $clients = array();

        while ($row = $result->fetch_assoc()) {
            $cliente = new Cliente(
                $row['tbclienteid'],
                $row['tbclientenombre'],
                $row['tbclienteprimerapellido'],
                $row['tbclientesegundoapellido'],
                $row['tbclientecorreo'],
                $row['tbclientepassword'],
                $row['tbclientefechaingreso'],
                $row['tbclienteactivo']
            );
            $clients[] = $cliente;
        }

        $stmt->close();
        mysqli_close($conn);

        return $clients;
    }

    public function getClientsByIdGanador($clienteId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbcliente WHERE tbclienteid = ? AND tbclienteactivo = 1";

        $stmt = $conn->prepare($querySelect);
        $stmt->bind_param("i", $clienteId);

        $stmt->execute();
        $result = $stmt->get_result();

        $cliente = null;

        while ($row = $result->fetch_assoc()) {
            $cliente = new Cliente(
                $row['tbclienteid'],
                $row['tbclientenombre'],
                $row['tbclienteprimerapellido'],
                $row['tbclientesegundoapellido'],
                $row['tbclientecorreo'],
                $row['tbclientepassword'],
                $row['tbclientefechaingreso'],
                $row['tbclienteactivo']
            );
            //$clients[] = $cliente;
        }

        $stmt->close();
        mysqli_close($conn);

        return $cliente;
    }
}
