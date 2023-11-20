<?php

class ClienteCriterio{
    
    private $idCliente;
    private $idCriterio;

    function __construct($idCliente, $idCriterio)
    {
        $this->idCliente = $idCliente;
        $this->idCriterio = $idCriterio;
    }

    //Getters
    function getIdCliente(){
        return $this->idCliente;
    }

    function getIdCriterio(){
        return $this->idCriterio;
    }

    
    //Setters
    function setIdCliente($idCliente){
        $this->idCliente = $idCliente;
    }

    function setIdCriterio($idCriterio){
        $this->idCriterio = $idCriterio;
    }

}

?>