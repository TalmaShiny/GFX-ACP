<?php
include("header.php");
if (isset($_SESSION["acp"])) {

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "newtutorial") {
        $select = mysqli_query($link, "SELECT name FROM benutzer WHERE id ='" . $_SESSION["acp"] . "'");
        $row = mysqli_fetch_object($select);

        if (!empty($_POST["title"]) && !empty($_POST["message"])) {
            $newnews = "INSERT INTO tutorials (titel, webby, date, serie, text, vorschau) VALUES (
				'" . save($_POST["title"], $link) . "',
				'" . save($row->name, $link) . "',
				'" . time() . "',
				'" . save($_POST["serie"], $link) . "',
				'" . save($_POST["message"], $link) . "',
				'" . save(strstr($_FILES["vorschau"]["name"], "."), $link) . "'
				)";
            $newwebby_query = mysqli_query($link, $newnews) OR die(mysqli_error($link));
            $id = mysqli_insert_id($link);
            $endung = strstr($_FILES["vorschau"]["name"], ".");
            move_uploaded_file($_FILES["vorschau"]["tmp_name"], "Tutorials/" . $id . $endung);
            echo "<p class='ok'>Neues Tutorial erfolgreich erstellt.<br /></p>";
            echo "<meta http-equiv='refresh' content='1; URL=tutorialsverwalten.php'>"; // Weiterleitung

        } else {
            echo "<p class='fault'>Ein benötigtes Feld wurde nicht ausgefüllt!</p>";
        }
    }

    echo "<h1>Neues Tutorial hinzufügen</h1>";
    echo "Die Namen der Tutorials sollten <i>kurz</i> gehalten und dennoch aussagekräftig sein! 
		Die Vorschau-Grafik ist standardmässig wieder 100x100 Pixel gross sein!<br><br>";

    echo "<script language='Javascript' src='bbcode.js'></script>";
    echo "<form action='?action=newtutorial' method='post' name='bbform' enctype='multipart/form-data'>";
    echo "<table width='500'>";
    echo "<tr>";
    echo "<td valign='top'>Titel:</td>";
    echo "<td><input type='text' name='title' value='' /></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td valign='top'>Vorschau:</td>";
    echo "<td><input type='file' name='vorschau'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td valign='top'>Serie:</td>";
    echo "<td>";
    echo "<select name='serie'>
						<option value='Grafikprogramm'>Grafikprogramm</option>
						<option value='PHP-Programmierung'>PHP-Programmierung</option>
						<option value='HTML/CSS'>HTML/CSS</option>
						<option value='Sonstiges'>Sonstiges</option>
						</select>";
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td></td>";
    echo "<td>";
    include('bbc-buttons.php');
    echo "<textarea name='message'  rows='10' cols='34'></textarea>";
    echo "<div class='gfx' style='text-align: center; width:270px;'>" . smilies($link) . "</div>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td></td>";
    echo "<td><input type='submit' name='create' value='NEUES TUTORIAL' />";
    echo "</td>";
    echo "</tr>";
    echo "</form>";
    echo "</table>";
} else {
    echo "<p class='fault'>Nicht eingeloggt!</p>";
}
include("footer.php");
?>
