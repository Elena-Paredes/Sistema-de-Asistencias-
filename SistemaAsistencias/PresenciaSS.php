<?php
include 'Verificar_sesion.php';
// Paso 1: Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Paso 2: Realizar la consulta
$query = "
    SELECT 
        s.nombreSS,
        t.FechaTurno,
        t.hEntrada,
        t.hSalida
    FROM ServicioSocial s
    LEFT JOIN Turno t ON s.nCuenta = t.nCuenta
    WHERE 
    (
        t.FechaTurno = (
            SELECT MAX(FechaTurno) 
            FROM Turno 
            WHERE nCuenta = s.nCuenta
        ) 
    ) OR t.FechaTurno IS NULL
    GROUP BY s.nCuenta
";

$result = $conn->query($query);
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
                        <h1 class="mt-4">Actividad</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="Index.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Actividad</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                               ¿Quién se encuentra en la Unidad de Cómputo?
                               Se muestra la última hora de entrada y salida del personal de Servicio Social.
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Actividad</h5>
                                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                        <!--<a href="AgregarTurno.php" class="btn btn-success"><i class="fa-solid fa-plus"></i></a>-->
                                    </div>
                            </div>
                            <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Fecha</th>
                                        <th>Hra. Entrada</th>
                                        <th>Hra. Salida</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Fecha</th>
                                        <th>Hra. Entrada</th>
                                        <th>Hra. Salida</th>
                                        <th>Estado</th>                                        
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['nombreSS'] . "</td>";
                                        echo "<td>" . (isset($row['FechaTurno']) ? $row['FechaTurno'] : "") . "</td>";
                                        echo "<td>" . (isset($row['hEntrada']) ? $row['hEntrada'] : "") . "</td>";
                                        echo "<td>" . (isset($row['hSalida']) ? $row['hSalida'] : "") . "</td>";
                                        
                                        // Determina el estado basado en la hora de entrada y salida
                                        if (isset($row['hSalida'])) {
                                            // Entrada y Salida registradas
                                            echo "<td><i class='fa-solid fa-user' style='color: #9c9fa5;'></i></td>";
                                        } elseif (isset($row['hEntrada'])) {
                                            // Sólo entrada registrada (Dentro)
                                            echo "<td><i class='fa-solid fa-user' style='color: #26c929;'></i></td>";
                                        } else {
                                            // Sin registros de Firma
                                            echo "<td><i class='fa-solid fa-user' style='color: #9c9fa5;'></i></td>";
                                        }
                                        
                                        echo "</tr>";
                                    }                                    
                                    ?>
                                </tbody>
                            </table>
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
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            <script src="js/scripts.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
            <script src="assets/demo/chart-area-demo.js"></script>
            <script src="assets/demo/chart-bar-demo.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
            <script src="js/datatables-simple-demo.js"></script> 
        <script>
            function editarFila(idFirma) {
                console.log("Editar fila con ID: " + idFirma);
                window.location.href = "EditarTurno.php?idFirma=" + idFirma;
            }
        </script>
    </body>
</html>