<?php
include('header.php');
include('pagetest.php');

echo "<h1>Neue PSD hinzufügen</h1>";

if (isset($_SESSION["acp"])) {
    if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'deletepsd') {
        unlink("Psds/" . $_REQUEST["id"] . wert("gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'", "bild", $link) . "");
        unlink("Psds/" . $_REQUEST["id"] . wert("gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'", "down", $link) . "");

        $delete = "DELETE FROM gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'";
        $delete_go = mysqli_query($link, $delete) OR die(mysqli_error($link));
        echo "<p class='ok'>PSD erfolgreich gelöscht.</p>";
    }

    if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'newpsd') {
        $select = mysqli_query($link, "SELECT name FROM benutzer WHERE id ='" . $_SESSION["acp"] . "'");
        $row = mysqli_fetch_object($select);

        if (!empty($_FILES["psd_download"]["name"])) {
            if (!empty($_FILES["psd_vorschau"]["name"])) {
                $endung = strstr($_FILES["psd_vorschau"]["name"], ".");
                $endung2 = strstr($_FILES["psd_download"]["name"], ".");

                if ($endung2 == ".zip" || $endung2 == ".rar" || $endung2 == ".psd") {
                    $eintrag = "INSERT INTO gfx (typ, timestamp, webby, bild, vorschau, vorschaugross, down, serie, name, views) VALUES (
						'PSD',
						'" . time() . "',
						'" . save($row->name, $link) . "',
						'" . save($endung, $link) . "',
						'',
						'',
						'" . save($endung2, $link) . "',
						'',
						'" . save($_POST["name"], $link) . "',
						'0')";
                    $eintragen = mysqli_query($link, $eintrag) OR die(mysqli_error($link));
                    $id = mysqli_insert_id($link);

                    move_uploaded_file($_FILES["psd_vorschau"]["tmp_name"], "Psds/" . $id . $endung);
                    move_uploaded_file($_FILES["psd_download"]["tmp_name"], "Psds/" . $id . $endung2);
                } else {
                    echo "<p class='fault'>Die Download-Datei liegt in keinem RAR/ZIP oder PSD-Format vor.</p>";
                }
            } else {
                echo "<p class='fault'>Du hast für die PSD keine Bildvorschau hochgeladen!</p>";
            }
        } else {
            echo "<p class='fault'>Du hast keine .psd oder .zip/.rar Datei hochgeladen!</p>";
        }
        echo "<p class='ok'>Erfolgreich eingetragen!</p>";
    }

    echo "Hier kannst du die bisherigen PSDs bearbeiten, sowie löschen oder neue hinzufügen! <br>
		Zu jeder PSD kann ein Name angegeben werden (z.B. enthaltender Filter, Colorierung etc), 
		es wird eine kleine Vorschau hochgeladen (alle sollten gleich gross sein) 
		und du musst eine RAR/ZIP-Datei oder PSD-Datei hochladen, die der Besucher herunterladen kann.<br><br>";

    echo "<form action='?action=newpsd' method='post' enctype='multipart/form-data'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>Name:</td>";
    echo "<td><input type='text' name='name' size='20'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Vorschau (zB. 100x100 Pixel):</td>";
    echo "<td><input type='file' name='psd_vorschau' size='20'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>RAR/ZIP/PSD Datei:</td>";
    echo "<td><input type='file' name='psd_download' size='20'></td>";
    echo "</tr>";
    echo "<td></td>";
    echo "<td><input type='submit' value='Hochladen!' name='hochladen'></td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";
    echo "<br><br>";

    echo "<h1>PSDs verwalten</h1>";
    /* SEITEN FUNKTION */
    $itemsPerPage = 20;
    $start = 0;
    if (!empty($_GET['go'])) {
        $start = ($_GET['go'] - 1) * $itemsPerPage;
    }
    pagemittyp($itemsPerPage, "gfx", "PSD", $link);

    echo "<table>";
    $i = 0;
    if ($start >= 0) {
        $abfrage = "SELECT * FROM gfx WHERE typ = 'PSD' ORDER BY id DESC LIMIT " . $start . ", " . $itemsPerPage;
    } else {
        $abfrage = "SELECT * FROM gfx WHERE typ = 'PSD' ORDER BY id DESC LIMIT 0, " . $itemsPerPage;
    }
    $ergebnis = mysqli_query($link, $abfrage);
    while ($row = mysqli_fetch_object($ergebnis)) {
        if ($i != 0 && $i % 4 == 0) {
            echo "</tr><tr>";
        }
        echo "<td align='center'>";
        echo "<div class='gfx'>";
        echo "<img src='Psds/" . $row->id . $row->bild . "'><br>";
        echo "By " . $row->webby . " <br />";
        echo "<a href='?action=deletepsd&id=" . $row->id . "'>
				<img src='webicons/delete.png' border='0'></a>";
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
