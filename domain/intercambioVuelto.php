<?php

class IntercambioVuelto{

    private $intercambioVueltoId;
    private $articulo;
    private $vendedor;
    private $comprador;
    private $subasta;
    private $intercambioVueltoDinero;
    private $intercambioVueltoCompradorActivo;
    private $intercambioVueltoVendedorActivo;

    public function __construct($intercambioVueltoId, $articulo, $vendedor, $comprador, $subasta, $intercambioVueltoDinero, $intercambioVueltoCompradorActivo, $intercambioVueltoVendedorActivo){
        $this->intercambioVueltoId = $intercambioVueltoId;
        $this->articulo = $articulo;
        $this->vendedor = $vendedor;
        $this->comprador = $comprador;
        $this->subasta = $subasta;
        $this->intercambioVueltoDinero = $intercambioVueltoDinero;
        $this->intercambioVueltoCompradorActivo = $intercambioVueltoCompradorActivo;
        $this->intercambioVueltoVendedorActivo = $intercambioVueltoVendedorActivo;
    }
    

    /**
     * Get the value of intercambioVueltoId
     */
    public function getIntercambioVueltoId()
    {
        return $this->intercambioVueltoId;
    }

    /**
     * Set the value of intercambioVueltoId
     */
    public function setIntercambioVueltoId($intercambioVueltoId): self//self es para que retorne el objeto
    {
        $this->intercambioVueltoId = $intercambioVueltoId;

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
     */
    public function setArticulo($articulo): self
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
     */
    public function setVendedor($vendedor): self
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
     */
    public function setComprador($comprador): self
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
     */
    public function setSubasta($subasta): self
    {
        $this->subasta = $subasta;

        return $this;
    }

    /**
     * Get the value of intercambioVueltoDinero
     */
    public function getIntercambioVueltoDinero()
    {
        return $this->intercambioVueltoDinero;
    }

    /**
     * Set the value of intercambioVueltoDinero
     */
    public function setIntercambioVueltoDinero($intercambioVueltoDinero): self
    {
        $this->intercambioVueltoDinero = $intercambioVueltoDinero;

        return $this;
    }

    /**
     * Get the value of intercambioVueltoCompradorActivo
     */
    public function getIntercambioVueltoCompradorActivo()
    {
        return $this->intercambioVueltoCompradorActivo;
    }

    /**
     * Set the value of intercambioVueltoCompradorActivo
     */
    public function setIntercambioVueltoCompradorActivo($intercambioVueltoCompradorActivo): self
    {
        $this->intercambioVueltoCompradorActivo = $intercambioVueltoCompradorActivo;

        return $this;
    }

    /**
     * Get the value of intercambioVueltoVendedorActivo
     */
    public function getIntercambioVueltoVendedorActivo()
    {
        return $this->intercambioVueltoVendedorActivo;
    }

    /**
     * Set the value of intercambioVueltoVendedorActivo
     */
    public function setIntercambioVueltoVendedorActivo($intercambioVueltoVendedorActivo): self
    {
        $this->intercambioVueltoVendedorActivo = $intercambioVueltoVendedorActivo;

        return $this;
    }
}
