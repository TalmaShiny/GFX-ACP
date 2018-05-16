<?php
include("header.php");
include("pagetest.php");

echo "<h1>Reviews";
if (isset($_REQUEST["serie"])) {
    echo "&raquo " . $_REQUEST["serie"];
}
echo "</h1>";

/* Serien */
echo "<center>";
echo "<b>Filter-Typ wählen:</b><br><br> ";
echo "<a class='kommentare' href='reviews.php'>Alle</a> ";
echo "<a class='kommentare' href='?serie=Website'>Website</a> ";
echo "<a class='kommentare' href='?serie=Buch'>Buch/Zeitschrift</a> ";
echo "<a class='kommentare' href='?serie=Film'>Film/Serie</a> ";
echo "<a class='kommentare' href='?serie=Kosmetik'>Kosmetik</a> ";
echo "<a class='kommentare' href='?serie=Musik'>Musik/Bands</a> ";
echo "<a class='kommentare' href='?serie=Sonstiges'>Sonstiges</a>
		<br/><br/>";
echo "</center>";

$itemsPerPage = 10;
$start = 0;
if (!empty($_GET['go'])) {
    $start = ($_GET['go'] - 1) * $itemsPerPage;
}

$zusatz = "";
/* Seitenfunktion wenn nach Kategorie gefiltert */
if (!empty($_REQUEST["serie"])) {
    pagemittypundserie($itemsPerPage, "reviews", "", $_REQUEST["serie"], $link);
    $zusatz = "WHERE serie = '" . save($_REQUEST["serie"], $link) . "'";
} else {
    pagefunc($itemsPerPage, "reviews", $link);
}

echo "<table align='center'>";
echo "<tr>";

if ($start >= 0) {
    $abfragen_c1 = "SELECT * FROM reviews " . $zusatz . " ORDER BY id DESC LIMIT " . $start . "," . $itemsPerPage;
} else {
    $abfragen_c1 = "SELECT * FROM reviews " . $zusatz . " ORDER BY id DESC LIMIT 0," . $itemsPerPage;
}

$ergebnis_c1 = mysqli_query($link, $abfragen_c1);
$i = 0;
while ($row_c = mysqli_fetch_object($ergebnis_c1)) {
    if ($i != 0 && $i % 2 == 0) {
        echo "</tr><tr>";
    }

    echo "<td>";
    echo "<div class='gfx'>";
    echo "<strong>";
    echo substr($row_c->titel, 0, 18);
    if (strlen($row_c->titel) > 18) {
        echo "...";
    }
    echo "</strong><br>";
    echo "<div class='gfx'>";
    echo "<center><img src='Reviews/" . $row_c->id . $row_c->vorschau . "'></center>";
    echo "</div>";
    echo "Von: " . $row_c->webby . "<br>";
    echo "Typ: " . $row_c->serie . "<br>";
    echo "Kommentare: ";
    echo anzahl("reviews_kommentare WHERE review_id = '" . save($row_c->id, $link) . "'", $link) . "<br>";
    echo "Erstellt am: " . date("d.m.y", $row_c->date) . "<br>";

    if ($row_c->serie != "Website") {
        $bewertung = $row_c->bewertung;
    } else {
        $bewertung = ($row_c->rate1 + $row_c->rate2 + $row_c->rate3 + $row_c->rate4 + $row_c->rate5) / 5;
        $bewertung = round($bewertung);
    }
    echo "Bewertung: ";
    for ($b = 1; $b <= $bewertung; $b++) {
        echo "<img src='ratingsystem/star.png'>";
    }
    if ($i <= 5) {
        for ($a = 1; $b <= 5; $a++) {
            echo "<img src='ratingsystem/star_leer.png'>";
            $b++;
        }
    }
    echo "<center><a href='view_review.php?&id=" . $row_c->id . "'>
				<img src='webicons/view1.png' border='0px'></a></center>";
    echo "</div><br>";
    echo "</td>";
    $i++;
}
if ($i < 1) {
    echo "<center>Bisher sind keine Reviews vorhanden</center>";
}
echo "</tr>";
echo "</table>";

include("footer.php");
?>
