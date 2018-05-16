<?php
include('header.php');
include('pagetest.php');
include('bbc.inc.php');

/* LATEST ADDS ANFANG */
$select = "SELECT * FROM gfx WHERE typ='Icon' ORDER BY id DESC LIMIT 1";
$query = mysqli_query($link, $select);
$icons = mysqli_fetch_object($query);
echo "<h1>Latest Additions</h1>";
echo "<table>";
echo "<tr>";
echo "<td>";
echo "<div class='gfx'><center><B>Icon</B><br>";
if (!empty($icons)) {
    echo "<a href='icons.php'><img src='Icons/" . $icons->id . $icons->bild . "' border='0' alt='Latest Icon'></a>";
}
echo "</center></div>";
echo "</td>";

$select2 = "SELECT * FROM gfx WHERE typ='Header' ORDER BY id DESC LIMIT 1";
$query2 = mysqli_query($link, $select2);
$header = mysqli_fetch_object($query2);
echo "<td>";
echo "<div class='gfx'><center><B>Header</B><br>";
if (!empty($header)) {
    echo "<a href='headers.php'><img src='Headers/" . $header->id . "_vorschau" . $header->vorschau . "' 
		border='0' alt='Latest Header'></a>";
}
echo "</center></div>";
echo "</td>";

$select3 = "SELECT * FROM gfx WHERE typ='Wallpaper' ORDER BY id DESC LIMIT 1";
$query3 = mysqli_query($link, $select3);
$wally = mysqli_fetch_object($query3);
echo "<td>";
echo "<div class='gfx'><center><B>Wallpapers</B><br>";
if (!empty($wally)) {
    echo "<a href='wallpapers.php'><img src='Wallpapers/" . $wally->id . "_vorschau" . $wally->vorschau . "' 
		border='0' alt='Latest Wallpaper'></a>";
}
echo "</center></div>";
echo "</td>";

$select4 = "SELECT * FROM gfx WHERE typ='Design' ORDER BY id DESC LIMIT 1";
$query4 = mysqli_query($link, $select4);
$design = mysqli_fetch_object($query4);
echo "<td>";
echo "<div class='gfx'><center><B>Design</B><br>";
if (!empty($design)) {
    echo "<a href='designs.php'><img src='Designs/" . $design->id . "_vorschau" . $design->vorschau . "' 
		border='0' alt='Latest Design'></a>";
}
echo "</center></div>";
echo "</td>";
echo "</tr>";
echo "</table>";
/* LATEST ADDS ENDE */

$itemsPerPage = 4;
$start = 0;
if (!empty($_GET['go'])) {
    $start = ($_GET['go'] - 1) * $itemsPerPage;
}
pagefunc($itemsPerPage, "news", $link);

if ($start >= 0) {
    $abfrage = "SELECT * FROM news ORDER BY id DESC LIMIT " . $start . ", " . $itemsPerPage;
} else {
    $abfrage = "SELECT * FROM news ORDER BY id DESC LIMIT 0, " . $itemsPerPage;
}
$ergebnis = mysqli_query($link, $abfrage);

while ($row = mysqli_fetch_object($ergebnis)) {
    echo "<div class='gfx'>";
    echo "<h1>" . $row->title . "</h1>";
    echo "<table width='100%'>";
    echo "<tr>";
    echo "<td>";
    echo "<p class='datum'><i>Von <b>" . $row->autor . "</b> - am 
					" . date("d.m.Y", $row->time) . " um " . date("H:i", $row->time) . " Uhr</i></p>";
    echo bbccode($row->text, $link) . "<br>";
    echo "<br>";
    if ($row->updates != "") {
        echo "<div class='updates'><h2>Updates:</h2>" . bbccode($row->updates, $link) . "</div>";
    }
    echo "<p align='right'><a href='newsentry.php?id=" . $row->id . "' class='kommentare'>Kommentieren (";
    $abfrage2 = "SELECT COUNT(id) AS anzahl FROM news_kommentare WHERE news_id='" . $row->id . "'";
    $ergebnis2 = mysqli_query($link, $abfrage2);
    while ($row2 = mysqli_fetch_object($ergebnis2)) {
        echo $row2->anzahl;
    }
    echo ")</a></p>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
}

include('footer.php');
?>
