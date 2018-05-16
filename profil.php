<?php
include("header.php");
include("bbc.inc.php");

if (exist("benutzer WHERE id = '" . save($_REQUEST["user"], $link) . "'", $link)) {
    $abfrage = "SELECT * FROM benutzer WHERE id = '" . save($_REQUEST["user"], $link) . "' LIMIT 0,1";
    $ergebnis = mysqli_query($link, $abfrage);
    while ($row = mysqli_fetch_object($ergebnis)) {
        echo "<center>";
        echo "<h1>Profil von " . $row->name . "</h1>";
        echo "<table width=90%>";
        echo "<tr>";
        echo "<td width=1% valign=top>";
        echo "<div class=\"gfx\">";
        if (!empty($row->bild)) {
            echo "<img src=Teamicons/" . $row->id . $row->bild . " border=0><br>";
        } else {
            echo "<img src='Teamicons/default.png' border='0'><br>";
        }
        echo "<center>" . $row->name . "</center></div>";
        echo "</td>";
        echo "<td width=99%>";
        echo "<table width=100%>";
        echo "<tr>";
        echo "<td width=50%><b>Name:</b></td>";
        echo "<td width=50%>" . $row->name . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td width=50%><b>Letztes mal online:</b></td>";
        echo "<td width=50%>" . date("d.m.Y", $row->refresh) . " um " . date("H:i", $row->refresh) . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td width=50%><b>Im Team seit:</b></td>";
        echo "<td width=50%>" . date("d.m.Y", $row->since);
        echo "</tr>";
        if (!empty($row->email)) {
            echo "<tr>";
            echo "<td width=50%><b>E-Mail:</b></td>";
            echo "<td width=50%><a href='mailto:" . $row->email . "'>" . $row->email . "</a>";
            echo "</td>";
            echo "</tr>";
        }
        if (!empty($row->tag)) {
            echo "<tr>";
            echo "<td width=50%><b>Geburtstag:</b></td>";
            echo "<td width=50%>";
            echo $row->tag . "." . $row->monat . "." . $row->jahr;
            echo "</td>";
            echo "</tr>";
        }
        if (!empty($row->hp)) {
            echo "<tr>";
            echo "<td width=50%><b>Homepage:</b></td>";
            echo "<td width=50%> <a href='" . $row->hp . "' target='_blank'>" . $row->hp . "</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "</center>";

        echo "<br><b>Benutzertext:</b><br />" . bbccode($row->benutzertext, $link);
        echo "<br /><br>";
    }
}
include("footer.php");
?>
