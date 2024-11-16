<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Generator - Sebastian Choque</title>
</head>
<body>
    <div class="card">
        <header>
            <h1>Web Generator Sebastian Choque</h1>    
        </header>
        <main>

            <?php
                // Hacemos la conexion con la base de datos
                $conexion=mysqli_connect('localhost', 'adm_webgenerato', 'webgenerator2024', 'webgenerator');

                session_start(); 

                // Verificamos si recibio un formulario POST
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    
                    // Guardamos los valores en sus variables
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                        if ($email == 'admin@server.com') {
                            if ($password == 'serveradmin') {
                                header('location:panel_admin.php');

                            }
                        }




                    // Realizamos consulta SQL
                    $query = "SELECT password FROM usuarios WHERE email='$email'";
                    $resultado = mysqli_query($conexion, $query);

                    // Verificamos si trajo algo
                    if ($resultado) {

                        // Recuperamos lo que retorno la consulta SQL
                        $dato = mysqli_fetch_assoc($resultado);

                        // Se la asignamos a su variable
                        $password_user = $dato['password'];

                        

                        // Verificamos si ambas contraseñas son iguales
                        if ($password == $password_user) {
                            $_SESSION['email'] = $email;
                            header('location:panel.php');
                        }else{
                            echo "CONTRASEÑA NO IGUALES";
                            exit();
                        }

                    };
                }
            ?>
            
            <form method="POST" action="login.php">
                <div class="box">
                    <label for="email" >Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="box">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="error">
                    <p>Error de logeo, usuario o contraseña incorrecto</p>
                </div>
                <div class="link">
                    <a href="register.php">Registrarse</a>
                </div>
                <button type="submit" name="loguearse">INGRESAR</button>
            </form>
        </main>
    </div>
</body>
</html>