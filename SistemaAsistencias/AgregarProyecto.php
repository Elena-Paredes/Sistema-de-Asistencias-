<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establece la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sistema";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Obtén los datos del formulario
    $nombreSS = $_POST['nombreSS'];
    $nombreProyecto = $_POST['nombreProyecto'];

    // Convertir la fecha de formato DD-MM-YY a YYYY-MM-DD
    list($day, $month, $shortYear) = explode('-', $_POST['FechaEntrega']);
    $year = 2000 + intval($shortYear);  // Convierte el año corto a un año completo (por ejemplo, 21 se convierte en 2021)
    $FechaEntregaFormatted = "{$year}-{$month}-{$day}";

    $descripcion = $_POST['descripcion'];

    // Busca nCuenta y idArea basándose en el nombre del servicio social
    $sql = "SELECT nCuenta, idArea FROM ServicioSocial WHERE nombreSS = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $nombreSS);
    $stmt->execute();
    $stmt->bind_result($nCuenta, $idArea);
    $stmt->fetch();
    $stmt->close();

    // Inserta el proyecto en la base de datos
    $sql = "INSERT INTO Proyecto (nombreProyecto, FechaEntrega, Descripcion, nCuenta, idArea) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $nombreProyecto, $FechaEntregaFormatted, $descripcion, $nCuenta, $idArea);
    $stmt->execute();

    // Verifica si el registro fue exitoso
    if ($stmt->affected_rows == 1) {
        echo "Proyecto agregado con éxito!";
    } else {
        echo "Error al agregar el proyecto.";
    }
    $stmt->close();
    $conn->close();
    
    // Redirecciona de vuelta a Proyecto.php
    header("Location: Proyecto.php");
    exit;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Proyectos</h3></div>
                                <div class="card-body">
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="row mb-3">
                                        <div class="form-floating mb-3">
                                            <select class="form-control" id="nombreSSSelect" name="nombreSS">
                                                <?php
                                                // Establece la conexión a la base de datos
                                                $servername = "localhost";
                                                $username = "root";
                                                $password = "";
                                                $dbname = "sistema";
                                                $conn = new mysqli($servername, $username, $password, $dbname);
                                                if ($conn->connect_error) {
                                                    die("Error de conexión a la base de datos: " . $conn->connect_error);
                                                }

                                                // Obtén los nombres de los servicios sociales
                                                $sql = "SELECT nombreSS FROM ServicioSocial";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo '<option>' . $row['nombreSS'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <label for="nombreSSSelect">Nombre Servicio Social</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputProyecto" type="text" name="nombreProyecto" placeholder="Nombre del proyecto"/>
                                            <label for="inputProyecto">Nombre de Proyecto</label>
                                        </div>

                                        <div class="col">
                                                <div class="form-floating mb-3 input-date-container">
                                                    <input class="form-control input-date" id="input_from" type="text" name="FechaEntrega" placeholder="Fecha de Entrega">
                                                    <label for="input_from">Fecha de Entrega</label>
                                                </div>
                                            </div>

                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" id="inputDescripcion" name="descripcion" placeholder="Descripción" rows="5"></textarea>
                                            <label for="inputDescripcion">Descripción</label>
                                        </div>
                                    </div>

                                    <div class="mt-4 mb-0">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary btn-block">Agregar</button>
                                            <button type="button" class="btn btn-danger btn-block mt-3" name="cancel" onclick="window.location.href='Proyecto.php'">Cancelar</button>
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
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script>
        var pickerFrom = new Pikaday({
            field: document.getElementById('input_from'),
            format: 'dd-mm-yy',
            i18n: {
                previousMonth: 'Mes anterior',
                nextMonth: 'Mes siguiente',
                months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb']
            },
            toString(date) {
                const day = date.getDate();
                const month = date.getMonth() + 1;
                const year = date.getFullYear().toString().slice(2);
                return `${day < 10 ? '0' : ''}${day}-${month < 10 ? '0' : ''}${month}-${year}`;
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>