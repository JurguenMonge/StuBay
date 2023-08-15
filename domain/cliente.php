<?php

class Cliente{

    private $clienteId;
    private $clienteNombre;
    private $clientePrimerApellido;
    private $clienteSegundoApellido;
    private $clienteCorreo;
    private $clientePassword;
    private $clienteFechaIngreso;
    private $clienteActivo;
    
    function __construct($clienteId, $clienteNombre, $clientePrimerApellido, $clienteSegundoApellido, $clienteCorreo, $clientePassword, $clienteFechaIngreso, $clienteActivo) {
        $this->clienteId = $clienteId;
        $this->clienteNombre = $clienteNombre;
        $this->clientePrimerApellido = $clientePrimerApellido;
        $this->clienteSegundoApellido = $clienteSegundoApellido;
        $this->clienteCorreo = $clienteCorreo;
        $this->clientePassword = $clientePassword;
        $this->clienteFechaIngreso = $clienteFechaIngreso;
        $this->clienteActivo = $clienteActivo;
    }


    //Getters
    function getClienteId() {
        return $this->clienteId;
    }

    function getClienteNombre() {
        return $this->clienteNombre;
    }

    function getClientePrimerApellido() {
        return $this->clientePrimerApellido;
    }

    function getClienteSegundoApellido() {
        return $this->clienteSegundoApellido;
    }

    function getClienteCorreo() {
        return $this->clienteCorreo;
    }

    function getClientePassword() {
        return $this->clientePassword;
    }

    function getClienteFechaIngreso() {
        return $this->clienteFechaIngreso;
    }

    function getClienteActivo() {
        return $this->clienteActivo;
    }

    //Setters
    function setClienteId($clienteId) {
        $this->clienteId = $clienteId;
    }

    function setClienteNombre($clienteNombre) {
        $this->clienteNombre = $clienteNombre;
    }

    function setClientePrimerApellido($clientePrimerApellido) {
        $this->clientePrimerApellido = $clientePrimerApellido;
    }

    function setClienteSegundoApellido($clienteSegundoApellido) {
        $this->clienteSegundoApellido = $clienteSegundoApellido;
    }

    function setClienteCorreo($clienteCorreo) {
        $this->clienteCorreo = $clienteCorreo;
    }

    function setClientePassword($clientePassword) {
        $this->clientePassword = $clientePassword;
    }

    function setClienteFechaIngreso($clienteFechaIngreso) {
        $this->clienteFechaIngreso = $clienteFechaIngreso;
    }

    function setClienteActivo($clienteActivo) {
        $this->clienteActivo = $clienteActivo;
    }

}

?>