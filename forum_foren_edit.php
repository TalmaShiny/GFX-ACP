<?php
include('header.php');
if (isset($_SESSION["acp"])) { // Wenn eingeloggt..

    if (isset($_POST['submit2'])) {
        if (isset($_POST['name'])) {
            $insert = "UPDATE forum_foren SET
				name = '" . mysqli_real_escape_string($link, $_POST['name']) . "', 
				status = '" . $_POST['status'] . "',
				beschreibung = '" . mysqli_real_escape_string($link, $_POST['beschreibung']) . "',
				position = '" . $_REQUEST['position'] . "',
				kategorie_id = '" . $_REQUEST['kategorie_id'] . "'
				WHERE id='" . $_REQUEST['foren_id'] . "'";
            mysqli_query($link, $insert) OR die(mysqli_error($link));

            echo "<p class='ok'>Erfolgreich geändert!</p><br>";
            echo "<meta http-equiv='refresh' content='1; URL=forum_themen.php?foren_id=" . $_REQUEST['foren_id'] . "'>"; // Weiterleitung
        } else {
            echo "<p class='fault'>Du hast ein Pflichtfeld vergessen!</p><br>";
        }
    }
    $select = "SELECT * FROM forum_foren WHERE id='" . $_REQUEST['foren_id'] . "'";
    $query = mysqli_query($link, $select);
    $row = mysqli_fetch_object($query);

    echo "<h1>Forenkategorie \"" . $row->name . "\" bearbeiten</h1>";
    echo "<p class='history'><b>History:</b> <a href='forum_index.php'>Übersicht</a> | <a href='forum_themen.php?foren_id=" . $_REQUEST['foren_id'] . "'>" . $row->name . "</a> | Unterforum bearbeiten</p>";
    echo "<B>Info:</B> Mit dem Feld <i>Position</i> lässt sich die Reihenfolge der Unterforen auf der Forenübersicht/dem Index ändern.<br>
		Einfach verschieden grosse Zahlen wählen, ganz oben ist das Forum mit der kleinsten Zahl und unten das grösste.<BR>
		Beispiel: News erhält Position 10 und Bugs 20.<BR><BR>";

    $abfrage_kat = "SELECT id, name FROM forum_kategorien";
    $ergebnis_kat = mysqli_query($link, $abfrage_kat);
    $kategorien = "";
    while ($row_kat = mysqli_fetch_object($ergebnis_kat)) {
        if ($row_kat->id == $row->kategorie_id) {
            $kategorien .= "<option value='" . $row_kat->id . "' selected>" . $row_kat->name . "</option>";
        } else {
            $kategorien .= "<option value='" . $row_kat->id . "'>" . $row_kat->name . "</option>";
        }
    }

    /* FORMULAR */
    echo "<form method='post'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>Kategorie:</td>";
    echo "<td>";
    echo "<select name='kategorie_id'>";
    echo $kategorien;
    echo "</select>";
    echo "</td>";
    echo "</tr><tr>";
    echo "<tr>";
    echo "<td>Name:</td>";
    echo "<td><input type='text' name='name' value='" . $row->name . "'></td>";
    echo "</tr><tr>";
    echo "<tr>";
    echo "<td>Beschreibung:</td>";
    echo "<td><textarea name='beschreibung'>" . $row->beschreibung . "</textarea></td>";
    echo "</tr><tr>";
    echo "<td>Status:</td>";
    echo "<td><select name='status'>";
    if ($row->status == "aktiv") {
        echo "<option value='aktiv' selected>geöffnet</option>";
    } else {
        echo "<option value='aktiv'>geöffnet</option>";
    }
    if ($row->status == "closed") {
        echo "<option value='closed' selected>geschlossen</option>";
    } else {
        echo "<option value='closed'>geschlossen</option>";
    }
    echo "</select></td>";
    echo "</tr><tr>";
    echo "<td>Position:</td>";
    echo "<td><input type='text' name='position' value='" . $row->position . "'></td>";
    echo "</tr><tr>";
    echo "<td></td>";
    echo "<td><input type='submit' name='submit2' value='ändern!'></td>";
    echo "</tr>";
    echo "</table>";
    echo "</form><br><br>";
} else {
    echo "<p class='fault'>Nur eingeloggte Benutzer haben Zugriff auf das Forum!</p>";
}
include('footer.php');
?>
