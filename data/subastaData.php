<?php

    include_once 'data.php';
    include '../domain/subasta.php';

    class SubastaData extends Data{

        public function insertarTBSubasta($subasta){
            $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
            $conn->set_charset('utf8');
    
            $getLastId = "SELECT MAX(tbsubastaid) AS tbsubastaid FROM tbsubasta";
            $idCont = mysqli_query($conn, $getLastId); 
            $nextId = 1;
    
            if ($row = mysqli_fetch_row($idCont)) { 
                $nextId = trim($row[0]) + 1;            
            }
    
            $queryInsert = "INSERT INTO tbsubasta VALUES (" . $nextId . ",'" .
                $subasta->getSubastaFechaHoraInicio() . "','" .
                $subasta->getSubastaFechaHoraFinal() . "','" .
                $subasta->getSubastaPrecioInicial() . "','" .
                $subasta->getSubastaActivo() . "'," .
                $subasta->getSubastaArticuloId() . ");";
    
            $result = mysqli_query($conn, $queryInsert); 
            mysqli_close($conn);
            return $result;
        }
        
        public function updateTBSubasta($subasta){
            $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
            $conn->set_charset('utf8');
    
            $queryUpdate = "UPDATE tbsubasta SET tbsubastaFechaHoraInicio='" . $subasta->getSubastaFechaHoraInicio() .
            "', tbsubastaFechaHoraFinal='" . $subasta->getSubastaFechaHoraFinal() .
            "', tbsubastaPrecio='" . $subasta->getSubastaPrecioInicial() . 
            "', tbsubastaActivo='" . $subasta->getSubastaActivo() .
            "', tbarticuloId=" . $subasta->getSubastaArticuloId() .
            " WHERE tbsubastaid=" . $subasta->getSubastaId() . ";";
    
            $result = mysqli_query($conn, $queryUpdate); 
            mysqli_close($conn); 
            return $result;  
        }
    
        public function deleteTBSubasta($subasta) {
            $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
            $conn->set_charset('utf8');
            
            $queryUpdate = "UPDATE tbsubasta SET tbsubastaFechaHoraInicio='" . $subasta->getSubastaFechaHoraInicio() .
            "', tbsubastaFechaHoraFinal='" . $subasta->getSubastaFechaHoraFinal() .
            "', tbsubastaPrecio='" . $subasta->getSubastaPrecioInicial() . 
            "', tbsubastaActivo='" . $subasta->getSubastaActivo() .
            "', tbarticuloId=" . $subasta->getSubastaArticuloId() .
            " WHERE tbsubastaid=" . $subasta->getSubastaId() . ";";
    
            
            $result = mysqli_query($conn, $queryUpdate);
            mysqli_close($conn);
            return $result;
        }

        public function getAllTBSubasta(){
            $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
            $conn->set_charset('utf8');
    
            $querySelect = "SELECT * FROM tbsubasta WHERE tbsubastaActivo = 1;";
            $result = mysqli_query($conn, $querySelect);
    
            $array = array();
    
            while ($row = mysqli_fetch_array($result)) {
                $currentSubasta = new Subasta($row['tbsubastaid'],$row['tbsubastaFechaHoraInicio'],$row['tbsubastaFechaHoraFinal'],$row['tbsubastaPrecio']
                ,$row['tbsubastaActivo'], $row['tbarticuloId']);
                array_push($array,$currentSubasta);
            }
    
            mysqli_close($conn);
            return $array;
        }
    }

?>