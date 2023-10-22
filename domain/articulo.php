<?php

class Articulo{
    
    private $articuloId;
    private $articuloNombre;
    private $articuloMarca;
    private $articuloModelo;
    private $articuloSerie;
    private $articuloActivo;
    private $articuloSubCategoriaId;
    private $clienteId;
    private $articuloFoto;
    private $articuloFoto2;

    function __construct($articuloId, $articuloNombre, $articuloMarca, $articuloModelo, $articuloSerie, $articuloActivo, $articuloSubCategoriaId, $clienteId, $articuloFoto, $articuloFoto2)
    {
        $this->articuloId = $articuloId;
        $this->articuloNombre = $articuloNombre;      
        $this->articuloMarca = $articuloMarca;
        $this->articuloModelo = $articuloModelo;
        $this->articuloSerie = $articuloSerie;
        $this->articuloActivo = $articuloActivo;
        $this->articuloSubCategoriaId = $articuloSubCategoriaId;
        $this->clienteId = $clienteId;
        $this->articuloFoto = $articuloFoto;
        $this->articuloFoto2 = $articuloFoto2;
    }

    //Getters
    function getArticuloId(){
        return $this->articuloId;
    }

    function getArticuloNombre(){
        return $this->articuloNombre;
    }

    function getArticuloMarca(){
        return $this->articuloMarca;
    }

    function getArticuloModelo(){
        return $this->articuloModelo;
    }

    function getArticuloSerie(){
        return $this->articuloSerie;
    }

    function getArticuloActivo(){
        return $this->articuloActivo;
    }

    function getArticuloSubCategoriaId(){
        return $this->articuloSubCategoriaId;
    }

    function getClienteId(){
        return $this->clienteId;
    }

    function getArticuloFoto(){
        return $this->articuloFoto;
    }

    function getArticuloFoto2(){
        return $this->articuloFoto2;
    }

    //Setters
    function setArticuloId($articuloId){
        $this->articuloId = $articuloId;
    }

    function setArticuloNombre($articuloNombre){
        $this->articuloNombre = $articuloNombre;
    }

    function setArticuloMarca($articuloMarca){
        $this->articuloMarca = $articuloMarca;
    }

    function setArticuloModelo($articuloModelo){
        $this->articuloModelo = $articuloModelo;
    }

    function setArticuloSerie($articuloSerie){
        $this->articuloSerie = $articuloSerie;
    }

    function setArticuloActivo($articuloActivo){
        $this->articuloActivo = $articuloActivo;
    }

    function setArticuloSubCategoriaId($articuloSubCategoriaId){
        $this->articuloSubCategoriaId = $articuloSubCategoriaId;
    }

    function setClienteId($clienteId){
        $this->clienteId = $clienteId;
    }

    function setArticuloFoto($articuloFoto){
        $this->articuloFoto = $articuloFoto;
    }

    function setArticuloFoto2($articuloFoto2){
        $this->articuloFoto2 = $articuloFoto2;
    }
}

?>