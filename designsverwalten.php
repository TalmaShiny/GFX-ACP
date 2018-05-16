<?php
include('header.php');
include('pagetest.php');

echo "<h1>Neues Design hinzufügen</h1>";

if (isset($_SESSION["acp"])) {
    if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'deletedesign') {
        unlink("Designs/" . $_REQUEST["id"] . "_view" . wert("gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'", "bild", $link) . "");
        unlink("Designs/" . $_REQUEST["id"] . "_vorschau" . wert("gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'", "vorschau", $link) . "");
        unlink("Designs/" . $_REQUEST["id"] . "_download" . wert("gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'", "down", $link) . "");
        unlink("Designs/" . $_REQUEST["id"] . "_vorschaugross" . wert("gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'", "vorschaugross", $link) . "");
        $delete = "DELETE FROM gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'";
        $delete_go = mysqli_query($link, $delete) OR die(mysqli_error($link));
        echo "<p class='ok'>Design erfolgreich gelöscht.</p>";
    }

    if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'newdesign') {
        $select = mysqli_query($link, "SELECT name FROM benutzer WHERE id ='" . $_SESSION["acp"] . "'");
        $row = mysqli_fetch_object($select);

        if (!empty($_FILES["designview"]["name"])) {
            if (!empty($_FILES["designvorschau"]["name"])) {
                $endung = strstr($_FILES["designview"]["name"], ".");
                $endung2 = strstr($_FILES["designvorschau"]["name"], ".");
                $endung3 = strstr($_FILES["designvorschaugross"]["name"], ".");
                $endung4 = strstr($_FILES["designdownload"]["name"], ".");

                $eintrag = "INSERT INTO gfx (typ, timestamp, webby, bild, vorschau, vorschaugross, down, serie, name, views) VALUES (
					'Design',
					'" . time() . "',
					'" . save($row->name, $link) . "',
					'" . save($endung, $link) . "',
					'" . save($endung2, $link) . "',
					'" . save($endung3, $link) . "',
					'" . save($endung4, $link) . "',
					'" . save($_POST["series"], $link) . "',
					'" . save($_POST["name"], $link) . "',
					'0')";
                $eintragen = mysqli_query($link, $eintrag) OR die(mysqli_error($link));
                $id = mysqli_insert_id($link);

                move_uploaded_file($_FILES["designview"]["tmp_name"], "Designs/" . $id . "_view" . $endung);
                move_uploaded_file($_FILES["designvorschau"]["tmp_name"], "Designs/" . $id . "_vorschau" . $endung2);
                move_uploaded_file($_FILES["designvorschaugross"]["tmp_name"], "Designs/" . $id . "_vorschaugross" . $endung3);
                move_uploaded_file($_FILES["designdownload"]["tmp_name"], "Designs/" . $id . "_download" . $endung4);
            } else {
                echo "<p class='fault'>Du hast für das Design kein Bild hochgeladen!</p>";
            }
        } else {
            echo "<p class='fault'>Du hast für das Design keine HTML/PHP-Vorschau hochgeladen!</p>";
        }
        echo "<p class='ok'>Erfolgreich eingetragen!</p>";
    }

    echo "Hier kannst du die bisherigen Designs bearbeiten sowie löschen oder neue hinzufügen! <br>
		Zu jedem Designs wird der Name angegeben z.B. der Name der Person, die sich 
		darauf befindet, es wird eine kleine Vorschau hochgeladen (alle sollten 100x100 Pixel gross sein), 
		es ist eine PHP oder HTML-Vorschau für deine Besucher erforderlich und eine Serie wird verlangt!<br>
		Ausserdem kannst du eine RAR/ZIP-Datei hochladen, die für deinen Besucher alle Elemente des Designs enthalten.<br><br>";

    echo "<form action='designsverwalten.php?action=newdesign' method='post' enctype='multipart/form-data'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>Name:</td>";
    echo "<td><input type='text' name='name' size='20'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Serie:</td>";
    echo "<td><input type='text' name='series' size='20'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Design-Screen (100x100 Pixel):</td>";
    echo "<td><input type='file' name='designvorschau' size='20'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Design-Ausschnitt (ca. 333x250 Pixel):</td>";
    echo "<td><input type='file' name='designvorschaugross' size='20'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>PHP/HTML-Vorschau:</td>";
    echo "<td><input type='file' name='designview' size='20'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>ZIP/RAR-Datei:</td>";
    echo "<td><input type='file' name='designdownload' size='20'></td>";
    echo "</tr>";
    echo "<tr height='10px'></tr>";
    echo "<tr>";
    echo "<td></td>";
    echo "<td><input type='submit' value='Hochladen!' name='hochladen'></td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";
    echo "<br><br>";

    echo "<h1>Designs verwalten</h1>";
    /* SEITEN FUNKTION */
    $itemsPerPage = 20;
    $start = 0;
    if (!empty($_GET['go'])) {
        $start = ($_GET['go'] - 1) * $itemsPerPage;
    }
    pagemittyp($itemsPerPage, "gfx", "Design", $link);

    echo "<table>";
    $i = 0;
    if ($start >= 0) {
        $abfrage = "SELECT * FROM gfx WHERE typ = 'Design' ORDER BY id DESC LIMIT " . $start . ", " . $itemsPerPage;
    } else {
        $abfrage = "SELECT * FROM gfx WHERE typ = 'Design' ORDER BY id DESC LIMIT 0, 10";
    }
    $ergebnis = mysqli_query($link, $abfrage);
    while ($row = mysqli_fetch_object($ergebnis)) {
        if ($i != 0 && $i % 4 == 0) {
            echo "</tr><tr>";
        }
        echo "<td align='center'>";
        echo "<div class='gfx'>";
        echo "<img src='Designs/" . $row->id . "_vorschau" . $row->vorschau . "'><br>";
        echo "By " . $row->webby . " <br />";
        echo "<a href='designsverwalten.php?action=deletedesign&id=" . $row->id . "'>
				<img src='webicons/delete.png' border='0'></a>";
        echo " <a href='designsverwalten_edit.php?id=" . $row->id . "'><img src='webicons/edit.png' border='0'></a>";
        echo "</div>";
        echo "</td>";
        $i++;
    }

    echo "</table>";
} else {
    echo "<p class='fault'>Kein Zutritt!</p>";
}
include('footer.php');
?>
