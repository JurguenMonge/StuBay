<?php

class CalificacionVendedor
{

    private $calificacionVendedorId;
    private $subastaId;
    private $clienteId;
    private $calificacionVendedorPuntos;
    private $calificacionVendedorComentarios;
    private $calificacionVendedorActivo;

    function __construct($calificacionVendedorId, $subastaId, $clienteId, $calificacionVendedorPuntos, $calificacionVendedorComentarios, $calificacionVendedorActivo)
    {
        $this->calificacionVendedorId = $calificacionVendedorId;
        $this->subastaId = $subastaId;
        $this->clienteId = $clienteId;
        $this->calificacionVendedorPuntos = $calificacionVendedorPuntos;
        $this->calificacionVendedorActivo = $calificacionVendedorActivo;
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

    function getCalificacionVendedorPuntos()
    {
        return $this->calificacionVendedorPuntos;
    }

    function getCalificacionVendedorComentarios()
    {
        return $this->calificacionVendedorComentarios;
    }

    function getCalificacionVendedorActivo()
    {
        return $this->calificacionVendedorActivo;
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

    function setCalificacionVendedorPuntos($calificacionVendedorPuntos)
    {
        $this->calificacionVendedorPuntos = $calificacionVendedorPuntos;
    }

    function setCalificacionVendedorComentarios($calificacionVendedorComentarios)
    {
        $this->calificacionVendedorComentarios = $calificacionVendedorComentarios;
    }

    function setCalificacionVendedorActivo($calificacionVendedorActivo)
    {
        $this->calificacionVendedorActivo = $calificacionVendedorActivo;
    }
}
