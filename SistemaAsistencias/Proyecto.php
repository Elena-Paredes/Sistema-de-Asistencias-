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

// Paso 2: Consultar los datos de la tabla "Proyecto"
$sql = "SELECT p.idProyecto, p.nombreProyecto, ss.nombreSS, a.nombreArea, p.FechaEntrega, p.Descripcion
        FROM Proyecto p
        INNER JOIN ServicioSocial ss ON p.nCuenta = ss.nCuenta
        INNER JOIN Area a ON p.idArea = a.idArea";
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
                        <h1 class="mt-4">Proyectos</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="Index.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Proyectos</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                               Proyectos asignados al personal del servicio social por la Unidad de Cómputo durante su estancia. 
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">PROYECTOS</h5>
                                    <div class="d-flex">
                                    <a href="AgregarProyecto.php" class="btn btn-success me-2"><i class="fa-solid fa-plus"></i></a>
                                </div>
                                </div>
                                </div>
                            <div class="card-body">
                            <form id="deleteForm" action="eliminarProyecto.php" method="post">
                                <input type="hidden" id="deleteId" name="deleteId" value="">
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>Proyecto</th>
                                                <th>Asignado</th>
                                                <th>Área</th>
                                                <th>Fecha de Entrega</th>
                                                <th>Descripción</th>
                                                <th>Configuración</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Proyecto</th>
                                                <th>Asignado</th>
                                                <th>Área</th>
                                                <th>Fecha de Entrega</th>
                                                <th>Descripción</th>
                                                <th>Configuración</th>                                           
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php
                                            // Paso 3: Recorrer los resultados y generar las filas
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<tr data-project-id="' . $row['idProyecto'] . '">';
                                                    echo "<td>" . $row['nombreProyecto'] . "</td>";
                                                    echo "<td>" . $row['nombreSS'] . "</td>";
                                                    echo "<td>" . $row['nombreArea'] . "</td>";
                                                    echo "<td>" . $row['FechaEntrega'] . "</td>";
                                                    echo "<td>" . $row['Descripcion'] . "</td>";
                                                    echo '<td>
                                                    <div class="btn-group">
                                                        <a href="ModificarProyecto.php?id=' . $row["idProyecto"] . '" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                                        <button type="button" class="btn btn-success" onclick="deleteRow(' . $row['idProyecto'] . ')" data-bs-toggle="modal" data-bs-target="#my-modal"><i class="fa fa-check"></i></i></button>
                                
                                                    </div>
                                                </td>';
                                                
                                                }
                                            } 
                                            // Cerrar la conexión
                                            $conn->close();
                                            
                                            ?>
                                        </tbody>
                                    </table>
                            </form>
                            <!-- Modal -->
                                <div class="modal" id="my-modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Confirmar eliminación</h5>
                                                <a class="btn-close" data-bs-dismiss="modal" href="Proyecto.php"></a>
                                            </div>
                                            <div class="modal-body">
                                                ¿El proyecto ha sido concluido?
                                            </div>
                                            <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Confirmar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="modal" id="my-modal2">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Confirmar acción</h5>
                                                <a class="btn-close" data-bs-dismiss="modal" href="Proyecto.php"></a>
                                            </div>
                                            <div class="modal-body">
                                                ¿El proyecto ha sido concluido?
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button class="btn btn-success" data-bs-dismiss="modal" onclick="confirmDone()">Confirmar</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>-->
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
                let projectIdToMarkAsDone = null;

                function deleteRow(id) {
                    document.getElementById("deleteId").value = id;
                    // Las demás acciones, como mostrar el modal, etc.
                }

                function confirmDelete() {
                    document.getElementById("deleteForm").submit();
                }

                function confirmProjectCompletion(idProyecto) {
                    console.log("ID obtenido del botón:", idProyecto);
                    projectIdToMarkAsDone = idProyecto;
                }

                function confirmDone() {
                    console.log("Confirm Done called. Intended row ID:", projectIdToMarkAsDone);
                    
                    // Diagnostic code: Let's log all available project IDs
                    document.querySelectorAll('tr[data-project-id]').forEach(row => {
                        console.log("Available row with ID:", row.getAttribute('data-project-id'));
                    });
                    
                    // Find the intended row
                    const row = document.querySelector('tr[data-project-id="11"]');
                    console.log(row);
                    
                    if (row) {
                        row.classList.add('table-success'); // Esto colorea la fila
                        row.querySelectorAll('td').forEach(td => td.classList.add('table-success')); // Esto colorea cada celda de la fila
                    } else {
                        console.error("Row not found for project ID:", projectIdToMarkAsDone);
                    }

                    var modalElement = document.getElementById('my-modal2');
                    var modal = new bootstrap.Modal(modalElement);
                    modal.hide();
                }

                // Añadimos el event listener para todos los botones de confirmación
                document.querySelectorAll("[id^='confirm-']").forEach(button => {
                    button.addEventListener('click', function() {
                        const projectId = button.id.split('-')[1];
                        confirmProjectCompletion(projectId);
                    });
                });
            </script>
        </body>
</html>