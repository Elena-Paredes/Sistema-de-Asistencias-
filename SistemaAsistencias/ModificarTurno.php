<?php
// Establecer la conexión con la base de datos
$mysqli = new mysqli("localhost", "root", "", "sistema");

// Verificar conexión
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

// Obtener los nombres de personal de Servicio Social
$query = "SELECT nCuenta, nombreSS FROM ServicioSocial";
$result = $mysqli->query($query);
$personalOptions = '';
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nCuenta = $row['nCuenta'];
        $nombreSS = $row['nombreSS'];
        $personalOptions .= "<option value='$nCuenta'>$nombreSS</option>";
    }
} else {
    $personalOptions = "<option>No hay nombres de personal disponibles</option>";
}

// Cerrar conexión
$mysqli->close();

// Inicializa las variables
$fechaTurno = '';
$horaEntrada = '';
$horaSalida = '';
$actividad = '';
$idTurno = '';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $idTurno = $_POST["idTurno"] ?? "";
    $nCuenta = $_POST["nCuenta"] ?? ""; // No se puede cambiar, se mantiene igual
    $fechaTurno = $_POST["fechaTurno"] ?? "";
    $horaEntrada = $_POST["horaEntrada"] ?? "";
    $horaSalida = $_POST["horaSalida"] ?? "";
    $actividad = $_POST["actividad"] ?? "";

    // Convertir la fecha al formato correcto (yyyy-mm-dd)
    $fechaTurno = DateTime::createFromFormat('d-m-Y', $fechaTurno)->format('Y-m-d');

    // Establecer la conexión con la base de datos
    $mysqli = new mysqli("localhost", "root", "", "sistema");

    // Verificar conexión
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    // Actualizar los datos en la tabla "Turno"
    $stmt = $mysqli->prepare("UPDATE Turno SET fechaTurno = ?, hEntrada = ?, hSalida = ?, actividad = ? WHERE idTurno = ?");
    $stmt->bind_param('sssss', $fechaTurno, $horaEntrada, $horaSalida, $actividad, $idTurno);
    if ($stmt->execute()) {
        // Éxito al actualizar los datos
        echo "El turno ha sido actualizado correctamente.";
        header("Location: Registros.php");
        exit;
    } else {
        // Error al actualizar los datos
        echo "Error: " . $mysqli->error;
    }

    // Cerrar conexión
    $mysqli->close();
} elseif (isset($_GET["idTurno"])) {
    // Verificar si se proporcionó un ID de turno para editar
    $idTurno = $_GET["idTurno"];

    // Establecer la conexión con la base de datos
    $mysqli = new mysqli("localhost", "root", "", "sistema");

    // Verificar conexión
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    // Obtener los datos del turno existente
    $stmt = $mysqli->prepare("SELECT idTurno, fechaTurno, hEntrada, hSalida, actividad, nCuenta FROM Turno WHERE idTurno = ?");
    $stmt->bind_param('i', $idTurno);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $idTurno = $row['idTurno'];
        $fechaTurno = $row['fechaTurno'];
        $horaEntrada = $row['hEntrada'];
        $horaSalida = $row['hSalida'];
        $actividad = $row['actividad'];
        $nCuenta = $row['nCuenta'];
    } else {
        echo "No se encontró el turno especificado.";
        exit;
    }

    // Cerrar conexión
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Editar turnos</h3></div>
                                    <div class="card-body">
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <div class="form-floating mb-3 input-date-container">
                                                    <input class="form-control input-date" id="input_from" type="text" name="fechaTurno" placeholder="Fecha de inicio" value="<?php echo $fechaTurno; ?>">
                                                    <label for="input_from">Fecha de turno</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-floating mb-3 input-date-container">
                                                    <input class="form-control timepicker" id="input_entry" type="text" name="horaEntrada" placeholder="Hora de entrada" value="<?php echo $horaEntrada; ?>">
                                                        <label for="input_entry">Hora de Entrada</label>
                                                    </div>
                                                    <div class="form-floating mb-3 input-date-container">
                                                    <input class="form-control timepicker" id="input_exit" type="text" name="horaSalida" placeholder="Hora de salida" value="<?php echo $horaSalida; ?>">
                                                        <label for="input_exit">Hora de Salida</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Actividad</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" name="actividad" rows="3"><?php echo $actividad; ?></textarea>
                                            </div> 
                                        </div>
                                        <input type="hidden" name="idTurno" value="<?php echo $idTurno; ?>">
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.timepicker').timepicker({
                showMeridian: false,
                minuteStep: 1
            });
        });
    </script>
    <script>
        var pickerFrom = new Pikaday({
            field: document.getElementById('input_from'),
            format: 'DD-MM-YYYY',
            i18n: {
                previousMonth: 'Mes anterior',
                nextMonth: 'Mes siguiente',
                months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb']
            },
            toString(date, format) {
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                return `${day < 10 ? '0' : ''}${day}-${month < 10 ? '0' : ''}${month}-${year}`;
            },
            parse: function (dateString, format) {
                var parts = dateString.split('-');
                var day = parseInt(parts[0], 10);
                var month = parseInt(parts[1] - 1, 10);
                var year = parseInt(parts[2], 10);
                return new Date(year, month, day);
            }
        });

    </script>
</body>
</html>