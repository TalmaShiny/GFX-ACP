<?php
include("header.php");

echo "<h1>Das Team</h1>";
$abfrage = "SELECT count(id) AS anzahl FROM benutzer";
$ergebnis = mysqli_query($link, $abfrage);
$webby = mysqli_fetch_object($ergebnis);
$i = 0;
echo "Momentan besteht das Team aus <b>" . $webby->anzahl . "</b> Webbys!<br><br>";

echo "<table width=90% align=center";
echo "<tr>";
$abfrage = "SELECT * FROM benutzer";
$ergebnis = mysqli_query($link, $abfrage);
while ($row = mysqli_fetch_object($ergebnis)) {
    if ($i % 2 == 0) {
        echo "</tr><tr>";
    }
    $i++;
    echo "<td>";
    echo "<div class=\"gfx\" align='center'>";
    if (!empty($row->bild)) {
        echo "<div class='gfx' style='padding-right:6px; width:100px;'><img src=Teamicons/" . $row->id . $row->bild . " border='0'></div>";
    } else {
        echo "<div class='gfx' style='padding-right:6px; width:100px;'><img src='Teamicons/default.png' border='0'></div>";
    }
    echo "<b>Name:</b> " . $row->name . "<br>";
    echo "<b>Rang:</b> ";
    if ($row->gruppe == 1) {
        echo "Admin<br>";
    } elseif ($row->gruppe == 2) {
        echo "Webby<br>";
    }
    echo "<b>Status:</b> ";
    if ($row->refresh > (time() - 60 * 3)) {
        echo " <b><font color='#04B404'>online</font></b><br>";
    } else {
        echo " offline<br>";
    }
    echo "<br><br>";
    echo "<a href='profil.php?user=" . $row->id . "' class='kommentare'>Profil ansehen</a>";
    echo "<br><br>";
    echo "</div>";
    echo "</td>";
}
echo "</tr>";
echo "</table>";
include("footer.php");
?>
