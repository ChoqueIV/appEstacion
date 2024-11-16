<?php
    if (empty($_POST['cerrar_sesion'])) {
        session_start();
        if (session_destroy()) {
            echo '<script>window.location = "./login.php"</script>';
        }
    }
?>

