<?php

$x_values = array(-4, -3, -2, -1, 0, 1, 2, 3, 4);
function checkData()
{
    global $x_values;

    $y = $_POST['y'];
    $r = $_POST['r'];
    $x = $_POST['rangeSlider'];

    if ($y < -3 || $y > 3 || $r < 1 || $r > 4 || !in_array($x, $x_values)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        $doc = new DOMDocument();
        @$doc->loadHTMLFile("table.html");
        $_SESSION['message'] = "wrong login";
        echo $doc->saveHTML();
    }
}

checkData();
