<?php
session_start();
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
$actividad = $_POST['actividad'];

// Inicializar el mensaje
$mensaje = "Error al registrar la salida.";

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
        // Verificar si hay un registro de entrada sin salida para la fecha actual
        $fechaActual = date("Y-m-d");
        $sqlVerificarEntrada = "SELECT * FROM Turno WHERE nCuenta = '$nCuenta' AND fechaTurno = '$fechaActual' AND hSalida IS NULL";
        $resultadoVerificarEntrada = $conn->query($sqlVerificarEntrada);

        if ($resultadoVerificarEntrada->num_rows > 0) {
            // Obtener el nombre del usuario
            $nombreSS = $rowUsuario['nombreSS'];

            // Actualizar el registro de entrada con los datos de salida
            $hSalida = date("H:i:s");
            $sqlActualizar = "UPDATE Turno SET hSalida = '$hSalida', actividad = '$actividad' WHERE nCuenta = '$nCuenta' AND fechaTurno = '$fechaActual' AND hSalida IS NULL";

            if ($conn->query($sqlActualizar) === TRUE) {
                $mensaje = "Registro de salida exitoso. ¡Hasta luego, $nombreSS, descansa! :)";
            }
        } else {
            $mensaje = "No hay registro de entrada para la fecha actual.";
        }
    } else {
        $mensaje = "Token incorrecto";
    }
} else {
    $mensaje = "Usuario no válido";
}

$conn->close();

// Devolver el mensaje como JSON
echo json_encode(array("mensaje" => $mensaje));
?>











