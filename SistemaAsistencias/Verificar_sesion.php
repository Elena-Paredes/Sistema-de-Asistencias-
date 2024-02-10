<?php
// Siempre inicia la sesión al comienzo del archivo
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
    header('Location: login.php'); // Redirige al usuario al login si no ha iniciado sesión
    exit();
}

// Establece la variable $nombre con el valor de la sesión
$nombre = $_SESSION['nombre'];
?>
