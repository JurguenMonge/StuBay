<?php

include '../data/calificacionVendedorData.php';

class CalificacionVendedorBusiness{

    private $calificacionVendedorData;

    public function __construct(){
        $this->calificacionVendedorData = new CalificacionVendedorData();//aca se crea el objeto de Data
    }

    public function insertTBCalificacionVendedor($calificacionVendedor){
        return $this->calificacionVendedorData->insertTBCalificacionVendedor($calificacionVendedor);//
    }

    public function updateTBCalificacionVendedor($calificacionVendedor){
        return $this->calificacionVendedorData->updateTBCalificacionVendedor($calificacionVendedor);
    }

    public function deleteTBCalificacionVendedor($calificacionVendedor){
        return $this->calificacionVendedorData->deleteTBCalificacionVendedor($calificacionVendedor);
    }

    public function getAllTBCalificacionVendedor(){
        return $this->calificacionVendedorData->getAllTBCalificacionVendedor();
    }

    public function getClienteById($calificacionVendedorId){
        return $this->calificacionVendedorData->getClienteById($calificacionVendedorId);
    }

    public function getCalificacionVendedorClienteById($calificacionVendedorId)
    {
        return $this->calificacionVendedorData->getCalificacionVendedorClienteById($calificacionVendedorId);
    }
    
}