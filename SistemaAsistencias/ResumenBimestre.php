<?php
include 'Verificar_sesion.php';
// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se ha enviado la solicitud de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar"])) {
    // Consulta SQL para borrar todos los registros de la tabla Bimestre
    $truncateQuery = "TRUNCATE TABLE Bimestre";

    // Ejecutar la consulta de borrado
    if ($conn->query($truncateQuery) === TRUE) {
        // Consulta SQL para insertar los datos actualizados en la tabla Bimestre
        $insertQuery = "INSERT INTO Bimestre (periodoBim, totalTurnosBim, totalHorasBim, nCuenta)
                        SELECT
                            CONCAT('Mes-', MONTH(FechaTurno), '-', MONTH(DATE_ADD(FechaTurno, INTERVAL 1 MONTH))) AS periodoBim,
                            COUNT(*) AS totalTurnosBim,
                            TRUNCATE(SUM(TIMEDIFF(hSalida, hEntrada))/10000, 2) AS totalHorasBim,
                            Turno.nCuenta
                        FROM
                            Turno
                        JOIN
                            ServicioSocial ON Turno.nCuenta = ServicioSocial.nCuenta
                        WHERE
                            FechaTurno BETWEEN '2023-01-01' AND '2023-12-31' -- Rango de fechas de interés
                        GROUP BY
                            CONCAT('Mes-', MONTH(FechaTurno), '-', MONTH(DATE_ADD(FechaTurno, INTERVAL 1 MONTH))),
                            Turno.nCuenta";

        // Ejecutar la consulta de inserción
        if ($conn->query($insertQuery) === TRUE) {
            echo "Datos actualizados correctamente.";
        } else {
            echo "Error al actualizar los datos: " . $conn->error;
        }
    } else {
        echo "Error al borrar los datos: " . $conn->error;
    }
}

$sql = "SELECT r.idBimestre, r.periodoBim, r.totalTurnosBim, r.totalHorasBim, s.nombreSS, s.fInicioSS, s.fFinSS, c.totalHorasCompl, c.periodoCompl 
        FROM Bimestre r
        INNER JOIN ServicioSocial s ON r.nCuenta = s.nCuenta
        INNER JOIN Completo c ON r.nCuenta = c.nCuenta";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sistema de Asistencia de Servicio Social</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
        <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>
        <script src="ruta/al/chart.min.js"></script>
      
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="Index.php">Sistema de Asistencias</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <ul class="navbar-nav ms-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <?php if (isset($_SESSION['imagen'])) : ?>
                                <img src="data:image/jpeg;base64,<?php echo $_SESSION['imagen']; ?>" alt="Imagen del Usuario" class="profile-picture">
                            <?php else : ?>
                                <img src="img/default-profile-picture.jpg" alt="Imagen por defecto" class="profile-picture">
                            <?php endif; ?>
                            <span class="username">¡Hola, <?php echo $nombre; ?>!</span>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <!--<li><a class="dropdown-item" href="#!">Mi Perfil</a></li>-->
                        <hr class="dropdown-divider" />
                        <li>
                            <a class="dropdown-item" href="logout.php?logout=1">Cerrar sesión</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!--BARRA LATERAL-->
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="Index.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></div>
                                Inicio
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseHuella" aria-expanded="false" aria-controls="pagesCollapseHuella">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-fingerprint"></i></div>
                                Firmas
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseHuella" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="MenuEntrada.php"><i class="fa-solid fa-sun"></i>Entrada</a>
                                    <a class="nav-link" href="MenuSalida.php"><i class="fa-solid fa-moon"></i> Salida</a>
                                </nav>
                            </div>
                            <a class="nav-link" href="PresenciaSS.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-eye"></i></div>
                                Actividad
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapsePrin" aria-expanded="false" aria-controls="pagesCollapsePrin">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-thumbtack"></i></div>
                                Principal
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapsePrin" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="Area.php">
                                        <i class="fa-solid fa-handshake"></i> Áreas
                                    </a>
                                    <a class="nav-link" href="Servicio-Social.php">
                                        <i class="fa-solid fa-users"></i> Servicio Social
                                    </a>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">INFORMACIÓN</div>
                            <a class="nav-link" href="Registros.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-book"></i></div>
                                Registros
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseResumen" aria-expanded="false" aria-controls="pagesCollapseResumen">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-traffic-light"></i></div>
                                Resumen
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseResumen" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="ResumenSemanal.php">Semanal</a>
                                    <a class="nav-link" href="ResumenMes.php">Mensual</a>
                                    <a class="nav-link" href="ResumenBimestre.php">Bimestral</a>
                                </nav>
                            </div>
                            <a class="nav-link" href="Proyecto.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-folder-open"></i></div>
                                Proyectos
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Sesión como:</div>
                        Administrador
                    </div>
                </nav>
            </div>
            
             <!--PARTE FRONTAL DE LA PÁGINA-->
             <div id="layoutSidenav_content">
                <main>        
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Resumen</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="Index.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Resumen</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                               Resumen de las horas laboradas del personal del Servicio Social durante su estancia en la Unidad de Cómputo. 
                            </div>
                        </div>

                        <div class="card mb-4">
                        <form method="POST">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">BIMESTRE</h5>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <div class="d-flex">
                                    <button type="submit" name="actualizar" class="btn btn-success me-2">Actualizar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                            <div class="card-body">
                            <form id="deleteForm" action="#" method="post">
                            <input type="hidden" id="deleteId" name="deleteId" value="">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>F. Inicio</th>
                                            <th>F. Salida</th>
                                            <th>Bimestre</th>
                                            <th>H. Total</th>
                                            <th>Configuración</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>F. Inicio</th>
                                            <th>F. Salida</th>
                                            <th>Bimestre</th>
                                            <th>H. Total</th>
                                            <th>Configuración</th>                    
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $totalHorasBim = $row["totalHorasBim"];
                                                $rowClass = ($totalHorasBim >= 160) ? "table-success" : (($totalHorasBim >= 120 && $totalHorasBim < 160) ? "table-warning" : "table-danger");
                                        
                                                echo "<tr class='$rowClass'>";
                                                echo "<td>" . $row["nombreSS"] . "</td>";
                                                echo "<td>" . $row["fInicioSS"] . "</td>";
                                                echo "<td>" . $row["fFinSS"] . "</td>";
                                                echo "<td>" . $row["periodoBim"] . "</td>";
                                                echo "<td class='$rowClass'>" . $row["totalHorasBim"] . "</td>";
                                                echo '<td>';
                                                // Botón modificado
                                                echo '<button type="button" class="btn btn-primary viewBtn" 
                                                      data-totalhorascompl="'.$row["totalHorasCompl"].'" 
                                                      data-periodocompl="'.$row["periodoCompl"].'">
                                                      <i class="fa-solid fa-eye"></i></button>';
                                                echo '</td>';
                                                echo "</tr>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                            <!-- Modal -->
                            <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="infoModalLabel">Información Detallada</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Total Horas Completas:</strong> <span id="modalTotalHorasCompl"></span></p>
                                            <p><strong>Periodo Completo:</strong> <span id="modalPeriodoCompl"></span></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                    <footer class="py-4 bg-light mt-auto">
                        <div class="container-fluid px-4">
                            <div class="d-flex align-items-center justify-content-between small">
                                <div class="text-muted">División de Ingenierías Civil y Geomática &copy; | Teléfono: 56 22 80 01, EXT 1037  | Unidad de Cómputo </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
            <script src="ruta/al/chart.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            <script src="js/scripts.js"></script>
            <script src="assets/demo/chart-area-demo.js"></script>
            <script src="assets/demo/chart-bar-demo.js"></script>
            <script src="js/datatables-simple-demo.js"></script>  
            <script>
                $(document).on('click', '.viewBtn', function() {
                    const totalHorasCompl = $(this).attr('data-totalhorascompl');
                    const periodoCompl = $(this).attr('data-periodocompl');

                    $('#modalTotalHorasCompl').text(totalHorasCompl);
                    $('#modalPeriodoCompl').text(periodoCompl);
                    
                    $('#infoModal').modal('show');
                });


                $(document).ready(function() {
                    $('#datatablesSimple tbody tr').each(function() {
                        var totalHorasBim = parseInt($(this).find('td:last-child').text());

                        if (totalHorasBim >= 160) {
                            $(this).addClass('table-success');
                        } else if (totalHorasBim >= 159 && totalHorasBim < 120) {
                            $(this).addClass('table-warning');
                        } else {
                            $(this).addClass('table-danger');
                        }
                    });
                });
            </script>
    </body>
</html>