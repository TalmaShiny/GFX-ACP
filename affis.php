<?php
include('header.php');
echo "<h1>Affiliates</h1>";
echo "<center>Möchtest du hier auch verlinkt werden?<br>";
echo "Dann schau doch hier vorbei: <a href='becomeaffi.php'>Partner/Affi werden</a></center><br><br>";

echo "<h2>Top 3 Affis</h2>";
echo "<table align=\"center\">";
echo "<tr>";
$affis_top = "SELECT * FROM affis ORDER BY hits DESC Limit 0,3";
$affi_query = mysqli_query($link, $affis_top);
if (mysqli_num_rows($affi_query) != 0) {
    while ($rowa = mysqli_fetch_object($affi_query)) {
        echo "<td align='center'>";
        echo "<div>";
        echo "<a href='go_affi.php?id=" . $rowa->id . "' target='_blank'><img src='" . $rowa->button . "' class='border'></a><br>";
        echo "Hits: ";
        if ($rowa->hits != "") {
            echo $rowa->hits;
        } else {
            echo "0";
        }
        echo "</div><br>";
        echo "</td>";
    }
}
echo "</tr>";
echo "</table>";

echo "<h2>Alle Affis</h2>";
echo "<table align=\"center\"><tr>";

$affis = "SELECT * FROM affis ORDER BY name";
$affi_e = mysqli_query($link, $affis);
$i = 0;
if (mysqli_num_rows($affi_e) != 0) {
    while ($rowa = mysqli_fetch_object($affi_e)) {
        if ($i % 4 == 0 && $i != 0) {
            echo "</tr><tr>";
        }
        $i++;

        echo "<td align='center'>";
        echo "<div>";
        echo "<a href='go_affi.php?id=" . $rowa->id . "' target='_blank'><img src='" . $rowa->button . "' class='border'></a><br>";
        echo "Hits: ";
        if ($rowa->hits != "") {
            echo $rowa->hits;
        } else {
            echo "0";
        }
        echo "</div><br>";
        echo "</td>";
    }
} else {
    echo "<td align=\"center\">Momentan keine Affis vorhanden.</td>";
}
echo "</tr></table>";

include("footer.php");
?>
