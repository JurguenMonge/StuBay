<?php

include '../data/studentData.php';

class StudentBusiness{

    private $studentData;

    public function __construct(){
        $this->studentData = new StudentData();
    }

    public function insertTBStudent($student){
        return $this->studentData->insertTBStudent($student);
    }

    public function updateTBStudent($student){
        return $this->studentData->updateTBStudent($student);
    }

    public function deleteTBStudent($student){
        return $this->studentData->deleteTBStudent($student);
    }
    

    public function getAllTBStudent(){
        return $this->studentData->getAllTBStudent();
    }

    // public function getStudentById($id){
    //     return $this->studentData->getStudentById($id);
    // }
    
}