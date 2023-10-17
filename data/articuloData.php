<?php

include_once 'data.php';
include '../domain/articulo.php';

class ArticuloData extends Data
{

    public function insertarTBArticulo($articulo)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $getLastId = "SELECT MAX(tbarticuloid) AS tbarticuloid FROM tbarticulo";
        $idCont = mysqli_query($conn, $getLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = trim($row[0]) + 1;
        }

        // Utiliza un query parametrizado para la inserción
        $queryInsert = "INSERT INTO tbarticulo 
                       (tbarticuloid, tbarticulonombre, tbarticulomarca, tbarticulomodelo, tbarticuloserie, tbarticuloactivo, tbsubcategoriaid, tbclienteid) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la consulta
        $stmt = mysqli_prepare($conn, $queryInsert);

        if ($stmt) {
            // Asignar valores a los parámetros
            mysqli_stmt_bind_param(
                $stmt,
                "isssssii",
                $nextId,
                $articulo->getArticuloNombre(),
                $articulo->getArticuloMarca(),
                $articulo->getArticuloModelo(),
                $articulo->getArticuloSerie(),
                $articulo->getArticuloActivo(),
                $articulo->getArticuloSubCategoriaId(),
                $articulo->getClienteId()
            );

            // Ejecutar la consulta
            $result = mysqli_stmt_execute($stmt);

            // Cerrar la consulta
            mysqli_stmt_close($stmt);
        } else {
            // Error al preparar la consulta
            $result = false;
        }

        mysqli_close($conn);
        return $result;
    }


    public function updateTBArticulo($articulo)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryUpdate = "UPDATE tbarticulo SET tbarticulonombre='" . $articulo->getArticuloNombre() .
            "', tbarticulomarca='" . $articulo->getArticuloMarca() .
            "', tbarticulomodelo='" . $articulo->getArticuloModelo() .
            "', tbarticuloserie='" . $articulo->getArticuloSerie() .
            "', tbarticuloactivo='" . $articulo->getArticuloActivo() .
            "', tbsubcategoriaid='" . $articulo->getArticuloSubCategoriaId() .
            "', tbclienteid=" . $articulo->getClienteId() .
            " WHERE tbarticuloid=" . $articulo->getArticuloId() . ";";

        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);
        return $result;
    }

    public function deleteTBArticulo($articulo)
    { // este metodo actualiza el estado del cliente para no perder el registro del mismo solo de desactiva.
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryUpdate = "UPDATE tbarticulo SET tbarticulonombre='" . $articulo->getArticuloNombre() .
            "', tbarticulomarca='" . $articulo->getArticuloMarca() .
            "', tbarticulomodelo='" . $articulo->getArticuloModelo() .
            "', tbarticuloserie='" . $articulo->getArticuloSerie() .
            "', tbarticuloactivo='" . $articulo->getArticuloActivo() .
            "', tbsubcategoriaid=" . $articulo->getArticuloSubCategoriaId() .
            " WHERE tbarticuloid=" . $articulo->getArticuloId() . ";";


        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);
        return $result;
    }

    public function getAllTBArticulo()
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbarticulo WHERE tbarticuloactivo = 1;";
        $result = mysqli_query($conn, $querySelect);

        $array = array();

        while ($row = mysqli_fetch_array($result)) {
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

        mysqli_close($conn);
        return $array;
    }

    public function buscarNombres($nombre)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $nombreSeguro = mysqli_real_escape_string($conn, $nombre);
        $consulta = "SELECT tbarticulonombre FROM tbarticulo WHERE tbarticulonombre LIKE '%$nombreSeguro%' AND tbarticuloactivo = 1 LIMIT 10;";
        $resultados = $conn->query($consulta);

        $nombres = array();
        while ($fila = mysqli_fetch_array($resultados)) {
            $nombres[] = $fila['tbarticulonombre'];
        }

        mysqli_close($conn);
        return $nombres;
    }

    public function getAllTBArticuloSubastadp()
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbarticulo WHERE tbarticuloactivo = 1;";
        $result = mysqli_query($conn, $querySelect);

        $array = array();

        while ($row = mysqli_fetch_array($result)) {
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

        mysqli_close($conn);
        return $array;
    }

    public function getArticulosBySubcategoriaId($subcategoriaId){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');
    
        $querySelect = "SELECT * FROM tbarticulo WHERE tbsubcategoriaid='$subcategoriaId' && tbarticuloactivo = 1;";
    
        $result = mysqli_query($conn, $querySelect);
    
        $array = array();
    
        while ($row = mysqli_fetch_array($result)) {
            $currentArticulo = new Articulo($row['tbarticuloid'],$row['tbarticulonombre'],$row['tbarticulomarca'],$row['tbarticulomodelo']
            ,$row['tbarticuloserie'], $row['tbarticuloactivo'],$row['tbsubcategoriaid'],$row['tbclienteid']);
            array_push($array, $currentArticulo);
        }
        mysqli_close($conn);
        return $array;
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
