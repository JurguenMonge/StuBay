<?php

class CompradorPerfil{
    
    private $idCompradorPerfil;
    private $criterio;
    private $cantidadCompra;
    private $montoCompra;
    private $frecuenciaCompra;
    private $devolucion;
    private $idComprador;

    function __construct($idCompradorPerfil, $criterio, $cantidadCompra, $montoCompra, $frecuenciaCompra, $devolucion, $idComprador)
    {
        $this->idCompradorPerfil = $idCompradorPerfil;
        $this->cantidadCompra = $cantidadCompra;
        $this->criterio = $criterio;
        $this->montoCompra = $montoCompra;
        $this->frecuenciaCompra = $frecuenciaCompra;
        $this->devolucion = $devolucion;
        $this->idComprador = $idComprador;
    }

    //Getters
    function getIdCompradorPerfil(){
        return $this->idCompradorPerfil;
    }

    function getCantidadCompra(){
        return $this->cantidadCompra;
    }

    function getCriterio(){
        return $this->criterio;
    }

    function getMontoCompra(){
        return $this->montoCompra;
    }

    function getFrecuenciaCompra(){
        return $this->frecuenciaCompra;
    }

    function getDevolucion(){
        return $this->devolucion;
    }

    function getIdComprador(){
        return $this->idComprador;
    }

    //Setters
    function setIdCompradorPerfil($idCompradorPerfil){
        $this->idCompradorPerfil = $idCompradorPerfil;
    }

    function setCantidadCompra($cantidadCompra){
        $this->cantidadCompra = $cantidadCompra;
    }

    function setCriterio($criterio){
        $this->criterio = $criterio;
    }

    function setMontoCompra($montoCompra){
        $this->montoCompra = $montoCompra;
    }

    function setFrecuenciaCompra($frecuenciaCompra){
        $this->frecuenciaCompra = $frecuenciaCompra;
    }

    function setDevolucion($devolucion){
        $this->devolucion = $devolucion;
    }

    function setIdComprador($idComprador){
        $this->idComprador = $idComprador;
    }
}

?>