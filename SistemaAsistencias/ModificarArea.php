<?php
// Establecer la conexión con la base de datos
$mysqli = new mysqli("localhost", "root", "", "sistema");

// Verificar la conexión
if ($mysqli->connect_error) {
    die("Error en la conexión: " . $mysqli->connect_error);
}

// Obtener el ID del área a modificar
$idArea = $_GET['id'];

// Consulta SQL para obtener los datos del área
$sql = "SELECT * FROM area WHERE idArea = $idArea";

// Ejecutar la consulta SQL
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // Procesar los datos obtenidos
    $row = $result->fetch_assoc();
    $nombreArea = $row['nombreArea'];
    $nombreAyudante = $row['nombreAyudante'];
    $Token = $row['Token'];
} else {
    echo "No se encontró el área con ID: $idArea";
}

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar los valores del formulario
    $nombreArea = $_POST['nombreArea'];
    $nombreAyudante = $_POST['nombreAyudante'];
    $Token = $_POST['Token'];

    // Consulta SQL para actualizar el registro
    $sql = "UPDATE area SET nombreArea = '$nombreArea', nombreAyudante = '$nombreAyudante', Token = '$Token' WHERE idArea = $idArea";

    // Ejecutar la consulta de actualización
    if ($mysqli->query($sql) === TRUE) {
        // La actualización se realizó correctamente
        header("Location: Area.php");
        exit(); // Es importante agregar esta línea para detener la ejecución del script después de la redirección
    } else {
        // Hubo un error en la actualización
        echo "Error al actualizar el registro: " . $mysqli->error;
    }
}

// Cerrar la conexión
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Registro de Personal</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Modificar datos</h3></div>
                                    <div class="card-body">
                                    <form method="POST" action="ModificarArea.php?id=<?php echo $idArea; ?>">
                                        <div class="row mb-3">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputLastName" type="text" name="nombreArea" placeholder="Nombre del área" value="<?php echo $nombreArea; ?>" />
                                                <label for="inputLastName">Nombre área</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputLastName" type="text" name="nombreAyudante" placeholder="Nombre del encargado" value="<?php echo $nombreAyudante; ?>" />
                                                <label for="inputLastName">Nombre de encargado</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputToken" type="text" name="Token" placeholder="Clave de registro" value="<?php echo $Token; ?>" />
                                                <label for="inputEmail">Correo de encargado</label>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">División de Ingenierías Civil y Geomática &copy; | Teléfono: 56 22 80 01, EXT 1037  | Unidad de Cómputo </div>
                            <!--<div>
                                <a href="#">Unidad de Cómputo</a>
                                &middot;
                                <a href="#">. &amp; .</a>
                            </div>
                        -->
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>