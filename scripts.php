<?php


function checkData()
{
    global $doc;
    $y = $_POST['y'];
    $r = $_POST['r'];
    $x = $_POST['rangeSlider'];

    if ($y <= -1 || $y >= 3) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        echo '<style type="text/css">
        #y {
            display: none;
        }
        </style>';
    }

}

checkData();

