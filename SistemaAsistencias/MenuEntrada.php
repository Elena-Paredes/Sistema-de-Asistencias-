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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>

    <body class="sb-nav-fixed">
        <div class="my-custom-navbar">
            <!-- Titulo de encabezado-->
            <a class="my-navbar-brand" href="MenuEntrada.php">Sistema de Gestión de Servicio Social</a>
            <!-- Menu encabezado-->
            <div class="my-navbar-nav">
                <div class="my-nav-item">
                    <a class="my-dropdown-item" href="login.php">Iniciar Sesión</a>
                </div>
                <div class="my-nav-item">
                    <a class="my-dropdown-item" href="MenuSalida.php">Registrar salida</a>
                </div>
            </div>
        </div>

        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">ENTRADA</h1>
                        <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="MenuSalida.php">/Registro de Salida</a></li>
                        </ol>

                        <!-- Recuadro resaltado -->
                        <div class="text-center shadow-sm bg-light my-4 p-5" style="position: relative; left: 2000;">
                            <img src="http://132.248.139.119/~uc/assets/img/logos/logo_uc_nombre.png" style="width:140px; height:90px;" class="responsive-img" alt="Logo UC">
                            <p>El presente menú está diseñado para garantizar un proceso seguro de registro de entrada del personal de Servicio Social. Para registrar tu hora de entrada al edificio requiere que proporciones un "token", que es un código único por área. Favor de ponerte en contacto con tu líder técnico.</p>
                        </div>

                        <div class="row">
                            <div class="container">
                                <div style="position: absolute; top: 1; right: 0; margin: 1px;">
                                    <h2><a style="text-decoration:none;" href="https://www.zeitverschiebung.net/es/city/3530597"><span style="color:gray;">Hora actual en</span><br />Mexico City, México</a></h2>
                                    <iframe src="https://www.zeitverschiebung.net/clock-widget-iframe-v2?language=es&size=large&timezone=America%2FMexico_City" width="100%" height="140" frameborder="0" seamless></iframe>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row justify-content-start" style="margin-left: -15px;">
                            <div class="col-md-4">
                                <div class="card">
                                    <img class="card-img-top" src="http://localhost/img/UC.png" alt="Card image cap">
                                    <div class="card-body">
                                        <div id="alert-container"></div>
                                        <h5 class="card-title">Datos</h5>
                                        <form id="miFormulario" method="POST" action="registrarEntrada.php" autocomplete="off">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputNumber" type="text" name="nCuenta" placeholder="Número de Cuenta" />
                                                <label for="inputNumber">Número de Cuenta</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputName" type="password" name="token" placeholder="token" autocomplete="off" />
                                                <label for="inputName">Token</label>
                                            </div>
                                            <input type="submit" class="btn btn-danger" value="Confirmar">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        <script>
            document.getElementById('miFormulario').addEventListener('submit', function(e) {
                e.preventDefault();

                var nCuenta = document.getElementById('inputNumber').value;
                var token = document.getElementById('inputName').value;

                $.ajax({
                    type: "POST",
                    url: "registrarEntrada.php",
                    data: {nCuenta: nCuenta, token: token},
                    success: function(response) {
                        if(response.startsWith("Registro exitoso")) {
                            // Mostrar modal de éxito
                            $('#myModal .modal-body p').text(response);
                            $('#myModal').modal('show');
                            
                            setTimeout(function() {
                                window.location = "MenuEntrada.php";
                            }, 5000);
                        } else {
                            // Mostrar alerta con el mensaje de error
                            document.getElementById('alert-container').innerHTML = 
                            '<div class="alert alert-danger" role="alert">' + response + '</div>';
                        }
                    }
                });
            });
        </script>

    </body>
</html>







