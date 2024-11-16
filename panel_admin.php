<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webgenerator - Sebastian Choque</title>
</head>
<body>
    <div class="card">
        <?php
        // Hacemos la conexion con la base de datos
        $conexion=mysqli_connect('localhost', 'adm_webgenerato', 'webgenerator2024', 'webgenerator');

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        session_start();

        $email = $_SESSION['email'];

        $query = "SELECT usuarios.idUsuario, usuarios.email FROM usuarios WHERE email = '$email'";
        $result = mysqli_query($conexion, $query);

        if ($datos = mysqli_fetch_assoc($result)) {
            $email = htmlspecialchars($datos['email']);
            $id = htmlspecialChars($datos['idUsuario']);
        }

    
        echo "<header>";
            echo "<h1>Bienvenido a tu panel!</h1>";

    
        echo "</header>";
        echo "<main>";
            echo "<a href='logout.php'>Cerrar Sesion de ". $id ."</a>";

            echo "<form method='POST'>";
                echo "<p>Generar Web de: </p>";
                echo "<input type='text' name='new_web'>";
                echo "<button type='submit'>Crear web</button>";
            echo "</form>";

            
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitizar el input del usuario
            $new_web = htmlspecialchars($_POST['new_web']);
            $dominio = "$id$new_web";

            // Preparar la consulta SQL para evitar inyecciones SQL
            $query = "SELECT COUNT(*) AS count FROM webs WHERE dominio = ?";
            $stmt = mysqli_prepare($conexion, $query);

            // Verificar si la preparación fue exitosa
            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . mysqli_error($conexion));
            }

            // Vincular el parámetro
            mysqli_stmt_bind_param($stmt, 's', $dominio);

            // Ejecutar la consulta
            mysqli_stmt_execute($stmt);

            // Asociar el resultado
            mysqli_stmt_bind_result($stmt, $count);

            // Obtener el resultado
            mysqli_stmt_fetch($stmt);

            mysqli_stmt_close($stmt);


            if ($count>0) {
                echo "<div class='error'>";
                echo "<p>Error: El dominio no se encuentra disponible</p>";
            }else{
                $fechaCreacion = date('Y-m-d H:i:s');
                $sql = "INSERT INTO webs(idUsuario, dominio, fechaCreacion) VALUES ('$id', '$dominio', '$fechaCreacion')";
                $resultados = mysqli_query($conexion, $sql);
                shell_exec('./wix.sh '.$dominio);
            }
        }

        $query = "SELECT * FROM webs";
        $result = mysqli_query($conexion, $query);

        $resultados = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $resultados[] = $row;
        }

        foreach ($resultados as $resultado) {
            $file = $resultado['dominio'];
            $idWeb = $resultado['idWeb'];
            echo "<ul>";
                echo "<li><a href='$file'>$file</a></li>";
                echo "<li><a href='$file' download='$file'>Descargar Web</a></li>";
                echo "<li><a href='panel.php?boton-eliminar=$idWeb'>Eliminar Web</a></li>";
            echo "</ul>";
        }
        echo "</main>";
    echo "</div>";
    ?>
</body>
</html>