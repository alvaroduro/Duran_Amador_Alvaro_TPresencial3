<!--Script para finalizar la sesion y destruirla-->
<?php
session_start(); //Iniciamos sesión

// ----Borrar contador de accesos (opcional, si reiniciar el contador)----
/*if (isset($_COOKIE["contador_" . ($_SESSION['usuario'] ?? '')])) {
    echo "Eliminamos cookie contador" . "<br>";
    //var_dump($_COOKIE["contador_" . $_SESSION['usuario']]);
    setcookie("contador_" . $_SESSION['usuario'], "", time() - 36000, "/");
    unset($_COOKIE["contador_" . $_SESSION['usuario']]);
}*/


session_unset(); //Liberamos las variables de la sesión
session_destroy(); //Destruimos la sesión

header("location:../login.php"); //Redirigimos al inicio con las sesiones destruidas
exit();
?>