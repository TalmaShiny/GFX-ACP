<?php
include('header.php');
include('pagetest.php');

echo "<h1>Neues Brushset hinzufügen</h1>";

if (isset($_SESSION["acp"])) {
    if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'deletebrush') {
        unlink("Brushes/" . $_REQUEST["id"] . "" . wert("gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'", "bild", $link) . "");
        unlink("Brushes/" . $_REQUEST["id"] . "_vorschau" . wert("gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'", "vorschau", $link) . "");
        unlink("Brushes/" . $_REQUEST["id"] . "_download" . wert("gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'", "down", $link) . "");

        $delete = "DELETE FROM gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'";
        $delete_go = mysqli_query($link, $delete) OR die(mysqli_error($link));
        echo "<p class='ok'>Brushes erfolgreich gelöscht.</p>";
    }

    if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'newbrush') {
        $select = mysqli_query($link, "SELECT name FROM benutzer WHERE id ='" . $_SESSION["acp"] . "'");
        $row = mysqli_fetch_object($select);

        if (!empty($_FILES["brushview"]["name"])) {
            if (!empty($_FILES["brushvorschau"]["name"])) {
                $endung1 = strstr($_FILES["brushview"]["name"], ".");
                $endung2 = strstr($_FILES["brushvorschau"]["name"], ".");
                $endung3 = strstr($_FILES["brushdownload"]["name"], ".");

                $eintrag = "INSERT INTO gfx (typ, timestamp, webby, bild, vorschau, vorschaugross, down, serie, name, views) VALUES (
					'Brush',
					'" . time() . "',
					'" . save($row->name, $link) . "',
					'" . save($endung1, $link) . "',
					'" . save($endung2, $link) . "',
					'',
					'" . save($endung3, $link) . "',
					'" . save($_POST["series"], $link) . "',
					'" . save($_POST["name"], $link) . "',
					'0')";
                $eintragen = mysqli_query($link, $eintrag) OR die(mysqli_error($link));
                $id = mysqli_insert_id($link);

                move_uploaded_file($_FILES["brushview"]["tmp_name"], "Brushes/" . $id . $endung1);
                move_uploaded_file($_FILES["brushvorschau"]["tmp_name"], "Brushes/" . $id . "_vorschau" . $endung2);
                move_uploaded_file($_FILES["brushdownload"]["tmp_name"], "Brushes/" . $id . "_download" . $endung3);
            } else {
                echo "<p class='fault'>Du hast kein Image zu den Brushes hochgeladen!</p>";
            }
        } else {
            echo "<p class='fault'>Du hast keine Vorschau hochgeladen!</p>";
        }
        echo "<p class='ok'>Erfolgreich eingetragen!</p>";
    }

    echo "Hier kannst du die bisherigen Brushes bearbeiten, sowie löschen oder neue hinzufügen! <br>
		Zu jedem Brushset wird ein Name sowie eine Serie angegeben z.B. Swirls, Lyrics ... 
		Ebenfalls wird eine kleine Vorschau hochgeladen (alle sollten 100x100 Pixel gross sein) 
		und du kannst eine ABR/RAR/ZIP-Datei hochladen, die deinen Besucher downloaden können.<br><br>";

    echo "<form action='?action=newbrush' method='post' enctype='multipart/form-data'>";
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
    echo "<td>Vorschau (100x100 Pixel):</td>";
    echo "<td><input type='file' name='brushview' size='20'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Image (ca. 333x250 Pixel):</td>";
    echo "<td><input type='file' name='brushvorschau' size='20'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>ABR/ZIP/RAR-Datei:</td>";
    echo "<td><input type='file' name='brushdownload' size='20'></td>";
    echo "</tr>";
    echo "<tr height='10px'></tr>";
    echo "<tr>";
    echo "<td></td>";
    echo "<td><input type='submit' value='Hochladen!' name='hochladen'></td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";
    echo "<br><br>";

    echo "<h1>Brushes verwalten</h1>";
    /* SEITEN FUNKTION */
    $itemsPerPage = 20;
    $start = 0;
    if (!empty($_GET['go'])) {
        $start = ($_GET['go'] - 1) * $itemsPerPage;
    }
    pagemittyp($itemsPerPage, "gfx", "Brush", $link);

    echo "<table>";
    $i = 0;
    if ($start >= 0) {
        $abfrage = "SELECT * FROM gfx WHERE typ = 'Brush' ORDER BY id DESC LIMIT " . $start . ", " . $itemsPerPage;
    } else {
        $abfrage = "SELECT * FROM gfx WHERE typ = 'Brush' ORDER BY id DESC LIMIT 0, " . $itemsPerPage;
    }
    $ergebnis = mysqli_query($link, $abfrage);
    while ($row = mysqli_fetch_object($ergebnis)) {
        if ($i != 0 && $i % 4 == 0) {
            echo "</tr><tr>";
        }
        echo "<td align='center'>";
        echo "<div class='gfx'>";
        echo "<img src='Brushes/" . $row->id . $row->bild . "'><br>";
        echo "By " . $row->webby . " <br />";
        echo "<a href='?action=deletebrush&id=" . $row->id . "'>
				<img src='webicons/delete.png' border='0'></a>";
        echo " <a href='brushesverwalten_edit.php?id=" . $row->id . "'><img src='webicons/edit.png' border='0'></a>";
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
