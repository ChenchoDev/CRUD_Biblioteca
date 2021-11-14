
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

//echo 'conexion delete ok';
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
