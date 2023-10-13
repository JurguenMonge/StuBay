<?php

include '../data/clienteDireccionData.php';

class ClienteDireccionBusiness{

    private $clienteDireccionData;

    public function __construct(){
        $this->clienteDireccionData = new ClienteDireccionData();
    }

    public function insertTBClienteDireccion($clienteDireccion){
        return $this->clienteDireccionData->insertTBClienteDireccion($clienteDireccion);
    }

    public function updateTBClienteDireccion($clienteDireccion){
        return $this->clienteDireccionData->updateTBClienteDireccion($clienteDireccion);
    }

    public function deleteTBClienteDireccion($clienteDireccion){
        return $this->clienteDireccionData->deleteTBClienteDireccion($clienteDireccion);
    }

    public function getAllTBClienteDireccion(){
        return $this->clienteDireccionData->getAllTBClienteDireccion();
    }

    public function getTBClienteDireccionByClienteId($idCliente){
        return $this->clienteDireccionData->getTBClienteDireccionByClienteId($idCliente);
    }

    public function getTBClienteDireccionByClienteIdView($idClienteDireccion){
        return $this->clienteDireccionData->getTBClienteDireccionByClienteIdView($idClienteDireccion);
    }
}