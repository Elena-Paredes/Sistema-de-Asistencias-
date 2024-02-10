<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sistema de Gestión de Servicio Social</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
        <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fingerprintjs2/2.1.0/fingerprint2.min.js"></script> <!-- Biblioteca para capturar la huella digital -->
    </head>

    <body class="sb-nav-fixed">
        <div class="my-custom-navbar">
                <!-- Titulo de encabezado-->
                <a class="my-navbar-brand" href="MenuSalida.php">Sistema de Gestión de Servicio Social</a>
                <!-- Menu encabezado-->
                <div class="my-navbar-nav">
                    <div class="my-nav-item">
                        <a class="my-dropdown-item" href="login.php">Iniciar Sesión</a>
                    </div>
                    <div class="my-nav-item">
                        <a class="my-dropdown-item" href="MenuEntrada.php">Registrar Entrada</a>
                    </div>
                </div>
            </div>
        
        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">SALIDA</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="MenuEntrada.php">/Registro de Entrada</a></li>
                    </ol>

                    <!-- Recuadro resaltado -->
                        <div class="container text-center shadow-sm bg-light my-4 p-5">
                            <img src="http://132.248.139.119/~uc/assets/img/logos/logo_uc_nombre.png" style="width:140px; height:90px;" class="responsive-img" alt="Logo UC">
                            <p>El presente menú está diseñado para garantizar un proceso seguro de registro de salida del personal de Servicio Social. Para registrar tu hora de salida al edificio requiere que proporciones un "token", que es un código único por área. Favor de ponerte en contacto con tu líder técnico.</p>
                        </div>

                        <div class="row">
                            <div class="container">
                                <div style="position: absolute; top: 1; right: 0; margin: 1px;">
                                    <h2><a style="text-decoration:none;" href="https://www.zeitverschiebung.net/es/city/3530597"><span style="color:gray;">Hora actual en</span><br />Mexico City, México</a></h2>
                                    <iframe src="https://www.zeitverschiebung.net/clock-widget-iframe-v2?language=es&size=large&timezone=America%2FMexico_City" width="100%" height="140" frameborder="0" seamless></iframe>
                                </div>
                            </div>
                        </div>

                        <form id="miFormulario" method="POST" action="registrarSalida.php" autocomplete="off">
                            <div class="row justify-content-start"> 
                                <div class="col-md-4">
                                    <div class="card">
                                        <!-- Contenido del primer recuadro -->
                                        <img class="card-img-top" src="http://localhost/img/UC.png" alt="Card image cap">
                                        <div class="card-body">
                                        <div id="alert-container"></div>
                                            <h5 class="card-title">Datos</h5>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputNumber" type="text" name="nCuenta" placeholder="Número de Cuenta" />
                                                <label for="inputNumber">Número de Cuenta</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputToken" type="password" name="token" placeholder="token" autocomplete="off"/>
                                                <label for="inputToken">Token</label>
                                            </div>
                                            <!--<button class="btn btn-primary" id="captureButton">Capturar Huella</button>  Botón de captura de huella -->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4"> 
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Actividad</h5>
                                            <div class="form-floating mb-3">
                                                <!-- Cambiar input por textarea -->
                                                <textarea class="form-control" id="inputComment" name="actividad" placeholder="Escribe tu comentario aquí" rows="5"></textarea>
                                                <label for="inputComment">Actividad</label>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Confirmar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                <h4 class="modal-title">Registro exitoso</h4>
                                </div>
                                <div class="modal-body">
                                <p><?php echo $mensaje; ?></p>
                                </div>
                            </div>
                            </div>
                        </div>
                </div>
            </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
           document.getElementById('miFormulario').addEventListener('submit', function(e) {
    e.preventDefault();

    var nCuenta = document.getElementById('inputNumber').value;
    var token = document.getElementById('inputToken').value;
    var actividad = document.getElementById('inputComment').value;

    $.ajax({
        type: "POST",
        url: "registrarSalida.php",
        data: {nCuenta: nCuenta, token: token, actividad: actividad},
        dataType: "json", // Indica que esperas un JSON como respuesta
        success: function(response) {
            if(response.mensaje.startsWith("Registro de salida exitoso")) {
                // Mostrar modal de éxito con mensaje personalizado
                $('#myModal .modal-body p').text(response.mensaje);
                $('#myModal').modal('show');

                // Redirigir después de 5 segundos
                setTimeout(function() {
                    window.location = "MenuSalida.php";
                }, 5000);
            } else {
                // Mostrar alerta con el mensaje de error
                document.getElementById('alert-container').innerHTML = 
                '<div class="alert alert-danger" role="alert">' + response.mensaje + '</div>';
            }
        },
        error: function() {
            // Mostrar alerta en caso de error de conexión
            document.getElementById('alert-container').innerHTML = 
            '<div class="alert alert-danger" role="alert">Error de conexión con el servidor.</div>';
        }
    });
});


    
            </script>
    </body>
</html>

