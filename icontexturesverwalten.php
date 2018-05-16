<?php
include('header.php');
include('pagetest.php');

if (isset($_SESSION["acp"])) {
    if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'deleteicontexture') {
        unlink("Icontextures/" . $_REQUEST["id"] . "" . wert("gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'", "bild", $link) . "");
        $delete = "DELETE FROM gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'";
        $delete_go = mysqli_query($link, $delete) OR die(mysqli_error($link));
        echo "<p class='ok'>Icontexture erfolgreich gelöscht.</p>";
    }
    if (isset($_REQUEST['submit_anzahl'])) {
        $Eingabe = $_REQUEST['eingabe'];
    } else {
        $Eingabe = 1;
    }

    if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'newicontexture') {
        $anzahl = $_REQUEST["anzahl"];
        $select = mysqli_query($link, "SELECT name FROM benutzer WHERE id ='" . $_SESSION["acp"] . "'");
        $row = mysqli_fetch_object($select);

        for ($i = 1; $i <= $anzahl; $i++) {
            if (!empty($_FILES["icontexture_" . $i]["name"])) {
                $endung = strstr($_FILES["icontexture_" . $i]["name"], ".");

                $eintrag = "INSERT INTO gfx (typ, timestamp, webby, bild, vorschau, vorschaugross, down, serie, name, views) VALUES (
					'Icontexture',
					'" . time() . "',
					'" . save($row->name, $link) . "',
					'" . save($endung, $link) . "',
					'',
					'',
					'',
					'',
					'',
					'0'
					)";
                $eintragen = mysqli_query($link, $eintrag) OR die(mysqli_error($link));
                $id = mysqli_insert_id($link);
                move_uploaded_file($_FILES["icontexture_" . $i]["tmp_name"], "Icontextures/" . $id . $endung);
            } else {
                echo "<p class='fault'>Du hast eine Icontexture vergessen!</p>";
            }
        }
        echo "<p class='ok'>Erfolgreich eingetragen!</p>";
    }

    /* ANZAHL HOCHLADEN */
    echo "<h1>Neue Icontexture hinzufügen</h1>";
    echo "Hier kannst du die bisherigen Icontextures bearbeiten sowie löschen oder neue hinzufügen! <br><BR>";

    if ($Eingabe <= 0) {
        $Eingabe = 1;
    }
    echo "Wieviele Icontextures möchtest du hochladen?</br>";
    echo "<form method='post'>";
    echo "<input type='text' name='eingabe' value='" . $Eingabe . "'> 
			<input type='submit' name='submit_anzahl' value='Go' >";
    echo "</form>";
    echo "<br /><br />";

    /* HOCHLADEN */
    echo "<form action='?action=newicontexture' method='post' enctype='multipart/form-data'>";
    echo "<table>";

    for ($i = 1; $i <= $Eingabe; $i++) {
        echo "<tr>";
        echo "<td>Icontexture <b>" . $i . "</b>:</td>";
        echo "<td><input type='file' name='icontexture_" . $i . "' size='20'></td>";
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

    echo "<h1>Icontexture verwalten</h1>";
    /* SEITEN FUNKTION */
    $itemsPerPage = 10;
    $start = 0;
    if (!empty($_GET['go'])) {
        $start = ($_GET['go'] - 1) * $itemsPerPage;
    }
    pagemittyp($itemsPerPage, "gfx", "Icontexture", $link);

    echo "<table>";
    $i = 0;
    if ($start >= 0) {
        $abfrage = "SELECT * FROM gfx WHERE typ = 'Icontexture' ORDER BY id DESC LIMIT " . $start . ", " . $itemsPerPage;
    } else {
        $abfrage = "SELECT * FROM gfx WHERE typ = 'Icontexture' ORDER BY id DESC LIMIT 0, " . $itemsPerPage;
    }
    $ergebnis = mysqli_query($link, $abfrage);
    while ($row = mysqli_fetch_object($ergebnis)) {
        if ($i != 0 && $i % 4 == 0) {
            echo "</tr><tr>";
        }
        echo "<td align='center'>";
        echo "<div class='gfx'>";
        echo "<img src='Icontextures/" . $row->id . $row->bild . "'><br>";
        echo "By " . $row->webby . " <br />";
        echo "<a href='?action=deleteicontexture&id=" . $row->id . "'>
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
