<?php 

class Subasta{
    private $subastaId;
    private $subastaFechaHoraInicio;
    private $subastaFechaHoraFinal;
    private $subastaPrecioInicial;
    private $subastaEstadoArticulo;
    private $subastaDiasUsoArticulo;
    private $subastaActivo;
    private $subastaArticuloId;
    private $subastaVendedorId;

    function __construct($subastaId, $subastaFechaHoraInicio, $subastaFechaHoraFinal, $subastaPrecioInicial, $subastaEstadoArticulo, $subastaDiasUsoArticulo, $subastaActivo, $subastaArticuloId, $subastaVendedorId)
    {
        $this->subastaId = $subastaId;
        $this->subastaFechaHoraInicio = $subastaFechaHoraInicio;
        $this->subastaFechaHoraFinal = $subastaFechaHoraFinal;
        $this->subastaPrecioInicial = $subastaPrecioInicial;
        $this->subastaEstadoArticulo = $subastaEstadoArticulo;
        $this->subastaDiasUsoArticulo = $subastaDiasUsoArticulo;
        $this->subastaActivo = $subastaActivo;
        $this->subastaArticuloId = $subastaArticuloId;
        $this->subastaVendedorId = $subastaVendedorId;
    }

    public function getSubastaId()
    {
        return $this->subastaId;
    }

    public function setSubastaId($subastaId)
    {
        $this->subastaId = $subastaId;

        return $this;
    }

    public function getSubastaFechaHoraInicio()
    {
        return $this->subastaFechaHoraInicio;
    }

    public function setSubastaFechaHoraInicio($subastaFechaHoraInicio)
    {
        $this->subastaFechaHoraInicio = $subastaFechaHoraInicio;

        return $this;
    }

    public function getSubastaFechaHoraFinal()
    {
        return $this->subastaFechaHoraFinal;
    }

    public function setSubastaFechaHoraFinal($subastaFechaHoraFinal)
    {
        $this->subastaFechaHoraFinal = $subastaFechaHoraFinal;

        return $this;
    }

    public function getSubastaPrecioInicial()
    {
        return $this->subastaPrecioInicial;
    }

    public function setSubastaPrecioInicial($subastaPrecioInicial)
    {
        $this->subastaPrecioInicial = $subastaPrecioInicial;

        return $this;
    }

    public function getSubastaArticuloId()
    {
        return $this->subastaArticuloId;
    }

    public function setSubastaArticuloId($subastaArticuloId)
    {
        $this->subastaArticuloId = $subastaArticuloId;

        return $this;
    }

    public function getSubastaActivo()
    {
        return $this->subastaActivo;
    }

    public function setSubastaActivo($subastaActivo)
    {
        $this->subastaActivo = $subastaActivo;

        return $this;
    }

    public function getSubastaEstadoArticulo()
    {
        return $this->subastaEstadoArticulo;
    }

    public function setSubastaEstadoArticulo($subastaEstadoArticulo)
    {
        $this->subastaEstadoArticulo = $subastaEstadoArticulo;

        return $this;
    }

    public function getSubastaDiasUsoArticulo()
    {
        return $this->subastaDiasUsoArticulo;
    }

    public function setSubastaDiasUsoArticulo($subastaDiasUsoArticulo)
    {
        $this->subastaDiasUsoArticulo = $subastaDiasUsoArticulo;

        return $this;
    }

    /**
     * Get the value of subastaVendedorId
     */ 
    public function getSubastaVendedorId()
    {
        return $this->subastaVendedorId;
    }

    /**
     * Set the value of subastaVendedorId
     *
     * @return  self
     */ 
    public function setSubastaVendedorId($subastaVendedorId)
    {
        $this->subastaVendedorId = $subastaVendedorId;

        return $this;
    }
}
?>