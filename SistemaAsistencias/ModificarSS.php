<?php
// Obtener el número de cuenta del registro a modificar
$nCuenta = isset($_GET['nCuenta']) ? $_GET['nCuenta'] : '';

// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario
if (isset($_POST['submit'])) {
    // Recuperar los valores del formulario
    $nombreSS = isset($_POST['nombreCompleto']) ? $_POST['nombreCompleto'] : '';
    $institucion = isset($_POST['institucion']) ? $_POST['institucion'] : '';
    $fechaInicio = isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : '';
    $fechaSalida = isset($_POST['fechaSalida']) ? $_POST['fechaSalida'] : '';
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
    $areaDesignada = isset($_POST['areaDesignada']) ? $_POST['areaDesignada'] : '';

    // Consulta SQL para actualizar el registro
    $sql = "UPDATE ServicioSocial SET
                nCuenta = '$nCuenta',
                nombreSS = '$nombreSS',
                institucion = '$institucion',
                fInicioSS = '$fechaInicio',
                fFinSS = '$fechaSalida',
                correoSS = '$correo',
                telefonoSS = '$telefono',
                idArea = '$areaDesignada'
            WHERE nCuenta = '$nCuenta'";

    // Ejecutar la consulta de actualización
    if ($conn->query($sql) === TRUE) {
        // La actualización se realizó correctamente
        echo "Registro actualizado correctamente";
        // Redirigir a la página "Servicio-Social.php" después de 2 segundos
        header("refresh:2;url=Servicio-Social.php");
        exit();
    } else {
        // Hubo un error en la actualización
        echo "Error al actualizar el registro: " . $conn->error;
    }
}

// Consulta SQL para obtener los datos del registro de Servicio Social
$sql = "SELECT * FROM ServicioSocial WHERE nCuenta = '$nCuenta'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Procesar los datos obtenidos
    $row = $result->fetch_assoc();
    $nombreSS = $row['nombreSS'];
    $institucion = $row['institucion'];
    $fechaInicio = $row['fInicioSS'];
    $fechaSalida = $row['fFinSS'];
    $correo = $row['correoSS'];
    $telefono = $row['telefonoSS'];
    $areaDesignada = $row['idArea'];
} else {
    echo "No se encontró el registro con el número de cuenta: $nCuenta";
}

// Cerrar la conexión
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
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Información de Servicio Social</h3></div>
                                <div class="card-body">
                                    <form method="POST" action="">
                                        <div class="row mb-3">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputNumber" type="text" name="nCuenta" placeholder="Número de Cuenta" value="<?php echo $nCuenta; ?>"/>
                                            <label for="inputNumber">Número de Cuenta</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputName" type="text" name="nombreCompleto" placeholder="Nombre completo" value="<?php echo $nombreSS; ?>"/>
                                            <label for="inputName" class="form-label">Nombre Completo</label>      
                                        </div>
                                        
                                        </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputSchool" type="text" name="institucion" placeholder="Escuela procedencia" value="<?php echo $institucion; ?>"/>
                                                <label for="inputLastName">Institución</label>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                <div class="form-floating mb-3 input-date-container">
                                                    <input class="form-control input-date" id="input_from" type="text" name="fechaInicio" placeholder="Fecha de inicio" value="<?php echo $fechaInicio; ?>"/>
                                                    <label for="input_from">Fecha de Inicio</label>
                                                </div>
                                                </div>
                                                <div class="col">
                                                <div class="form-floating mb-3 input-date-container">
                                                    <input class="form-control input-date" id="input_to" type="text" name="fechaSalida" placeholder="Fecha de salida" value="<?php echo $fechaSalida; ?>"/>
                                                    <label for="input_to">Fecha de Salida</label>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" name="correo" placeholder="Correo electronico" value="<?php echo $correo; ?>"/>
                                                <label for="inputEmail">Correo</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputTelephone" type="text" name="telefono" placeholder="telefono" value="<?php echo $telefono; ?>"/>
                                                <label for="inputEmail">Teléfono</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                            <select class="form-control" id="exampleFormControlSelect1" name="areaDesignada">
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

                                                // Obtén los nombres de las áreas desde la tabla "Area"
                                                $sql = "SELECT idArea, nombreArea FROM Area";
                                                $result = $conn->query($sql);

                                                // Genera las opciones del select con los nombres de las áreas
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        if ($row['idArea'] == $areaDesignada) {
                                                            echo '<option value="' . $row['idArea'] . '" selected="selected">' . $row['nombreArea'] . '</option>';
                                                        } else {
                                                            echo '<option value="' . $row['idArea'] . '">' . $row['nombreArea'] . '</option>';
                                                        }
                                                    }
                                                } else {
                                                    echo '<option value="">No hay áreas disponibles</option>';
                                                }
                                                
                                                // Cierra la conexión a la base de datos
                                                $conn->close();
                                                ?>
                                            </select>
                                            <label for="exampleFormControlSelect1">Área designada</label>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary btn-block" name="submit">Agregar</button>
                                                <button type="button" class="btn btn-danger btn-block mt-3" name="cancel" onclick="window.location.href='Servicio-Social.php'">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                        
                                        <input type="hidden" name="nCuenta" value="<?php echo $nCuenta; ?>">
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
