<?php
    if(!isset($_SESSION)){ 
        session_start();
        
        switch ($_GET["option"]) {
            case "todas":
                include_once ("./analyzer/textAnalyzer.php");
                include_once ("./analyzer/designAnalyzer.php");
                $textResult = textAnalyzer();
                $designResult = designAnalyzer();
                break;
            case "texto":
                include_once ("./analyzer/textAnalyzer.php");
                $textResult = textAnalyzer();
                break;
            case "maquetacion":
                include_once ("./analyzer/designAnalyzer.php");
                $designResult = designAnalyzer();
                break;
        }
    }
    //Get the file uploaded, included in session
    $file_uploaded = $_SESSION['file_uploaded'];
    

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
    
    $textScore = array();
    $textScore['P1'] = rtrim($all_parameters[31]);
    $textScore['P2'] = rtrim($all_parameters[32]);
    $textScore['P3'] = rtrim($all_parameters[33]);
    $textScore['P4'] = rtrim($all_parameters[34]);
    $textScore['P5'] = rtrim($all_parameters[35]);
    $textScore['P6'] = rtrim($all_parameters[36]);
    $textScore['P7'] = rtrim($all_parameters[37]);
    $textScore['P8'] = rtrim($all_parameters[38]);
    $textScore['P9'] = rtrim($all_parameters[39]);
    $textScore['P10'] = rtrim($all_parameters[40]);
    $textScore['P11'] = rtrim($all_parameters[41]);
    $textScore['P12'] = rtrim($all_parameters[42]);

    $designScore = array();
    $designScore['P1'] = rtrim($all_parameters[45]);
    $designScore['P2'] = rtrim($all_parameters[46]);
    $designScore['P3'] = rtrim($all_parameters[47]);
    $designScore['P4'] = rtrim($all_parameters[48]);
    $designScore['P5'] = rtrim($all_parameters[49]);
    $designScore['P6'] = rtrim($all_parameters[50]);
    $designScore['P7'] = rtrim($all_parameters[51]);
    $designScore['P8'] = rtrim($all_parameters[52]);
    $designScore['P9'] = rtrim($all_parameters[53]);
    $designScore['P10'] = rtrim($all_parameters[54]);

    $clas = array();
    $clas['CL0'] = rtrim($all_parameters[56]);
    $clas['CL1'] = rtrim($all_parameters[58]);
    $clas['CL2'] = rtrim($all_parameters[59]);
    $clas['CL3'] = rtrim($all_parameters[60]);

    $com = array();
    $com['CM0'] = rtrim($all_parameters[62]);
    $com['CM1'] = rtrim($all_parameters[64]);
    $com['CM2'] = rtrim($all_parameters[65]);
    $com['CM3'] = rtrim($all_parameters[66]);

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

    <body onload="load()" style="padding-top: 50px">
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
                        <a id="back-to-top" href="#" class="btn btn-primary" data-toggle="tooltip" style="display: none;">Inicio</a>
                        </li>
                        <li>
                            <a class="btn btn-primary" href="#clasificacion">Clasificación</a>
                        </li>
                        <li>
                            <a class="btn btn-primary" href="#maquetacion">Maquetación</a>
                        </li>
                        <li>
                            <a class="btn btn-primary" href="#texto">Texto</a>
                        </li>
                        <li>
                            <a class="btn btn-primary" href="#pautas">Pautas</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container" style="background-color: #3E606F">

            <div id="loader"></div>

            <div class="time" style="display:none;" id="myDiv">

                <!-- Score -->
                <div class="jumbotron" id="clasificacion" style="text-align: center; background-color: #3E606F">
                    <h1 class="display-4">Tu clasificación es:</h1>
                    <hr class="my-3">
                    <center>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="lead">Has obtenido una valoración de:</p>
                                <h1>
                                    <?php
                                    //If textResult array doesn't contain a key, that means that this one is correct.
                                        if(!empty($file_uploaded)){
                                            $finalScore=0;
                                            $totalScore=0;
                                            //Text
                                            if(($_GET["option"] == "texto") || ($_GET["option"] == "todas")) {
                                                $totalScore+=50;
                                                foreach($textScore as $key => $value){
                                                    if(!array_key_exists ($key, $textResult)){
                                                        $finalScore += $textScore[$key];
                                                        $finalTextScore += $textScore[$key];
                                                    }
                                                }
                                            }
                                            //Design
                                            if(($_GET["option"] == "maquetacion") || ($_GET["option"] == "todas")) {
                                                $totalScore+=50;
                                                foreach($designScore as $key => $value){
                                                    if(!array_key_exists ($key, $designResult)){
                                                        $finalScore += $designScore[$key];
                                                        $finalDesignScore += $designScore[$key];
                                                    }
                                                }
                                            }
                                            if (($finalScore/$totalScore)*100 < 50){
                                                echo $clas['CL1'];
                                            } else if (($finalScore/$totalScore)*100 < 80){
                                                echo $clas['CL2'];
                                            } else{
                                                echo $clas['CL3'];
                                            }
                                        }else{
                                            echo "-";
                                        }
                                    ?>
                                </h1>

                                <!-- Gráfico -->
                                <p class="lead">Gráfico de aciertos:</p>
                                <canvas id="pie-chart" width="800" height="600"></canvas>
                            </div>
                        <div class="col-md-6">
                            <table class="table table-bordered table-striped table-dark">
                                <thead>
                                    <tr>
                                        <th scope="clasificacion"><?php echo $clas['CL0']; ?></th>
                                        <th scope="descripcion"><?php echo $com['CM0']; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row"><?php echo $clas['CL1']; ?></th>
                                        <td><?php echo $com['CM1']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $clas['CL2']; ?></th>
                                        <td><?php echo $com['CM2']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $clas['CL3']; ?></th>
                                        <td><?php echo $com['CM3']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </center>
                </div>

                <!-- Análisis -->
                <div class="jumbotron">
                    <h1 style="text-align:center; color: #3E606F">Analisis de resultados</h1>
                    <center>
                        <h3 style="color:#3E606F">
                            <?php 
                    if(empty($file_uploaded)){
                        echo "- correctos y - incorrectos";                        
                    } else if($_GET["option"] == "todas") {
                        $incorrects=count($designResult)+count($textResult);
                        $corrects= 22 - $incorrects;  
                        echo "$corrects correctos y $incorrects incorrectos"; 
                    } else if($_GET["option"] == "texto") {
                        $incorrects=count($textResult);
                        $corrects= 12 - $incorrects;  
                        echo "$corrects correctos y $incorrects incorrectos"; 
                    } else if($_GET["option"] == "maquetacion") {
                        $incorrects=count($designResult);
                        $corrects= 10 - $incorrects;  
                        echo "$corrects correctos y $incorrects incorrectos"; 
                    }
                ?>
                        </h3>
                    </center>
                        <div class="panel panel-info">
                            <div class="panel-heading" id="maquetacion" style="text-align: center; font-size: 26px; color: #3E606F">MAQUETACIÓN</div>
                            <table class="table table-hover">
                                <tbody style="text-align: left">

                                    <?php
                    if(($_GET["option"] == "maquetacion") || ($_GET["option"] == "todas")) {
                        if(!empty($file_uploaded)){
                            $i=0;
                            foreach($pautasDesign as $key => $value){
                                if(array_key_exists ($key, $designResult)){ ?>
                                        <tr>
                                            <td>
                                                <div class='panel panel-danger'>
                                                    <div class='panel-heading'>
                                                            <a style="color: red" data-toggle='collapse' <?php echo "href=#$key >"; echo $pautasDesign[$key]; ?>
                                                                (+info)</a>
                                                    </div>
                                                    <div <?php echo "id=$key "; ?> class='panel-collapse collapse'>
                                                        <div class='panel-body' style="font-size: 16px">
                                                            <?php echo $designResult[$key]; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } else {}
                                $i++;
                            }
                        }
                        ?>

                                        <?php

                        if(!empty($file_uploaded)){
                            $i=0;
                            foreach($pautasDesign as $key => $value){
                                if(array_key_exists ($key, $designResult)){} else { ?>
                                            <tr>
                                                <td>
                                                    <p style="color: green">
                                                        <?php echo $pautasDesign[$key]; ?>
                                                    </p>
                                                </td>
                                            </tr>
                                            <?php }
                                $i++;
                            }
                        }
                    } else { ?>
                                            <tr>
                                                <td>
                                                    <p style="text-align: center; color: green">
                                                        No hay datos.
                                                    </p>
                                                </td>
                                            </tr>
                                            <?php
                    }
                    ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="panel panel-info">
                            <div class="panel-heading" id="texto" style="text-align: center; font-size: 26px; color: #3E606F">TEXTO</div>
                            <table class="table table-hover">
                                <tbody style="text-align: left">
                                    <?php
                    $j=0;
                    if(($_GET["option"] == "texto") || ($_GET["option"] == "todas")) {
                        if(!empty($file_uploaded)){
                            foreach($pautasText as $key => $value){
                                if(array_key_exists ($key, $textResult)){ ?>
                                        <tr>
                                            <td>
                                                <div class='panel panel-danger'>
                                                    <div class='panel-heading'>
                                                            <a style="color: red" data-toggle='collapse' <?php echo "href=#$key". "_2 >"; echo $pautasText[$key]; ?>
                                                                (+info)</a>
                                                    </div>
                                                    <div <?php echo "id=$key". "_2 "; ?> class='panel-collapse collapse'>
                                                        <div class='panel-body' style="font-size: 16px">
                                                            <?php echo $textResult[$key]; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                }
                                $j++;
                            }
                        }
                    ?>
                                            <?php
                        $j=0;
                        if(!empty($file_uploaded)){
                            foreach($pautasText as $key => $value){
                                if(array_key_exists ($key, $textResult)){} else { ?>
                                                <tr>
                                                    <td>
                                                        <p style="color: green">
                                                            <?php echo $pautasText[$key]; ?>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <?php
                                }
                                $j++;
                            }
                        }
                    } else { ?>
                                                    <tr>
                                                        <td>
                                                            <p style="text-align: center; color: green">
                                                                No hay datos.
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <?php
                    }
                        ?>

                                </tbody>
                            </table>
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

                <!-- Button back-to-top -->
                <a id="back-to-top" href="#" class="btn btn-secondary back-to-top" role="button" title="Click para subir" data-toggle="tooltip"
                    data-placement="left" style="display: none">Volver</a>

                <!-- Footer -->
                <center>
                    <hr class="my-3">
                    <blockquote class="blockquote">
                        <footer class="blockquote-footer">This web application has been developed in the context of the SlideWiki project. Such a project has
                            received funding from the European Union's Horizon 2020 research and innovation programme under
                            grant agreement nº 688095</cite>
                        </footer>
                    </blockquote>
                </center>
                <hr>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="./scripts/loading.js"></script>
        <script src="./scripts/top.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        <script>
            new Chart(document.getElementById("pie-chart"), {
                type: 'pie',
                data: {
                    labels: ["Texto", "Maquetación", "Fallos"],
                    datasets: [{
                        backgroundColor: ["#193441", "#91AA9D", "#A3ACB4"],
                        data: [
                            '<?php echo round($finalTextScore, 2); ?>',
                            '<?php echo round($finalDesignScore, 2); ?>',
                            '<?php echo round(($totalScore-(round($finalTextScore,2) + round($finalDesignScore,2))), 2); ?>'
                        ]
                    }]
                },
            });
        </script>
    </body>

    </html>