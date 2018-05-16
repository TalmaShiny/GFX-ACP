<?php
include('header.php');

if (isset($_SESSION["acp"]) && wert("benutzer WHERE id='" . $_SESSION["acp"] . "'", "gruppe", $link) == 1) {
    echo "<h1>Auswertung des Logs</h1>";
    $proseite = 10; // Eintrage pro Seite
    if (!isset($_REQUEST["seite"])) { // Wenn die Seite leer ist, ist Seite = 0
        $seite = 0;
    } else { //Ansonsten wird sie erfragt
        $seite = $_REQUEST["seite"];
    }
    $count = 0;
    echo "<center>";
    echo "Seite/n: ";

    $abfrage1 = "SELECT id FROM benutzer_login";
    $ergebnis1 = mysqli_query($link, $abfrage1);
    while ($row1 = mysqli_fetch_object($ergebnis1)) {
        if ($count % $proseite == 0) {
            $aktuelleseite = $count / $proseite + 1;
            if ($count == $seite) {
                echo $aktuelleseite . " ";
            } else {
                echo " <a href=?seite=$count>" . $aktuelleseite . "</a> ";
            }
        }
        $count++; // Bildernummer erhöhen beim Durchlauf
    }

    echo "<br><br>";

    $abfrage = mysqli_query($link, "SELECT * FROM benutzer_login ORDER BY timestamp desc LIMIT " . $seite . "," . $proseite);
    echo "<table width='90%' cellpadding='4' cellspacing='1' border='0' class='tableinborder'><tr>";
    echo "<th width=\"30%\">Name</th>";
    echo "<th width=\"20%\">IP-Adresse</th>";
    echo "<th width=\"20%\">Datum</th>";
    echo "<th width=\"10%\">Uhrzeit</th>";
    echo "<th width=\"15%\">Status</th>";
    while ($row = mysqli_fetch_assoc($abfrage)) {
        echo "<tr>";
        echo "<td align='center'>" . $row['name'] . "</td>";
        echo "<td align='center'>" . $row['ip'] . "</td>";
        echo "<td align='center'>" . date("d.m.Y", $row['timestamp']) . "</td>";
        echo "<td align='center'>" . date("H:i", $row['timestamp']) . "</td>";
        echo "<td align='center'>" . $row['status'] . "</td>";
        echo "</tr>";
    }
    echo "</table></center>";
} else {
    echo "<br>Du hast keinen Zutritt!";
}
include('footer.php');
?>
