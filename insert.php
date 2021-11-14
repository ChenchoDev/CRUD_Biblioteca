
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
<html>

    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS v5.0.2 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    </head>
    <body>
        <div class="card-header">
            <h1 class="display-3">Biblioteca</h1>
        </div>

        <h2>Insertar nuevo préstamo</h2>
        <form action="insert.php" method="post">

            <!-- SELECT SOCIOS -->
            <div class="mb-3 p-5 bg-light">
                <?php
                $sql = mysqli_query($connection, "SELECT username FROM users");
                while ($row = $sql->fetch_assoc()) {
                    echo "<option value=\"owner1\">" . $row['username'] . "</option>";
                }
                ?>
            </div>
        </form>
    </body>
</html>






