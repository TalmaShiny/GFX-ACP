<?php

// teammitglieder zählen
function countteammitglieder($link)
{

    $suchstring = "select id as anzahl from benutzer";
    $result = mysqli_query($link, $suchstring);
    $ergebnis = mysqli_num_rows($result);

    return $ergebnis;
}

// tutorials zählen
function counttutorial($link)
{

    $suchstring = "select id as anzahl from tutorials";
    $result = mysqli_query($link, $suchstring);
    $ergebnis = mysqli_num_rows($result);

    return $ergebnis;
}

// Affiliates zählen
function countaffiliate($link)
{

    $suchstring = "select id as anzahl from affis";
    $result = mysqli_query($link, $suchstring);
    $ergebnis = mysqli_num_rows($result);

    return $ergebnis;
}

// Graphics zählen
function countgraphics($link)
{

    $icons = "select id as anzahl from gfx";
    $result = mysqli_query($link, $icons);
    $ergebnis = mysqli_num_rows($result);

    return $ergebnis;
}

?>
