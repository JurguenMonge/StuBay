<?php

class Categoria{
    
    private $id;
    private $sigla;
    private $nombre;
    private $descripcion;
    private $activo;

    function __construct($id, $sigla, $nombre, $descripcion, $activo)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->sigla = $sigla;
        $this->descripcion = $descripcion;
        $this->activo = $activo;
    }

    //Getters
    function getId(){
        return $this->id;
    }

    function getNombre(){
        return $this->nombre;
    }

    function getSigla(){
        return $this->sigla;
    }

    function getDescripcion(){
        return $this->descripcion;
    }

    function getActivo(){
        return $this->activo;
    }

    //Setters
    function setId($id){
        $this->id = $id;
    }

    function setNombre($nombre){
        $this->nombre = $nombre;
    }

    function setSigla($sigla){
        $this->sigla = $sigla;
    }

    function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }

    function setActivo($activo){
        $this->activo = $activo;
    }
}

?>