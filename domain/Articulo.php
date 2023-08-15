<?php

class Articulo{
    private $id;
    private $nombre;
    private $categoriaid;
    private $subcategoriaid;
    private $marca;
    private $modelo;
    private $serie;
    private $activo;

    function __construct($id, $nombre, $categoriaid, $subcategoriaid, $marca, $modelo, $serie, $activo)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->categoriaid = $categoriaid;
        $this->subcategoriaid = $subcategoriaid;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->serie = $serie;
        $this->activo = $activo;
    }

    //Getters
    function getId(){
        return $this->id;
    }

    function getNombre(){
        return $this->nombre;
    }

    function getCategoriaId(){
        return $this->categoriaid;
    }

    function getSubCategoriaId(){
        return $this->subcategoriaid;
    }

    function getMarca(){
        return $this->marca;
    }

    function getModelo(){
        return $this->modelo;
    }

    function getSerie(){
        return $this->serie;
    }

    function getActivo(){
        return $this->activo;
    }

    //Setters
    function setId($id){
        
    }
}

?>