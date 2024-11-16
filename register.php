<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Generator - Sebastian Choque</title>
</head>
<body>
    <div class="card">
        <?php
            // Hacemos la conexion con la base de datos
            $conexion=mysqli_connect('localhost', 'adm_webgenerato', 'webgenerator2024', 'webgenerator');

            // Verificamos si recibimos el formulario POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    
                // Guardamos los datos en sus variables
                $email = $_POST['email'];
                $password = $_POST['password'];
                $repeat_password = $_POST['repeat_password'];
                
                // verificamos si ambas contraseñas ingresadas son iguales
                if ($password == $repeat_password) {

                    $password = password_hash($password, PASSWORD_DEFAULT);

                    // Realizamos la consulta SQL
                    $query = "INSERT INTO usuarios(email, password) VALUES ('$email', '$password')";
                    $resultado = mysqli_query($conexion, $query);

                    if ($resultado) {
                        header('location:panel.php');
                    }else{
                        echo "Error al registrarse";
                        exit();
                    }
                }else{
                    echo "NO SON IGUALES";
                }
            }
        ?>
        <header>
            <h1>REGISTRARTE ES SIMPLE</h1>
        </header>
        <main>
            <form method="POST">
                <div class="box">
                    <label for="email">email</label>
                    <input type="email" name="email" id="email">
                </div>
                <div class="box">
                    <label for="password">password</label>
                    <input type="password" name="password" id="password">
                </div>
                <div class="box">
                    <label for="repeat_password">repeat password</label>
                    <input type="password" name="repeat_password" id="repeat_password">
                </div>
                <div class="error">
                    <p>Error de registro</p>
                </div>
                <button>REGISTRARSE</button>
            </form>
        </main>
    </div>
</body>
</html>