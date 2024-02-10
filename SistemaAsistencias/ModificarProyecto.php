<?php
// Suponemos que has obtenido el ID del proyecto de la URL
$idProyecto = $_GET['id'];

// Establece la conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Si el formulario ha sido enviado, actualiza los datos en la base de datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreSS = $_POST['nombreSS'];
    $nombreProyecto = $_POST['nombreProyecto'];
    $FechaEntrega = $_POST['FechaEntrega'];
    $descripcion = $_POST['descripcion'];

    // Obtiene el nCuenta del servicio social basado en el nombreSS
    $sqlnCuenta = "SELECT nCuenta FROM ServicioSocial WHERE nombreSS = ?";
    $stmtnCuenta = $conn->prepare($sqlnCuenta);
    $stmtnCuenta->bind_param('s', $nombreSS);
    $stmtnCuenta->execute();
    $resultnCuenta = $stmtnCuenta->get_result();
    $dataSS = $resultnCuenta->fetch_assoc();
    $nCuenta = $dataSS['nCuenta'];

    $sqlUpdate = "UPDATE Proyecto SET nCuenta = ?, nombreProyecto = ?, FechaEntrega = ?, descripcion = ? WHERE idProyecto = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param('isssi', $nCuenta, $nombreProyecto, $FechaEntrega, $descripcion, $idProyecto);

    if ($stmtUpdate->execute()) {
        // Redirecciona a Proyecto.php si se ha actualizado con éxito
        header('Location: Proyecto.php');
        exit;
    } else {
        echo "Error al actualizar el proyecto.";
    }
}

// Consulta la información del proyecto con base en ese ID para mostrar en el formulario
$sql = "SELECT * FROM Proyecto WHERE idProyecto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $idProyecto);

$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$conn->close();
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
                                <form method="POST" action="#">
                                    <div class="row mb-3">
                                        <div class="form-floating mb-3">
                                            <div class="form-floating mb-3">
                                                <select class="form-control" id="exampleFormControlSelect1" name="nombreSS">
                                                <?php
                                                // Nueva conexión para obtener los servicios sociales
                                                $conn = new mysqli($servername, $username, $password, $dbname);
                                                if ($conn->connect_error) {
                                                    die("Error de conexión: " . $conn->connect_error);
                                                }

                                                $sql = "SELECT nombreSS FROM ServicioSocial";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        // Verificar si el nombreSS actual es el mismo que tiene el proyecto para seleccionarlo por defecto
                                                        $selected = $data['nombreSS'] == $row['nombreSS'] ? 'selected' : '';
                                                        echo '<option value="' . $row['nombreSS'] . '" ' . $selected . '>' . $row['nombreSS'] . '</option>';
                                                    }
                                                }
                                                $conn->close();
                                                ?>
                                                </select>
                                                <label for="exampleFormControlSelect1">Nombre Servicio Social</label>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputProyecto" type="text" name="nombreProyecto" placeholder="Nombre del proyecto" value="<?php echo isset($data['nombreProyecto']) ? $data['nombreProyecto'] : ''; ?>"/>
                                            <label for="inputProyecto">Nombre de Proyecto</label>
                                        </div>

                                        <div class="form-floating mb-3 input-date-container">
                                            <input class="form-control input-date" id="input_from" type="text" name="FechaEntrega" placeholder="Fecha de Entrega" value="<?php echo isset($data['FechaEntrega']) ? $data['FechaEntrega'] : ''; ?>">
                                            <label for="input_from">Fecha de Entrega</label>
                                        </div> 

                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" id="inputDescripcion" name="descripcion" placeholder="Descripción" rows="5"><?php echo isset($data['descripcion']) ? $data['descripcion'] : ''; ?></textarea>
                                            <label for="inputDescripcion">Descripción</label>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary btn-block">Modificar</button>
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

    <script>
        var pickerTo = new Pikaday({
            field: document.getElementById('input_to'),
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