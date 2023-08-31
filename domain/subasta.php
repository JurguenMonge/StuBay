<?php 

class Subasta{
    private $subastaId;
    private $subastaFechaHoraInicio;
    private $subastaFechaHoraFinal;
    private $subastaPrecioInicial;
    private $subastaActivo;
    private $subastaArticuloId;

    function __construct($subastaId, $subastaFechaHoraInicio, $subastaFechaHoraFinal, $subastaPrecioInicial, $subastaActivo, $subastaArticuloId)
    {
        $this->subastaId = $subastaId;
        $this->subastaFechaHoraInicio = $subastaFechaHoraInicio;
        $this->subastaFechaHoraFinal = $subastaFechaHoraFinal;
        $this->subastaPrecioInicial = $subastaPrecioInicial;
        $this->subastaActivo = $subastaActivo;
        $this->subastaArticuloId = $subastaArticuloId;
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
}
?>