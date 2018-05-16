<?php
include("header.php");
if (isset($_SESSION["acp"])) {

    if (!empty($_POST['newreview'])) {
        $select = mysqli_query($link, "SELECT name FROM benutzer WHERE id ='" . $_SESSION["acp"] . "'");
        $row = mysqli_fetch_object($select);

        if (!empty($_POST["title"]) && !empty($_POST["message"])) {
            if (!empty($_FILES["vorschau"]["name"])) {
                $endung = strstr($_FILES["vorschau"]["name"], ".");
            }

            $newnews = "INSERT INTO reviews (titel, freitext, info, rate1, rate1_text, rate2, rate2_text, rate3, 
				rate3_text, rate4, rate4_text, rate5, rate5_text, bewertung, gesamt_text, webby, date, serie, vorschau) VALUES (
				'" . save($_POST["title"], $link) . "',
				'" . save($_POST["url"], $link) . "',
				'" . save($_POST["info"], $link) . "',
				'" . save($_POST["Estars"], $link) . "',
				'" . save($_POST["Etext"], $link) . "',
				'" . save($_POST["Dstars"], $link) . "',
				'" . save($_POST["Dtext"], $link) . "',
				'" . save($_POST["Cstars"], $link) . "',
				'" . save($_POST["Ctext"], $link) . "',
				'" . save($_POST["Astars"], $link) . "',
				'" . save($_POST["Atext"], $link) . "',
				'" . save($_POST["Rstars"], $link) . "',
				'" . save($_POST["Rtext"], $link) . "',
				'',
				'" . save($_POST["message"], $link) . "',
				'" . save($row->name, $link) . "',
				'" . time() . "',
				'Website',
				'" . $endung . "'
				)";
            $newwebby_query = mysqli_query($link, $newnews) OR die(mysqli_error($link));
            $id = mysqli_insert_id($link);

            move_uploaded_file($_FILES["vorschau"]["tmp_name"], "Reviews/" . $id . $endung);
            echo "<p class='ok'>Neues Review erfolgreich erstellt.<br /></p>";
            echo "<meta http-equiv='refresh' content='1; URL=reviewsverwalten.php'>"; // Weiterleitung
        } else {
            echo "<p class='fault'>Ein benötigtes Feld wurde nicht ausgefüllt!</p>";
        }
    }

    echo "<h1>Neues Website-Review hinzufügen</h1>";
    echo "Die Namen des Reviews sollte <i>kurz</i> gehalten und dennoch aussagekräftig sein! <BR>
		Keine Verwendung von HTML, lediglich BBCodes (Buttons unten als Hilfe).<br>
		Die Vorschau-Grafik ist standardmässig wieder 100x100 Pixel gross sein!<br><br>";

    echo "<script language='Javascript' src='bbcode.js'></script>";
    echo "<form method='post' name='bbform' enctype='multipart/form-data'>";
    echo "<table width='95%'>";
    echo "<tr>";
    echo "<td width='38%'>Websitenamen:</td>";
    echo "<td width='62%'><input type='text' name='title' value='" . (!empty($_POST['title']) ? $_POST['title'] : "") . "' /></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Web-Adresse:</td>";
    echo "<td><input type='text' name='url' value='https://' /></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Infos über die Website:</td>";
    echo "<td><textarea name='info'>" . (!empty($_POST['info']) ? $_POST['info'] : "") . "</textarea></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td valign='top'>Vorschau:</td>";
    echo "<td><input type='file' name='vorschau'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2'><h2>Erster Eindruck</h2> Farbkombi? Übersichtlich? Schöner Header?</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Wieviele von 5 Sternen?:</td>";
    echo "<td>";
    echo "<select size='1' name='Estars'>";
    echo "<option value='1'>1</option>";
    echo "<option value='2'>2</option>";
    echo "<option value='3'>3</option>";
    echo "<option value='4'>4</option>";
    echo "<option value='5'>5</option>";
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Text:</td>";
    echo "<td><textarea name='Etext'>" . (!empty($_POST['Etext']) ? $_POST['Etext'] : "") . "</textarea></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2'><h2>Design</h2> Headerverarbeitung? Gut geblendet? Saubere Führung?</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Wieviele von 5 Sternen?:</td>";
    echo "<td>";
    echo "<select size='1' name='Dstars'>";
    echo "<option value='1'>1</option>";
    echo "<option value='2'>2</option>";
    echo "<option value='3'>3</option>";
    echo "<option value='4'>4</option>";
    echo "<option value='5'>5</option>";
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Text:</td>";
    echo "<td><textarea name='Dtext'>" . (!empty($_POST['Dtext']) ? $_POST['Dtext'] : "") . "</textarea></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2'><h2>Coding</h2> Valide? Sauber? CSS und Inhalt getrennt?</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Wieviele von 5 Sternen?:</td>";
    echo "<td>";
    echo "<select size='1' name='Cstars'>";
    echo "<option value='1'>1</option>";
    echo "<option value='2'>2</option>";
    echo "<option value='3'>3</option>";
    echo "<option value='4'>4</option>";
    echo "<option value='5'>5</option>";
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Text:</td>";
    echo "<td><textarea name='Ctext'>" . (!empty($_POST['Ctext']) ? $_POST['Ctext'] : "") . "</textarea></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2'><h2>Angebot</h2> regelmässige Updates/Blogs, Unterseiten, Aktionen etc.?</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Wieviele von 5 Sternen?:</td>";
    echo "<td>";
    echo "<select size='1' name='Astars'>";
    echo "<option value='1'>1</option>";
    echo "<option value='2'>2</option>";
    echo "<option value='3'>3</option>";
    echo "<option value='4'>4</option>";
    echo "<option value='5'>5</option>";
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Text:</td>";
    echo "<td><textarea name='Atext'>" . (!empty($_POST['Atext']) ? $_POST['Atext'] : "") . "</textarea></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2'><h2>Rechtliches</h2> Disclaimer, Credits, evtl. Review-Button-Verlinkung?</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Wieviele von 5 Sternen?:</td>";
    echo "<td>";
    echo "<select size='1' name='Rstars'>";
    echo "<option value='1'>1</option>";
    echo "<option value='2'>2</option>";
    echo "<option value='3'>3</option>";
    echo "<option value='4'>4</option>";
    echo "<option value='5'>5</option>";
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Text:</td>";
    echo "<td><textarea name='Rtext'>" . (!empty($_POST['Rtext']) ? $_POST['Rtext'] : "") . "</textarea></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2'><h2>Gesamt/Fazit</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='2'>";

    include('bbc-buttons.php');

    echo "<textarea name='message' rows='10' cols='34'>" . (!empty($_POST['message']) ? $_POST['message'] : "") . "</textarea>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='2'><input type='submit' name='newreview' value='Neues Website-Review'></td>";
    echo "</tr>";
    echo "</table>";
} else {
    echo "<p class='fault'>Nicht eingeloggt!</p>";
}
include("footer.php");
?>
