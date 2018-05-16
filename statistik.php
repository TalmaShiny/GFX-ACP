<?php
include("header.php");

echo "<h1>Statistiken</h1>";

echo "<table width='95%'>";
echo "<tr>";
echo "<td style='vertical-align: top;'>"; // Besucher
echo "<h2>Besucher</h2>";
echo "Besucher online: " . countbesucheronline(time(), $link) . "<br>";
echo "Besucher gestern: ";
$gestern = date("Y-m-d", time() - 86400);
echo countbesuchertag($gestern, $link) . "<br>";
echo "Besucher heute: ";
$heute = date("Y-m-d");
echo countbesuchertag($heute, $link) . "<br>";
echo "Besucher gesamt: ";
echo countbesuchergesamt($link) . "<br>";
echo "meisten Besucher: ";
$besucher = maxbesucher($link);
echo $besucher["datum"] . " (" . $besucher["anzahl"] . ")<br>";
echo "</td>";
echo "<td style='vertical-align: top;'>";// Other
echo "<h2>Other</h2>";
echo "Teammitglieder: " . countteammitglieder($link) . "<br>";
echo "Graphics: ";
echo countgraphics($link) . "<br>";
echo "Tutorials: ";
echo counttutorial($link) . "<br>";
echo "Affiliates: ";
echo countaffiliate($link) . "<br>";
echo "</td>";
echo "</tr>";
echo "</table>";

include "footer.php";

?>
