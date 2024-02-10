<?php
// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$sql = "SELECT s.nCuenta, s.nombreSS, s.institucion, s.fInicioSS, s.fFinSS, s.correoSS, s.telefonoSS, a.nombreArea
        FROM ServicioSocial s";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deleteId = $_POST["deleteId"];

    // Establece la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sistema";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Prepara la consulta SQL utilizando una sentencia preparada
    $sql = "DELETE FROM ServicioSocial WHERE nCuenta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $deleteId); // "s" indica que el valor es de tipo cadena (string)

    // Ejecuta la consulta preparada
    if ($stmt->execute()) {
        // La eliminación se realizó con éxito
        echo "Fila eliminada correctamente.";
        header("Location: Servicio-Social.php");
        exit(); // Asegúrate de incluir exit() para detener la ejecución adicional del script
    } else {
        // Hubo un error al eliminar la fila
        echo "Error al eliminar la fila: " . $stmt->error;
    }

    // Cierra la conexión a la base de datos
    $stmt->close();
    $conn->close();
}
?>



