<?php
$link = new mysqli('localhost', 'super', '123456', 'biblioteca');

if (!$link) {
    die("No se ha podido establecer conexión con la base de datos: \n"
            . $db->connect_error . "\n"
            . $db->connect_errno);
}
?>

<?php

$sql="SELECT e.eje_signatura, l.lib_titulo FROM Libros l  JOIN Ejemplares e ON l.lib_isbn=e.eje_libro
WHERE e.eje_signatura NOT IN (SELECT DISTINCT pre_ejemplar FROM Prestamos)";//Consulta SQL preparada buscando los nombres de los jugadores del equipo introducido por formulario

$resultado=$link->query($sql);//Preparamos la consulta

if($resultado){
while($fila=$resultado->fetch_row()){//Recorremos el resultado
    echo "<option value='$fila[0]'>$fila[1] - $fila[0]</option>";
   
}

}else{
echo "Error en la consulta";
}  
$resultado->close(); 



?>