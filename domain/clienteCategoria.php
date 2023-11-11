<?php

class ClienteCategoria{
    
    private $idCliente;
    private $idClase;

    function __construct($idCliente, $idClase)
    {
        $this->idCliente = $idCliente;
        $this->idClase = $idClase;
    }

    //Getters
    function getIdCliente(){
        return $this->idCliente;
    }

    function getIdClase(){
        return $this->idClase;
    }

    
    //Setters
    function setIdCliente($idCliente){
        $this->idCliente = $idCliente;
    }

    function setidClase($idClase){
        $this->idClase = $idClase;
    }

}

?>