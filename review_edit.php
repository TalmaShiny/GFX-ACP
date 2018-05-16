<?php
include("header.php");
include("bbc.inc.php");

/* NACH DEM ABSCHICKEN DES FORMULARS */
if (isset($_POST['edit_sonstiges'])) { // SONSTIGES, KOSMETIK, MUSIK,
    if ($_POST['message'] != "" && $_POST['title'] != "") {
        $abfrage1 = "UPDATE reviews SET
			titel ='" . save($_POST['title'], $link) . "',
			bewertung ='" . save($_POST['bewertung'], $link) . "',
			gesamt_text ='" . save($_POST['message'], $link) . "'
			WHERE id='" . $_POST["id"] . "'";

        mysqli_query($link, $abfrage1);

        echo "<p class='ok'>Review erfolgreich geändert!<br><br>
			<a href='reviewsverwalten.php'> <- Zurück zur Review-Übersicht</a>
			</p><br>";
    } else {
        echo "<p class='fault'>Du hast den Title oder den Textinhalt des Reviews vergessen!</p><br>";
    }
} elseif (isset($_POST['edit_website'])) { // WEBSITE
    $abfrage2 = "UPDATE reviews SET
		titel ='" . save($_POST['title'], $link) . "',
		freitext ='" . save($_POST['url'], $link) . "',
		info ='" . save($_POST['info'], $link) . "',
		rate1 ='" . $_POST['Estars'] . "',
		rate1_text ='" . save($_POST['Etext'], $link) . "',
		rate2 ='" . $_POST['Dstars'] . "',
		rate2_text ='" . save($_POST['Dtext'], $link) . "',
		rate3 ='" . $_POST['Cstars'] . "',
		rate3_text ='" . save($_POST['Ctext'], $link) . "',
		rate4 ='" . $_POST['Astars'] . "',
		rate4_text ='" . save($_POST['Atext'], $link) . "',
		rate5 ='" . $_POST['Rstars'] . "',
		rate5_text ='" . save($_POST['Rtext'], $link) . "',
		gesamt_text ='" . save($_POST['message'], $link) . "'
		WHERE id='" . $_POST["id"] . "'";

    mysqli_query($link, $abfrage2);

    echo "<p class='ok'>Website-Review erfolgreich geändert!<br><br>
		<a href='reviewsverwalten.php'> <- Zurück zur Review-Übersicht</a></p><br>";
} elseif (isset($_POST['edit_buch'])) { // BUCH ODER FILM
    $abfrage3 = "UPDATE reviews SET
		titel ='" . save($_POST['title'], $link) . "',
		freitext ='" . save($_POST['preis'], $link) . "',
		info ='" . save($_POST['message'], $link) . "',
		rate1 ='" . $_POST['spannung'] . "',
		rate2 ='" . $_POST['romantik'] . "',
		rate3 ='" . $_POST['humor'] . "',
		bewertung ='" . $_POST['bewertung'] . "',
		gesamt_text ='" . save($_POST['fazit'], $link) . "'
		WHERE id='" . $_POST["id"] . "'";

    mysqli_query($link, $abfrage3);

    echo "<p class='ok'>Review erfolgreich geändert!<br><br>
		<a href='reviewsverwalten.php'> <- Zurück zur Review-Übersicht</a></p><br>";
}
/* FORMULAR ABGESCHICKT AKTIONEN ENDE */


/* FORMULAR AUSGABE */
$abfrage = "SELECT * FROM reviews WHERE id='" . save($_REQUEST["id"], $link) . "'";
$query = mysqli_query($link, $abfrage);
$row = mysqli_fetch_object($query);

echo "<h1>" . $row->serie . "-Review bearbeiten</h1>";
echo "Die Namen des Reviews sollte <i>kurz</i> gehalten und dennoch aussagekräftig sein! <BR>
	Keine Verwendung von HTML, lediglich BBCodes (Buttons unten als Hilfe).<br><br>";

echo "<script language='Javascript' src='bbcode.js'></script>";
echo "<form method='post' name='bbform'>";

if ($row->serie == "Website") {
    echo "<table width='95%'>";
    echo "<tr>";
    echo "<td width='38%'>Websitenamen:</td>";
    echo "<td width='62%'><input type='text' name='title' value='" . $row->titel . "' /></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Web-Adresse:</td>";
    echo "<td><input type='text' name='url' value='" . $row->freitext . "' /></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Infos über die Website:</td>";
    echo "<td><textarea name='info'>" . $row->info . "</textarea></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='2'><h2>Erster Eindruck</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Wieviele von 5 Sternen?:</td>";
    echo "<td>";
    echo "<select size='1' name='Estars'>";
    if ($row->rate1 == 1) {
        echo "<option value='1' selected>1</option>";
    } else {
        echo "<option value='1'>1</option>";
    }
    if ($row->rate1 == 2) {
        echo "<option value='2' selected>2</option>";
    } else {
        echo "<option value='2'>2</option>";
    }
    if ($row->rate1 == 3) {
        echo "<option value='3' selected>3</option>";
    } else {
        echo "<option value='3'>3</option>";
    }
    if ($row->rate1 == 4) {
        echo "<option value='4' selected>4</option>";
    } else {
        echo "<option value='4'>4</option>";
    }
    if ($row->rate1 == 5) {
        echo "<option value='5' selected>5</option>";
    } else {
        echo "<option value='5'>5</option>";
    }
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Text:</td>";
    echo "<td><textarea name='Etext'>" . $row->rate1_text . "</textarea></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='2'><h2>Design</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Wieviele von 5 Sternen?:</td>";
    echo "<td>";
    echo "<select size='1' name='Dstars'>";
    if ($row->rate2 == 1) {
        echo "<option value='1' selected>1</option>";
    } else {
        echo "<option value='1'>1</option>";
    }
    if ($row->rate2 == 2) {
        echo "<option value='2' selected>2</option>";
    } else {
        echo "<option value='2'>2</option>";
    }
    if ($row->rate2 == 3) {
        echo "<option value='3' selected>3</option>";
    } else {
        echo "<option value='3'>3</option>";
    }
    if ($row->rate2 == 4) {
        echo "<option value='4' selected>4</option>";
    } else {
        echo "<option value='4'>4</option>";
    }
    if ($row->rate2 == 5) {
        echo "<option value='5' selected>5</option>";
    } else {
        echo "<option value='5'>5</option>";
    }
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Text:</td>";
    echo "<td><textarea name='Dtext'>" . $row->rate2_text . "</textarea></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2'><h2>Coding</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Wieviele von 5 Sternen?:</td>";
    echo "<td>";
    echo "<select size='1' name='Cstars'>";
    if ($row->rate3 == 1) {
        echo "<option value='1' selected>1</option>";
    } else {
        echo "<option value='1'>1</option>";
    }
    if ($row->rate3 == 2) {
        echo "<option value='2' selected>2</option>";
    } else {
        echo "<option value='2'>2</option>";
    }
    if ($row->rate3 == 3) {
        echo "<option value='3' selected>3</option>";
    } else {
        echo "<option value='3'>3</option>";
    }
    if ($row->rate3 == 4) {
        echo "<option value='4' selected>4</option>";
    } else {
        echo "<option value='4'>4</option>";
    }
    if ($row->rate3 == 5) {
        echo "<option value='5' selected>5</option>";
    } else {
        echo "<option value='5'>5</option>";
    }
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Text:</td>";
    echo "<td><textarea name='Ctext'>" . $row->rate3_text . "</textarea></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2'><h2>Angebot (regelmässige Updates/Blogs, Unterseiten, Aktionen etc.)</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Wieviele von 5 Sternen?:</td>";
    echo "<td>";
    echo "<select size='1' name='Astars'>";
    if ($row->rate4 == 1) {
        echo "<option value='1' selected>1</option>";
    } else {
        echo "<option value='1'>1</option>";
    }
    if ($row->rate4 == 2) {
        echo "<option value='2' selected>2</option>";
    } else {
        echo "<option value='2'>2</option>";
    }
    if ($row->rate4 == 3) {
        echo "<option value='3' selected>3</option>";
    } else {
        echo "<option value='3'>3</option>";
    }
    if ($row->rate4 == 4) {
        echo "<option value='4' selected>2</option>";
    } else {
        echo "<option value='4'>4</option>";
    }
    if ($row->rate4 == 5) {
        echo "<option value='5' selected>5</option>";
    } else {
        echo "<option value='5'>5</option>";
    }
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Text:</td>";
    echo "<td><textarea name='Atext'>" . $row->rate4_text . "</textarea></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2'><h2>Rechtliches (Disclaimer, Credits etc.)</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Wieviele von 5 Sternen?:</td>";
    echo "<td>";
    echo "<select size='1' name='Rstars'>";
    if ($row->rate5 == 1) {
        echo "<option value='1' selected>1</option>";
    } else {
        echo "<option value='1'>1</option>";
    }
    if ($row->rate5 == 2) {
        echo "<option value='2' selected>2</option>";
    } else {
        echo "<option value='2'>2</option>";
    }
    if ($row->rate5 == 3) {
        echo "<option value='3' selected>3</option>";
    } else {
        echo "<option value='3'>3</option>";
    }
    if ($row->rate5 == 4) {
        echo "<option value='4' selected>2</option>";
    } else {
        echo "<option value='4'>4</option>";
    }
    if ($row->rate5 == 5) {
        echo "<option value='5' selected>5</option>";
    } else {
        echo "<option value='5'>5</option>";
    }
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Text:</td>";
    echo "<td><textarea name='Rtext'>" . $row->rate5_text . "</textarea></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2'><h2>Gesamt/Fazit</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='2'>";

    include('bbc-buttons.php');

    echo "<textarea name='message' rows='10' cols='34'>" . $row->gesamt_text . "</textarea>";
    echo "<input type='hidden' name='id' value='" . $_REQUEST["id"] . "'>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='2'><input type='submit' name='edit_website' value='Edit " . $row->serie . "-Review'></td>";
    echo "</tr>";
    echo "</table>";
} elseif ($row->serie == "Buch" || $row->serie == "Film") {
    echo "<table width='90%'>";
    echo "<tr>";
    echo "<td>Title:</td>";
    echo "<td><input type='text' name='title' value='" . $row->titel . "' /></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Preis:</td>";
    echo "<td><input type='text' name='preis' value='" . $row->freitext . "' /></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Story:</td>";
    echo "<td>";
    include('bbc-buttons.php');
    echo "<textarea name='message' rows='10' cols='34'>" . $row->info . "</textarea></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Spannung ?/5:</td>";
    echo "<td>";
    echo "<select size='1' name='spannung'>";
    if ($row->rate1 == 1) {
        echo "<option value='1' selected>1</option>";
    } else {
        echo "<option value='1'>1</option>";
    }
    if ($row->rate1 == 2) {
        echo "<option value='2' selected>2</option>";
    } else {
        echo "<option value='2'>2</option>";
    }
    if ($row->rate1 == 3) {
        echo "<option value='3' selected>3</option>";
    } else {
        echo "<option value='3'>3</option>";
    }
    if ($row->rate1 == 4) {
        echo "<option value='4' selected>4</option>";
    } else {
        echo "<option value='4'>4</option>";
    }
    if ($row->rate1 == 5) {
        echo "<option value='5' selected>5</option>";
    } else {
        echo "<option value='5'>5</option>";
    }
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Romantik ?/5:</td>";
    echo "<td>";
    echo "<select size='1' name='romantik'>";
    if ($row->rate2 == 1) {
        echo "<option value='1' selected>1</option>";
    } else {
        echo "<option value='1'>1</option>";
    }
    if ($row->rate2 == 2) {
        echo "<option value='2' selected>2</option>";
    } else {
        echo "<option value='2'>2</option>";
    }
    if ($row->rate2 == 3) {
        echo "<option value='3' selected>3</option>";
    } else {
        echo "<option value='3'>3</option>";
    }
    if ($row->rate2 == 4) {
        echo "<option value='4' selected>4</option>";
    } else {
        echo "<option value='4'>4</option>";
    }
    if ($row->rate2 == 5) {
        echo "<option value='5' selected>5</option>";
    } else {
        echo "<option value='5'>5</option>";
    }
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Humor ?/5:</td>";
    echo "<td>";
    echo "<select size='1' name='humor'>";
    if ($row->rate3 == 1) {
        echo "<option value='1' selected>1</option>";
    } else {
        echo "<option value='1'>1</option>";
    }
    if ($row->rate3 == 2) {
        echo "<option value='2' selected>2</option>";
    } else {
        echo "<option value='2'>2</option>";
    }
    if ($row->rate3 == 3) {
        echo "<option value='3' selected>3</option>";
    } else {
        echo "<option value='3'>3</option>";
    }
    if ($row->rate3 == 4) {
        echo "<option value='4' selected>4</option>";
    } else {
        echo "<option value='4'>4</option>";
    }
    if ($row->rate3 == 5) {
        echo "<option value='5' selected>5</option>";
    } else {
        echo "<option value='5'>5</option>";
    }
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Fazit:</td>";
    echo "<td><textarea name='fazit'>" . $row->gesamt_text . "</textarea></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Endbewertung ?/5:</td>";
    echo "<td>";
    echo "<select size='1' name='bewertung'>";
    if ($row->bewertung == 1) {
        echo "<option value='1' selected>1</option>";
    } else {
        echo "<option value='1'>1</option>";
    }
    if ($row->bewertung == 2) {
        echo "<option value='2' selected>2</option>";
    } else {
        echo "<option value='2'>2</option>";
    }
    if ($row->bewertung == 3) {
        echo "<option value='3' selected>3</option>";
    } else {
        echo "<option value='3'>3</option>";
    }
    if ($row->bewertung == 4) {
        echo "<option value='4' selected>4</option>";
    } else {
        echo "<option value='4'>4</option>";
    }
    if ($row->bewertung == 5) {
        echo "<option value='5' selected>5</option>";
    } else {
        echo "<option value='5'>5</option>";
    }
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><input type='hidden' name='id' value='" . $_REQUEST["id"] . "'></td>";
    echo "<td><input type='submit' name='edit_buch' value='Edit " . $row->serie . "-Review'></td>";
    echo "</tr>";
    echo "</table>";
} elseif ($row->serie == "Sonstiges" || $row->serie == "Musik" || $row->serie == "Kosmetik") {
    echo "<table width='90%'>";
    echo "<tr>";
    echo "<td valign='top'><b>Title:</b></td>";
    echo "<td><input type='text' name='title' value='" . $row->titel . "' /></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td valign='top'><b>Typ:</b></td>";
    echo "<td>" . $row->serie . " (nur in der Übersicht änderbar)</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><b>Bewertung</b> ?/5:</td>";
    echo "<td>";
    echo "<select size='1' name='bewertung'>";
    if ($row->bewertung == 1) {
        echo "<option value='1' selected>1</option>";
    } else {
        echo "<option value='1'>1</option>";
    }
    if ($row->bewertung == 2) {
        echo "<option value='2' selected>2</option>";
    } else {
        echo "<option value='2'>2</option>";
    }
    if ($row->bewertung == 3) {
        echo "<option value='3' selected>3</option>";
    } else {
        echo "<option value='3'>3</option>";
    }
    if ($row->bewertung == 4) {
        echo "<option value='4' selected>4</option>";
    } else {
        echo "<option value='4'>4</option>";
    }
    if ($row->bewertung == 5) {
        echo "<option value='5' selected>5</option>";
    } else {
        echo "<option value='5'>5</option>";
    }
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td></td>";
    echo "<td>";

    include('bbc-buttons.php');

    echo "<textarea name='message' rows='10' cols='34'>" . $row->gesamt_text . "</textarea>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><input type='hidden' name='id' value='" . $_REQUEST["id"] . "'></td>";
    echo "<td><input type='submit' name='edit_sonstiges' value='Edit " . $row->serie . "-Review' /></td>";
    echo "</tr>";
    echo "</table>";
}
echo "</form>";
include('footer.php');
?>
