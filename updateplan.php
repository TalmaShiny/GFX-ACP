<?php
include("header.php");

echo "<h1>Update-Kalender</h1>";

echo "Hier findest du den Kalender, in dem wichtige Ereignisse, 
	wie z.B. zukünftige Updates und Events festgehalten werden.<br><br><center>";

$tag = date("d");
$monat = date("m");
$jahr = date("y");

echo "<table cellpadding='4' cellspacing='1' border='0' class='tableinborder' width='90%'>";
echo "<th>Datum</th>";
echo "<th>Webby</th>";
echo "<th>Event</th>";
echo "<tr>";
$upa = "SELECT * FROM updateplan WHERE monat >='" . $monat . "' AND jahr >='" . $jahr . "' ORDER BY monat, tag, jahr ASC";
$upa_a = mysqli_query($link, $upa) OR die(mysqli_error($link));
while ($up = mysqli_fetch_object($upa_a)) {
    if ($up->monat == $monat) {
        if ($up->tag >= $tag) {
            echo "<tr valign='top'>";
            echo "<td valign='top'>";
            echo "" . $up->tag . "." . $up->monat . "." . $up->jahr;
            echo "</td>";
            echo "<td valign='top'>" . $up->name . "</td>";
            if ($up->event != "") {
                echo "<td valign='top'>" . $up->event . "</td>";
            } else {
                echo "<td valign='top'>Kein Event eingetragen.</td>";
            }
            echo "</tr>";
        }
    } elseif ($up->monat >= $monate) {
        echo "<tr valign='top'>";
        echo "<td valign='top'>";
        echo "" . $up->tag . "." . $up->monat . "." . $up->jahr;
        echo "</td>";
        echo "<td valign='top'>" . $up->name . "</td>";
        if ($up->event != "") {
            echo "<td valign='top'>" . $up->event . "</td>";
        } else {
            echo "<td valign='top'>Kein Event eingetragen.</td>";
        }
        echo "</tr>";
    }
}
echo "</table>";

include("footer.php");
?>
