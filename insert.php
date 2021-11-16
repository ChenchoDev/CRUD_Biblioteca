<?php
$link = new mysqli('localhost', 'super', '123456', 'biblioteca');

if (!$link) {
    die("No se ha podido establecer conexión con la base de datos: \n"
            . $db->connect_error . "\n"
            . $db->connect_errno);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <!-- Bootstrap CSS v5.0.2 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Biblioteca - Tarea 03 DWES - Fltro</title>
    </head>
    <body>
        <div class="p-5  bg-light">

            <div class="container">
                <h1 class="display-3">Biblioteca</h1>
                <hr class="my-2">

                <h2>Préstamos</h2>


                <form action="insert.php" method="POST">


                    <br>Socios: <br><select  class="form-select" id="inputGroupSelect04" name="socios">
                        <?php include("select_socio.php"); ?>
                    </select>
                    <br>Libros: <br><select  class="form-select" id="inputGroupSelect04" name="libros">
                        <?php include("select_libro.php"); ?>
                    </select>
                    <?php
                    $sql = "SELECT MAX(pre_id) FROM prestamos"; //Consulta SQL preparada buscando los nombres de los jugadores del equipo introducido por formulario

                    $resultado = $link->query($sql); //Preparamos la consulta

                    if ($resultado) {
                        $fila = $resultado->fetch_row();
                        $indice = $fila[0] + 1;
                        echo "<input type='text' name='id' value='$indice' hidden>";
                    } else {
                        echo "Error en la consulta";
                    }
                    $resultado->close();
                    ?>

                    <br>
                    <div class="d-inline-flex p-2 bd-highlight flex-row">
                        <div class="d-inline-flex p-2 bd-highlight">
                            <input type="submit" class="btn btn-success" name="insertar" value="Insertar">
                        </div>
                </form>






                <div class="d-inline-flex p-2 bd-highlight">
                    <form action="index.php" method="POST">
                        <input class="btn btn-danger" type="submit" value="Cancelar">

                    </form>
                </div>
            </div>
            <?php
            if (isset($_POST["insertar"])) {

                if (isset($_POST["id"])) {
                    $id = $_POST["id"];
                }

                if (isset($_POST["socios"])) {
                    $socio = $_POST["socios"];
                }
                if (isset($_POST["libros"])) {
                    $libro = $_POST["libros"];
                }
                $devolucion = null;

                $fecha = date("Y-m-d");

                $sql = "INSERT INTO Prestamos VALUES(?,?,?,?,?)";

                $resultado = $link->prepare($sql); //Preparamos la consulta

                $ok = $resultado->bind_param("issis", $id, $fecha, $devolucion, $socio, $libro); //Introducimos el parámetro de la ?

                $ok = $resultado->execute(); //Ejecutamos la consulta


                if ($ok == false) {
                    echo"Error al ejecutar la consulta";
                } else {//Si la consulta es correcta empezamos una sesión con el código como identificación
                    header("location:index.php");
                }

                $link->close(); //Cerramos conexión
            }
            ?>
        </div>
    </body>
</html>




