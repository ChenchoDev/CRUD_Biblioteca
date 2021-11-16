<!DOCTYPE html>
<?php
header("Content-Type: text/html;charset=utf-8");

function connect() {

    $link = mysqli_connect('localhost', 'super', '123456', 'biblioteca');

    if (!$link) {
        die("No se ha podido establecer conexión con la base de datos: \n"
                . $db->connect_error . "\n"
                . $db->connect_errno);
    }
    return $link;
}
?>
<html>
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


                <form action="filtrar.php" method="POST">
                    <div class="input-group">

                        <select class="form-select" id="inputGroupSelect04" name="socio">
                            <?php include("filtro_socio.php"); ?>
                        </select>
                        <select class="form-select" id="inputGroupSelect04" name="libro">
                            <?php include("filtro_libro.php"); ?>
                        </select>

                        <input class="btn btn-outline-secondary" type="submit" name="filtrar" value="Filtrar">
                    </div>

                </form>

                <?php
                ///****************TABLA PRINCIPAL**********************
                $link = connect();
                $consulta = "SELECT  soc_nombre , pre_ejemplar, lib_titulo,pre_fecha , pre_devolucion, pre_id
                    FROM socios JOIN prestamos ON (soc_id=pre_socio)
                    JOIN ejemplares ON (pre_ejemplar=eje_signatura)
                    JOIN libros ON (eje_libro=lib_isbn)
                    ORDER BY pre_fecha DESC";
                $resultado = mysqli_query($link, $consulta);

                echo '<table class="table table-bordered">';
                echo '<tr><th>NOMBRE</th><th>EJEMPLAR</th><th>TITULO</th><th>FECHA PRESTAMO</th><th>FECHA DEVOLUCION</th><th>BORRADO</th></tr>';

                while ($fila = mysqli_fetch_row($resultado)) {
                    echo '<tr><td>' . $fila[0] . '</td><td>' . $fila[1] . '</td><td>' . $fila[2] . '</td><td>' . $fila[3] . '</td>';
                    if ($fila[4] == null) {
                        echo '</td><td>';
                        echo '<form action="index.php" method="post">';
                        echo '<input type="text"  name="pre_id" value="' . $fila[5] . '" hidden>';
                        echo '<input class="btn btn-success" type="submit" value="DEVOLVER">';
                        echo '</form>';
                    } else {
                        echo '</td><td>' . $fila[4] . '</td>';
                    }
                    echo '<td>';
                    echo '<form action="delete.php?var=cancelar&id=1" method="post"> ';
                    echo '<input type="hidden'
                    . '" name="pre_id" readonly="readonly" value="' . $fila[5] . '">';
                    echo '<input class="btn btn-danger" type="submit" name="Borrar" value="Borrar">';
                    echo '</form>';

                    echo '</td><tr>';

                    if (isset($_POST['pre_id'])) {
                        $devolucion = "UPDATE Prestamos SET pre_devolucion=curdate() WHERE pre_id=" . $_POST['pre_id'];
                        mysqli_query($link, $devolucion);
                        header("Location:index.php");
                    }
                }
                echo '</table>';
                ?>
                <div class="d-grid gap-2 col-6 mx-auto" action="index.php" method="post">

                    <a class="btn btn-primary btn-lg my-2 " href="insert.php" role="button">Nuevo Préstamo</a>       
                </div>
                <?php
                //*************************BORRAR**************************************
                if (isset($_POST['Borrar'])) {
                    if (isset($_POST['pre_id'])) {
                        $pre_id = $_POST['pre_id'];
                        echo 'borrar';

                        $link = connect();
                        $consulta = "DELETE FROM `prestamos` WHERE `prestamos`.`pre_id` =" . $_POST['pre_id'];
                        $resultado = mysqli_query($link, $consulta);

                        if ($resultado) {
                            echo 'Borrado OK';
                            header("Location:index.php");
                        } else {
                            die(mysqli_error($link));
                        }
                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>
