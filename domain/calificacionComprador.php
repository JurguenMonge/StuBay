<?php

class CalificacionComprador{

    private $calificacionCompradorId;
    private $subastaId;
    private $clienteId;
    private $calificacionCompradorPuntos;
    private $calificacionCompradorComentarios;
    private $calificacionCompradorActivo;

    function __construct($calificacionCompradorId, $subastaId, $clienteId, $calificacionCompradorPuntos, $calificacionCompradorComentarios, $calificacionCompradorActivo)
    {
        $this->calificacionCompradorId = $calificacionCompradorId;
        $this->subastaId = $subastaId;
        $this->clienteId = $clienteId;
        $this->calificacionCompradorPuntos = $calificacionCompradorPuntos;
        $this->calificacionCompradorComentarios = $calificacionCompradorComentarios;
        $this->calificacionCompradorActivo = $calificacionCompradorActivo;
    }

    //Getters
    function getCalificacionCompradorId()
    {
        return $this->calificacionCompradorId;
    }

    function getSubastaId()
    {
        return $this->subastaId;
    }

    function getClienteId()
    {
        return $this->clienteId;
    }

    function getCalificacionCompradorPuntos()
    {
        return $this->calificacionCompradorPuntos;
    }

    function getCalificacionCompradorComentarios()
    {
        return $this->calificacionCompradorComentarios;
    }

    function getCalificacionCompradorActivo()
    {
        return $this->calificacionCompradorActivo;
    }

    //Setters
    function setCalificacionCompradorId($calificacionCompradorId)
    {
        $this->calificacionCompradorId = $calificacionCompradorId;
    }

    function setSubastaId($subastaId)
    {
        $this->subastaId = $subastaId;
    }

    function setClienteId($clienteId)
    {
        $this->clienteId = $clienteId;
    }

    function setCalificacionCompradorPuntos($calificacionCompradorPuntos)
    {
        $this->calificacionCompradorPuntos = $calificacionCompradorPuntos;
    }

    function setCalificacionCompradorComentarios($calificacionCompradorComentarios)
    {
        $this->calificacionCompradorComentarios = $calificacionCompradorComentarios;
    }

    function setCalificacionCompradorActivo($calificacionCompradorActivo)
    {
        $this->calificacionCompradorActivo = $calificacionCompradorActivo;
    }


}