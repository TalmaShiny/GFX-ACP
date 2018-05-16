<?php
include("header.php");
if (isset($_SESSION["acp"])) {

    if (isset($_POST['wahl'])) {
        if ($_POST['serie'] == "Website") {
            echo "<meta http-equiv='refresh' content='0; URL=review_neu_website.php'>";
        } elseif ($_POST['serie'] == "Sonstiges" || $_POST['serie'] == "Kosmetik" || $_POST['serie'] == "Musik") {
            echo "<meta http-equiv='refresh' content='0; URL=review_neu_sonstiges.php?typ=" . $_POST['serie'] . "'>";
        } else if ($_POST['serie'] == "Buch" || $_POST['serie'] == "Film") {
            echo "<meta http-equiv='refresh' content='0; URL=review_neu_media.php?typ=" . $_POST['serie'] . "'>";
        }
    }


    echo "<h1>Neues Review hinzufügen</h1>";
    echo "<center>";
    echo "<form method='post'>";
    echo "<b>Review-Typ wählen:</b><br><br>";
    echo "<select name='serie'>
			<option value='Buch'>Buch/Zeitschrift</option>
			<option value='Film'>Film/Serie</option>
			<option value='Kosmetik'>Kosmetik</option>
			<option value='Website'>Website</option>
			<option value='Musik'>Musik/Bands</option>
			<option value='Sonstiges'>Sonstiges</option>
			</select><br><br>";
    echo "<input type='submit' value='WÄHLEN' name='wahl'>";
    echo "</form>";
    echo "</center>";
} else {
    echo "<p class='fault'>Nicht eingeloggt!</p>";
}
include("footer.php");
?>
