<?php

include_once 'data.php';
include '../domain/student.php';

class StudentData extends Data {

    public function insertTBStudent($student)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        //get the last id in the database
        $queryGetLastId = "SELECT MAX(id) AS id FROM tbstudent";
        $idCont = mysqli_query($conn, $queryGetLastId); //execute the query and get the result 
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) { //if there is a last id, get it and add 1 to get the next id 
            $nextId = trim($row[0]) + 1; //get the last id and add 1 to get the next id 
            //trim is used to remove spaces before and after the string 
        }
        //Insert the new user in the database
        $queryInsert = "INSERT INTO tbstudent VALUES (" . $nextId . ",'" .
            $student->getName()     . "','" .
            $student->getLastName() . "','" .
            $student->getIdentification() . "','" .
            $student->getBirthDate() . "','" .
            $student->getEmail() . "'," .
            $student->getActive() . ");";


        $result = mysqli_query($conn, $queryInsert); //execute the query and get the result
        mysqli_close($conn); //close the connection
        return $result; //return the result 
    }

    public function updateTBStudent($student)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8'); //set the charset to utf8

        //update the user in the database
        $queryUpdate = "UPDATE tbstudent SET name = '" . $student->getName() .
            "', lastname = '" . $student->getLastName() .
            "', identification = '" . $student->getIdentification() .
            "', birthdate = '" . $student->getBirthDate() .
            "', email = '" . $student->getEmail() .
            "', active = " . $student->getActive() .
            " WHERE id = " . $student->getId() . ";";

        $result = mysqli_query($conn, $queryUpdate); //execute the query and get the result
        mysqli_close($conn); //close the connection

        return $result; //return the result
    }

    public function deleteTBStudent($student) {// este metodo actualiza el estado del cliente para no perder el registro del mismo solo de desactiva.
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');
        
        $queryUpdate = "UPDATE tbstudent SET name='" . $student->getName() .
                "', lastname='" . $student->getLastName() .
                "', identification='" . $student->getIdentification() .
                "', birthdate='" . $student->getBirthDate() .
                "', email='" . $student->getEmail() .
                "', active=" . $student->getActive() .
                " WHERE id=" . $student->getId() . ";";
        
        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);

        return $result;
    }

    public function getAllTBStudent()
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        // obtener todos los estudiantes activos (active = 1) de la base de datos y guardarlos en un array de estudiantes 
        $querySelect = "SELECT * FROM tbstudent WHERE active = 1;";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $array = array(); // declarar el array

        // recorrer el resultado y llenar el array
        while ($row = mysqli_fetch_array($result)) {
            $currentStudent = new Student($row['id'], $row['name'], $row['lastname'], $row['identification'], $row['birthdate'], $row['email'], $row['active']);
            array_push($array, $currentStudent);
        }

        mysqli_close($conn); // cerrar la conexión
        return $array; // devolver el array
    }

    public function getTBStudentById($id)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        // obtener el estudiante con el id especificado de la base de datos y guardarlos en un objeto estudiante
        $querySelect = "SELECT * FROM tbstudent WHERE id = " . $id . ";";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $student = null; // declarar el objeto estudiante

        // si se obtuvo un resultado, llenar el objeto estudiante
        if ($row = mysqli_fetch_array($result)) {
            $student = new Student($row['id'], $row['name'], $row['lastname'], $row['identification'], $row['birthdate'], $row['email'], $row['password'], $row['active']);
        }

        mysqli_close($conn); // cerrar la conexión
        return $student; // devolver el objeto estudiante
    }
}