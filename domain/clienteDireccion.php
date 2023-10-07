<?php

class ClienteDireccion{

    private $clienteDireccionId;
    private $clienteId;
    private $clienteDireccionBarrio;
    private $clienteDireccionLatitud;
    private $clienteDireccionLongitud;
    private $clienteDireccionActivo;

    function __construct($clienteDireccionId, $clienteId, $clienteDireccionBarrio, $clienteDireccionLatitud, $clienteDireccionLongitud, $clienteDireccionActivo){
        $this->clienteDireccionId = $clienteDireccionId;
        $this->clienteId = $clienteId;
        $this->clienteDireccionBarrio = $clienteDireccionBarrio;
        $this->clienteDireccionLatitud = $clienteDireccionLatitud;
        $this->clienteDireccionLongitud = $clienteDireccionLongitud;
        $this->clienteDireccionActivo = $clienteDireccionActivo;
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

    function getClienteDireccionLatitud() {
        return $this->clienteDireccionLatitud;
    }

    function getClienteDireccionLongitud() {
        return $this->clienteDireccionLongitud;
    }

    function getClienteDireccionActivo() {
        return $this->clienteDireccionActivo;
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

    function setClienteDireccionLatitud($clienteDireccionLatitud) {
        $this->clienteDireccionLatitud = $clienteDireccionLatitud;
    }

    function setClienteDireccionLongitud($clienteDireccionLongitud) {
        $this->clienteDireccionLongitud = $clienteDireccionLongitud;
    }

    function setClienteDireccionActivo($clienteDireccionActivo) {
        $this->clienteDireccionActivo = $clienteDireccionActivo;
    }
    
}