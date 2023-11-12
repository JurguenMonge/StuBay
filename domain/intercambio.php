<?php

class Intercambio {
   private $intercambioId;
   private $articulo;
   private $vendedor;
   private $comprador;
   private $subasta;
   private $compradorActivo;
   private $vendedorActivo;

   function __construct($intercambioId,$articulo,$vendedor,$comprador,$subasta,$compradorActivo,$vendedorActivo)
   {
        $this->intercambioId = $intercambioId;
        $this->articulo = $articulo;
        $this->vendedor = $vendedor;
        $this->comprador = $comprador;
        $this->subasta = $subasta;
        $this->compradorActivo = $compradorActivo;
        $this->vendedorActivo = $vendedorActivo;
   }



   /**
    * Get the value of intercambioId
    */ 
   public function getIntercambioId()
   {
      return $this->intercambioId;
   }

   /**
    * Set the value of intercambioId
    *
    * @return  self
    */ 
   public function setIntercambioId($intercambioId)
   {
      $this->intercambioId = $intercambioId;

      return $this;
   }

   /**
    * Get the value of articulo
    */ 
   public function getArticulo()
   {
      return $this->articulo;
   }

   /**
    * Set the value of articulo
    *
    * @return  self
    */ 
   public function setArticulo($articulo)
   {
      $this->articulo = $articulo;

      return $this;
   }

   /**
    * Get the value of vendedor
    */ 
   public function getVendedor()
   {
      return $this->vendedor;
   }

   /**
    * Set the value of vendedor
    *
    * @return  self
    */ 
   public function setVendedor($vendedor)
   {
      $this->vendedor = $vendedor;

      return $this;
   }

   /**
    * Get the value of comprador
    */ 
   public function getComprador()
   {
      return $this->comprador;
   }

   /**
    * Set the value of comprador
    *
    * @return  self
    */ 
   public function setComprador($comprador)
   {
      $this->comprador = $comprador;

      return $this;
   }

   /**
    * Get the value of subasta
    */ 
   public function getSubasta()
   {
      return $this->subasta;
   }

   /**
    * Set the value of subasta
    *
    * @return  self
    */ 
   public function setSubasta($subasta)
   {
      $this->subasta = $subasta;

      return $this;
   }

   /**
    * Get the value of compradorActivo
    */ 
   public function getCompradorActivo()
   {
      return $this->compradorActivo;
   }

   /**
    * Set the value of compradorActivo
    *
    * @return  self
    */ 
   public function setCompradorActivo($compradorActivo)
   {
      $this->compradorActivo = $compradorActivo;

      return $this;
   }

   /**
    * Get the value of vendedorActivo
    */ 
   public function getVendedorActivo()
   {
      return $this->vendedorActivo;
   }

   /**
    * Set the value of vendedorActivo
    *
    * @return  self
    */ 
   public function setVendedorActivo($vendedorActivo)
   {
      $this->vendedorActivo = $vendedorActivo;

      return $this;
   }
}