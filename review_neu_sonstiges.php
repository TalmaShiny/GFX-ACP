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
				'',
				'',
				'0',
				'',
				'0',
				'',
				'0',
				'',
				'0',
				'',
				'0',
				'',
				'" . save($_POST["bewertung"], $link) . "',
				'" . save($_POST["message"], $link) . "',
				'" . save($row->name, $link) . "',
				'" . time() . "',
				'" . save($_POST["serie"], $link) . "',
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

    if (isset($_REQUEST["typ"]) && $_REQUEST["typ"] != "") {
        echo "<h1>Neues " . $_REQUEST["typ"] . "-Review hinzufügen</h1>";
        echo "Die Namen des Reviews sollte <i>kurz</i> gehalten und dennoch aussagekräftig sein! <BR>
			Keine Verwendung von HTML, lediglich BBCodes (Buttons unten als Hilfe).<br>
			Die Vorschau-Grafik ist standardmässig wieder 100x100 Pixel gross sein!<br><br>";

        echo "<script language='Javascript' src='bbcode.js'></script>";
        echo "<form method='post' name='bbform' enctype='multipart/form-data'>";
        echo "<table width='500'>";
        echo "<tr>";
        echo "<td valign='top'>Titel:</td>";
        echo "<td><input type='text' name='title' value='' /></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td valign='top'>Bewertung(Anzahl Sterne):</td>";
        echo "<td>";
        echo "<select name='bewertung'>
							<option value='1'>1</option>
							<option value='2'>2</option>
							<option value='3'>3</option>
							<option value='4'>4</option>
							<option value='5'>5</option>
							</select>";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td valign='top'>Vorschau:</td>";
        echo "<td><input type='file' name='vorschau'></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td></td>";
        echo "<td>";
        include('bbc-buttons.php');
        echo "<textarea name='message' rows='10' cols='34'></textarea>";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><input type='hidden' name='serie' value='" . $_REQUEST['typ'] . "'></td>";
        echo "<td><input type='submit' name='newreview' value='Neues " . $_REQUEST['typ'] . "-Review' />";
        echo "</td>";
        echo "</tr>";
        echo "</form>";
        echo "</table>";
    }
} else {
    echo "<p class='fault'>Nicht eingeloggt!</p>";
}
include("footer.php");
?>
