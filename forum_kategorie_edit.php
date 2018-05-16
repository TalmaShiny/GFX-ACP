<?php
include('header.php');
if (isset($_SESSION["acp"])) { // Wenn eingeloggt..

    if (isset($_POST['submit2'])) {
        if (isset($_POST['name']) && isset($_POST['zugriff'])) {
            $insert = "UPDATE forum_kategorien SET
				name = '" . save($_POST['name'], $link) . "', 
				zugriff = '" . $_REQUEST['zugriff'] . "',
				position = '" . $_REQUEST['position'] . "'
				WHERE id='" . $_REQUEST['id'] . "'";
            mysqli_query($link, $insert) OR die(mysqli_error($link));

            echo "<p class='ok'>Erfolgreich geändert!</p><br>";
            echo "<meta http-equiv='refresh' content='1; URL=forum_index.php'>"; // Weiterleitung
        } else {
            echo "<p class='fault'>Du hast ein Pflichtfeld vergessen!</p><br>";
        }
    }
    $select = "SELECT * FROM forum_kategorien WHERE id='" . $_REQUEST['id'] . "'";
    $query = mysqli_query($link, $select);
    $row = mysqli_fetch_object($query);

    echo "<h1>Forenkategorie \"" . $row->name . "\" bearbeiten</h1>";
    echo "<p class='history'><b>History:</b> <a href='forum_index.php'>Übersicht</a> | Kategorie bearbeiten</p>";
    echo "<B>Info:</B> Mit dem Feld <i>Position</i> lässt sich die Reihenfolge der Kategorien auf der Forenübersicht/dem Index ändern.<br>
		Einfach verschieden grosse Zahlen wählen, ganz oben ist die Kategorie mit der kleinsten Zahl und unten die grösste.<BR>
		Beispiel: Admin-Zone erhält Position 0, 1 oder 10 und Off-Topic 9 oder 90.<BR><BR>";

    /* FORMULAR */
    echo "<form method='post'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>Name:</td>";
    echo "<td><input type='text' name='name' value='" . $row->name . "'></td>";
    echo "</tr><tr>";
    echo "<td>Zugriff:</td>";
    echo "<td><select name='zugriff'>";
    if ($row->zugriff == 1) {
        echo "<option value='1' selected>Nur für Admins</option>";
    } else {
        echo "<option value='1'>Nur für Admins</option>";
    }
    if ($row->zugriff == 2) {
        echo "<option value='2' selected>Auch für Webbys</option>";
    } else {
        echo "<option value='2'>Auch für Webbys</option>";
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
