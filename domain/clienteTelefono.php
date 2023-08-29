<?php

class ClienteTelefono{

    private $clienteTelefonoId;
    private $clienteId;
    private $clienteTelefonoNumero;
    private $clienteTelefonoDescripcion;
    private $clienteTelefonoActivo;
    

    function __construct($clienteTelefonoId, $clienteId, $clienteTelefonoNumero, $clienteTelefonoActivo, $clienteTelefonoDescripcion){
        $this->clienteTelefonoId = $clienteTelefonoId;
        $this->clienteId = $clienteId;
        $this->clienteTelefonoNumero = $clienteTelefonoNumero;
        $this->clienteTelefonoDescripcion = $clienteTelefonoDescripcion;
        $this->clienteTelefonoActivo = $clienteTelefonoActivo;
    }

    //Getters
    function getClienteTelefonoId() {
        return $this->clienteTelefonoId;
    }

    function getClienteId() {
        return $this->clienteId;
    }

    function getClienteTelefonoNumero() {
        return $this->clienteTelefonoNumero;
    }

    function getClienteTelefonoDescripcion() {
        return $this->clienteTelefonoDescripcion;
    }

    function getClienteTelefonoActivo() {
        return $this->clienteTelefonoActivo;
    }

    //Setters

    function setClienteTelefonoId($clienteTelefonoId) {
        $this->clienteTelefonoId = $clienteTelefonoId;
    }

    function setClienteId($clienteId) {
        $this->clienteId = $clienteId;
    }

    function setClienteTelefonoNumero($clienteTelefonoNumero) {
        $this->clienteTelefonoNumero = $clienteTelefonoNumero;
    }

    function setClienteTelefonoDescripcion($clienteTelefonoDescripcion) {
        $this->clienteTelefonoDescripcion = $clienteTelefonoDescripcion;
    }

    function setClienteTelefonoActivo($clienteTelefonoActivo) {
        $this->clienteTelefonoActivo = $clienteTelefonoActivo;
    }



   
}