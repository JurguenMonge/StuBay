<?php
include_once 'data.php';
include '../domain/devolucion.php';

class DevolucionData extends Data
{

    public function insertarTBDevolucion($devolucion)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $getLastId = "SELECT MAX(tbdevolucionid) AS tbdevolucionid FROM tbdevolucion";
        $idCont = mysqli_query($conn, $getLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = trim($row[0]) + 1;
        }

        // Utiliza un query parametrizado para la inserción
        $queryInsert = "INSERT INTO tbdevolucion 
                        (tbdevolucionid, 
                        tbdevolucionjustificacion, 
                        tbsubastaid, 
                        tbclienteid
                        ) 
                        VALUES (?, ?, ?, ?)";

        // Preparar la consulta
        $stmt = mysqli_prepare($conn, $queryInsert);

        if ($stmt) {
            // Asignar valores a los parámetros
            mysqli_stmt_bind_param(
                $stmt,
                "isii",
                $nextId,
                $devolucion->getTbdevolucionjustificacion(),
                $devolucion->getTbsubastaid(),
                $devolucion->getTbclienteid()
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

    public function getCantidadDevolucionesPorClienteYSubasta($idCliente, $subastaId)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $querySelect = "SELECT COUNT(*) AS cantidadDevoluciones FROM tbdevolucion 
                    WHERE tbclienteid = ? AND tbsubastaid = ?";

        $stmt = mysqli_prepare($conn, $querySelect);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ii", $idCliente, $subastaId);

            mysqli_stmt_execute($stmt);

            mysqli_stmt_bind_result($stmt, $cantidadDevoluciones);

            mysqli_stmt_fetch($stmt);

            mysqli_stmt_close($stmt);
        } else {
            $cantidadDevoluciones = 0;
        }

        mysqli_close($conn);
        return $cantidadDevoluciones;
    }
}
