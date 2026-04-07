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
                            <a class="btn btn-primary" href="#">Inicio</a>
                        </li>
                        <li>
                            <a class="btn btn-primary" href="#analizar">Analizar</a>
                        </li>
                        <li>
                            <a class="btn btn-primary" href="#info">Información</a>
                        </li>
                        <li>
                            <a class="btn btn-primary" href="tutorial.php" target="_blank">Tutorial</a>
                        </li>
                        <li>
                            <a class="btn btn-primary" href="#lectura">Lectura fácil</a>
                        </li>
                        <li>
                            <a class="btn btn-primary" data-toggle="collapse" data-target=".navbar-collapse" href="#pautas">Pautas</a>
                        </li>
                        <li>
                            <a class="btn btn-primary" href="#contacto">Contacto</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container" style="background-color: #3E606F">
            <!-- Main jumbotron for a primary marketing message or call to action -->
            <div class="jumbotron" style="background-color: #3E606F">
                <h1 class="display-4">Easy to read - Advisor</h1>
                <p class="lead">La Lectura Fácil ayuda a personas con limitaciones lingüísticas, es la adaptación que permite una lectura
                    y comprensión más sencilla del contenido</p>
                <hr class="my-3">
                <p>Comprueba aquí la accesibilidad de tus diapositivas.</p>
                <a class="btn btn-secondary btn-lg" href="#analizar" role="button">Empezar</a>
            </div>

            <!-- Upload file -->
            <div class="jumbotron" id="analizar">
                <h1 style="text-align:center; color: #3E606F">Analizar diapositiva</h1>
                <div class="row">
                    <div class="col align-self-start">
                        <form action="./input/upload.php" method="post" enctype="multipart/form-data">
                            <center>
                                <div class="col-lg-6 col-sm-12 col-md-12" style="margin-top: 20px">
                                <div class="input-group form-inline">
                                    <label class="input-group-btn">
                                        <span class="btn btn-secondary">
                                            Examinar
                                            <input type="file" name="file_uploaded" style="display: none;">
                                        </span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Importar diapositiva..." name="file_name" required>
                                </div>
                                    <center>
                                        <h6 class="help-block" style="text-align:center; color: #3E606F">
                                            *Solo se permiten archivos de tipo html.
                                        </h6>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineTodas" value="todas" checked>
                                            <label class="form-check-label" for="inlineTodas">Todas</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineTexto" value="texto">
                                            <label class="form-check-label" for="inlineTexto">Texto</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineMaquetacion" value="maquetacion">
                                            <label class="form-check-label" for="inlineMaquetacion">Maquetación</label>
                                        </div>
                                    </center>
                                    <center>
                                        <input type="submit" class="btn btn-secondary" id="upload" value="Comprobar resultados">
                                    </center>
                                </div>
                            </center>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Información -->
            <div class="jumbotron" id="info" style="background-color: #3E606F">
                <h1 style="text-align:center">Información</h1>
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="card">
                            <img class="card-img-top img-responsive" src="./images/cambio.png" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title" style="color: #FCFFF5;">Cambio de formato</h5>
                                <p class="card-text">Analizamos tu diapositiva en
                                    <b>formato HTML</b>. Por tanto, el primer paso es obtener el contenido en dicho formato.
                                    Para ello te dejamos aquí un
                                    <b>tutorial</b> de como hacerlo.</p>
                                <center>
                                    <a href="https://slidewiki.org/" class="btn btn-secondary" target="_blank">Slidewiki</a>
                                    <a href="tutorial.php" class="btn btn-secondary" target="_blank">Tutorial</a>
                                </center>
                            </div>    
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="card">
                            <img class="card-img-top img-responsive" src="./images/subir.png" alt="Subir archivo">
                            <div class="card-body">
                                <h5 class="card-title" style="color: #FCFFF5;">Analiza tu archivo</h5>
                                <p class="card-text">Sube tu archivo con extensión .html, y podrás comprobar si
                                    <b>cumples</b> con las pautas de accesibilidad.</p>
                                <center>
                                    <a href="#pautas" class="btn btn-secondary">Pautas</a>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="card">
                            <img class="card-img-top img-responsive" src="./images/resultados.png" alt="Resultados">
                            <div class="card-body">
                                <h5 class="card-title" style="color: #FCFFF5;">Resultados</h5>
                                <p class="card-text">Cuando la aplicación procese tu fichero, proporcionará unos
                                    <b>resultados</b>. Además, podrás recibir un
                                    <b>análisis detallado</b> de aquellos puntos que debes mejorar.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" style="background-color: #3E606F">
            <!-- Lectura fácil -->
            <div class="jumbotron" id="lectura" style="background-color: #3E606F">
                <h1 style="text-align:center">¿Qué es la Lectura Fácil?</h1>
                <div class="row featurette">
                    <h2 class="featurette-heading" id="metodologia">Metodología</h2>
                    <br>
                    <p class="lead" style="padding-left: 26px; font-size: 16px">Lectura Fácil es la adaptación que permite una lectura y comprensión más sencilla del contenido. No sólo
                        abarca el
                        <b>texto</b>, sino también se refiere a las
                        <b>ilustraciones</b> y
                        <b>maquetación</b>. </p>
                    <p class="lead" style="padding-left: 26px; font-size: 16px">El método por el cual se hacen más comprensibles los textos, también es Lectura Fácil. Esto elimina barreras
                        para la
                        <b>comprensión, aprendizaje y participación.</b>
                    </p>
                    <p class="lead" style="padding-left: 26px; font-size: 16px">La intención de la Lectura Fácil es dirigirse a todas las personas. Aquellas que tienen
                        <b>dificultades lectoras transitorias</b> son las principales beneficiadas. </p>
                    <p class="lead" style="padding-left: 26px; font-size: 16px">Los colectivos involucrados son personas con escolarización deficiente, inmigrantes o con algún tipo
                        de transtorno.</p>
                    <hr class="my-3">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/gbPXbMo7NiQ" frameborder="0" allow="autoplay; encrypted-media"
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>

            <!-- Pautas -->
            <div class="jumbotron" id="pautas">
                <h1 style="text-align:center; color: #3E606F">Pautas</h1>
                <center>
                    <h5 style="text-align:center; color: #3E606F">
                        <em>Tenga en cuenta que no todas las pautas se valoran igual.</em>
                    </h5>
                </center>
                <div class="row featurette">
                    <div class="col-md-6">
                        <div class="panel panel-warning" style="margin: 20px 20px 0px 20px">
                            <div class="panel-heading" style="text-align: center; font-size: 20px; color: black">MAQUETACIÓN</div>
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td>
                                            <?php echo $pautasDesign['P1']; ?>
                                            <div class="info">
                                                <img src="./images/info.png" alt="info" style="margin-left: 8px">
                                                <span class="infoText">
                                                    <ul>
                                                        <li>Arial</li>
                                                        <li>Calibri</li>
                                                        <li>Candara</li>
                                                        <li>Corbel</li>
                                                        <li>Gill Sans</li>
                                                        <li>Helvética</li>
                                                        <li>Myriad</li>
                                                        <li>Segoe</li>
                                                        <li>Tahoma</li>
                                                        <li>Tiresias</li>
                                                        <li>Verdana</li>
                                                    </ul>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasDesign['P2']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasDesign['P3']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasDesign['P4']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasDesign['P5']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasDesign['P6']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasDesign['P7']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasDesign['P8']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasDesign['P9']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasDesign['P10']; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-info" style="margin: 20px 20px 0px 20px">
                            <div class="panel-heading" style="text-align: center; font-size: 20px; color:black">TEXTO</div>
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td>
                                            <?php echo $pautasText['P1']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasText['P2']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasText['P3']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasText['P4']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasText['P5']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasText['P6']; ?>
                                            <div class="info">
                                                <img src="./images/info.png" alt="info" style="margin-left: 8px">
                                                <span class="infoText2">
                                                    <dl>
                                                        <dt>
                                                            <span class="glyphicon glyphicon-ok"></span>
                                                        </dt>
                                                        <dd>22 de junio del 2018</dd>
                                                        <dt>
                                                            <span class="glyphicon glyphicon-remove"></span>
                                                        </dt>
                                                        <dd>22/06/2018</dd>
                                                    </dl>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasText['P7']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasText['P8']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasText['P9']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasText['P10']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasText['P11']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $pautasText['P12']; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contacto -->
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
                    data-placement="left">Volver</a>

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
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="./scripts/browse.js"></script>
        <script src="./scripts/top.js"></script>
    </body>

    </html>