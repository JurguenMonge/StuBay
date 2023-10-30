<?php

include '../data/eventoArticuloData.php';

class EventoArticuloBussiness{

    private $eventoArticuloData;

    public function __construct()
    {
        $this->eventoArticuloData = new EventoArticuloData();
    }

    public function insertarTBEventoArticulo($eventoArticulo)
    {
        return $this->eventoArticuloData->insertarTBEventoArticulo($eventoArticulo);
    }



}