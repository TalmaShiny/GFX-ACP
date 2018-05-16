<?php
include('header.php');
echo "<h1>Credits</h1>";

//INSPIRATION
$abfragei = "SELECT COUNT(id) AS anzahl FROM credits WHERE typ='inspiration'";
$ergebnisi = mysqli_query($link, $abfragei);
while ($row = mysqli_fetch_object($ergebnisi)) {
    echo "<h2>Inspirationsquellen (" . $row->anzahl . ")</h2>";
}
$abfrage = "SELECT * FROM credits WHERE typ='inspiration'";
$ergebnis = mysqli_query($link, $abfrage);
$a = 0;
while ($row = mysqli_fetch_object($ergebnis)) {
    echo "<a href='" . $row->url . "' target='_blank'>" . $row->name . "</a><br>";
    $a++;
}
if ($a == 0) {
    echo "Bisher keine Credits.<br>";
}
echo "<br>";

//TUTORIALS
$abfraget = "SELECT COUNT(id) AS anzahl FROM credits WHERE typ='tutorial'";
$ergebnist = mysqli_query($link, $abfraget);
while ($row = mysqli_fetch_object($ergebnist)) {
    echo "<h2>Tutorials (" . $row->anzahl . ")</h2>";
}
$abfrage = "SELECT * FROM credits WHERE typ='tutorial'";
$ergebnis = mysqli_query($link, $abfrage);
$b = 0;
while ($row = mysqli_fetch_object($ergebnis)) {
    echo "<a href='" . $row->url . "' target='_blank'>" . $row->name . "</a><br>";
    $b++;
}
if ($b == 0) {
    echo "Bisher keine Credits.<br>";
}
echo "<br>";

//BRUSHES
$abfrageb = "SELECT COUNT(id) AS anzahl FROM credits WHERE typ='brushes'";
$ergebnisb = mysqli_query($link, $abfrageb);
while ($row = mysqli_fetch_object($ergebnisb)) {
    echo "<h2>Brushes (" . $row->anzahl . ")</h2>";
}
$abfrage = "SELECT * FROM credits WHERE typ='brushes'";
$ergebnis = mysqli_query($link, $abfrage);
$c = 0;
while ($row = mysqli_fetch_object($ergebnis)) {
    echo "<a href='" . $row->url . "' target='_blank'>" . $row->name . "</a><br>";
    $c++;
}
if ($c == 0) {
    echo "Bisher keine Credits.<br>";
}
echo "<br>";

//TEXTURE
$abfraget = "SELECT COUNT(id) AS anzahl FROM credits WHERE typ='texture'";
$ergebnist = mysqli_query($link, $abfraget);
while ($row = mysqli_fetch_object($ergebnist)) {
    echo "<h2>Textures (" . $row->anzahl . ")</h2>";
}
$abfrage = "SELECT * FROM credits WHERE typ='texture'";
$ergebnis = mysqli_query($link, $abfrage);
$d = 0;
while ($row = mysqli_fetch_object($ergebnis)) {
    echo "<a href='" . $row->url . "' target='_blank'>" . $row->name . "</a><br>";
    $d++;
}
if ($d == 0) {
    echo "Bisher keine Credits.<br>";
}
echo "<br>";

//SONSTIGES
$abfrages = "SELECT COUNT(id) AS anzahl FROM credits WHERE typ='sonstiges'";
$ergebniss = mysqli_query($link, $abfrages);
while ($row = mysqli_fetch_object($ergebniss)) {
    echo "<h2>Sonstiges (" . $row->anzahl . ")</h2>";
}
$abfrage = "SELECT * FROM credits WHERE typ='sonstiges'";
$ergebnis = mysqli_query($link, $abfrage);
$e = 0;
while ($row = mysqli_fetch_object($ergebnis)) {
    echo "<a href='" . $row->url . "' target='_blank'>" . $row->name . "</a><br>";
    $e++;
}
if ($e == 0) {
    echo "Bisher keine Credits.<br>";
}

include('footer.php');
?>
