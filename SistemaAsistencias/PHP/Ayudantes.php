<?php
// Establece la conexión a la base de datos y realiza la consulta
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

$sql = "SELECT idArea, nombreArea, nombreAyudante, correoAyudante FROM Area";
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
            <!-- Titulo de encabezado-->
            <a class="navbar-brand ps-3" href="principal.php">Sistema de Asistencias</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="principal.php"><i class="fas fa-bars"></i></button>
            
            <!-- Menu encabezado-->
            <ul class="navbar-nav ms-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Perfil</a></li>
                        <li><a class="dropdown-item" href="#!">Configuración</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="login.php">Cerrar sesión<nav></nav></a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- Menu encabezado-->
        <ul class="navbar-nav ms-auto mr-0 mr-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Perfil</a></li>
                    <li><a class="dropdown-item" href="#!">Configuración</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="login.php">Cerrar sesión<nav></nav></a></li>
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
                            <a class="nav-link" href="principal.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></div>
                                    Inicio</a>
                            <div class="sb-sidenav-menu-heading">ACTIVIDAD</div>
                            
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth"> 
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                                    Servicio Social
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                    <a class="nav-link" href="#">
                                        <div class="sb-nav-link-icon"><i class="fa-solid fa-notes-medical"></i></i></div>
                                        Estado
                                    </a>
                                    <a class="nav-link" href="#">
                                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                                        Actividad Actual</a>
                                       <!-- <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="login.html">Horas 
                                    </a></nav>-->
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        <div class="sb-nav-link-icon"><i class="fa-solid fa-folder-open"></i></div>
                                        Proyectos
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="#">En proceso</a>
                                            <a class="nav-link" href="#">Finalizados</a>
                                        </nav>
                                    </div>
                                <a class="nav-link" href="#">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-fingerprint"></i></i></div>
                                    Huella
                                </a>
                            </div>
                        </div>
                    
                    <div class="sb-sidenav-footer">
                        <div class="small">Sesión como:</div>
                            Administrador
                        </div>
                        </nav>
                    </div>

            <!--PARTE DE TABLA-->
            <div id="layoutSidenav_content">
                <main>        
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Áreas</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Inicio</a></li>
                            <li class="breadcrumb-item active">Áreas</li>
                        </ol>
                        <div class="card mb-4">
                        <div class="card-body">
                        Áreas especializadas dentro de la Unidad de Cómputo.  
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Áreas</h5>
                                <div class="d-flex">
                                    <a href="RegistroAyudante.php" class="btn btn-success me-2">Agregar</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="deleteForm" action="eliminarArea.php" method="POST">
                                    <input type="hidden" id="deleteId" name="deleteId" value="">
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Área</th>
                                                <th>Líder</th>
                                                <th>Correo</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Área</th>
                                            <th>Líder</th>
                                            <th>Correo</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </tfoot>
                                            <tbody>
                                                <?php
                                                    // Realiza la consulta a la base de datos
                                                    $sql = "SELECT idArea, nombreArea, nombreAyudante, correoAyudante FROM area";
                                                    $result = $conn->query($sql);

                                                    // Genera las filas de la tabla con los datos obtenidos
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<tr id='row_" . $row["idArea"] . "'>";
                                                            echo "<td>" . $row["idArea"] . "</td>";
                                                            echo "<td>" . $row["nombreArea"] . "</td>";
                                                            echo "<td>" . $row["nombreAyudante"] . "</td>";
                                                            echo "<td>" . $row["correoAyudante"] . "</td>";
                                                            echo '<td>
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-primary">Modificar</button>
                                                                    <button type="button" class="btn btn-danger" onclick="deleteRow(' . $row["idArea"] . ')">Eliminar</button>
                                                                </div>
                                                            </td>';
                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='5'>No se encontraron registros.</td></tr>";
                                                    }
                                                    // Cierra la conexión a la base de datos
                                                    $conn->close();
                                                ?>
                                            </tbody>
                                        </table>
                                    </form>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        
        <script>
            
            function deleteRow(id) {
                document.getElementById("deleteId").value = id;
                submitForm();
            }

            function submitForm() {
                document.getElementById("deleteForm").submit();
            }
        </script>
    </body>
</html>



