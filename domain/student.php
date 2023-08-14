<?php

class Student{

    private $id;
    private $name;
    private $lastName;
    private $identification;
    private $birthDate;
    private $email;
    private $active;

    function __construct($id, $name, $lastName, $identification, $birthDate,$email, $active){
        $this->id = $id;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->identification = $identification;
        $this->birthDate = $birthDate;
        $this->email = $email;
        $this->active = $active;

    }


    //Getters
    function getId(){
        return $this->id;
    }

    function getName(){
        return $this->name;
    }

    function getLastName(){
        return $this->lastName;
    }

    function getIdentification(){
        return $this->identification;
    }

    function getBirthDate(){
        return $this->birthDate;
    }

    function getEmail(){
        return $this->email;
    }


    function getActive(){
        return $this->active;
    }


    //Setters
    function setId($id){
        $this->id = $id;
    }

    function setName($name){
        $this->name = $name;
    }

    function setLastName($lastName){
        $this->lastName = $lastName;
    }

    function setIdentification($identification){
        $this->identification = $identification;
    }

    function setBirthDate($birthDate){
        $this->birthDate = $birthDate;
    }

    function setEmail($email){
        $this->email = $email;
    }


    function setActive($active){
        $this->active = $active;
    }

}

?>