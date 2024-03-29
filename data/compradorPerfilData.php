<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once 'data.php';
include '../domain/compradorPerfil.php';

class CompradorPerfilData extends Data
{

    public function insertarTBCompradorPerfil($compradorPerfil)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryGetLastId = "SELECT MAX(tbcompradorperfilid) AS tbcompradorperfilid FROM tbcompradorperfil";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = isset($row[0]) ? intval($row[0]) + 1 : 1;
        }


        $queryInsert = "INSERT INTO tbcompradorperfil(tbcompradorperfildevolucion, tbcompradorperfilfrecuencia, tbcompradorperfilmontocompra, tbcompradorperfilcantidadcompra, tbcompradorid) VALUES ('" .
            $compradorPerfil->getDevolucion() . "','" .
            $compradorPerfil->getFrecuenciaCompra() . "','" .
            $compradorPerfil->getMontoCompra() . "','" .
            $compradorPerfil->getCantidadCompra() . "'," .
            $compradorPerfil->getIdComprador() . ");";

        $result = mysqli_query($conn, $queryInsert);
        mysqli_close($conn);
        return $result;
    }

    public function actualizarTBCompradorPerfil($compradorPerfil)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8');
        $queryUpdate = "UPDATE tbcompradorperfil SET tbcompradorperfildevolucion = '" . $compradorPerfil->getDevolucion() .
            "', tbcompradorperfilfrecuencia = '" . $compradorPerfil->getFrecuenciaCompra() .
            "', tbcompradorperfilmontocompra = '" . $compradorPerfil->getMontoCompra() .
            "', tbcompradorperfilcantidadcompra = '" . $compradorPerfil->getCantidadCompra() .
            "', tbcompradorid = " . $compradorPerfil->getIdComprador() .
            " WHERE tbcompradorperfilid = " . $compradorPerfil->getIdCompradorPerfil() . ";";

        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);

        return $result;
    }

    public function actualizarTBCompradorPerfilById($compradorPerfil)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8');
        $queryUpdate = "UPDATE tbcompradorperfil SET tbcompradorperfildevolucion = '" . $compradorPerfil->getDevolucion() .
            "', tbcompradorperfilfrecuencia = '" . $compradorPerfil->getFrecuenciaCompra() .
            "', tbcompradorperfilmontocompra = '" . $compradorPerfil->getMontoCompra() .
            "', tbcompradorperfilcantidadcompra = " . $compradorPerfil->getCantidadCompra() .
            " WHERE tbcompradorid = " . $compradorPerfil->getIdComprador() . ";";

        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);

        return $result;
    }

    public function eliminarTBCompradorPerfil($compradorPerfilid)
    { // este metodo actualiza el estado del cliente para no perder el registro del mismo solo de desactiva.
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        // actualizar el valor de active a 0
        $queryUpdate = "DELETE  FROM tbcompradorperfil WHERE tbcompradorperfilid = " . $compradorPerfilid . ";";

        $result = mysqli_query($conn, $queryUpdate); // ejecutar la consulta y obtener el resultado
        mysqli_close($conn); // cerrar la conexión
        return $result;
    }

    public function getAllTBCompradorPerfil()
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        $querySelect = "SELECT * FROM tbcompradorperfil;";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $array = array(); // declarar el array

        // recorrer el resultado y llenar el array
        while ($row = mysqli_fetch_array($result)) {
            $currentCompradorPerfil = new CompradorPerfil($row['tbcompradorperfilid'], $row['tbcompradorperfildevolucion'], $row['tbcompradorperfilfrecuencia'], $row['tbcompradorperfilmontocompra'], $row['tbcompradorperfilcantidadcompra'], $row['tbcompradorid']);
            array_push($array, $currentCompradorPerfil);
        }

        mysqli_close($conn); // cerrar la conexión
        return $array; // devolver el array
    }

    public function existeCompradorPerfil($idComprador)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        // Consulta para verificar si existe un comprador con el ID dado en tbcompradorperfil
        $querySelect = "SELECT COUNT(*) AS count FROM tbcompradorperfil WHERE tbcompradorid = $idComprador";

        $result = mysqli_query($conn, $querySelect);

        // Verificar si la consulta se ejecutó correctamente
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $count = $row['count'];

            mysqli_close($conn);

            // Si count es mayor que 0, significa que existe un comprador con ese ID en tbcompradorperfil
            return $count > 0;
        } else {
            // Si hay un error en la consulta, puedes manejarlo según tus necesidades (lanzar una excepción, devolver false, etc.)
            mysqli_close($conn);
            return false;
        }
    }


    public function getTBCompradorPerfilById($id)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        // obtener el estudiante con el id especificado de la base de datos y guardarlos en un objeto estudiante
        $querySelect = "SELECT * FROM tbcompradorperfil WHERE tbcompradorperfilid = " . $id . ";";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $compradorPerfil = null;

        // si se obtuvo un resultado, llenar el objeto estudiante
        if ($row = mysqli_fetch_array($result)) {
            $compradorPerfil = new CompradorPerfil($row['tbcompradorperfilid'], $row['tbcompradorperfildevolucion'], $row['tbcompradorperfilfrecuencia'], $row['tbcompradorperfilmontocompra'], $row['tbcompradorperfilcantidadcompra'], $row['tbcompradorid']);
        }

        mysqli_close($conn); // cerrar la conexión
        return $compradorPerfil;
    }
}
