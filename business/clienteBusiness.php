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

    public function clienteByIdDelete($clienteId){
        return $this->clienteData->clienteByIdDelete($clienteId);
    }

    public function clienteById($clienteCorreo){//aca se recibe el correo del cliente para buscarlo en la base de datos y retornar el cliente con todos sus datos 
        return $this->clienteData->clienteById($clienteCorreo);
    }

    public function clienteLogin($clienteCorreo, $clientePassword){//aca se recibe el correo y la contraseña del cliente para buscarlo en la base de datos y retornar el cliente con todos sus datos
        return $this->clienteData->clienteLogin($clienteCorreo, $clientePassword);
    }

    public function nombreClienteById($clienteCorreo){//aca se recibe el correo del cliente para buscarlo en la base de datos y retornar el cliente con todos sus datos 
        return $this->clienteData->nombreClienteById($clienteCorreo);
    }
    
    public function reactivarCuenta($clienteCorreo, $clientePassword){//aca se recibe el correo y la contraseña del cliente para buscarlo en la base de datos y retornar el cliente con todos sus datos
        return $this->clienteData->reactivarCuenta($clienteCorreo, $clientePassword);
    }

    // public function desactivarCuenta($clienteCorreo, $clientePassword){//aca se recibe el correo y la contraseña del cliente para buscarlo en la base de datos y retornar el cliente con todos sus datos
    //     return $this->clienteData->desactivarCuenta($clienteCorreo, $clientePassword);
    // }

    public function getClientsById($clienteCorreo){
        return $this->clienteData->getClientsById($clienteCorreo);
    }

    public function getClientsByIdGanador($clienteId){
        return $this->clienteData->getClientsByIdGanador($clienteId);
    }
}