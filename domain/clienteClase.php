<?php

class ClienteClase{
    
    private $idClase;
    private $nombre;
    private $valor;
    private $estado;

    function __construct($idClase, $valor, $nombre, $estado)
    {
        $this->idClase = $idClase;
        $this->nombre = $nombre;
        $this->valor = $valor;
        $this->estado = $estado;
    }

    //Getters
    function getIdClase(){
        return $this->idClase;
    }

    function getNombre(){
        return $this->nombre;
    }

    function getValor(){
        return $this->valor;
    }

    function getEstado(){
        return $this->estado;
    }

    //Setters
    function setIdClase($idClase){
        $this->idClase = $idClase;
    }

    function setNombre($nombre){
        $this->nombre = $nombre;
    }

    function setValor($valor){
        $this->valor = $valor;
    }

    function setEstado($estado){
        $this->estado = $estado;
    }
}

?>