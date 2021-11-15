
<?php

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="insertar.php" method="POST">
        
   
        <br>Socios: <br><select name="socios">
            <?php include("select-socio.php");  ?>
        </select>
        <br>Libros: <br><select name="libros">
        <?php include("select-libro.php");  ?>
        </select>
        <?php
        
            $sql="SELECT MAX(pre_id) FROM Prestamos";//Consulta SQL preparada buscando los nombres de los jugadores del equipo introducido por formulario

            $resultado=$conexion->query($sql);//Preparamos la consulta

            if($resultado){
                $fila=$resultado->fetch_row();
                $indice=$fila[0]+1;
                echo "<input type='text' name='id' value='$indice' hidden>";
            }else{
            echo "Error en la consulta";
            }  
            $resultado->close(); 
        ?>
        
        <br>
        <input type="submit" name="inserta" value="Insertar">
        </form>
        <form action="index.php" method="POST">
            <input type="submit" value="Cancelar">

        </form>
    
    
</body>
</html>




