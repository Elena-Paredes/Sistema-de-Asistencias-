<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

  // Elimina la fila correspondiente en la base de datos
  $sql = "DELETE FROM Area WHERE idArea = $deleteId";
  if ($conn->query($sql) === TRUE) {
    // La eliminación se realizó con éxito
    echo "Fila eliminada correctamente.";
  } else {
    // Hubo un error al eliminar la fila
    echo "Error al eliminar la fila: " . $conn->error;
  }

  // Cierra la conexión a la base de datos
  $conn->close();
}
?>
