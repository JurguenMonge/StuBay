<?php

class Articulo{
    
    private $articuloId;
    private $articuloNombre;
    private $articuloMarca;
    private $articuloModelo;
    private $articuloSerie;
    private $articuloActivo;
    private $articuloSubCategoriaId;

    function __construct($articuloId, $articuloNombre, $articuloMarca, $articuloModelo, $articuloSerie, $articuloActivo, $articuloSubCategoriaId)
    {
        $this->articuloId = $articuloId;
        $this->articuloNombre = $articuloNombre;      
        $this->articuloMarca = $articuloMarca;
        $this->articuloModelo = $articuloModelo;
        $this->articuloSerie = $articuloSerie;
        $this->articuloActivo = $articuloActivo;
        $this->articuloSubCategoriaId = $articuloSubCategoriaId;
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
}

?>