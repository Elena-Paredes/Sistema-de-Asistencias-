<?php
session_start(); // Iniciar sesión al principio del script
date_default_timezone_set('America/Mexico_City');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nCuenta = $_POST['nCuenta'];
$token = $_POST['token'];

// Validar si el usuario existe en la tabla ServicioSocial
$sqlUsuario = "SELECT * FROM ServicioSocial WHERE nCuenta = '$nCuenta'";
$resultadoUsuario = $conn->query($sqlUsuario);

if ($resultadoUsuario->num_rows > 0) {
    // Validar si el token es correcto
    $rowUsuario = $resultadoUsuario->fetch_assoc();
    $idAreaUsuario = $rowUsuario['idArea'];

    $sqlToken = "SELECT * FROM Area WHERE idArea = '$idAreaUsuario' AND Token = '$token'";
    $resultadoToken = $conn->query($sqlToken);

    if ($resultadoToken->num_rows > 0) {
        // Verificar si ya existe un registro para la misma fecha sin hSalida
        $fechaActual = date("Y-m-d");
        $sqlVerificar = "SELECT * FROM Turno WHERE nCuenta = '$nCuenta' AND fechaTurno = '$fechaActual' AND hSalida IS NULL";
        $resultadoVerificar = $conn->query($sqlVerificar);

        if ($resultadoVerificar->num_rows == 0) {
            // Proceder con la inserción si no hay registros pendientes de salida
            $hEntrada = date("H:i:s");
            $sqlInsertar = "INSERT INTO Turno (fechaTurno, hEntrada, nCuenta) VALUES ('$fechaActual', '$hEntrada', '$nCuenta')";

            if ($conn->query($sqlInsertar) === TRUE) {
                $nombreSS = $rowUsuario['nombreSS'];
                echo "Registro exitoso. Bienvenido $nombreSS";
            } else {
                echo "Error al registrar: " . $conn->error;
            }
        } else {
            echo "Aún no has registrado la salida de tu turno anterior.";
        }
    } else {
        echo "Token incorrecto";
    }
} else {
    echo "Usuario no válido";
}

$conn->close();
?>










