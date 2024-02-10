<?php
// Obtener los datos enviados por el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreArea = $_POST["nombreArea"];
    $nombreAyudante = $_POST["nombreAyudante"];
    $correoAyudante = $_POST["correoAyudante"];

    // Establecer la conexión con la base de datos
    $mysqli = new mysqli("localhost", "root", "", "sistema");

    // Verificar la conexión
    if ($mysqli->connect_error) {
        die("Error en la conexión: " . $mysqli->connect_error);
    }

    // Preparar la consulta SQL
    $sql = "INSERT INTO Area (nombreArea, nombreAyudante, correoAyudante) VALUES 
    ('$nombreArea', '$nombreAyudante', '$correoAyudante')";

    // Ejecutar la consulta SQL
    if ($mysqli->query($sql) === TRUE) {
        // Redirigir a la página Ayudantes.php
        header("Location: Ayudantes.php");
        exit(); // Asegurar que el script se detenga después de la redirección
    } else {
        echo "Error al guardar los datos: " . $mysqli->error;
    }

    // Cerrar la conexión
    $mysqli->close();
}

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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Anexo de área</h3></div>
                                    <div class="card-body">
                                        <form method="POST" action="RegistroAyudante.php">
                                            <div class="row mb-3">
                                                <div class="form-floating mb-3">
                                                    <input class="form-control" id="inputLastName" type="text" name="nombreArea" placeholder="Nombre del área" />
                                                    <label for="inputLastName">Nombre área</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input class="form-control" id="inputLastName" type="text" name="nombreAyudante" placeholder="Nombre del encargado" />
                                                    <label for="inputLastName">Nombre de encargado</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input class="form-control" id="inputEmail" type="email" name="correoAyudante" placeholder="name@example.com" />
                                                    <label for="inputEmail">Correo electrónico</label>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary btn-block">Agregar</button>
                                                </div>
                                            </div>
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