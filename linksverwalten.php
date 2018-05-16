<?php
include('header.php');
include('pagetest.php');

if (isset($_SESSION["acp"])) {

    if (isset($_REQUEST['submit_anzahl'])) {
        if ($_REQUEST['eingabe'] <= 10) {
            $Eingabe = $_REQUEST['eingabe'];
        } else {
            echo "<p class='fault'>Die Grenze beträgt 10!</p>";
            $Eingabe = 10;
        }
    } else {
        $Eingabe = 1;
    }

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "delete") {
        if (is_numeric($_REQUEST["id"])) {
            if (exist("navilinks WHERE id = '" . $_REQUEST["id"] . "'", $link)) {
                mysqli_query($link, "DELETE FROM navilinks WHERE id = '" . $_REQUEST["id"] . "'");
                echo "<p class='ok'>Navigationspunkt wurde erfolgreich gelöscht.</p>";
            }
        }
    }
    if (!empty($_REQUEST["action"]) && $_REQUEST['action'] == 'update') {
        $eintrag = "UPDATE navilinks SET
			name = '" . save($_POST["name"], $link) . "',
			datei = '" . save($_POST["datei"], $link) . "',
			sparte = '" . save($_POST["sparte"], $link) . "'
			WHERE id= '" . $_REQUEST["id"] . "'";
        $eintragen = mysqli_query($link, $eintrag) OR die(mysqli_error($link));
        echo "<p class='ok'>Erfolgreich geändert!</p>";
    }
    if (!empty($_REQUEST["action"]) && $_REQUEST['action'] == 'newlink') {
        $anzahl = $_REQUEST["anzahl"];
        for ($i = 1; $i <= $anzahl; $i++) {
            $eintrag = "INSERT INTO navilinks (name, datei, sparte) VALUES (
				'" . save($_POST["name_" . $i], $link) . "',
				'" . save($_POST["datei_" . $i], $link) . "',
				'" . save($_POST["sparte_" . $i], $link) . "'
				)";
            $eintragen = mysqli_query($link, $eintrag) OR die(mysqli_error($link));
        }
        echo "<p class='ok'>Erfolgreich eingetragen!</p>";
    }
    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "edit") {
        if (is_numeric($_REQUEST["id"])) {
            $abfrage = "SELECT * FROM navilinks WHERE id = '" . $_REQUEST["id"] . "'";
            $query = mysqli_query($link, $abfrage);
            $row = mysqli_fetch_object($query);
            echo "<h1>ACP-Menü-Link bearbeiten</h1>";
            echo "<form action='?action=update&id=" . $_REQUEST["id"] . "' method='post'>";
            echo "<table>";
            echo "<tr>";
            echo "<td>Name:</td>";
            echo "<td><input type='text' name='name' size='20' value='" . $row->name . "'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Datei:</td>";
            echo "<td><input type='text' name='datei' size='20' value='" . $row->datei . "'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Sparte:</td>";
            echo "<td><input type='text' name='sparte' size='20' value='" . $row->sparte . "'></td>";
            echo "</tr>";
            echo "<tr height='10px'></tr>";
            echo "<tr>";
            echo "<td></td>";
            echo "<td><input type='submit' value='Speichern!' name='ok'></td>";
            echo "</tr>";
            echo "</table>";
            echo "</form>";
        }
    } else {

        /* ANZAHL HOCHLADEN */
        echo "<h1>Neuen Link hinzufügen</h1>";

        echo "Hier kannst du die Menüpunkte eintragen, die links im ACP-Menü sofort eingeblendet werden!<br>
			Sparte 1 ist nur für Admins zugänglich, Sparte 2 bezeichnet den Allgemeinen Bereich und 3 den GFX-Bereich.<BR><br>";

        if ($Eingabe <= 0) {
            $Eingabe = 1;
        }
        echo "Wieviele Links möchtest du erstellen?</br>";
        echo "<form action='?action=submit_anzahl' method='post'>";
        echo "<input type='text' name='eingabe' value='" . $Eingabe . "'> 
				<input type='submit' name='submit_anzahl' value='Go' >";
        echo "</form>";
        echo "<br /><br />";

        /* HOCHLADEN */
        echo "<form action='?action=newlink' method='post'>";
        echo "<table>";

        for ($i = 1; $i <= $Eingabe; $i++) {
            echo "<tr>";
            echo "<td>Name <b>" . $i . "</b>:</td>";
            echo "<td><input type='text' name='name_" . $i . "' size='20'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Datei <b>" . $i . "</b>:</td>";
            echo "<td><input type='text' name='datei_" . $i . "' size='20'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Sparte <b>" . $i . "</b>:</td>";
            echo "<td><input type='text' name='sparte_" . $i . "' size='20'></td>";
            echo "</tr>";
            echo "<tr height='10px'></tr>";

        }
        echo "<tr>";
        echo "<input type='hidden' name='anzahl' value='";
        if (isset($_REQUEST["eingabe"])) {
            echo $_REQUEST["eingabe"];
        } else {
            echo "1";
        }
        echo "'>";
        echo "<td></td>";
        echo "<td><input type='submit' value='Speichern!' name='ok'></td>";
        echo "</tr>";
        echo "</table>";
        echo "</form>";
        echo "<br><br>";

        echo "<h1>Bisherige Navilinks verwalten</h1>";
        /* SEITEN FUNKTION */
        $itemsPerPage = 20;
        $start = 0;
        if (!empty($_GET['go'])) {
            $start = ($_GET['go'] - 1) * $itemsPerPage;
        }
        pagefunc($itemsPerPage, "navilinks", $link);

        echo "<table cellpadding='4' cellspacing='1' border='0' class='tableinborder' width='90%'>";
        echo "<th>Name im Menü</th>";
        echo "<th>Link</th>";
        echo "<th>Menüsparte</th>";
        echo "<th></th>";
        $i = 0;
        if ($start >= 0) {
            $abfrage = "SELECT * FROM navilinks ORDER BY sparte ASC LIMIT " . $start . ", " . $itemsPerPage;
        } else {
            $abfrage = "SELECT * FROM navilinks ORDER BY sparte ASC LIMIT 0, " . $itemsPerPage;
        }
        $ergebnis = mysqli_query($link, $abfrage);
        while ($row = mysqli_fetch_object($ergebnis)) {
            echo "<tr>";
            echo "<td>";
            echo $row->name;
            echo "</td>";
            echo "<td>";
            echo $row->datei;
            echo "</td>";
            echo "<td align='center'>";
            echo $row->sparte;
            echo "</td>";
            echo "<td>";
            echo "<a href=?action=delete&id=" . $row->id . ">
					<img src='webicons/delete.png' border='0'></a> ";
            echo "<a href=?action=edit&id=" . $row->id . ">
					<img src='webicons/edit.png' border='0'></a>";
            echo "</td>";
            echo "</tr>";
            $i++;
        }

        echo "</table><br><br>";
    }
} else {
    echo "<p class='fault'>Kein Zutritt!</p>";
}
include('footer.php');
?>
