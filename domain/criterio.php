<?php
class Criterio{
    private $idCriterio;
    private $nombre;
    private $valor;
    private $estado;

    function __construct($idCriterio, $valor, $nombre, $estado)
    {
        $this->idCriterio = $idCriterio;
        $this->nombre = $nombre;
        $this->valor = $valor;
        $this->estado = $estado;
    }

    //Getters
    function getIdCriterio(){
        return $this->idCriterio;
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
    function setIdCriterio($idCriterio){
        $this->idCriterio = $idCriterio;
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