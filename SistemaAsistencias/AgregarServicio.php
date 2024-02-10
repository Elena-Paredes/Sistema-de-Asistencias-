<?php
// Obtener los datos enviados por el formulario y proporcionado por el usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nCuenta = $_POST["nCuenta"];
    $nombreSS = $_POST["nombreCompleto"];
    $institucion = $_POST["institucion"];
    $fInicioSS = date("d-m-y", strtotime($_POST["fechaInicio"])); // Convertir el formato de fecha
    $fFinSS = date("d-m-y", strtotime($_POST["fechaSalida"])); // Convertir el formato de fecha
    $correoSS = $_POST["correo"];
    $telefonoSS = $_POST["telefono"];
    $idArea = $_POST["areaDesignada"];

    // Establecer la conexión con la base de datos
    $mysqli = new mysqli("localhost", "root", "", "sistema");

    // Verificar la conexión
    if ($mysqli->connect_error) {
        die("Error en la conexión: " . $mysqli->connect_error);
    }

    // Obtener el idArea correspondiente al nombre de área seleccionado
    $sql = "SELECT idArea FROM Area WHERE nombreArea = '$idArea'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $idArea = $row["idArea"];

        // Insertar los datos en la tabla "ServicioSocial"
        $sql = "INSERT INTO ServicioSocial (nCuenta, nombreSS, institucion, fInicioSS, fFinSS, correoSS, telefonoSS, idArea) 
        VALUES ('$nCuenta', '$nombreSS', '$institucion', '$fInicioSS', '$fFinSS', '$correoSS', '$telefonoSS', '$idArea')";

        // Ejecutar la consulta SQL
        if ($mysqli->query($sql) === TRUE) {
            header("Location: Servicio-Social.php");
            exit(); 
        } else {
            echo "Error al guardar los datos: " . $mysqli->error;
        }
    } else {
        echo "Error: No se encontró el idArea correspondiente al nombre de área seleccionado.";
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
                                <form method="POST" action="AgregarServicio.php">
                                    <div class="container-form">
                                        <div id="preview"></div>
                                        <div class="form-wrapper">
                                            <div class="form-floating mb-3">
                                               <!-- <div class="d-grid">
                                                    <button type="button" class="btn btn-secondary btn-block" id="captureFingerprint">Capturar huella</button>
                                                </div>-->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputNumber" type="text" name="nCuenta" placeholder="Número de Cuenta" />
                                            <label for="inputLastName">Número de Cuenta</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputName" type="text" name="nombreCompleto" placeholder="Nombre completo" />
                                            <label for="inputLastName">Nombre Completo</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputSchool" type="text" name="institucion" placeholder="Escuela procedencia" />
                                            <label for="inputLastName">Institución</label>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating mb-3 input-date-container">
                                                    <input class="form-control input-date" id="input_from" type="text" name="fechaInicio" placeholder="Fecha de inicio">
                                                    <label for="input_from">Fecha de Inicio</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-floating mb-3 input-date-container">
                                                    <input class="form-control input-date" id="input_to" type="text" name="fechaSalida" placeholder="Fecha de salida">
                                                    <label for="input_to">Fecha de Salida</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="email" name="correo" placeholder="Correo electrónico" />
                                            <label for="inputEmail">Correo</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputTelephone" type="text" name="telefono" placeholder="Teléfono" />
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
                                                $sql = "SELECT nombreArea FROM Area";
                                                $result = $conn->query($sql);

                                                // Genera las opciones del select con los nombres de las áreas
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo '<option>' . $row['nombreArea'] . '</option>';
                                                    }
                                                }
                                                // Cierra la conexión a la base de datos
                                                $conn->close();
                                                ?>
                                            </select>
                                            <label for="exampleFormControlSelect1">Área designada</label>
                                        </div>
                                        <div class="mt-0 mb-0">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary btn-block">Agregar</button>
                                                    <button type="button" class="btn btn-danger btn-block mt-3" name="cancel" onclick="window.location.href='Servicio-Social.php'">Cancelar</button>
                                                </div>
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