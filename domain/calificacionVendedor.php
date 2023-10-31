<?php

class CalificacionVendedor
{

    private $calificacionVendedorId;
    private $subastaId;
    private $clienteId;
    private $calificacionVendedorClienteId;
    private $calificacionVendedorPuntos;
    private $calificacionVendedorComentarios;

    function __construct($calificacionVendedorId, $subastaId, $clienteId, $calificacionVendedorClienteId, $calificacionVendedorPuntos, $calificacionVendedorComentarios)
    {
        $this->calificacionVendedorId = $calificacionVendedorId;
        $this->subastaId = $subastaId;
        $this->clienteId = $clienteId;
        $this->calificacionVendedorClienteId = $calificacionVendedorClienteId;
        $this->calificacionVendedorPuntos = $calificacionVendedorPuntos;
        $this->calificacionVendedorComentarios = $calificacionVendedorComentarios;
    }

    //Getters
    function getCalificacionVendedorId()
    {
        return $this->calificacionVendedorId;
    }

    function getSubastaId()
    {
        return $this->subastaId;
    }

    function getClienteId()
    {
        return $this->clienteId;
    }

    function getCalificacionVendedorClienteId()
    {
        return $this->calificacionVendedorClienteId;
    }

    function getCalificacionVendedorPuntos()
    {
        return $this->calificacionVendedorPuntos;
    }

    function getCalificacionVendedorComentarios()
    {
        return $this->calificacionVendedorComentarios;
    }



    //Setters
    function setCalificacionVendedorId($calificacionVendedorId)
    {
        $this->calificacionVendedorId = $calificacionVendedorId;
    }

    function setSubastaId($subastaId)
    {
        $this->subastaId = $subastaId;
    }

    function setClienteId($clienteId)
    {
        $this->clienteId = $clienteId;
    }

    function setCalificacionVendedorClienteId($calificacionVendedorClienteId)
    {
        $this->calificacionVendedorClienteId = $calificacionVendedorClienteId;
    }

    function setCalificacionVendedorPuntos($calificacionVendedorPuntos)
    {
        $this->calificacionVendedorPuntos = $calificacionVendedorPuntos;
    }

    function setCalificacionVendedorComentarios($calificacionVendedorComentarios)
    {
        $this->calificacionVendedorComentarios = $calificacionVendedorComentarios;
    }

}
