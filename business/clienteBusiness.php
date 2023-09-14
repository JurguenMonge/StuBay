<?php

include '../data/clienteData.php';

class ClienteBusiness{

    private $clienteData;

    public function __construct(){
        $this->clienteData = new ClienteData();
    }

    public function insertTBCliente($cliente){
        return $this->clienteData->insertTBCliente($cliente);
    }

    public function updateTBCliente($cliente){
        return $this->clienteData->updateTBCliente($cliente);
    }

    public function deleteTBCliente($cliente){
        return $this->clienteData->deleteTBCliente($cliente);
    }
    

    public function getAllTBCliente(){
        return $this->clienteData->getAllTBCliente();
    }

    public function clienteById($clienteCorreo){
        return $this->clienteData->clienteById($clienteCorreo);
    }

    public function clienteLogin($clienteCorreo, $clientePassword){
        return $this->clienteData->clienteLogin($clienteCorreo, $clientePassword);
    }
    
}