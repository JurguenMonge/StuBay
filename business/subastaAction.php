<?php 

include '../business/subastaBusiness.php';

if(isset($_POST['create'])){
    //Validar que lleguen los datos
    if(isset($_POST['subastaArticuloView']) && isset($_POST['subastaFechaHoraInicioView']) && isset($_POST['subastaFechaHoraFinalView']) 
        && isset($_POST['subastaPrecioInicialView'])){

            //Obtener datos
            echo $subastaFechaHoraInicio = $_POST['subastaFechaHoraInicioView'];
            echo $subastaFechaHoraFinal = $_POST['subastaFechaHoraFinalView'];
            echo $subastaPrecioInicial = $_POST['subastaPrecioInicialView'];
            echo $subastaActivo = 1;
            echo $subastaArticuloId = $_POST['subastaArticuloView'];
            
            //Validar que contengan datos
            if(strlen($subastaFechaHoraInicio)>0 && strlen($subastaFechaHoraFinal)>0 && strlen($subastaPrecioInicial)>0
            && strlen($subastaArticuloId)>0){
                $subasta = new Subasta(
                    0,
                    $subastaFechaHoraInicio,
                    $subastaFechaHoraFinal,
                    $subastaPrecioInicial,
                    $subastaActivo,
                    $subastaArticuloId
                );
                $subastaBusiness = new SubastaBusiness();
                $result = $subastaBusiness->insertarTBSubasta($subasta);
                if ($result == 1) { 
                    header("location: ../index.php?success=insert"); 
                } else {
                    header("location: ../index.php?error=dbError"); 
                }
            } else {
                header("location: ../index.php?error=emptyField"); 
            }
    } else {
        header("location: ../index.php?error=error"); 
    }
}else if($_POST['delete']){
    if(isset($_POST['subastaIdView']) && isset($_POST['subastaArticuloView']) && isset($_POST['subastaFechaHoraInicioView']) && isset($_POST['subastaFechaHoraFinalView']) && 
    isset($_POST['subastaPrecioInicialView']) && isset($_POST['subastaActivoView'])){
        $subastaId = $_POST['subastaIdView'];
        $subastaArticuloId = $_POST['subastaArticuloView'];
        $subastaFechaHoraInicio = $_POST[''];
    }
}