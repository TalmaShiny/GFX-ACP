<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include("db.php");
include("funktionen.php");
include("ratingsystem/rating.php"); /* Wenn Ratingsystem nicht downgeloaden und installiert wurde, bitte Zeile entfernen */
include("counter/besucherzaehler_class.php"); /* Wenn Besucherzähler nicht downgeloaden und installiert wurde, bitte Zeile entfernen */
include("counter/besucherzaehler.php"); /* Wenn Besucherzähler nicht downgeloaden und installiert wurde, bitte Zeile entfernen */
include("counter/statistik_functions.php"); /* Wenn Besucherzähler nicht downgeloaden und installiert wurde, bitte Zeile entfernen */

if (isset($_SESSION["acp"])) { // Wenn eingeloggt..
    refresh($_SESSION["acp"], $link); // refresht
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>The-Peril.com ACP Giveaway - Version 2.0</title>
    <link rel="stylesheet" media="all" type="text/css" href="style.css">
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
</head>
<body>
<script type="text/javascript" src="Tooltip/wz_tooltip.js"></script>
<div id="container">
    <div id="header"><br><br>ACP Giveaway - Version 2.0</div>

    <div id="navigation">
        <?php
        include('navi.php');
        ?>
    </div>

    <div id='content'>
