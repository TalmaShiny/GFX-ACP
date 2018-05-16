<?php
include("header.php");
include("pagetest.php");

echo "<h1>Tutorials";
if (isset($_REQUEST["serie"])) {
    echo "&raquo " . $_REQUEST["serie"];
}
echo "</h1>";

/* Serien */
echo "<table align='center'>";
echo "<tr>";
echo "<td colspan='5'>";
echo "<center><b>Filter-Typ wählen:</b><br><br></center>";
echo "<a class='kommentare' href='tutorials.php'>Alle</a> ";
echo "<a class='kommentare' href='?serie=Grafikprogramm'>Grafikprogramme</a> ";
echo "<a class='kommentare' href='?serie=PHP-Programmierung'>PHP-Programmierung</a> ";
echo "<a class='kommentare' href='?serie=HTML/CSS'>HTML/CSS</a> ";
echo "<a class='kommentare' href='?serie=Sonstiges'>Sonstiges</a>
				<br/><br/>";
echo "</td>";
echo "</tr>";
echo "</table>";

$itemsPerPage = 10;
$start = 0;
if (!empty($_GET['go'])) {
    $start = ($_GET['go'] - 1) * $itemsPerPage;
}

$zusatz = "";
/* Seitenfunktion wenn nach Kategorie gefiltert */
if (!empty($_REQUEST["serie"])) {
    pagemittypundserie($itemsPerPage, "tutorials", "", $_REQUEST["serie"], $link);
    $zusatz = "WHERE serie = '" . save($_REQUEST["serie"], $link) . "'";
} else {
    pagefunc($itemsPerPage, "tutorials", $link);
}

echo "<table align='center'>";
echo "<tr>";

if ($start >= 0) {
    $abfragen_c1 = "SELECT * FROM tutorials " . $zusatz . " ORDER BY id DESC LIMIT " . $start . "," . $itemsPerPage;
} else {
    $abfragen_c1 = "SELECT * FROM tutorials " . $zusatz . " ORDER BY id DESC LIMIT 0," . $itemsPerPage;
}

$ergebnis_c1 = mysqli_query($link, $abfragen_c1);
$i = 0;
while ($row_c = mysqli_fetch_object($ergebnis_c1)) {
    if ($i != 0 && $i % 2 == 0) {
        echo "</tr><tr>";
    }

    echo "<td>";
    echo "<div class='gfx'>";
    echo "<strong>" . $row_c->titel . "</strong><br>";
    echo "<div class='gfx'>";
    echo "<center><img src='Tutorials/" . $row_c->id . $row_c->vorschau . "'></center>";
    echo "</div>";
    echo "Von: " . $row_c->webby . "<br>";
    echo "Typ: " . $row_c->serie . "<br>";
    echo "Kommentare: ";
    echo anzahl("tutorials_kommentare WHERE tutorial_id = '" . save($row_c->id, $link) . "'", $link) . "<br>";
    echo "Erstellt am: " . date("d.m.y", $row_c->date) . "<br>";
    echo "<center><a href='view_tutorials.php?id=" . $row_c->id . "'>
				<img src='webicons/view1.png' border='0px'></a></center>";
    echo "</div><br>";
    echo "</td>";
    $i++;
}
if ($i < 1) {
    echo "<center>Bisher sind keine Tutorials vorhanden</center>";
}
echo "</tr>";
echo "</table>";

include("footer.php");
?>
