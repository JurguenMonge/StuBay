<?php

class SeguirSubasta{

    private $clienteId;
    private $pujaId;
    
    function __construct($clienteId, $pujaId) {
        $this->clienteId = $clienteId;
        $this->pujaId = $pujaId;
    }

    function getClienteId() {
        return $this->clienteId;
    }

    function getPujaId() {
        return $this->pujaId;
    }

    

    function setClienteId($clienteId) {
        $this->clienteId = $clienteId;
    }

    function setPujaId($pujaId) {
        $this->pujaId = $pujaId;
    }

    
}