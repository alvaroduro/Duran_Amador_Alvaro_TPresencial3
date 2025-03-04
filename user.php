<!--Controlamos la sesion-->

<!--Vemos si nos hemos logueado-->
<?php

//Iniciamos sesion, siempre se debe
session_start();

//Traemos si hay sesion abierta
$abierta_key = $_SESSION['usuario'] ?? "abierta_" . $nuevoUser;
echo $abierta_key . "<br>";

// Obtenemos el nombre de usuario si recordo o no 
$usuario = $_SESSION['usuario'] ?? $_COOKIE[$abierta_key]; //Guardamos nombre sesion abierta
echo $usuario . "<br>";

// Obtener el contador de accesos
$contador_key = "contador_" . $usuario;
$contador = $_SESSION['contador'] ?? $_COOKIE[$contador_key] ?? 1; // Si no hay sesion ponemos a 1

echo "contador = " . $contador . "<br>";
?>

<html>

<head lang="es">
    <?php require 'includes/header.php'; ?>
</head>

<body>
    <div class="encabezado text-center">
        <h1>DAWES-Tarea Presencial 3:Sesiones y Cookies</h1>
    </div>
    <div class="container d-flex justify-content-center align-items-center gap-3 flex-wrap my-4">
        <a href="./login.php" class="btn btn-info">Volver</a>
        <?php echo "<h1>Bienvenido , " . $usuario . "</h1>"; ?>
        <a href="includes/logout.php" class="btn btn-danger">Cerrar Sesión</a>

        <h2><?php

            //---Comprobamos el login y sesion abierta ----------------

            //Si no existe la sesion ni mantener la sesion abierta
            if (!isset($_SESSION['logueado']) && (!isset($_COOKIE[$abierta_key]))) {

                //En caso de no existir la sesion logueado
                header("location:login.php?error=fuera"); //Redirigimos al inicio al usuario ya que no está logueado

            } else {

                //----------Si existe la cookie mostramos mensaje(si ya se ha visitado la web)-----
                if ($contador > 1) {

                    //echo "Existe cookie (Ya se ha visitado)";

                    //Sumamos 1 al contador de visitas-----------------------------
                    setcookie($contador_key, ++$_COOKIE[$contador_key], time() + 3600, "/");
                    //echo "<br>Sumamos 1 a las visitas";

                    //Mostramos mensaje
                    echo "</h2><h2>Que alegría verte de nuevo por aquí, " . $usuario . "</h2></br>";

                    //-----------Si la sesion se queda abierta-------------------------------
                    if (isset($_COOKIE[$abierta_key])) {
                        //echo "<br>Mostramos ultima visita con sesion abierta";
                        echo "</h2><h2>Tu última visita fué " . $_COOKIE['fecha'] . "</h2></br></br>";

                        //-----Si la sesion no se queda abierta------------------
                    } else {
                        // Definir la fecha actual
                        $fecha = date("d/m/Y | H:i:s");

                        // Establecer la cookie
                        setcookie("fecha", $fecha, time() + 31536000, "/");

                        // Verificar si la cookie ya está disponible
                        if (isset($_COOKIE['fecha'])) {
                            //echo "COOKIE CREADA";
                            $fecha = $_COOKIE['fecha']; // Usar la cookie si está disponible
                        } else {
                            //echo "Usamos la fecha actual NO COOKIE HECHA";
                            $fecha = date("d/m/Y | H:i:s"); // Usar la fecha actual si la cookie aún no se ha guardado
                        }

                        // Mostrar la fecha
                        //echo "<br>Mostramos última visita con sesión cerrada (fecha actual)=" . $fecha;
                        echo "<h2>Tu última visita fue " . $fecha . "</h2></br>";
                    }

                    echo "<h2 class='text-primary'>Total número de visitas a la web:  " . $contador . "</h2>";


                    //---------------Usuario 1 vez loguea-----------------------------
                } else {
                    if ($_SESSION['usuario']) {
                        //Establecemos cookie contador
                        setcookie($contador_key, 1, time() + 3600, "/"); //validez  1h
                        //echo "<br>Establecemos cookie contador a 1";

                        //Definimos fecha de hoy
                        //echo "fecha = hoy";
                        $fecha = date("d/m/Y | H:i:s");

                        //Establecemos una cookie
                        setcookie("fecha", $fecha, time() + 31536000, "/");
                        $contador = 1;

                        //echo "<br>Metemos cookie fecha actual(1 vez iniciada sesion)";

                        //Mostramos mensajes
                        echo "<h2>Bienvenido a mi página por primera vez <b>" . $usuario . ".</b></h2>";

                        //Vemos si se ha creado la cookie de fecha
                        if (isset($_COOKIE['fecha'])) {
                            //echo "<h2>Tu última visita fue " . $_COOKIE['fecha'] . "</h2></br>";
                        } else {
                            //echo "<h2>Esta es tu primera visita.</br></br>Fecha: $fecha.</h2></br>";
                        }

                        echo "<h2>Total número de visitas a la web: 1</h2>";
                    }
                }
            }
            ?>
    </div>


    <div class="container d-flex justify-content-center my-3">

        <!--FORMULARIO OPCIONES-->
        <form method="post" action="opciones.php">
            <div class="text-center">
                <!-- Título con borde -->
                <div class="container">

                    <h1>Opciones User</h1>

                    <!-- Opciones tipo radio -->
                    <div class="mt-3">

                        <!--Opcion Recre-->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="opcion" id="recre" value="recre" <?php if (isset($_COOKIE['opcion']) && $_COOKIE['opcion'] == "recre") {
                                                                                                                    echo "checked";
                                                                                                                } ?>>
                            <label class="form-check-label" for="recre">Recre</label>
                        </div>

                        <!--Opcion Recre-->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="opcion" id="sanro" value="sanro" <?php if (isset($_COOKIE['opcion']) && $_COOKIE['opcion'] == "sanro") {
                                                                                                                    echo "checked";
                                                                                                                } ?>>
                            <label class="form-check-label" for="sanro">San Roque</label>
                        </div>
                    </div>

                    <!-- Botón Ir -->
                    <button class="btn btn-primary mt-3">Ir</button>
                </div>
            </div>
        </form>
    </div>

    <?php require 'includes/footer.php'; ?>
</body>

</html>