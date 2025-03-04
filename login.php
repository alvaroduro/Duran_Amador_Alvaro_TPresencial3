<!--Logica para login-->
<!--Alvaro Duran Amador -- Tarea Presencial 3 Sesiones y Cookies-->

<?php
//Definimos logica para controlar el acceso

//Variables par iniciar sesion
$admin = "admin";
$user = "user";
$passadmin = "admin";
$passuser = "user";

//------Si pulsamos en entrar-----
if (isset($_POST['enviar'])) {

    //Vemos las creedenciales coincidan
    //-----Comprobamos campos de nombre y pass no esten vacios-----
    if (
        isset($_POST['usuario'])
        && isset($_POST['password'])
        && !empty($_POST['usuario'])
        && !empty($_POST['password'])
    ) {

        // Guardamos en variables nueva los inputs recibidos
        $nuevoUser = $_POST['usuario'];
        $nuevoPass = $_POST['password'];

        //------ Comprobamos los campos si coinciden al loguearse-------
        if (
            ($nuevoUser == $user
                && $nuevoPass == $passuser)
            || ($nuevoUser == $admin
                && $nuevoPass == $passadmin)
        ) {

            //Si son correctos es que nos hemos logueado
            session_start(); //Iniciamos sesion

            // Guardar sesión
            $_SESSION['logueado'] = $nuevoUser;
            $_SESSION['usuario'] = $nuevoUser;
            $_SESSION['password'] = $nuevoPass;

            // Control de CONTADOR de accesos
            // Definimos 2 contadores para la sesión nuevo usuario y usuario sesión abierta
            $contador_key = "contador_" . $nuevoUser;
            $abierta_key = "abierta_" . $nuevoUser;

            // Si existe la cookie de contador
            if (isset($_COOKIE[$contador_key])) {

                // Si existe la sesión, sumamos uno al contador
                $_SESSION['contador'] = $_COOKIE[$contador_key] + 1;
            } else {
                // Si no existe ponemos el contador a 1(1 vez visita)
                $_SESSION['contador'] = 1;
            }

            // Guardar contador en una cookie (365 días)
            setcookie($contador_key, $_SESSION['contador'], time() + 365 * 24 * 60 * 60, "/");

            //Comprobamos si está seleccionado el checkbox RECORDAR USUARIO

            //------Creamos las cookies necesarias para el usuario-----
            if (isset($_POST['recuerdo']) && ($_POST['recuerdo'] == "on")) {
                echo "creamos cookie recuerdo usuario y contraseña";
                setcookie('usuario', $nuevoUser, time() + 15 * 24 * 60 * 60, "/");
                setcookie('password', $nuevoPass, time() + 15 * 24 * 60 * 60, "/");

                //----Si no está seleccionado el checkbox--------

            } else {
                //Si no está seleccionado el checkbox
                //Si existe cookies las eliminamos
                if (isset($_COOKIE['usuario'])) { //Si existe
                    echo "Eliminamos la cookie usuario";
                    setcookie('usuario', "", time() - 3600, "/"); //Eliminamos
                }
                if (isset($_COOKIE['password'])) { //Si existe
                    echo "Eliminamos la cookie pass";
                    setcookie('password', "", time() - 3600, "/"); //Eliminamos
                }
            }

            //------Logica para mantener la SESION ABIERTA--------
            if (
                isset($_POST['abierta'])
                && ($_POST['abierta'] = "on")
            ) {
                echo "creamos cookie abierta";

                //Si se ha clicado en mantener la sesion abierta
                //Creamos una cookie con los valores
                setcookie($abierta_key, $nuevoUser, time() + 15 * 24 * 60 * 60, "/");
            } else {

                //Si no se pulsa en mantener la sesion abierta
                //Eliminamos la cookie
                if (isset($_COOKIE['abierta'])) { //Si existe la cookie
                    echo "Eliminamos abieta";
                    setcookie('abierta', "", time() - 3600, "/");
                }
            }

            //Accedemos a la página de inicio

            //-----------SI ES ADMIN---------------
            if (
                (isset($_COOKIE['usuario']) || isset($_COOKIE['abierta']))
                && ($nuevoUser == "admin")
            ) {
                header("location:admin.php"); //Vamos a admin

                //No recuerda ni inicia sesion----------------ADMIN
            } elseif ($nuevoUser == "admin") {
                echo "sin usuario y abierta admin";
                header("location:admin.php"); //Vamos a admin
                exit();
            }

            //-----------SI ES USUARIO-------------
            if (
                (isset($_COOKIE['usuario']) || isset($_COOKIE['abierta']))
                && ($nuevoUser == "user")
            ) {
                header("location:user.php"); //Vamos a user

                //No recuerda ni inicia sesion----------------USER
            } elseif ($nuevoUser == "user") {
                echo "sin usuario y abierta user";
                header("location:user.php"); //Vamos a user
            }

            /*var_dump($_COOKIE['usuario']);
      var_dump(isset($_COOKIE['usuario']));
      var_dump(isset($_COOKIE['abierta']));
      var_dump($nuevoUser == "admin");*/

            //---En caso contrario nos quedamos y pasamos error por GET (campos mal)----
        } else {
            header("location:login.php?error=datos");
        }

        //----En caso contrario nos quedamos y pasamos error por GET (campos vacios)-----
    } else {
        header("location:login?error=vacios");
    }
} //Todavia no se ha pulsado
?>

<html>

<head lang="es">
    <?php require 'includes/header.php'; ?>
</head>

<body>
    <!--Título-->
    <div class="container text-center my-5">
        <h2 class="text-center"> Login de Usuario</h2>
    </div>

    <!--Formulario login-->
    <div class="container border my-2">
        <form action="login.php" method="POST">
            <label for="name">Usuario:
                <!--En caso de haber un usuario introducido anteriormente lo colocamos en el input-->
                <input type="text" name="usuario" class="form-control" value="<?php if (isset($_COOKIE['usuario'])) {
                                                                                    echo $_COOKIE['usuario'];
                                                                                } ?>" />
            </label>
            <br />
            <label for="password">Contraseña:
                <!--En caso de haber un usuario introducido anteriormente lo colocamos en el input-->
                <input type="password" name="password" class="form-control" value="<?php if (isset($_COOKIE['password'])) {
                                                                                        echo $_COOKIE['password'];
                                                                                    } ?>" />
            </label>
            <br />
            <label class="my-3">
                <input class="mx-2" type="checkbox" name="recuerdo" <?php if (isset($_COOKIE['recuerdo'])) {
                                                                        echo "checked";
                                                                    } ?>>Recordar Usuario </label>
            <br />
            <label class="my-3">
                <input class="mx-2" type="checkbox" name="abierta" <?php if (isset($_COOKIE['abierta'])) {
                                                                        echo "checked";
                                                                    } ?>>Mantener la sesion inciada</label>
            <br />
            <input type="submit" value="Entrar" name="enviar" class="btn btn-success" />
        </form>
    </div>
    <?php require 'includes/footer.php'; ?>
</body>

</html>