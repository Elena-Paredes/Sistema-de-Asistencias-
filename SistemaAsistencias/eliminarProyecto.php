<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (isset($_POST["deleteId"]) && !empty($_POST["deleteId"])) {
    // Obtén el ID de la fila a eliminar desde el formulario
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

    // Elimina la fila correspondiente en la base de datos usando prepared statement
    $sql = "DELETE FROM Proyecto WHERE idProyecto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $deleteId);

    if ($stmt->execute()) {
      header("Location: Proyecto.php");
      exit();
    } else {
      // Hubo un error al eliminar la fila
      echo "Error al eliminar la fila: " . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $conn->close();
  } else {
    echo "ID no definido o inválido.";
  }
}
?>

