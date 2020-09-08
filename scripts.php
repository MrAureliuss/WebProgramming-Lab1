<?php

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
        $doc = new DOMDocument();
        @$doc->loadHTMLFile("table.html");
        $resultArray = array($x, $y, $r, checkSpotInArea());
        array_push($_SESSION['history'], $resultArray);
        echo $doc->saveHTML();
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
<html>
<body>
<script type="text/javascript">
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
    } else {
        document.getElementById("pResult").innerHTML = "Рикошет!"
        document.getElementById("pResult").style.color = "red"
    }


    let tableRef = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
    let data = <?php echo json_encode($_SESSION['history'])?>;

    for (let i = 0; i < data.length; i++) {
        let tr = document.createElement('TR');
        for (let j = 0; j < data[i].length; j++) {
            let text = data[i][j];
            let td = document.createElement('TD')
            if (typeof data[i][j] === "boolean") {
                data[i][j] === true ? td.style.cssText = 'color: green' : td.style.cssText = 'color: red';
                data[i][j] === true ? text = "Есть пробитие!" : text = "Рикошет!";
            }
            td.appendChild(document.createTextNode(text));
            tr.appendChild(td)
        }
        tableRef.appendChild(tr);
    }

</script>
</body>
</html>
