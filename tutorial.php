<?php
    session_start();
    $file_uploaded = $_SESSION['file_uploaded'];
    $file_upload = './input' . $file_uploaded . '.html';
    unlink($file_upload);
    session_destroy();

    $parameters = 'parameters.txt';
    $all_parameters = file($parameters);

    $pautasText = array();
    $pautasText['P1'] = rtrim($all_parameters[2]);
    $pautasText['P2'] = rtrim($all_parameters[3]);
    $pautasText['P3'] = rtrim($all_parameters[4]);
    $pautasText['P4'] = rtrim($all_parameters[5]);
    $pautasText['P5'] = rtrim($all_parameters[6]);
    $pautasText['P6'] = rtrim($all_parameters[7]);
    $pautasText['P7'] = rtrim($all_parameters[8]);
    $pautasText['P8'] = rtrim($all_parameters[9]);
    $pautasText['P9'] = rtrim($all_parameters[10]);
    $pautasText['P10'] = rtrim($all_parameters[11]);
    $pautasText['P11'] = rtrim($all_parameters[12]);
    $pautasText['P12'] = rtrim($all_parameters[13]);

    $pautasDesign = array();
    $pautasDesign['P1'] = rtrim($all_parameters[17]);
    $pautasDesign['P2'] = rtrim($all_parameters[18]);
    $pautasDesign['P3'] = rtrim($all_parameters[19]);
    $pautasDesign['P4'] = rtrim($all_parameters[20]);
    $pautasDesign['P5'] = rtrim($all_parameters[21]);
    $pautasDesign['P6'] = rtrim($all_parameters[22]);
    $pautasDesign['P7'] = rtrim($all_parameters[23]);
    $pautasDesign['P8'] = rtrim($all_parameters[24]);
    $pautasDesign['P9'] = rtrim($all_parameters[25]);
    $pautasDesign['P10'] = rtrim($all_parameters[26]);
    
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Application that provides an easy-to-read analysis">
        <meta name="author" content="Roberto Barroso Garcia">
        <title>Easy-to-Read Advisor</title>

        <!-- Custom styles -->
        <link rel="shortcut icon" type="image/png" href="./images/icono-etr.png" />
        <link rel="stylesheet" href="css/styles.css">
    </head>

    <body style="padding-top: 50px">
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="./images/icono-etr.png" width="30" height="30" class="d-inline-block align-top" alt="Easy to read - Advisor">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMain" aria-controls="navbarMain"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav ml-auto">
                        <li>
                            <a class="btn btn-primary" href="index.php">Inicio</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container" style="background-color: #3E606F">
            <div class="jumbotron" id="lectura" style="background-color: #3E606F">
                <h2 class="display-4" style="text-align:left">Paso 1. Selecciona una diapositiva</h2>
                    <p class="lead">Una vez hayas accedido a SlideWiki, selecciona una diapositiva, o crea
                        una si lo prefieres. Aquí tienes un repositorio a modo de ejemplo:
                    </p>
                <div>
                    <center>
                        <a href="https://slidewiki.org/deck/125924/pruebas-de-diseno/deck/125924" class="btn btn-secondary" target="_blank">Ejemplos Diseño</a>
                        <a href="https://slidewiki.org/deck/125925/pruebas-de-texto/deck/125925" class="btn btn-secondary" target="_blank">Ejemplos Texto</a>
                        <hr class="my-3">
                        <img class="img-fluid" src="./images/instruc_1.png" alt="Instruccion 1">
                    </center>
                </div>
            </div>
        </div>
        <div class="container" style="background-color: #3E606F">
            <div class="jumbotron" style="background-color: #3E606F">
                <h2 class="display-4" style="text-align:left">Paso 2. Accede al modo edición</h2>
                    <p class="lead">Haz click en "Editar" y podrás realizar los cambios que consideres oportunos
                        en la diapositiva elegida.
                    </p>
                <hr class="my-3">
                <center>
                    <img class="img-fluid" src="./images/instruc_2.png" alt="Instruccion 2">
                </center>
            </div>
        </div>
        <div class="container" style="background-color: #3E606F">
            <div class="jumbotron" id="lectura" style="background-color: #3E606F">
                <h2 class="display-4" style="text-align:left">Paso 3. Obtén el código HTML</h2>
                    <p class="lead">Cuando estés listo, pulsa en "Editor HTML". Ahora debes copiar el código
                        que se muestra en la imagen y pegarlo en un editor de texto, y una
                        vez guardado tu archivo con extensión .html, ya podrás comprobar
                        si es de Lectura Fácil.
                    </p>
                    <hr class="my-3">
                <center>
                    <img class="img-fluid" src="./images/instruc_3.png" alt="Instruccion 3">
                </center>
                <hr class="my-3">
                <p class="lead">Esperamos que este tutorial te haya servido, si tienes alguna duda más, contacta con nosotros en el siguiente formulario.</p>
            </div>
        </div>

        <!-- Contacto -->
        <div class="container" style="background-color: #3E606F">
            <div class="jumbotron" id="lectura" style="background-color: #3E606F">
                <h1 id="contacto" style="text-align:center">Contacto</h1>
                <hr class="my-3">
                <div class="row">
                    <div class="col-md-6">
                        <iframe id="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3002.7683467614406!2d-3.8375662847629326!3d40.40540816425226!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd418f59d1469d93%3A0xf68b5804693b49f0!2sCampus+Montegancedo+-+Universidad+Polit%C3%A9cnica+de+Madrid!5e1!3m2!1ses!2ses!4v1520724376251"
                            width="650" height="350" frameborder="0" style="border:0; padding-left: 20px; width: 100%" allowfullscreen></iframe>
                    </div>
                    <div class="col-md-6">
                        <h4 style="margin-top: 20px; margin-bottom: 20px; padding-left: 25px">
                            <b>Envíanos tus comentarios</b>
                        </h4>
                        <form action="contact.php" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" value="" placeholder="Nombre *" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" value="" placeholder="E-mail *" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="subject" value="" placeholder="Asunto *" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="message" rows="3" placeholder="Mensaje *" required></textarea>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <button class="btn btn-secondary" type="submit" name="submit" value="submit">Enviar</button>
                                    </div>
                                    <div class="col">
                                        <h6>*Campos obligatorios</h6>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>        

            <!-- Button back-to-top -->
            <a id="back-to-top" href="#" class="btn btn-secondary back-to-top" role="button" title="Click para subir" data-toggle="tooltip"
                    data-placement="left" style="display: none">Volver</a>

            <!-- Footer -->
            <center>
                <hr class="my-3">
                <blockquote class="blockquote">
                    <footer class="blockquote-footer">This web application has been developed in the context of the SlideWiki project. Such a project has received
                        funding from the European Union's Horizon 2020 research and innovation programme under grant agreement
                        nº 688095</cite>
                    </footer>
                </blockquote>
            </center>
            <hr>
        </div>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="./scripts/browse.js"></script>
        <script src="./scripts/top.js"></script>
        <script>
            // Get the modal
            var modal = document.getElementById('id01');
            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
    </body>

    </html>