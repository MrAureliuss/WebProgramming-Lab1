<?php

// Да, я запихнул целую HTML страницу в PHP и что?

$x_values = array(-4, -3, -2, -1, 0, 1, 2, 3, 4);

$y = null;
$x = null;
$r = null;
$time_elapsed_secs = 0;
$resultArray = [];

session_start();
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = array();
}

function checkData()
{
    global $x_values;
    global $y, $x, $r;
    global $resultArray;

    $y = $_POST['y'];
    $r = $_POST['r'];
    $x = $_POST['select'];

    if ($y < -3 || $y > 3 || $r < 1 || $r > 4 || !in_array($x, $x_values)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        $resultArray = array($x, $y, $r, checkSpotInArea());
        array_push($_SESSION['history'], $resultArray);
    }
}

function checkSpotInArea()
{
    global $y, $x, $r;
    $inArea = false;

    if (($x >= -$r/2 && $x <= 0 && $y <= $r && $y >= 0) ||
    ($y >= (2*$x - $r/2) && $y <= 0 && $x >= 0) ||
    (($x*$x + $y*$y) <= $r*$r && $x <= 0 && $y <= 0)) {
        $inArea = true;
    }

    return $inArea;
}


checkData();

$inArea = checkSpotInArea();
$time_elapsed_secs = number_format((microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) * 1000000, 2, ",", ".") . " мкс";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">
    <script src="static/js/scripts.js" type="text/javascript"></script>
    <meta charset="UTF-8">
    <style>
        @import "https://fonts.googleapis.com/css?family=Lato:100";
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            overflow: hidden;
            font-size: 10px;
            font-family: "Lato", Arial, sans-serif;
        }

        button, input:focus {
            outline: 0;
        }

        section {
            overflow: hidden;
            width: 100%;
            height: 100vmax;
            color: #fff;
            background: linear-gradient(-45deg, #EE7752, #E73C73, #23A6D5, #23D5AB);
            background-size: 400% 400%;
            position: relative;
            animation: changeBack 10s ease-in-out infinite;
        }

        @keyframes changeBack {
            0% {
                background-position: 0 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0 50%;
            }
        }

        .footerRect {
            position: fixed;
            text-align: center;
            padding: 10px 10px 10px 21px;
            margin-left: -150px;
            top: 90%;
            left: 50%;
            width: 300px;
            height: 200px;
            font-size: 18px;
            font-family: Rockwell, sans-serif;
        }

        .baseInsideRect {
            position: absolute;
            top: 50%;
            left: 50%;
            mix-blend-mode: hard-light;
            padding: 30px 10px 10px 10px;
            border-radius: 20px;
            background-color: rgba(205, 205, 205, 0.85);
            font-family: Rockwell, sans-serif;
            font-size: 16px;
            color: black;
            text-align: center;
            vertical-align: middle;
        }

        .contentRect {
            position: fixed;
            text-align: left;
            top: 55%;
            left: 50%;
            margin-left: -250px;
            margin-top: -10%;
            width: 550px;
            height: 370px;
            mix-blend-mode: hard-light;
            border-radius: 20px;
            background-color: rgba(205, 205, 205, 0.85);
        }

        .baseInsideRect.actionTimeRect {
            margin-left: -225px;
            margin-top: -150px;
            width: 215px;
            height: 140px;
        }

        .baseInsideRect.currentTimeRect {
            margin-left: -225px;
            margin-top: 5px;
            width: 215px;
            height: 140px;
        }

        .baseInsideRect.xRect {
            margin-left: 5px;
            margin-top: -150px;
            width: 60px;
            height: 140px;
        }

        .baseInsideRect.yRect {
            margin-left: 85px;
            margin-top: -150px;;
            width: 60px;
            height: 140px;
        }

        .baseInsideRect.rRect {
            margin-left: 165px;
            margin-top: -150px;;
            width: 60px;
            height: 140px;
        }

        .baseInsideRect.resultRect {
            margin-left: 5px;
            margin-top: 5px;
            width: 220px;
            height: 140px;
        }

        p {
            padding-top: 16px;
        }

        #dataTable,
        #tableBody > td {
            table-layout: fixed;
            text-align: center;
            border-collapse: collapse;
        }

        td {
            padding: 10px;
        }

        .tableHead {
            overflow-y: auto;
            height: 250px;
            margin: -300px auto auto;
            width: 452px;
            color: black;
            font-size: 14px;
            font-family: sans-serif;
        }

        .tableHead thead th {
            position: sticky;
            top: 0;
            background-color: rgb(215, 215, 215);
            background-blend-mode: hard-light;
        }


        /* Photos */
        .photo {
            display: block;
            width: 32px;
            height: 32px;
            transition: transform .2s; /* Animation */
            opacity: .3;
            border: none;
            cursor: pointer;
        }

        .photo.cross {
            background-image: url("static/img/cross.png");
            margin-left: 510px;
            margin-top: 7px;
        }

        .photo.tableButton {
            background-image: url("static/img/datatable.png");
            margin-left: 510px;
            margin-top: 290px;
        }

        .photo:hover {
            opacity: .9;
        }


    </style>
    <title>Таблица</title>
</head>

<body>
<section>
    <table style="width: 100%; height: 100%;">
        <tr>
            <td>
                <main class="contentRect animated zoomIn">
                    <a class='photo cross' href='index.html'></a>
                    <a class='photo tableButton' id="tableButton" onclick="showTable()"></a>

                    <div id="infoContent">
                        <div class="baseInsideRect actionTimeRect">
                            <span>Время выполнения</span>
                            <p id="actionTime"></p>
                        </div>

                        <div class="baseInsideRect currentTimeRect">
                            <span>Текущее время</span>
                            <p id="currentTime"></p>
                            <script type="text/javascript">
                                function setTime() {
                                    document.getElementById("currentTime").innerHTML = new Date().toLocaleTimeString();
                                }

                                setInterval(setTime, 1000);
                                setTime();
                            </script>

                            <script type="text/javascript">
                                function setTime() {
                                    let audio = new Audio('');
                                    let x = '<?php echo $x;?>';
                                    let y = '<?php echo $y;?>';
                                    let r = '<?php echo $r;?>';
                                    let inArea = '<?php echo $inArea;?>';
                                    let elapsedTime = '<?php echo $time_elapsed_secs?>';
                                    document.getElementById("pX").innerHTML = x;
                                    document.getElementById("pY").innerHTML = y;
                                    document.getElementById("pR").innerHTML = r;
                                    document.getElementById("actionTime").innerHTML = elapsedTime;
                                    if (inArea) {
                                        document.getElementById("pResult").innerHTML = "Есть пробитие!"
                                        document.getElementById("pResult").style.color = "green"
                                        audio = new Audio('./static/audio/prob.mp3')
                                    } else {
                                        document.getElementById("pResult").innerHTML = "Рикошет!"
                                        document.getElementById("pResult").style.color = "red"
                                        audio = new Audio('./static/audio/ric.mp3')
                                    }

                                    // Зачем я сюда пихаю музыку?
                                    audio.volume = 0.1;
                                    audio.play();
                                }

                                setTimeout(setTime, 1);
                            </script>
                        </div>

                        <div class="baseInsideRect xRect">
                            <span>X</span>
                            <p id="pX"></p>
                        </div>

                        <div class="baseInsideRect yRect">
                            <span>Y</span>
                            <p id="pY"></p>
                        </div>

                        <div class="baseInsideRect rRect">
                            <span>R</span>
                            <p id="pR"></p>
                        </div>

                        <div class="baseInsideRect resultRect">
                            <span>Результат</span>
                            <p id="pResult"></p>
                        </div>
                    </div>

                    <div class="tableHead" id="table" style="visibility: hidden">
                        <table id="dataTable" style="text-align: center;" class="hide" width="100%">
                            <thead align="center">
                            <tr>
                                <th width="20%">X</th>
                                <th width="20%">Y</th>
                                <th width="20%">R</th>
                                <th width="40%">Результат</th>
                            </tr>
                            </thead>


                            <tbody id="tableBody">
                            <?php foreach ($_SESSION['history'] as $value) { ?>
                                <tr>
                                    <td><?php echo $value[0] ?></td>
                                    <td><?php echo $value[1] ?></td>
                                    <td><?php echo $value[2] ?></td>
                                    <?php
                                    if($value[3] == "1") echo "<td style='color:green;'>Есть пробитие!</td>";
                                    else echo "<td style='color:red;'>Рикошет!</td>";
                                    ?>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </main>
            </td>
        </tr>
        <tr>
            <td class="text-align:center;">
                <main class="footerRect animated rollIn">
                    2020
                    <br>
                    Какие у меня могут быть права?
                </main>
            </td>
        </tr>
    </table>
</section>
</body>
</html>
