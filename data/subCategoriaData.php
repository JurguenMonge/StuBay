<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once 'data.php';
include '../domain/subCategoria.php';

class SubCategoriaData extends Data
{

    public function insertarTBSubCategoria($subCategoria)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryGetLastId = "SELECT MAX(tbsubcategoriaid) AS tbsubcategoriaid FROM tbsubcategoria";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = isset($row[0]) ? intval($row[0]) + 1 : 1;
        }
        
        $subCategoriaSigla = $subCategoria->getSigla();
        $stmt = $conn->prepare("SELECT * FROM tbsubcategoria WHERE tbsubcategoriasigla = ?"); 
        $stmt->bind_param("s", $subCategoriaSigla); //to pass the parameter to the stmt and that "s" is to say that it is a string
        $stmt->execute(); //execute the statement
        $verificarSigla = $stmt->get_result(); //get the result of the statement 

        if (mysqli_num_rows($verificarSigla) > 0) {
            $stmt->close(); //cierra el stmt
            mysqli_close($conn);
            return 0;
        }

        $queryInsert = "INSERT INTO tbsubcategoria VALUES (" . $nextId . ",'" .
            $subCategoria->getSigla() . "','" .
            $subCategoria->getNombre() . "','" .
            $subCategoria->getCategoriaId() . "','" .
            $subCategoria->getDescripcion() . "'," .
            $subCategoria->getActivo() . ");";

        $result = mysqli_query($conn, $queryInsert);
        mysqli_close($conn);
        
        return $result;
    }

    public function actualizarTBSubCategoria($subCategoria)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8');
        $queryUpdate = "UPDATE tbsubcategoria SET tbsubcategoriasigla = '" . $subCategoria->getSigla() .
            "', tbsubcategorianombre = '" . $subCategoria->getNombre() .
            "', tbcategoriaid = '" . $subCategoria->getCategoriaId() . 
            "', tbsubcategoriadescripcion = '" . $subCategoria->getDescripcion() .
            "', tbsubcategoriaactivo = " . $subCategoria->getActivo() .
            " WHERE tbsubcategoriaid = " . $subCategoria->getId() . ";";

        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);

        return $result;
    }

    public function eliminarTBSubCategoria($subCategoria)
    { // este metodo actualiza el estado del cliente para no perder el registro del mismo solo de desactiva.
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');
        $queryUpdate = "UPDATE tbsubcategoria SET tbsubcategoriasigla='" . $subCategoria->getSigla() .
            "', tbsubcategorianombre='" . $subCategoria->getNombre() .
            "', tbcategoriaid='" . $subCategoria->getCategoriaId() .
            "', tbsubcategoriadescripcion='" . $subCategoria->getDescripcion() .
            "', tbsubcategoriaactivo=" . $subCategoria->getActivo() .
            " WHERE tbsubcategoriaid=" . $subCategoria->getId() . ";";
        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);

        return $result;
    }

    public function getAllTBSubCategorias()
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        $querySelect = "SELECT * FROM tbsubcategoria WHERE tbsubcategoriaactivo = 1;";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $array = array(); // declarar el array

        // recorrer el resultado y llenar el array
        while ($row = mysqli_fetch_array($result)) {
            $currentSubCategoria = new SubCategoria($row['tbsubcategoriaid'], $row['tbsubcategoriasigla'], $row['tbsubcategorianombre'],$row['tbcategoriaid'], $row['tbsubcategoriadescripcion'], $row['tbsubcategoriaactivo']);
            array_push($array, $currentSubCategoria);
        }

        mysqli_close($conn); // cerrar la conexión
        return $array; // devolver el array
    }

    public function getTBSubCategoriaById($id)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        // obtener el estudiante con el id especificado de la base de datos y guardarlos en un objeto estudiante
        $querySelect = "SELECT * FROM tbsubcategoria WHERE tbsubcategoriaid = " . $id . ";";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $subcategoria = null;

        // si se obtuvo un resultado, llenar el objeto estudiante
        if ($row = mysqli_fetch_array($result)) {
            $subcategoria = new SubCategoria($row['tbsubcategoriaid'], $row['tbsubcategoriasigla'], $row['tbsubcategorianombre'],$row['tbcategoriaid'], $row['tbsubcategoriadescripcion'], $row['tbsubcategoriaactivo']);
        }

        mysqli_close($conn); // cerrar la conexión
        return $subcategoria;
    }
}
