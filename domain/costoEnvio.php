<?php
class CostoEnvio{

    private $costoEnvioId;
    private $costoPorKM;
    private $tbclienteid;
    private $costoEnvioEstado;

    function __construct($costoEnvioId, $costoPorKM, $tbclienteid, $costoEnvioEstado)
    {
        $this->costoEnvioId = $costoEnvioId;
        $this->costoPorKM = $costoPorKM;
        $this->tbclienteid = $tbclienteid;
        $this->costoEnvioEstado = $costoEnvioEstado;
    }

    public function getCostoEnvioId()
    {
        return $this->costoEnvioId;
    }

    public function setCostoEnvioId($costoEnvioId)
    {
        $this->costoEnvioId = $costoEnvioId;

        return $this;
    }

    public function getCostoPorKM()
    {
        return $this->costoPorKM;
    }

    public function setCostoPorKM($costoPorKM)
    {
        $this->costoPorKM = $costoPorKM;

        return $this;
    }

    public function getTbclienteid()
    {
        return $this->tbclienteid;
    }

    public function setTbclienteid($tbclienteid)
    {
        $this->tbclienteid = $tbclienteid;

        return $this;
    }

    public function getCostoEnvioEstado()
    {
        return $this->costoEnvioEstado;
    }

    public function setCostoEnvioEstado($costoEnvioEstado)
    {
        $this->costoEnvioEstado = $costoEnvioEstado;

        return $this;
    }
}

?>