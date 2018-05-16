<?php
include('header.php');
include('pagetest.php');

if (isset($_SESSION["acp"])) {
    if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'deleteheader') {
        unlink("Headers/" . $_REQUEST["id"] . "" . wert("gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'", "bild", $link) . "");
        unlink("Headers/" . $_REQUEST["id"] . "_vorschau" . wert("gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'", "vorschau", $link) . "");
        $delete = "DELETE FROM gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'";
        $delete_go = mysqli_query($link, $delete) OR die(mysqli_error($link));
        echo "<p class='ok'>Header erfolgreich gelöscht.</p>";
    }
    if (isset($_REQUEST['submit_anzahl'])) {
        $Eingabe = $_REQUEST['eingabe'];
    } else {
        $Eingabe = 1;
    }

    if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'newheaders') {
        $anzahl = $_REQUEST["anzahl"];
        $select = mysqli_query($link, "SELECT name FROM benutzer WHERE id ='" . $_SESSION["acp"] . "'");
        $row = mysqli_fetch_object($select);

        for ($i = 1; $i <= $anzahl; $i++) {
            if (!empty($_FILES["header_" . $i]["name"])) {
                $endung = strstr($_FILES["header_" . $i]["name"], ".");
                $endung2 = strstr($_FILES["headervorschau_" . $i]["name"], ".");

                $eintrag = "INSERT INTO gfx (typ, timestamp, webby, bild, vorschau, vorschaugross, down, serie, name, views) VALUES (
					'Header',
					'" . time() . "',
					'" . save($row->name, $link) . "',
					'" . save($endung, $link) . "',
					'" . save($endung2, $link) . "',
					'',
					'',
					'" . save($_POST["series_" . $i], $link) . "',
					'" . save($_POST["name_" . $i], $link) . "',
					'0')";
                $eintragen = mysqli_query($link, $eintrag) OR die(mysqli_error($link));
                $id = mysqli_insert_id($link);
                move_uploaded_file($_FILES["header_" . $i]["tmp_name"], "Headers/" . $id . $endung);
                move_uploaded_file($_FILES["headervorschau_" . $i]["tmp_name"], "Headers/" . $id . "_vorschau" . $endung2);
            } else {
                echo "<p class='fault'>Du hast einen Header vergessen!</p>";
            }
        }
        echo "<p class='ok'>Erfolgreich eingetragen!</p>";
    }

    /* ANZAHL HOCHLADEN */
    echo "<h1>Neuen Header hinzufügen</h1>";
    echo "Hier kannst du die bisherigen Header bearbeiten sowie löschen oder neue hinzufügen! <br>
		Zu jedem Header wird der Name angegeben z.B. der Name der Person, die sich 
		darauf befindet und eine Serie wird verlangt!<br>
		Die Vorschau für die Headers.php-Unterseite sollte 100x100 Pixel gross sein.<br><BR>";

    if ($Eingabe <= 0) {
        $Eingabe = 1;
    }
    echo "Wieviele Headers möchtest du hochladen?</br>";
    echo "<form action='headersverwalten.php' method='post'>";
    echo "<input type='text' name='eingabe' value='" . $Eingabe . "'> 
			<input type='submit' name='submit_anzahl' value='Go' >";
    echo "</form>";
    echo "<br /><br />";

    /* HOCHLADEN */
    echo "<form action='headersverwalten.php?action=newheaders' method='post' enctype='multipart/form-data'>";
    echo "<table>";

    for ($i = 1; $i <= $Eingabe; $i++) {
        echo "<tr>";
        echo "<td>Name <b>" . $i . "</b>:</td>";
        echo "<td><input type='text' name='name_" . $i . "' size='20'></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Serie <b>" . $i . "</b>:</td>";
        echo "<td><input type='text' name='series_" . $i . "' size='20'></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Header <b>" . $i . "</b>:</td>";
        echo "<td><input type='file' name='header_" . $i . "' size='20'></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Vorschau <b>" . $i . "</b>:</td>";
        echo "<td><input type='file' name='headervorschau_" . $i . "' size='20'></td>";
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
    echo "<td><input type='submit' value='Hochladen!' name='hochladen'></td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";
    echo "<br><br>";

    echo "<h1>Headers verwalten</h1>";
    /* SEITEN FUNKTION */
    $itemsPerPage = 20;
    $start = 0;
    if (!empty($_GET['go'])) {
        $start = ($_GET['go'] - 1) * $itemsPerPage;
    }
    pagemittyp($itemsPerPage, "gfx", "Header", $link);

    echo "<table>";
    $i = 0;
    if ($start >= 0) {
        $abfrage = "SELECT * FROM gfx WHERE typ = 'Header' ORDER BY id DESC LIMIT " . $start . ", " . $itemsPerPage;
    } else {
        $abfrage = "SELECT * FROM gfx WHERE typ = 'Header' ORDER BY id DESC LIMIT 0, 10";
    }
    $ergebnis = mysqli_query($link, $abfrage);
    while ($row = mysqli_fetch_object($ergebnis)) {
        if ($i != 0 && $i % 4 == 0) {
            echo "</tr><tr>";
        }
        echo "<td align='center'>";
        echo "<div class='gfx'>";
        echo "<img src='Headers/" . $row->id . "_vorschau" . $row->vorschau . "'><br>";
        echo "By " . $row->webby . " <br />";
        echo "<a href='headersverwalten.php?action=deleteheader&id=" . $row->id . "'>
				<img src='webicons/delete.png' border='0'></a>";
        echo " <a href='headersverwalten_edit.php?id=" . $row->id . "'><img src='webicons/edit.png' border='0'></a>";
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
