<?php

include '../business/studentBusiness.php';

if (isset($_POST['update'])) {

    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['lastname']) 
    && isset($_POST['identification']) && isset($_POST['birthdate']) && isset($_POST['email'])) {
            
        $id = $_POST['id'];
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $identification = $_POST['identification'];
        $birthdate = $_POST['birthdate'];
        $email = $_POST['email'];
        $active = isset($_POST['active']) ? 1 : 0; 

        if (strlen($id) > 0 && strlen($name) > 0 && strlen($lastname) > 0 && strlen($identification) > 0
         && strlen($birthdate) > 0 && strlen($email)) {
                $student = new Student(
                    $id, 
                    $name, 
                    $lastname, 
                    $identification, 
                    $birthdate, 
                    $email, 
                    $active
                );//create a student object

                $studentBusiness = new StudentBusiness();

                $result = $studentBusiness->updateTBStudent($student);
                
                if ($result == 1) {
                    header("location: ../view/studentView.php?success=updated");
                } else {
                    
                    header("location: ../view/studentView.php?error=dbError");
                }
        } else {
            header("location: ../view/studentView.php?error=emptyField");
        }
    } else {
        header("location: ../view/studentView.php?error=error");
    }
}else if (isset($_POST['delete'])) { //if the user clicked on the delete button

    if (
        isset($_POST['id']) && isset($_POST['name']) && isset($_POST['lastname'])
        && isset($_POST['identification'])
        && isset($_POST['birthdate']) && isset($_POST['email'])
    ) { //check if the variables have values 
        $id = $_POST['id']; //get the id from the form
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $identification = $_POST['identification'];
        $birthdate = $_POST['birthdate'];
        $email = $_POST['email'];
        $active = 0; //set the student to 0
        if (
            strlen($id) > 0 && strlen($name) > 0 && strlen($lastname) > 0
            && strlen($identification) > 0 && strlen($birthdate) > 0
            && strlen($email) 
        ) { //check if the variables have values 

            $student = new Student(
                $id,
                $name,
                $lastname,
                $identification,
                $birthdate,
                $email,
                $active
            ); //create a new student instance

            $studentBusiness = new StudentBusiness(); //create a new instance of studentBusiness
            //deteleTBStudent
            $result = $studentBusiness->deleteTBStudent($student); //call the method deleteTBStudent from studentBusiness 

            if ($result == 1) { //if the method deleteTBStudent was executed succesfully it will return 1
                header("location: ../view/studentView.php?success=delete"); //redirect to the index.php page with a success message
            } else {
                header("location: ../view/studentView.php?error=dbError"); //redirect to the index.php page with an error message
            }
        } else {
            header("location: ../view/studentView.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    } else {
        header("location: ../view/studentView.php?error=error"); //redirect to the index.php page with an error message
    }
} else if (isset($_POST['create'])) { //if the user clicked on the create button

    if (isset($_POST['name']) && isset($_POST['lastname'])
        && isset($_POST['identification']) && isset($_POST['birthdate'])
        && isset($_POST['email'])) { //check if the variables have values

        $name = $_POST['name']; //get the name from the form
        $lastname = $_POST['lastname'];
        $identification = $_POST['identification'];
        $birthdate = $_POST['birthdate'];
        $email = $_POST['email'];
        $active = 1; //set the student to 1
        if (
            strlen($name) > 0 && strlen($lastname) > 0
            && strlen($identification) > 0 && strlen($birthdate) > 0
            && strlen($email)
        ) { //check if the variables have values

            $student = new Student(
                0,
                $name,
                $lastname,
                $identification,
                $birthdate,
                $email,
                $active
            ); //create a new student instance 

            $studentBusiness = new StudentBusiness(); //create a new instance of studentBusiness

            $result = $studentBusiness->insertTBStudent($student); //call the method insertTBStudent from studentBusiness
            
            if ($result == 1) { //if the method insertTBStudent was executed succesfully it will return 1
                header("location: ../index.php?success=insert"); //redirect to the index.php page with a success message
            } else {
                header("location: ../index.php?error=dbError"); //redirect to the index.php page with an error message
            }
        } else {
            header("location: ../index.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    } else {
        header("location: ../index.php?error=error"); //redirect to the index.php page with an error message
    }
} 