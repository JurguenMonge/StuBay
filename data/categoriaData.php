<?php

include_once 'data.php';
include '../domain/categoria.php';

class CategoriaData extends Data
{

    public function insertarTBCategoria($categoria)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');

        $queryGetLastId = "SELECT MAX(tbcategoriaid) AS tbcategoriaid FROM tbcategoria";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            $nextId = isset($row[0]) ? intval($row[0]) + 1 : 1;
        }

        $queryInsert = "INSERT INTO tbcategoria VALUES (" . $nextId . ",'" .
            $categoria->getSigla() . "','" .
            $categoria->getNombre() . "','" .
            $categoria->getDescripcion() . "'," .
            $categoria->getActivo() . ");";

        $result = mysqli_query($conn, $queryInsert);
        mysqli_close($conn);
        return $result;
    }

    public function actualizarTBCategoria($categoria)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); //connect to the database
        $conn->set_charset('utf8');
        $queryUpdate = "UPDATE tbcategoria SET tbcategoriasigla = '" . $categoria->getSigla() .
            "', tbcategorianombre = '" . $categoria->getNombre() .
            "', tbcategoriadescripcion = '" . $categoria->getDescripcion() .
            "', tbcategoriaactivo = " . $categoria->getActivo() .
            " WHERE tbcategoriaid = " . $categoria->getId() . ";";

        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);

        return $result;
    }

    public function eliminarTBCategoria($categoria)
    { // este metodo actualiza el estado del cliente para no perder el registro del mismo solo de desactiva.
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        $conn->set_charset('utf8');
        $queryUpdate = "UPDATE tbcategoria SET tbcategoriasigla='" . $categoria->getSigla() .
            "', tbcategorianombre='" . $categoria->getNombre() .
            "', tbcategoriadescripcion='" . $categoria->getDescripcion() .
            "', tbcategoriaactivo=" . $categoria->getActivo() .
            " WHERE tbcategoriaid=" . $categoria->getId() . ";";
        $result = mysqli_query($conn, $queryUpdate);
        mysqli_close($conn);

        return $result;
    }

    public function getAllTBCategorias()
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        $querySelect = "SELECT * FROM tbcategoria WHERE tbcategoriaactivo = 1;";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $array = array(); // declarar el array

        // recorrer el resultado y llenar el array
        while ($row = mysqli_fetch_array($result)) {
            $currentCategoria = new Categoria($row['tbcategoriaid'], $row['tbcategoriasigla'], $row['tbcategorianombre'], $row['tbcategoriadescripcion'], $row['tbcategoriaactivo']);
            array_push($array, $currentCategoria);
        }

        mysqli_close($conn); // cerrar la conexión
        return $array; // devolver el array
    }

    public function getTBCategoriaById($id)
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db); // conectar a la base de datos
        $conn->set_charset('utf8'); // establecer el conjunto de caracteres en utf8

        // obtener el estudiante con el id especificado de la base de datos y guardarlos en un objeto estudiante
        $querySelect = "SELECT * FROM tbcategoria WHERE tbcategoriaid = " . $id . ";";

        $result = mysqli_query($conn, $querySelect); // ejecutar la consulta y obtener el resultado

        $categoria = null;

        // si se obtuvo un resultado, llenar el objeto estudiante
        if ($row = mysqli_fetch_array($result)) {
            $categoria = new Categoria($row['tbcategoriaid'], $row['tbcategoriasigla'], $row['tbcategorianombre'], $row['tbcategoriadescripcion'], $row['tbcategoriaactivo']);
        }

        mysqli_close($conn); // cerrar la conexión
        return $categoria;
    }
}
