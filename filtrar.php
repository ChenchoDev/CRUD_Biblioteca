<?php

$link = new mysqli('localhost', 'super', '123456', 'biblioteca');

if (!$link) {
    die("No se ha podido establecer conexión con la base de datos: \n"
            . $db->connect_error . "\n"
            . $db->connect_errno);
}
//echo 'conexion OK!';
?>
<?php

if (isset($_POST["socio"])) {
    $socio = $_POST["socio"];
}
if (isset($_POST["libro"])) {
    $libro = $_POST["libro"];
}


$sql = "SELECT s.soc_nombre,e.eje_signatura,l.lib_titulo,p.pre_fecha, p.pre_devolucion FROM Prestamos p JOIN Socios s ON p.pre_socio=s.soc_id JOIN Ejemplares e
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
        $ok = $resultado->bind_result($socio, $signatura, $libro, $fecha, $devolucion); //Vinculamos variable nombre(hace referencia a NOMBRE_JUGADOR de tabla jugadores) para poder utilizarla en la consulta preparada

        echo '<table class="table table-bordered">';
        echo '<tr><th>NOMBRE</th><th>EJEMPLAR</th><th>TITULO</th><th>FECHA PRESTAMO</th><th>FECHA DEVOLUCION</th><th>BORRADO</th></tr>';
        while ($resultado->fetch()) {//Recorremos el resultado
            echo "<tr><td>$socio</td><td>$signatura</td><td>$libro</td><td>$devolucion</td><td>$fecha</td></tr>";
        }
        echo "</table>"; //Cerramos la tabla
    } else {

        echo "No existe resultados con estos filtros";
    }
    echo"<br><br><form action='index.php' method='POST'>
            <input type='submit' value='Volver'></form>";
}

$link->close(); //Cerramos conexión
?>