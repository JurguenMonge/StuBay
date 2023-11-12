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


    public function getIntercambiosByCliente($clienteid){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }
    
        $conn->set_charset('utf8');
        
        $querySelect = "SELECT * FROM tbintercambio WHERE tbvendedorid = " . $clienteid . " AND compradoractivo = 1 AND vendedoractivo = 0";
    
        $result = mysqli_query($conn, $querySelect);
    
        if (!$result) {
            die("Error en la consulta: " . mysqli_error($conn));
        }
    
        $intercambios = array();
    
        while ($row = mysqli_fetch_assoc($result)) {
            $intercambio = new Intercambio(
                $row['tbintercambioid'],
                $row['tbarticuloid'],
                $row['tbvendedorid'],
                $row['tbclienteid'],
                $row['tbsubastaid'],
                $row['compradoractivo'],
                $row['vendedoractivo']
            );
            $intercambios[] = $intercambio;
        }
    
        mysqli_close($conn);
    
        return $intercambios;
    }

    public function getIntercambiosRechazadosByCliente($clienteid){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }
    
        $conn->set_charset('utf8');
        
        $querySelect = "SELECT * FROM tbintercambio WHERE tbclienteid = " . $clienteid . " AND compradoractivo = 0 AND vendedoractivo = 1";
    
        $result = mysqli_query($conn, $querySelect);
    
        if (!$result) {
            die("Error en la consulta: " . mysqli_error($conn));
        }
    
        $intercambios = array();
    
        while ($row = mysqli_fetch_assoc($result)) {
            $intercambio = new Intercambio(
                $row['tbintercambioid'],
                $row['tbarticuloid'],
                $row['tbvendedorid'],
                $row['tbclienteid'],
                $row['tbsubastaid'],
                $row['compradoractivo'],
                $row['vendedoractivo']
            );
            $intercambios[] = $intercambio;
        }
    
        mysqli_close($conn);
    
        return $intercambios;
    }

    public function getIntercambiosAceptadosByCliente($clienteid){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }
    
        $conn->set_charset('utf8');
        
        $querySelect = "SELECT * FROM tbintercambio WHERE tbclienteid = " . $clienteid . " AND compradoractivo = 1 AND vendedoractivo = 1";
    
        $result = mysqli_query($conn, $querySelect);
    
        if (!$result) {
            die("Error en la consulta: " . mysqli_error($conn));
        }
    
        $intercambios = array();
    
        while ($row = mysqli_fetch_assoc($result)) {
            $intercambio = new Intercambio(
                $row['tbintercambioid'],
                $row['tbarticuloid'],
                $row['tbvendedorid'],
                $row['tbclienteid'],
                $row['tbsubastaid'],
                $row['compradoractivo'],
                $row['vendedoractivo']
            );
            $intercambios[] = $intercambio;
        }
    
        mysqli_close($conn);
    
        return $intercambios;
    }
    

    public function aceptarIntercambio($intercambioid){
        
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryUpdate = "UPDATE tbintercambio SET vendedoractivo = 1 WHERE tbintercambioid =" . $intercambioid . ";";

        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);
        return $result;
    
    }

    public function rechazarIntercambio($intercambioid){
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryUpdate = "UPDATE tbintercambio 
        SET vendedoractivo = 1, compradoractivo = 0
        WHERE tbintercambioid = " . $intercambioid . ";";

        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);
        return $result;
    }
}
