<?php
//Iniciamos sesion, siempre se debe
session_start();

//Traemos si hay sesion abierta
$abierta_key = $_SESSION['usuario'] ?? "abierta_" . $nuevoUser;
//echo $abierta_key;

// Obtenemos el nombre de usuario si recordo o no 
$usuario = $_SESSION['usuario'] ?? $_COOKIE[$abierta_key];
//echo $usuario;

// Obtener el contador de accesos
$contador_key = "contador_" . $usuario;
$contador = $_SESSION['contador'] ?? $_COOKIE[$contador_key] ?? 1;


?>

<html>

<head lang="es">
    <?php require 'includes/header.php'; ?>
</head>

<body>
    <div class="container d-flex flex-direction-column justify-content-center my-5">
        <h1>PAG-SAN ROQUE</h1>
    </div>
    <h2>Información para San Roque</h2>
    <?php
    //Si no existe la sesion ni mantener la sesion abierta
    if (!isset($_SESSION['logueado']) && (!isset($_COOKIE[$abierta_key]))) {

        //En caso de no existir la sesion logueado
        header("location:login.php?error=fuera"); //Redirigimos al inicio al usuario ya que no está logueado

    } else {

        //Si ha visitado la pagina
        if ($contador > 1) {
            //Sumamos 1 al contador de visitas-----------------------------
            setcookie($contador_key, ++$_COOKIE[$contador_key], time() + 3600, "/");
            echo "<h2 class='text-primary'>Total número de visitas a la web:  " . $contador . "</h2>";
        }
        //Si no ha visitado la pagina
        else {
            echo "<h2 class='text-primary'>Total número de visitas a la web: 1</h2>";
        }
    }
    ?>
    <div class="container my-3 d-flex flex-column justify-content-center w-50">
        <a href="./user.php" class="btn btn-info">Volver</a>
        <a href="includes/logout.php" class="btn btn-danger">Cerrar Sesión</a>
        <?php require 'includes/footer.php'; ?>
    </div>
</body>

</html>