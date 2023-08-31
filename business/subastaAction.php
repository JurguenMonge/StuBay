<?php 

include '../business/subastaBusiness.php';

if(isset($_POST['create'])){
    //Validar que lleguen los datos
    if(isset($_POST['subastaArticuloView']) && isset($_POST['subastaFechaHoraInicioView']) && isset($_POST['subastaFechaHoraFinalView']) 
        && isset($_POST['subastaPrecioInicialView'])){

            //Obtener datos
             $subastaFechaHoraInicio = $_POST['subastaFechaHoraInicioView'];
             $subastaFechaHoraFinal = $_POST['subastaFechaHoraFinalView'];
             $subastaPrecioInicial = $_POST['subastaPrecioInicialView'];
             $subastaActivo = 1;
             $subastaArticuloId = $_POST['subastaArticuloView'];
            
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
        $subastaFechaHoraInicio = $_POST['subastaFechaHoraInicioView'];
        $subastaFechaHoraFinal = $_POST['subastaFechaHoraFinalView'];
        $subastaPrecioInicial = $_POST['subastaPrecioInicialView'];
        $subastaActivo = 0;

        if(strlen($subastaId)>0 && strlen($subastaArticuloId)>0 && strlen($subastaFechaHoraInicio)>0 && strlen($subastaFechaHoraFinal)>0
        && strlen($subastaPrecioInicial)>0){
            $subasta = new Subasta(
                $subastaId,
                $subastaFechaHoraInicio,
                $subastaFechaHoraFinal, 
                $subastaPrecioInicial,
                $subastaActivo,
                $subastaArticuloId 
        );
        $subastaBusiness = new SubastaBusiness();
        $result = $subastaBusiness->deleteTBSubasta($subasta);
        if($result == 1){
            header("location: ../view/subastaView.php?success=updated");
        } else {        
            header("location: ../view/subastaView.php?error=dbError");
        }
        }else{
            header("location: ../view/subastaView.php?error=emptyField");
        }
    }
}else if($_POST['update']){
    if(isset($_POST['subastaIdView']) && isset($_POST['subastaArticuloView']) && isset($_POST['subastaFechaHoraInicioView']) && isset($_POST['subastaFechaHoraFinalView']) && 
    isset($_POST['subastaPrecioInicialView']) && isset($_POST['subastaActivoView'])){
        $subastaId = $_POST['subastaIdView'];
        $subastaArticuloId = $_POST['subastaArticuloView'];
        $subastaFechaHoraInicio = $_POST['subastaFechaHoraInicioView'];
        $subastaFechaHoraFinal = $_POST['subastaFechaHoraFinalView'];
        $subastaPrecioInicial = $_POST['subastaPrecioInicialView'];
        $subastaActivo = 1;

        if(strlen($subastaId)>0 && strlen($subastaArticuloId)>0 && strlen($subastaFechaHoraInicio)>0 && strlen($subastaFechaHoraFinal)>0
        && strlen($subastaPrecioInicial)>0){
            $subasta = new Subasta(
                $subastaId,
                $subastaFechaHoraInicio,
                $subastaFechaHoraFinal, 
                $subastaPrecioInicial,
                $subastaActivo,
                $subastaArticuloId 
        );
        $subastaBusiness = new SubastaBusiness();
        $result = $subastaBusiness->deleteTBSubasta($subasta);
        if($result == 1){
            header("location: ../view/subastaView.php?success=delete");
        } else {        
            header("location: ../view/subastaView.php?error=dbError");
        }
        }
    }
}