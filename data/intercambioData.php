<?php
include_once 'data.php';
include '../domain/intercambio.php';

class IntercambioData extends Data {

    public function insertarTBIntercambio($intercambio){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        $conn->set_charset('utf8');

        $queryGetLastId = "SELECT MAX(tbintercambioid) AS tbintercambioid FROM tbintercambio";
        $idCont = mysqli_query($conn, $queryGetLastId);

        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = isset($row[0]) ? intval($row[0]) + 1 : 1;
        }

        $queryInsert = "INSERT INTO tbintercambio(tbintercambioid, tbarticuloid, tbvendedorid, tbclienteid, tbsubastaid, compradoractivo, vendedoractivo) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $queryInsert);

        if (!$stmt) {
            die("Error en la preparación de la sentencia: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param(
            $stmt,
            'isssiii',
            $nextId,
            $intercambio->getArticulo(),
            $intercambio->getVendedor(),
            $intercambio->getComprador(),
            $intercambio->getSubasta(),
            $intercambio->getCompradorActivo(),
            $intercambio->getVendedorActivo()
        );

        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            die("Error en la ejecución de la sentencia: " . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        return $result;
    }
}
