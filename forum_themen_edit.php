<?php
include('header.php');
if (isset($_SESSION["acp"])) { // Wenn eingeloggt..

    if (isset($_POST['submit2'])) {
        if (isset($_POST['thema'])) {
            $insert = "UPDATE forum_themen SET
				thema = '" . save($_POST['thema'], $link) . "', 
				status = '" . $_POST['status'] . "',
				foren_id = '" . $_POST['foren_id'] . "'
				WHERE id='" . $_REQUEST['themen_id'] . "'";
            mysqli_query($link, $insert) OR die(mysqli_error($link));

            echo "<p class='ok'>Erfolgreich geändert!</p><br>";
            echo "<meta http-equiv='refresh' content='1; URL=forum_posts.php?themen_id=" . $_REQUEST['themen_id'] . "'>"; // Weiterleitung
        } else {
            echo "<p class='fault'>Du hast ein Pflichtfeld vergessen!</p><br>";
        }
    }
    $select = "SELECT * FROM forum_themen WHERE id='" . $_REQUEST['themen_id'] . "'";
    $query = mysqli_query($link, $select);
    $row = mysqli_fetch_object($query);

    $abfrage_for = "SELECT id, name FROM forum_foren WHERE id = '" . $row->foren_id . "'";
    $ergebnis_for = mysqli_query($link, $abfrage_for);
    $row_for = mysqli_fetch_object($ergebnis_for);

    echo "<h1>Thema \"" . $row->thema . "\" bearbeiten</h1>";
    echo "<p class='history'><b>History:</b> <a href='forum_index.php'>Übersicht</a> | <a href='forum_themen.php?foren_id=" . $row_for->id . "'>" . $row_for->name . "</a> | <a href='forum_posts.php?themen_id=" . $_REQUEST['themen_id'] . "'>" . $row->thema . "</a> | Thema bearbeiten</p>";

    $abfrage_foren = "SELECT id, name FROM forum_foren";
    $ergebnis_foren = mysqli_query($link, $abfrage_foren);
    $for = "";
    while ($foren = mysqli_fetch_object($ergebnis_foren)) {
        if ($foren->id == $row->foren_id) {
            $for .= "<option value='" . $foren->id . "' selected>" . $foren->name . "</option>";
        } else {
            $for .= "<option value='" . $foren->id . "'>" . $foren->name . "</option>";
        }
    }


    echo "<b>Info:</b> Zum Verschieben einfach ein anderes Forum auswählen.<br> Das Thema wird ohne Backlink verschoben!<br><br>";

    /* FORMULAR */
    echo "<form method='post'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>Thema:</td>";
    echo "<td><input type='text' name='thema' value='" . $row->thema . "'></td>";
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
    echo "<td>Forum:</td>";
    echo "<td>";
    echo "<select name='foren_id'>";
    echo $for;
    echo "</select>";
    echo "</td>";
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
