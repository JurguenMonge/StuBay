<?php

include_once 'data.php';
include '../domain/pujaCliente.php';

class PujaClienteData extends Data
{

    public function insertarTBPujaCliente($pujaCliente)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryGetLastId = "SELECT MAX(tbpujaclienteid) AS tbpujaclienteid FROM tbpujacliente";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = isset($row[0]) ? intval($row[0]) + 1 : 1;
        }

        $queryInsert = "INSERT INTO tbpujacliente VALUES (" . $nextId . ",'" .
            $pujaCliente->getClienteId() . "','" .
            $pujaCliente->getArticuloId() . "','" .
            $pujaCliente->getPujaClienteFecha() . "','" .
            $pujaCliente->getPujaClienteOferta() . "'," .
            $pujaCliente->getPujaClienteEnvio() . ");";

        $result = mysqli_query($conn, $queryInsert);
        mysqli_close($conn);
        return $result;
    }

    public function actualizarTBPujaCliente($pujaCliente)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8');
        $queryUpdate = "UPDATE tbpujacliente SET tbclienteid = '" . $pujaCliente->getClienteId() .
            "', tbarticuloid = '" . $pujaCliente->getArticuloId() .
            "', tbpujaclientefecha = '" . $pujaCliente->getPujaClienteFecha() .
            "', tbpujaclienteoferta = '" . $pujaCliente->getPujaClienteOferta() .
            "', tbpujaclienteenvio = " . $pujaCliente->getPujaClienteEnvio() .
            " WHERE tbpujaclienteid = " . $pujaCliente->getPujaClienteId() . ";";

        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);

        return $result;
    }

    public function eliminarTBPujaCliente($pujaCliente)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');
        $queryUpdate = "DELETE FROM tbpujacliente WHERE tbpujaclienteid=" . $pujaCliente->getPujaClienteId() . ";";
        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);

        return $result;
    }

    public function getAllTBPujaCliente()
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        $querySelect = "SELECT * FROM tbpujacliente;";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $array = array(); // declarar el array

        // recorrer el resultado y llenar el array
        while ($row = mysqli_fetch_array($result)) {
            $currentPujaCliente = new PujaCliente($row['tbpujaclienteid'], $row['tbclienteid'], $row['tbarticuloid'], $row['tbpujaclientefecha'], $row['tbpujaclienteoferta'], $row['tbpujaclienteenvio']);
            array_push($array, $currentPujaCliente);
        }

        mysqli_close($conn); // cerrar la conexión
        return $array; // devolver el array
    }

    public function getTBPujaClienteById($clienteId)
    { //Obtiene todas las pujas de un cliente específico por su id de cliente (tbclienteid)
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbpujacliente WHERE tbclienteid = ?";

        $stmt = $conn->prepare($querySelect);
        $stmt->bind_param("i", $clienteId);
        $stmt->execute();

        $result = $stmt->get_result();

        $array = array();

        while ($row = $result->fetch_assoc()) {
            $pujaCliente = new PujaCliente(
                $row['tbpujaclienteid'],
                $row['tbclienteid'],
                $row['tbarticuloid'],
                $row['tbpujaclientefecha'],
                $row['tbpujaclienteoferta'],
                $row['tbpujaclienteenvio']
            );
            array_push($array, $pujaCliente);
        }

        $stmt->close();
        mysqli_close($conn);

        return $array;
    }

    public function obtenerInformacionCompras($clienteId, $articuloId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        // Obtener la cantidad y monto total de compras en los últimos 30 días
        $queryCompras = "SELECT COUNT(*) AS cantidadCompras, SUM(tbpujaclienteoferta) AS montoCompras
                     FROM tbpujacliente
                     WHERE tbclienteid = ? AND tbarticuloid = ? AND tbpujaclientefecha >= DATE_SUB(NOW(), INTERVAL 30 DAY)";

        $stmtCompras = $conn->prepare($queryCompras);
        $stmtCompras->bind_param("ii", $clienteId, $articuloId);
        $stmtCompras->execute();
        $resultCompras = $stmtCompras->get_result();

        $compras = $resultCompras->fetch_assoc();
        $cantidadCompras = $compras['cantidadCompras'];
        $montoCompras = $compras['montoCompras'];

        $stmtCompras->close();

        // Obtener la última compra del cliente en los últimos 30 días
        $queryUltimaCompra = "SELECT MAX(tbpujaclientefecha) AS ultimaCompra
                          FROM tbpujacliente
                          WHERE tbclienteid = ? AND tbpujaclientefecha >= DATE_SUB(NOW(), INTERVAL 30 DAY)";

        $stmtUltimaCompra = $conn->prepare($queryUltimaCompra);
        $stmtUltimaCompra->bind_param("i", $clienteId);
        $stmtUltimaCompra->execute();
        $resultUltimaCompra = $stmtUltimaCompra->get_result();

        $ultimaCompra = $resultUltimaCompra->fetch_assoc()['ultimaCompra'];
        $stmtUltimaCompra->close();

        // Calcular la frecuencia de compra en los últimos 30 días
        $frecuenciaCompra = null;

        if ($ultimaCompra) {
            $fechaActual = new DateTime();
            $fechaUltimaCompra = new DateTime($ultimaCompra);
            $diferencia = $fechaActual->diff($fechaUltimaCompra);
            $frecuenciaCompra = $diferencia->days;
        }

        // Obtener el promedio de todas las compras en los últimos 30 días
        $queryPromedioCompras = "SELECT AVG(tbpujaclienteoferta) AS promedioCompras
                             FROM tbpujacliente
                             WHERE tbpujaclientefecha >= DATE_SUB(NOW(), INTERVAL 30 DAY)";

        $stmtPromedioCompras = $conn->prepare($queryPromedioCompras);
        $stmtPromedioCompras->execute();
        $resultPromedioCompras = $stmtPromedioCompras->get_result();

        $promedioCompras = $resultPromedioCompras->fetch_assoc()['promedioCompras'];
        $stmtPromedioCompras->close();

        mysqli_close($conn);

        return [
            'cantidadCompras' => $cantidadCompras,
            'montoCompras' => $montoCompras,
            'frecuenciaCompra' => $frecuenciaCompra,
            'promedioCompras' => $promedioCompras,
        ];
    }




    public function getTBPujaClienteByArticulo($articuloId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT * FROM tbpujacliente WHERE tbarticuloid = ?";

        $stmt = $conn->prepare($querySelect);
        $stmt->bind_param("i", $articuloId);
        $stmt->execute();

        $result = $stmt->get_result();

        $array = array();

        while ($row = $result->fetch_assoc()) {
            $pujaCliente = new PujaCliente(
                $row['tbpujaclienteid'],
                $row['tbclienteid'],
                $row['tbarticuloid'],
                $row['tbpujaclientefecha'],
                $row['tbpujaclienteoferta'],
                $row['tbpujaclienteenvio']
            );
            array_push($array, $pujaCliente);
        }

        $stmt->close();
        mysqli_close($conn);

        return $array;
    }



    public function getPrecioMaximoByArticuloId($articuloId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        // Modificar la consulta SQL para obtener el precio máximo de puja
        $querySelect = "SELECT MAX(tbpujaclienteoferta) AS precioMaximo FROM tbpujacliente WHERE tbarticuloid = " . $articuloId . ";";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $precioMaximo = 0; // Inicializa el precio máximo en 0

        if ($row = mysqli_fetch_assoc($result)) {
            $precioMaximo = $row['precioMaximo'];
        }

        mysqli_close($conn); // cerrar la conexión
        return $precioMaximo;
    }

    public function getTBPujaClienteGanador($articuloId)
    { //Obtiene la puja ganadora de un artículo específico por su id de artículo (tbarticuloid)
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT pc.* 
                    FROM tbpujacliente pc
                    WHERE pc.tbarticuloid = ?
                    AND pc.tbpujaclienteoferta = (
                        SELECT MAX(tbpujaclienteoferta) 
                        FROM tbpujacliente 
                        WHERE tbarticuloid = ?
                    )";

        $stmt = $conn->prepare($querySelect);
        $stmt->bind_param("ii", $articuloId, $articuloId);
        $stmt->execute();

        $result = $stmt->get_result();

        $array = array();

        while ($row = $result->fetch_assoc()) {
            $pujaCliente = new PujaCliente(
                $row['tbpujaclienteid'],
                $row['tbclienteid'],
                $row['tbarticuloid'],
                $row['tbpujaclientefecha'],
                $row['tbpujaclienteoferta'],
                $row['tbpujaclienteenvio']
            );
            array_push($array, $pujaCliente);
        }

        $stmt->close();
        mysqli_close($conn);

        return $array;
    }

    public function getTBPujaClienteGanadorById($clienteId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT pc.* 
                    FROM tbpujacliente pc
                    WHERE pc.tbclienteid = ?
                    AND pc.tbpujaclienteoferta = (
                        SELECT MAX(tbpujaclienteoferta) 
                        FROM tbpujacliente 
                        WHERE tbclienteid = ?
                    )";

        $stmt = $conn->prepare($querySelect);
        $stmt->bind_param("ii", $clienteId, $clienteId);
        $stmt->execute();

        $result = $stmt->get_result();

        $array = array();

        while ($row = $result->fetch_assoc()) {
            $pujaCliente = new PujaCliente(
                $row['tbpujaclienteid'],
                $row['tbclienteid'],
                $row['tbarticuloid'],
                $row['tbpujaclientefecha'],
                $row['tbpujaclienteoferta'],
                $row['tbpujaclienteenvio']
            );
            array_push($array, $pujaCliente);
        }

        $stmt->close();
        mysqli_close($conn);

        return $array;
    }

    public function getPujaClienteGanador($articuloId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        // Validación y limpieza del valor de entrada
        $articuloId = mysqli_real_escape_string($conn, $articuloId);

        $querySelect = "SELECT pc.* 
        FROM tbpujacliente pc
        WHERE pc.tbarticuloid = " . $articuloId . "
        AND pc.tbpujaclienteoferta = (
            SELECT MAX(tbpujaclienteoferta) 
            FROM tbpujacliente 
            WHERE tbarticuloid = " . $articuloId . "
        )";

        $result = mysqli_query($conn, $querySelect);

        if ($result) {
            // Verificar si se obtuvieron resultados
            if ($row = $result->fetch_assoc()) {
                $pujaCliente = new PujaCliente(
                    $row['tbpujaclienteid'],
                    $row['tbclienteid'],
                    $row['tbarticuloid'],
                    $row['tbpujaclientefecha'],
                    $row['tbpujaclienteoferta'],
                    $row['tbpujaclienteenvio']
                );
            } else {
                // No se encontraron resultados
                $pujaCliente = null; // Otra opción podría ser lanzar una excepción
            }
        } else {
            // Error al ejecutar la consulta
            $pujaCliente = null; // Otra opción podría ser lanzar una excepción
        }

        mysqli_close($conn);
        return $pujaCliente;
    }
}
