<?php

class ClienteDireccion{

    private $clienteDireccionId;
    private $clienteId;
    private $clienteDireccionBarrio;
    private $clienteDireccionCoordenadaGps;

    function __construct($clienteDireccionId, $clienteId, $clienteDireccionBarrio, $clienteDireccionCoordenadaGps){
        $this->clienteDireccionId = $clienteDireccionId;
        $this->clienteId = $clienteId;
        $this->clienteDireccionBarrio = $clienteDireccionBarrio;
        $this->clienteDireccionCoordenadaGps = $clienteDireccionCoordenadaGps;
    }

    //Getters
    function getClienteDireccionId() {
        return $this->clienteDireccionId;
    }

    function getClienteId() {
        return $this->clienteId;
    }

    function getClienteDireccionBarrio() {
        return $this->clienteDireccionBarrio;
    }

    function getClienteDireccionCoordenadaGps() {
        return $this->clienteDireccionCoordenadaGps;
    }

    //Setters
    function setClienteDireccionId($clienteDireccionId) {
        $this->clienteDireccionId = $clienteDireccionId;
    }

    function setClienteId($clienteId) {
        $this->clienteId = $clienteId;
    }

    function setClienteDireccionBarrio($clienteDireccionBarrio) {
        $this->clienteDireccionBarrio = $clienteDireccionBarrio;
    }

    function setClienteDireccionCoordenadaGps($clienteDireccionCoordenadaGps) {
        $this->clienteDireccionCoordenadaGps = $clienteDireccionCoordenadaGps;
    }

    
}