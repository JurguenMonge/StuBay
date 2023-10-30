<?php
include '../business/eventoArticuloBussiness.php';

if (isset($_POST['create'])){
    if(isset($_POST['clienteId']) && isset($_POST['articuloId'])){
        $tbclienteid = $_POST['clienteId'];
        $tbarticuloid =$_POST['articuloId'];
        if(strlen($tbclienteid) > 0 && strlen($tbarticuloid) > 0){
            $eventoArticulo = new EventoArticulo(0,$tbarticuloid,$tbclienteid);
            $eventoArticuloBussiness = new eventoArticuloBussiness();
            echo $result = $eventoArticuloBussiness->insertarTBEventoArticulo($eventoArticulo);
            if($result == 1){
                header("location: ../view/articuloView.php?success=success");
                session_start();
            } else {        
                header("location: ../view/articuloView.php?error=dbError");
                session_start();
            }
        }else{
            header("location: ../view/articuloView.php?error=emptyField");
        }
        
    }else{
        header("location: ../view/articuloView.php?error=error");
    }
}
