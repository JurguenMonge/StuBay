<?php
include_once 'data.php';
include '../domain/intercambioVuelto.php';

class IntercambioVueltoData extends Data {

    public function insertarTBIntercambioVuelto($intercambioVuelto){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        $conn->set_charset('utf8');

        $queryGetLastId = "SELECT MAX(tbintercambiovueltoid) AS tbintercambiovueltoid FROM tbintercambiovuelto";
        $idCont = mysqli_query($conn, $queryGetLastId);

        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = isset($row[0]) ? intval($row[0]) + 1 : 1;
        }

        $queryInsert = "INSERT INTO tbintercambiovuelto(
                                    tbintercambiovueltoid, 
                                    tbarticuloid, 
                                    tbvendedorid, 
                                    tbclienteid, 
                                    tbsubastaid, 
                                    tbintercambiovueltodinero, 
                                    tbintercambiovueltocompradoractivo, 
                                    tbintercambiovueltovendedoractivo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $queryInsert);

        if (!$stmt) {
            die("Error en la preparación de la sentencia: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param(
            $stmt,
            'isssiiii',
            $nextId,
            $intercambioVuelto->getArticulo(),
            $intercambioVuelto->getVendedor(),
            $intercambioVuelto->getComprador(),
            $intercambioVuelto->getSubasta(),
            $intercambioVuelto->getIntercambioVueltoDinero(),
            $intercambioVuelto->getIntercambioVueltoCompradorActivo(),
            $intercambioVuelto->getIntercambioVueltoVendedorActivo()
        );

        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            die("Error en la ejecución de la sentencia: " . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        return $result;
    }


    public function getIntercambiosVueltoByCliente($clienteid){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }
    
        $conn->set_charset('utf8');
        
        $querySelect = "SELECT * FROM tbintercambiovuelto 
        WHERE tbvendedorid = " . $clienteid . " 
        AND tbintercambiovueltocompradoractivo = 1 AND tbintercambiovueltovendedoractivo = 0";

        $result = mysqli_query($conn, $querySelect);

        if (!$result) {
            die("Error en la ejecución de la sentencia: " . mysqli_error($conn));
        }

        $intercambiosVuelto = array();

        while ($row = mysqli_fetch_assoc($result)){
            $intercambioVuelto = new IntercambioVuelto(
                $row['tbintercambiovueltoid'],
                $row['tbarticuloid'],
                $row['tbvendedorid'],
                $row['tbclienteid'],
                $row['tbsubastaid'],
                $row['tbintercambiovueltodinero'],
                $row['tbintercambiovueltocompradoractivo'],
                $row['tbintercambiovueltovendedoractivo']
            );
            $intercambiosVuelto[] = $intercambioVuelto;
        }

        mysqli_close($conn);

        return $intercambiosVuelto;
    }

    public function getIntercambiosVueltoRechazadosByCliente($clienteid){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }
    
        $conn->set_charset('utf8');
        
        $querySelect = "SELECT * FROM tbintercambiovuelto WHERE tbclienteid = " . $clienteid . " AND tbintercambiovueltocompradoractivo = 0 AND tbintercambiovueltovendedoractivo = 1";

        $result = mysqli_query($conn, $querySelect);

        if (!$result) {
            die("Error en la ejecución de la sentencia: " . mysqli_error($conn));
        }

        $intercambiosVuelto = array();

        while ($row = mysqli_fetch_assoc($result)){
            $intercambioVuelto = new IntercambioVuelto(
                $row['tbintercambiovueltoid'],
                $row['tbarticuloid'],
                $row['tbvendedorid'],
                $row['tbclienteid'],
                $row['tbsubastaid'],
                $row['tbintercambiovueltodinero'],
                $row['tbintercambiovueltocompradoractivo'],
                $row['tbintercambiovueltovendedoractivo']
            );
            $intercambiosVuelto[] = $intercambioVuelto;
        }

        mysqli_close($conn);

        return $intercambiosVuelto;
    }

    public function getIntercambiosVueltoAceptadosByCliente($clienteid){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }
    
        $conn->set_charset('utf8');
        
        $querySelect = "SELECT * FROM tbintercambiovuelto WHERE tbclienteid = " . $clienteid . " AND tbintercambiovueltocompradoractivo = 1 AND tbintercambiovueltovendedoractivo = 1";

        $result = mysqli_query($conn, $querySelect);

        if (!$result) {
            die("Error en la ejecución de la sentencia: " . mysqli_error($conn));
        }

        $intercambiosVuelto = array();

        while ($row = mysqli_fetch_assoc($result)){
            $intercambioVuelto = new IntercambioVuelto(
                $row['tbintercambiovueltoid'],
                $row['tbarticuloid'],
                $row['tbvendedorid'],
                $row['tbclienteid'],
                $row['tbsubastaid'],
                $row['tbintercambiovueltodinero'],
                $row['tbintercambiovueltocompradoractivo'],
                $row['tbintercambiovueltovendedoractivo']
            );
            $intercambiosVuelto[] = $intercambioVuelto;
        }

        mysqli_close($conn);

        return $intercambiosVuelto;
    }

    public function aceptarIntercambioVuelto($intercambioVueltoId){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        $conn->set_charset('utf8');

        $queryUpdate = "UPDATE tbintercambiovuelto SET tbintercambiovueltovendedoractivo = 1 WHERE tbintercambiovueltoid = " . $intercambioVueltoId;

        $result = mysqli_query($conn, $queryUpdate);

        if (!$result) {
            die("Error en la ejecución de la sentencia: " . mysqli_error($conn));
        }

        mysqli_close($conn);

        return $result;
    }

    public function rechazarIntercambioVuelto($intercambioVueltoId){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        $conn->set_charset('utf8');

        $queryUpdate = "UPDATE tbintercambiovuelto 
        SET tbintercambiovueltovendedoractivo = 1, tbintercambiovueltocompradoractivo = 0 
        WHERE tbintercambiovueltoid = " . $intercambioVueltoId;

        $result = mysqli_query($conn, $queryUpdate);

        if (!$result) {
            die("Error en la ejecución de la sentencia: " . mysqli_error($conn));
        }

        mysqli_close($conn);

        return $result;
    }
}