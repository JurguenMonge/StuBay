<?php

class CalificacionComprador{

    private $calificacionCompradorId;
    private $subastaId;
    private $clienteId;
    private $calificacionCompradorClienteId;
    private $calificacionCompradorPuntos;
    private $calificacionCompradorComentarios;

    function __construct($calificacionCompradorId, $subastaId, $clienteId, $calificacionCompradorClienteId, $calificacionCompradorPuntos, $calificacionCompradorComentarios)
    {
        $this->calificacionCompradorId = $calificacionCompradorId;
        $this->subastaId = $subastaId;
        $this->clienteId = $clienteId;
        $this->calificacionCompradorClienteId = $calificacionCompradorClienteId;
        $this->calificacionCompradorPuntos = $calificacionCompradorPuntos;
        $this->calificacionCompradorComentarios = $calificacionCompradorComentarios;
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

    function getCalificacionCompradorClienteId()
    {
        return $this->calificacionCompradorClienteId;
    }

    function getCalificacionCompradorPuntos()
    {
        return $this->calificacionCompradorPuntos;
    }

    function getCalificacionCompradorComentarios()
    {
        return $this->calificacionCompradorComentarios;
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

    function setCalificacionCompradorClienteId($calificacionCompradorClienteId)
    {
        $this->calificacionCompradorClienteId = $calificacionCompradorClienteId;
    }

    function setCalificacionCompradorPuntos($calificacionCompradorPuntos)
    {
        $this->calificacionCompradorPuntos = $calificacionCompradorPuntos;
    }

    function setCalificacionCompradorComentarios($calificacionCompradorComentarios)
    {
        $this->calificacionCompradorComentarios = $calificacionCompradorComentarios;
    }


}