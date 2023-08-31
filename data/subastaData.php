<?php

    include_once 'data.php';
    include '../domain/subasta.php';

    class SubastaData extends Data{

        public function insertarTBSubasta($subasta) {
            $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
            $conn->set_charset('utf8');
        
            $getLastId = "SELECT MAX(tbsubastaid) AS tbsubastaid FROM tbsubasta";
            $idCont = mysqli_query($conn, $getLastId); 
            $nextId = 1;
        
            if ($row = mysqli_fetch_row($idCont)) { 
                $nextId = trim($row[0]) + 1;            
            }
        
            // Formatear fechas y horas
            $fechaHoraInicio = date('Y-m-d H:i:s', strtotime($subasta->getSubastaFechaHoraInicio()));
            $fechaHoraFinal = date('Y-m-d H:i:s', strtotime($subasta->getSubastaFechaHoraFinal()));
        
            // insert into database
            $stmt = $conn->prepare("INSERT INTO tbsubasta 
                (tbsubastaid, tbsubastaFechaHoraInicio, tbsubastaFechaHoraFinal, tbsubastaPrecio, tbsubastaActivo, tbarticuloId)
                VALUES (?,?,?,?,?,?)");
        
            $precioInicial = $subasta->getSubastaPrecioInicial();
            echo $subasta->getSubastaPrecioInicial();
            $activo = $subasta->getSubastaActivo();
            $articuloId = $subasta->getSubastaArticuloId();
        
            echo $stmt->bind_param("isssii", $nextId, $fechaHoraInicio, $fechaHoraFinal, $precioInicial, $activo, $articuloId);
        
            $stmt->execute();
            $stmt->close();
            mysqli_close($conn);
        
            return true;
        }
        
    }

?>