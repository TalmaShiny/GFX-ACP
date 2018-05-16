<?php
include('header.php');
include('bbc.inc.php');
?>

<h1>Downloads</h1>

<?php
/* KATEGORIE AUSGABE */
echo "<center>";
echo "<b>Filter-Typ wählen:</b><br><br> ";
echo "<a href='downloads.php' class='kommentare'>Alle</a> ";
echo "<a href='?kategorie=php' class='kommentare'>PHP-Skripte</a> ";
echo "<a href='?kategorie=html' class='kommentare'>HTML/CSS-Skripte</a> ";
echo "<a href='?kategorie=psd' class='kommentare'>Photoshop Dateien</a> ";
echo "<a href='?kategorie=set' class='kommentare'>Resource Sets</a>";
echo "<br/>";
echo "</center><br><br>";

if (!empty($_REQUEST["kategorie"])) {
    $abfragephp = "SELECT COUNT(id) AS anzahl FROM downloads WHERE typ='" . $_REQUEST['kategorie'] . "'";
    $ergebnisphp = mysqli_query($link, $abfragephp);
    while ($row = mysqli_fetch_object($ergebnisphp)) {
        echo "<center>In dieser Kategorie findest du " . $row->anzahl . " Downloads!</center><br>";
    }
    $abfrage = "SELECT * FROM downloads WHERE typ='" . $_REQUEST['kategorie'] . "' ORDER by id DESC";
} else {
    $abfrage = "SELECT * FROM downloads ORDER by id DESC";
}
$ergebnis = mysqli_query($link, $abfrage);
echo "<table width='100%'>";
while ($row = mysqli_fetch_object($ergebnis)) {
    echo "<tr>";
    echo "<td>";
    echo "<div class='gfx'>";
    echo "<h2>" . $row->name . "</h2>";
    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<div class='gfx'>";
    echo "<img src='Downloads/vorschau" . $row->id . $row->vorschau . "'>";
    echo "</div>";
    echo "</td>";
    echo "<td>";
    echo "<B>Download-Typ:</B> " . $row->typ . "<br>";

    $select_kommentare = "SELECT count(id) AS anzahl FROM downloads_kommentare 
									WHERE dl_id='" . $row->id . "'";
    $queryanzahl = mysqli_query($link, $select_kommentare);
    $row2 = mysqli_fetch_object($queryanzahl);
    echo "<B>Kommentare:</B> " . $row2->anzahl . "<br>";

    echo "<B>Beschreibung:</B> " . bbccode($row->info, $link) . "<br><br>";
    echo "<a href='go_dls.php?id=" . $row->id . "' class='kommentare'>
									Lesen [" . $row->views . "]</a> ";
    echo "<a href='go_dls2.php?id=" . $row->id . "' class='kommentare'>
									Download [" . $row->downloads . "]</a>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
    echo "</td>";
    echo "</tr>";
}
echo "</table><br><br><br>";
echo "</center>";

include('footer.php');
?>
