<?php
$link = new mysqli('localhost', 'super', '123456', 'biblioteca');

if (!$link) {
    die("No se ha podido establecer conexión con la base de datos: \n"
            . $db->connect_error . "\n"
            . $db->connect_errno);
}
//echo 'conexion OK!';
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
                if (isset($_POST["socio"])) {
                    $socio = $_POST["socio"];
                }
                if (isset($_POST["libro"])) {
                    $libro = $_POST["libro"];
                }


                $sql = "SELECT s.soc_nombre,e.eje_signatura,l.lib_titulo,p.pre_devolucion,p.pre_fecha FROM Prestamos p JOIN Socios s ON p.pre_socio=s.soc_id JOIN Ejemplares e
        ON p.pre_ejemplar=e.eje_signatura JOIN Libros l ON l.lib_isbn=e.eje_libro WHERE s.soc_id=? and l.lib_titulo=? ORDER BY p.pre_fecha desc";

                $resultado = $link->prepare($sql); //Preparamos la consulta

                $ok = $resultado->bind_param("ss", $socio, $libro); //Introducimos el parámetro de la ?

                $ok = $resultado->execute(); //Ejecutamos la consulta


                $resultado->store_result();
                $filas_afectadas = $resultado->num_rows(); //Guardamos el número de filas afectadas

                if ($ok == false) {
                    echo"Error al ejecutar la consulta";
                } else {//Si la consulta es correcta empezamos una sesión con el código como identificación
                    if ($filas_afectadas != 0) {//Si la filas afectadas no son 0
                        $ok = $resultado->bind_result($socio, $signatura, $libro, $devolucion, $fecha); //Vinculamos variable nombre(hace referencia a NOMBRE_JUGADOR de tabla jugadores) para poder utilizarla en la consulta preparada

                        echo '<table class="table table-bordered">'; //Imprimimos el inicio de la tabla
                        echo '<tr><th>NOMBRE</th><th>EJEMPLAR</th><th>TITULO</th><th>FECHA PRESTAMO</th><th>FECHA DEVOLUCION</th><th>BORRADO</th></tr>';
                        while ($resultado->fetch()) {//Recorremos el resultado
                            echo "<tr><td>$socio</td><td>$signatura</td><td>$libro</td><td>$devolucion</td><td>$fecha</td></tr>";
                        }
                        echo "</table>"; //Cerramos la tabla
                    } else {
                        echo '<div class = "alert alert-danger" role = "alert">';
                        echo "No existe resultados para esta busqueda";
                        echo '</div>';
                        
                    }
                }

                $link->close(); //Cerramos conexión
                ?>

                <div class="d-grid gap-2 col-6 mx-auto" action="insert.php" method="post">

                    <a class="btn btn-primary btn-lg my-2 " href="index.php" role="button">Volver</a>       
                </div>
            </div>
        </div>
    </body>
</html>
