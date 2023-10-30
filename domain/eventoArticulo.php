<?php
class EventoArticulo{
    private $id;
    private $tbarticuloid;
    private $tbclienteid;

    function __construct($id, $tbarticuloid, $tbclienteid)
    {
        $this->id = $id;
        $this->tbarticuloid = $tbarticuloid;
        $this->tbclienteid = $tbclienteid;
    }

    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of tbarticuloid
     */ 
    public function getTbarticuloid()
    {
        return $this->tbarticuloid;
    }

    /**
     * Set the value of tbarticuloid
     *
     * @return  self
     */ 
    public function setTbarticuloid($tbarticuloid)
    {
        $this->tbarticuloid = $tbarticuloid;

        return $this;
    }

    /**
     * Get the value of tbclienteid
     */ 
    public function getTbclienteid()
    {
        return $this->tbclienteid;
    }

    /**
     * Set the value of tbclienteid
     *
     * @return  self
     */ 
    public function setTbclienteid($tbclienteid)
    {
        $this->tbclienteid = $tbclienteid;

        return $this;
    }
}