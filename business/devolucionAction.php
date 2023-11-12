<?php

include '../business/devolucionBusiness.php';
session_start();

if (isset($_POST['create'])) {
    if(isset($_POST['clienteid']) && isset($_POST['justificacion']) && isset($_POST['subastaidview'])){
        $tbclienteid = $_POST['clienteid'];
        $justificacion = $_POST['justificacion'];
        $subastaid = $_POST['subastaidview'];
        if(strlen($tbclienteid) > 0 && strlen($justificacion) > 0 && strlen($subastaid) > 0){
            $devolucion = new Devolucion(0,$justificacion,$subastaid,$tbclienteid);
            $devolucionBusiness = new DevolucionBusiness();
            $result = $devolucionBusiness->intsertarTBIntercambio($devolucion);
            if($result == 1){
                header("location: ../view/devolucionView.php?success=insert");
                $_SESSION['msj'] = "Devolucion enviada correctamente";
                session_start();
            } else {        
                header("location: ../view/devolucionView.phperror=dbError");
                $_SESSION['msj'] = "La devolucion no fue enviada correctamente";
                session_start();
            }
        }else{
            header("location: ../view/devolucionView.php?error=emptyField");
        }
        
    }else{
        header("location: ../view/devolucionView.php?error=error");
    }
}