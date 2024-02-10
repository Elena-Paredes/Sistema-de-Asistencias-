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

$sql = "SELECT s.nCuenta, s.nombreSS, s.institucion, s.fInicioSS, s.fFinSS, s.correoSS, s.telefonoSS, a.nombreArea
        FROM ServicioSocial s
        INNER JOIN Area a ON s.idArea = a.idArea";
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
                        <h1 class="mt-4">Servicio Social</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="Index.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Servicio Social</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                               Personal del servicio social registrado dentro de la Unidad de Cómputo. 
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">SERVICIO SOCIAL</h5>
                                    <div class="d-flex">
                                    <a href="AgregarServicio.php" class="btn btn-success me-2">Agregar</a>
                                </div>
                                </div>
                            <div class="card-body">
                            <form id="deleteForm" action="eliminarSS.php" method="post">
                            <input type="hidden" id="deleteId" name="deleteId" value="">
                            
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>N° Cuenta</th>
                                            <th>Nombre</th>
                                            <th>Institución</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Área</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>N° Cuenta</th>
                                            <th>Nombre</th>
                                            <th>Institución</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Área</th>
                                            <th>Opciones</th>                                            
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                        // Establecer la conexión con la base de datos
                                        $mysqli = new mysqli("localhost", "root", "", "sistema");

                                        // Verificar la conexión
                                        if ($mysqli->connect_error) {
                                            die("Error en la conexión: " . $mysqli->connect_error);
                                        }

                                        // Consulta SQL para obtener los registros de la tabla
                                        $sql = "SELECT * FROM ServicioSocial";

                                        // Ejecutar la consulta SQL
                                        $result = $mysqli->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row['nCuenta'] . "</td>";
                                                echo "<td>" . $row['nombreSS'] . "</td>";
                                                echo "<td>" . $row['institucion'] . "</td>";
                                                echo "<td>" . $row['correoSS'] . "</td>";
                                                echo "<td>" . $row['telefonoSS'] . "</td>";

                                                // Consulta adicional para obtener el nombre del área
                                                $sql_area = "SELECT nombreArea FROM area WHERE idArea = " . $row['idArea'];
                                                $result_area = $conn->query($sql_area);
                                                $nombreArea = "";
                                                if ($result_area->num_rows > 0) {
                                                    $row_area = $result_area->fetch_assoc();
                                                    $nombreArea = $row_area["nombreArea"];
                                                }

                                                // Mostrar el nombre del área en la tabla
                                                echo "<td>" . $nombreArea . "</td>";

                                                echo '<td>
                                                <div class="btn-group">
                                                    <a href="ModificarSS.php?nCuenta=' . $row['nCuenta'] . '" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                                    <button type="button" class="btn btn-danger" onclick="prepareDelete(' . $row['nCuenta'] . ')" data-bs-toggle="modal" data-bs-target="#my-modal"><i class="fa-solid fa-trash"></i></button>
                                                </div>
                                            </td>';
                                            }
                                        } 

                                        // Cerrar la conexión
                                        $mysqli->close();
                                    ?>

                                    </tbody>
                                </table>
                            </form>
                            <div class="modal" id="my-modal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Estás seguro de que deseas eliminar este elemento?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">Eliminar</button>
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
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            <script src="js/scripts.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
            <script src="assets/demo/chart-area-demo.js"></script>
            <script src="assets/demo/chart-bar-demo.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
            <script src="js/datatables-simple-demo.js"></script>
            <script>
                function prepareDelete(nCuenta) {
                    document.getElementById("deleteId").value = nCuenta;
                    var myModal = new bootstrap.Modal(document.getElementById('my-modal'));
                    myModal.show();
                }

                function confirmDelete() {
                    document.getElementById("deleteForm").submit();
                }

                // Capturar el evento click del botón de edición
                var editButtons = document.getElementsByClassName("edit-button");
                for (var i = 0; i < editButtons.length; i++) {
                    editButtons[i].addEventListener("click", function() {
                        var nCuenta = this.getAttribute("data-nCuenta");
                        window.location.href = "ModificarSS.php?nCuenta=" + nCuenta;
                    });
                }

                // Redireccionar a ServicioSocial.php después de cerrar el modal
                var myModal = new bootstrap.Modal(document.getElementById('my-modal'));
                myModal._element.addEventListener('hidden.bs.modal', function() {
                    setTimeout(function() {
                        window.location.href = "Servicio-Social.php";
                    }, 1000); // Redireccionar después de 1 segundo (1000 milisegundos)
                });
            </script>
    </body>
</html>