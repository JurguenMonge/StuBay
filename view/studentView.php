<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Estudiante</title>

    <?php
    error_reporting(0);
    include '../business/studentBusiness.php';
    ?>
</head>

<body>
    <header>
        <h1>Registro Estudiante</h1>
        <h2><a href="../index.php">Home</a></h2>
    </header>


    <section id="form">
        <table>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cedula</th>
                <th>Fecha Nacimiento</th>
                <th>Correo</th>
                <th>Activo</th>
                <th></th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/studentAction.php">
                <tr>
                    <td><input required type="text" name="name" id="name" /></td>
                    <td><input required type="text" name="lastname" id="lastname" /></td>
                    <td><input required type="text" name="identification" id="identification" /></td>
                    <td><input required type="date" name="birthdate" id="birthdate" /></td>
                    <td><input required type="email" name="email" id="email" /></td>
                    <td><input type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>
            <?php
            $studentBusiness = new studentBusiness();
            $allStudents = $studentBusiness->getAllTBStudent();
            foreach ($allStudents as $current) {
                echo '<form method="post" enctype="multipart/form-data" action="../business/studentAction.php">';
                echo '<input type="hidden" name="id" value="' . $current->getId() . '">';
                echo '<tr>';
                echo '<td><input type="text" name="name" id="name" value="' . $current->getName() . '"/></td>';
                echo '<td><input type="text" name="lastname" id="lastname" value="' . $current->getLastname() . '"/></td>';
                echo '<td><input type="text" name="identification" id="identification" value="' . $current->getIdentification() . '"/></td>';
                echo '<td><input type="date" name="birthdate" id="birthdate" value="' . $current->getBirthdate() . '"/></td>';
                echo '<td><input type="email" name="email" id="email" value="' . $current->getEmail() . '"/></td>';
                echo '<td><input type="checkbox" name="active" id="active" ' . ($current->getActive() == 1 ? "checked" : "") . '/></td>';
                echo '<td><input type="submit" value="Actualizar" name="update" id="update"/></td>';
                echo '<td><input type="submit" value="Eliminar" name="delete" id="delete"/></td>';
                echo '</tr>';
                echo '</form>';
            }
            ?>


            <tr>
                <td></td>
                <td>
                    <?php
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == "emptyField") {
                            echo '<p style="color: red">Campo(s) vacio(s)</p>';
                        } else if ($_GET['error'] == "dbError") {
                            echo '<center><p style="color: red">Error al procesar la transacción</p></center>';
                        }
                    } else if (isset($_GET['success'])) {
                        echo '<p style="color: green">Transacción realizada</p>';
                    }
                    ?>
                </td>
            </tr>
        </table>
    </section>

    <footer>
    </footer>
</body>

</html>