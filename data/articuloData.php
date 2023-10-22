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
                    (tbarticuloid, 
                    tbarticulonombre, 
                    tbarticulomarca, 
                    tbarticulomodelo, 
                    tbarticuloserie, 
                    tbarticuloactivo, 
                    tbsubcategoriaid, 
                    tbclienteid,
                    tbarticulofoto,
                    tbarticulofoto2
                    ) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la consulta
        $stmt = mysqli_prepare($conn, $queryInsert);

        if ($stmt) {
            // Asignar valores a los parámetros
            mysqli_stmt_bind_param(
                $stmt,
                "isssssiiss",
                $nextId,
                $articulo->getArticuloNombre(),
                $articulo->getArticuloMarca(),
                $articulo->getArticuloModelo(),
                $articulo->getArticuloSerie(),
                $articulo->getArticuloActivo(),
                $articulo->getArticuloSubCategoriaId(),
                $articulo->getClienteId(),
                $articulo->getArticuloFoto(),
                $articulo->getArticuloFoto2()
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


    /*public function updateTBArticulo($articulo)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');
        
        $queryUpdate = "UPDATE tbarticulo SET tbarticulonombre='" . $articulo->getArticuloNombre() .
            "', tbarticulomarca='" . $articulo->getArticuloMarca() .
            "', tbarticulomodelo='" . $articulo->getArticuloModelo() .
            "', tbarticuloserie='" . $articulo->getArticuloSerie() .
            "', tbarticuloactivo='" . $articulo->getArticuloActivo() .
            "', tbsubcategoriaid=" . $articulo->getArticuloSubCategoriaId() .
            "', tbarticulofoto=" . $articulo->getArticuloFoto() .
            " WHERE tbarticuloid=" . $articulo->getArticuloId() . ";";
        
        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);
        return $result;
    }*/
    public function updateTBArticulo($articulo)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryUpdate = "UPDATE tbarticulo SET tbarticulonombre=?, 
            tbarticulomarca=?, 
            tbarticulomodelo=?, 
            tbarticuloserie=?, 
            tbarticuloactivo=?, 
            tbsubcategoriaid=?, 
            tbarticulofoto=? ,
            tbarticulofoto2=?
            WHERE tbarticuloid=?";

        $stmt = mysqli_prepare($conn, $queryUpdate);

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "ssssisssi",
                $articulo->getArticuloNombre(),
                $articulo->getArticuloMarca(),
                $articulo->getArticuloModelo(),
                $articulo->getArticuloSerie(),
                $articulo->getArticuloActivo(),
                $articulo->getArticuloSubCategoriaId(),
                $articulo->getArticuloFoto(),
                $articulo->getArticuloFoto2(),
                $articulo->getArticuloId()
            );
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            $result = false;
        }

        mysqli_close($conn);
        return $result;
    }


    /*public function deleteTBArticulo($articulo)
    {
        require_once '../business/subastaBusiness.php'; //this is to use the checkSubasta method
        $subastaBusiness = new SubastaBusiness();
        $subasta = $subastaBusiness->checkSubastaArticulo($articulo->getArticuloId());

        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        if ($subasta == true) {
            mysqli_close($conn);
            return 8;
        } else {
            $queryUpdate = "UPDATE tbarticulo SET tbarticulonombre='" . $articulo->getArticuloNombre() .
                "', tbarticulomarca='" . $articulo->getArticuloMarca() .
                "', tbarticulomodelo='" . $articulo->getArticuloModelo() .
                "', tbarticuloserie='" . $articulo->getArticuloSerie() .
                "', tbarticuloactivo='" . $articulo->getArticuloActivo() .
                "', tbsubcategoriaid=" . $articulo->getArticuloSubCategoriaId() .
                "', tbarticulofoto=" . $articulo->getArticuloFoto() .
                " WHERE tbarticuloid=" . $articulo->getArticuloId() . ";";

            $result = mysqli_query($conn, $queryUpdate);
            mysqli_close($conn);
            return $result;
        }
    }*/
    public function deleteTBArticulo($articulo)
    {
        require_once '../business/subastaBusiness.php'; // Esto debe estar aquí si lo necesitas
        $subastaBusiness = new SubastaBusiness();

        // Verificar si el artículo está asociado a una subasta
        if ($subastaBusiness->checkSubastaArticulo($articulo->getArticuloId())) {
            return 8; // Código de error para indicar que el artículo pertenece a una subasta activa
        }

        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        // Iniciar una transacción para asegurarte de que ambas operaciones tengan éxito
        mysqli_begin_transaction($conn);

        // Utilizar una consulta SQL UPDATE para marcar el artículo como inactivo
        $queryUpdate = "UPDATE tbarticulo SET tbarticuloactivo = 0 WHERE tbarticuloid = ?";

        // Preparar la consulta
        $stmtUpdate = mysqli_prepare($conn, $queryUpdate);

        if ($stmtUpdate) {
            // Asignar el valor del ID del artículo como parámetro
            mysqli_stmt_bind_param($stmtUpdate, "i", $articulo->getArticuloId());

            // Ejecutar la consulta de actualización
            $resultUpdate = mysqli_stmt_execute($stmtUpdate);

            // Cerrar la consulta de actualización
            mysqli_stmt_close($stmtUpdate);
        } else {
            // Error al preparar la consulta de actualización
            $resultUpdate = false;
        }

        if ($resultUpdate) {
            // Confirmar la transacción
            mysqli_commit($conn);
        } else {
            // Error en la actualización del registro, realizar un rollback
            mysqli_rollback($conn);
        }

        // Cerrar la conexión
        mysqli_close($conn);

        return $resultUpdate;
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
                $row['tbclienteid'],
                $row['tbarticulofoto'],
                $row['tbarticulofoto2']
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
                $row['tbclienteid'],
                $row['tbarticulofoto'],
                $row['tbarticulofoto2']
            );
            array_push($array, $currentArticulo);
        }

        mysqli_close($conn);
        return $array;
    }

    public function getArticulosBySubcategoriaId($subcategoriaId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbarticulo WHERE tbsubcategoriaid='$subcategoriaId' && tbarticuloactivo = 1;";

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
                $row['tbclienteid'],
                $row['tbarticulofoto'],
                $row['tbarticulofoto2']
            );
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
                $row['tbclienteid'],
                $row['tbarticulofoto'],
                $row['tbarticulofoto2']
            );
            array_push($array, $currentArticulo);
        }

        // Cerrar la conexión y el stmt
        $stmt->close();
        mysqli_close($conn);

        return $array;
    }

    public function getArticuloById($id)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbarticulo WHERE tbarticuloid = ? AND tbarticuloactivo = 1";

        $stmt = mysqli_prepare($conn, $querySelect);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_array($result)) {
                $articulo = new Articulo(
                    $row['tbarticuloid'],
                    $row['tbarticulonombre'],
                    $row['tbarticulomarca'],
                    $row['tbarticulomodelo'],
                    $row['tbarticuloserie'],
                    $row['tbarticuloactivo'],
                    $row['tbsubcategoriaid'],
                    $row['tbclienteid'],
                    $row['tbarticulofoto'],
                    $row['tbarticulofoto2']
                );

                mysqli_stmt_close($stmt);
                mysqli_close($conn);

                return $articulo;
            }
        }

        mysqli_close($conn);
        return null; // Devuelve null si no se encuentra el artículo
    }
}
