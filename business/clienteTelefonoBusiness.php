<?php

include '../data/clienteTelefonoData.php';

class ClienteTelefonoBusiness{


    private $clienteTelefonoData;

    public function __construct(){
        $this->clienteTelefonoData = new ClienteTelefonoData();
    }

    public function insertTBClienteTelefono($clienteTelefono){
        return $this->clienteTelefonoData->insertTBClienteTelefono($clienteTelefono);
    }

    public function updateTBClienteTelefono($clienteTelefono){
        return $this->clienteTelefonoData->updateTBClienteTelefono($clienteTelefono);
    }

    public function deleteTBClienteTelefono($clienteTelefono){
        return $this->clienteTelefonoData->deleteTBClienteTelefono($clienteTelefono);
    }

    public function getAllTBClienteTelefono(){
        return $this->clienteTelefonoData->getAllTBClienteTelefono();
    }

    

}