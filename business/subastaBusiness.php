<?php

include '../data/subastaData.php';

class SubastaBusiness {

    private $subastaData;

    function __construct()
    {
        $this->subastaData = new SubastaData();
    }

    public function insertarTBSubasta($subasta){
        return $this->subastaData->insertarTBSubasta($subasta);
    }

    public function deleteTBSubasta($subasta){
        return $this->subastaData->deleteTBSubasta($subasta);
    }

    public function updateTBSubasta($subasta){
        return $this->subastaData->updateTBSubasta($subasta);
    }

    public function getAllTBSubasta(){
        return $this->subastaData->getAllTBSubasta();
    }

    public function getAllTBSubastaOrdenadas(){
        return $this->subastaData->getAllTBSubastaOrdenadas();
    }

    public function getAllTBSubastasTerminadas($fechaActual, $clienteId){
        return $this->subastaData->getAllTBSubastasTerminadas($fechaActual, $clienteId);
    }

    public function getTBSubastaById($subastaId){
        return $this->subastaData->getTBSubastaById($subastaId);
    }

    public function getSubastaByClienteId($clienteId){
        return $this->subastaData->getSubastaByClienteId($clienteId);
    }

    public function getTBSubastaByClienteId($articuloId){
        return $this->subastaData->getTBSubastaByClienteId($articuloId);
    }

    public function getSubastaByArticuloId($articuloId){
        return $this->subastaData->getSubastaByArticuloId($articuloId);
    }

    public function checkSubasta($clienteId){
        return $this->subastaData->checkSubasta($clienteId);
    }

    public function checkSubastaArticulo($articuloId){
        return $this->subastaData->checkSubastaArticulo($articuloId);
    }

    public function getAllSubastaByArticuloId($articuloId){
        return $this->subastaData->getAllSubastaByArticuloId($articuloId);
    }

    public function getAllTBSubastaNoActivas(){
        return $this->subastaData->getAllTBSubastaNoActivas();
    }
}