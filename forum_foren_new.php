<?php
include('header.php');
if (isset($_SESSION["acp"])) { // Wenn eingeloggt..

    if (isset($_POST['submit2'])) {
        if (isset($_POST['name'])) {
            $insert = "INSERT INTO forum_foren (status, name, beschreibung, position, kategorie_id) 
				VALUES (
				'" . $_POST['status'] . "', 
				'" . mysqli_real_escape_string($link, $_POST['name']) . "', 
				'" . mysqli_real_escape_string($link, $_POST['beschreibung']) . "', 
				'" . $_POST['position'] . "',
				'" . $_POST['kategorie_id'] . "'
				)";
            mysqli_query($link, $insert) OR die(mysqli_error($link));

            echo "<p class='ok'>Forum eingegangen. Vielen Dank!</p><br>";
            echo "<meta http-equiv='refresh' content='1; URL=forum_index.php'>"; // Weiterleitung
        } else {
            echo "<p class='fault'>Du hast ein Pflichtfeld vergessen!</p><br>";
        }
    }

    echo "<h1>Neues Unterforum anlegen</h1>";
    echo "<p class='history'><b>History:</b> <a href='forum_index.php'>Übersicht</a> | Neues Unterforum anlegen</p>";
    echo "<B>Info:</B> Mit dem Feld <i>Position</i> lässt sich die Reihenfolge der Unterforen auf der Forenübersicht/dem Index ändern.<br>
		Einfach verschieden grosse Zahlen wählen, ganz oben ist das Forum mit der kleinsten Zahl und unten das grösste.<BR>
		Beispiel: News erhält Position 10 und Bugs 20.<BR><BR>";

    $abfrage_kat = "SELECT id, name FROM forum_kategorien";
    $ergebnis_kat = mysqli_query($link, $abfrage_kat);
    $kategorien = "";
    while ($row_kat = mysqli_fetch_object($ergebnis_kat)) {
        $kategorien .= "<option value='" . $row_kat->id . "'>" . $row_kat->name . "</option>";
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
    echo "<td><input type='text' name='name' value='" . (!empty($_POST['name']) ? $_POST['name'] : "") . "'></td>";
    echo "</tr><tr>";
    echo "<tr>";
    echo "<td>Beschreibung:</td>";
    echo "<td><textarea name='beschreibung'>" . (!empty($_POST['beschreibung']) ? $_POST['beschreibung'] : "") . "</textarea></td>";
    echo "</tr><tr>";
    echo "<td>Status:</td>";
    echo "<td><select name='status'>";
    if (!empty($_POST['status']) && $_POST['status'] == "aktiv") {
        echo "<option value='aktiv' selected>geöffnet</option>";
    } else {
        echo "<option value='aktiv'>geöffnet</option>";
    }
    if (!empty($_POST['status']) && $_POST['status'] == "closed") {
        echo "<option value='closed' selected>geschlossen</option>";
    } else {
        echo "<option value='closed'>geschlossen</option>";
    }
    echo "</select></td>";
    echo "</tr><tr>";
    echo "<td>Position:</td>";
    echo "<td><input type='text' name='position' value='" . (!empty($_POST['position']) ? $_POST['position'] : "") . "'></td>";
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
