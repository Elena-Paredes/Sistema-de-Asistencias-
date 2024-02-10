<?php
if (isset($_POST["deleteId"])) {
    // Establece la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sistema";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Obtiene el ID del turno a eliminar desde el formulario
    $deleteId = $_POST["deleteId"];

    // Prepara la consulta SQL utilizando una sentencia preparada
    $sql = "DELETE FROM Turno WHERE idTurno = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $deleteId); // "i" indica que el valor es de tipo entero (integer)

    // Ejecuta la consulta preparada
    if ($stmt->execute()) {
        // La eliminación se realizó con éxito
        echo "Turno eliminado correctamente.";
        // Redirecciona a la página donde se encuentra la tabla de turnos
        header("Location: Registros.php");
        exit(); // Asegúrate de incluir exit() para detener la ejecución adicional del script
    } else {
        // Hubo un error al eliminar el turno
        echo "Error al eliminar el turno: " . $stmt->error;
    }

    // Cierra la conexión a la base de datos
    $stmt->close();
    $conn->close();
}
?>
