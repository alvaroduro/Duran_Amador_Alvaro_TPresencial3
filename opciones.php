<?php

//Mostramos las diferentes opciones depende sel user o admin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['opcion'])) {

    //Guardamos elección
    $opcion = $_POST['opcion'];

    // Guardamos la última opcion
    setcookie('opcion', $opcion, time() + 3600, "/");

    //Admin
    if ($opcion == "masculino") {
        header("Location: masculino.php");
        exit();
    } elseif ($opcion == "femenino") {
        header("Location: femenino.php");
        exit();
        //User
    } elseif ($opcion == "recre") {
        header("Location: recre.php");
        exit();
    } elseif ($opcion == "sanro") {
        header("Location: sanro.php");
        exit();
    }
}
