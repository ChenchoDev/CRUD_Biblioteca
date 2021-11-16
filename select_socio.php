<?php

$link = new mysqli('localhost', 'super', '123456', 'biblioteca');

if (!$link) {
    die("No se ha podido establecer conexión con la base de datos: \n"
            . $db->connect_error . "\n"
            . $db->connect_errno);
}
?>
<?php

$sql = "SELECT soc_id,soc_nombre FROM Socios"; //Consulta SQL preparada buscando los nombres de los jugadores del equipo introducido por formulario

$resultado = $link->query($sql); //Preparamos la consulta

if ($resultado) {
    while ($fila = $resultado->fetch_row()) {//Recorremos el resultado
        echo "<option value='$fila[0]'>$fila[1]</option>";
    }
} else {
    echo '<div class = "alert alert-danger" role = "alert">';
    echo "No se ha podido realizar la consulta";
    echo '</div>';
}
$resultado->close();
?>
