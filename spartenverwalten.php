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
            if (exist("navisparten WHERE id = '" . $_REQUEST["id"] . "'", $link)) {
                mysqli_query($link, "DELETE FROM navisparten WHERE id = '" . $_REQUEST["id"] . "'");
                echo "<p class='ok'>Menüsparte wurde erfolgreich gelöscht.</p>";
            }
        }
    }
    if (!empty($_REQUEST["action"]) && $_REQUEST['action'] == 'update') {
        $eintrag = "UPDATE navisparten SET spartenbezeichnung='" . save($_POST["name"], $link) . "' WHERE id='" . $_REQUEST["id"] . "'";
        $eintragen = mysqli_query($link, $eintrag) OR die(mysqli_error($link));
        echo "<p class='ok'>Erfolgreich geändert!</p>";
    }
    if (!empty($_REQUEST["action"]) && $_REQUEST['action'] == 'newsparte') {
        $anzahl = $_REQUEST["anzahl"];
        for ($i = 1; $i <= $anzahl; $i++) {
            $eintrag = "INSERT INTO navisparten (spartenbezeichnung) VALUES ('" . save($_POST["name_" . $i], $link) . "')";
            $eintragen = mysqli_query($link, $eintrag) OR die(mysqli_error($link));
        }
        echo "<p class='ok'>Erfolgreich eingetragen!</p>";
    }
    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "edit") {
        if (is_numeric($_REQUEST["id"])) {
            $abfrage = "SELECT * FROM navisparten WHERE id = '" . $_REQUEST["id"] . "'";
            $query = mysqli_query($link, $abfrage);
            $row = mysqli_fetch_object($query);
            echo "<h1>ACP-Menü-Sparte bearbeiten</h1>";
            echo "<form action='?action=update&id=" . $_REQUEST["id"] . "' method='post'>";
            echo "<table>";
            echo "<tr>";
            echo "<td>Menüspartenbezeichnung:</td>";
            echo "<td><input type='text' name='name' size='20' value='" . $row->spartenbezeichnung . "'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td></td>";
            echo "<td><input type='submit' value='Speichern!' name='ok'></td>";
            echo "</tr>";
            echo "</table>";
            echo "</form>";
        }
    } else {

        /* ANZAHL HOCHLADEN */
        echo "<h1>Neue Menüsparte hinzufügen</h1>";

        echo "Hier kannst du die Menüpunkte eintragen, die links im ACP-Menü sofort als Überschrift eingeblendet werden!<br>
			Die Nummern sind so genannte IDS und können daher lückenhaft auftreten. In der Navigation werden diese 
			aber fortlaufend nummeriert<BR> <b>Bisher:</b> Sparte 1 ist nur für Admins zugänglich, Sparte 2 bezeichnet 
			den Allgemeinen Bereich und 3 den GFX-Bereich.<br><br>";

        echo "Wieviele Sparten möchtest du erstellen?</br>";
        echo "<form action='?action=submit_anzahl' method='post'>";
        echo "<input type='text' name='eingabe' value='" . $Eingabe . "'> 
				<input type='submit' name='submit_anzahl' value='Go' >";
        echo "</form>";
        echo "<br /><br />";

        /* HOCHLADEN */
        echo "<form action='?action=newsparte' method='post'>";
        echo "<table>";

        for ($i = 1; $i <= $Eingabe; $i++) {
            echo "<tr>";
            echo "<td>Name <b>" . $i . "</b>:</td>";
            echo "<td><input type='text' name='name_" . $i . "' size='20'></td>";
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

        echo "<h1>Bisherige Menüsparten verwalten</h1>";
        /* SEITEN FUNKTION */
        $itemsPerPage = 20;
        $start = 0;
        if (!empty($_GET['go'])) {
            $start = ($_GET['go'] - 1) * $itemsPerPage;
        }
        pagefunc($itemsPerPage, "navisparten", $link);

        echo "<table cellpadding='4' cellspacing='1' border='0' class='tableinborder' width='90%'>";
        echo "<th>Nummer</th>";
        echo "<th>Bezeichnung</th>";
        echo "<th></th>";
        $i = 0;
        if ($start >= 0) {
            $abfrage = "SELECT * FROM navisparten ORDER BY id ASC LIMIT " . $start . ", " . $itemsPerPage;
        } else {
            $abfrage = "SELECT * FROM navisparten ORDER BY id ASC LIMIT 0, " . $itemsPerPage;
        }
        $ergebnis = mysqli_query($link, $abfrage);
        while ($row = mysqli_fetch_object($ergebnis)) {
            echo "<tr>";
            echo "<td align='center'>";
            echo $row->id;
            echo "</td>";
            echo "<td align='center'>";
            echo $row->spartenbezeichnung;
            echo "</td>";
            echo "<td align='center'>";
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
