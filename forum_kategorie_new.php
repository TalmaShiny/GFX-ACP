<?php
include('header.php');
if (isset($_SESSION["acp"])) { // Wenn eingeloggt..

    if (isset($_REQUEST['submit_anzahl'])) {
        $Eingabe = $_REQUEST['eingabe'];
    } else {
        $Eingabe = 1;
    }

    if (isset($_POST['submit2'])) {
        $anzahl = $_REQUEST["anzahl"];
        for ($i = 1; $i <= $anzahl; $i++) {
            if (isset($_POST['name_' . $i]) && isset($_POST['zugriff_' . $i])) {
                $insert = "INSERT INTO forum_kategorien (name, zugriff, position) 
					VALUES (
					'" . save($_POST['name_' . $i], $link) . "', 
					'" . $_REQUEST['zugriff_' . $i] . "',
					'" . $_REQUEST['position_' . $i] . "'
					)";
                mysqli_query($link, $insert) OR die(mysqli_error($link));
                $check = 0;
            } else {
                echo "<p class='fault'>Du hast ein Pflichtfeld vergessen!</p><br>";
                $check = 1;
            }
        }
        if ($check == 0) {
            echo "<p class='ok'>Kategorien eingegangen. Vielen Dank!</p><br>";
            echo "<meta http-equiv='refresh' content='1; URL=forum_index.php'>"; // Weiterleitung
        }
    }

    echo "<h1>Neue Forenkategorien erstellen</h1>";
    echo "<p class='history'><b>History:</b> <a href='forum_index.php'>Übersicht</a> | Neue Kategorien erstellen</p>";

    /* ANZAHL ERSTELLEN */
    if ($Eingabe <= 0) {
        $Eingabe = 1;
    }
    echo "Wieviele neue Kategorien möchtest du erstellen?</br>";
    echo "<form method='post'>";
    echo "<input type='text' name='eingabe' value='" . $Eingabe . "'> 
			<input type='submit' name='submit_anzahl' value='OK' >";
    echo "</form>";
    echo "<br /><br />";

    /* FORMULAR */
    echo "<form method='post'>";
    for ($i = 1; $i <= $Eingabe; $i++) {
        echo "<table>";
        echo "<tr>";
        echo "<td>Name " . $i . ":</td>";
        echo "<td><input type='text' name='name_" . $i . "'></td>";
        echo "</tr><tr>";
        echo "<td>Zugriff " . $i . ":</td>";
        echo "<td><select name='zugriff_" . $i . "'>";
        echo "<option value='1'>Nur für Admins</option>";
        echo "<option value='2'>Auch für Webbys</option>";
        echo "</select></td>";
        echo "</tr><tr>";
        echo "<td>Position " . $i . ":</td>";
        echo "<td><input type='text' name='position_" . $i . "'></td>";

        echo "<input type='hidden' name='anzahl' value='";
        if (isset($_REQUEST["eingabe"])) {
            echo $_REQUEST["eingabe"];
        } else {
            echo "1";
        }
        echo "'>";
        echo "</tr>";
        echo "</table>";
        echo "<br>";
    }
    echo "<input type='submit' name='submit2' value='Einfügen!'>";
    echo "</form><br><br>";
} else {
    echo "<p class='fault'>Nur eingeloggte Benutzer haben Zugriff auf das Forum!</p>";
}
include('footer.php');
?>
