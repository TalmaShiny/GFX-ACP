<?php
include("header.php");
if (isset($_SESSION["acp"])) {

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "edit") {
        if (is_numeric($_REQUEST["id"])) {
            if (!empty($_POST["serie"])) {
                $update = "UPDATE gfx SET 
					serie = '" . save($_POST["serie"], $link) . "' 
					WHERE id = '" . save($_REQUEST["id"], $link) . "'";
                $update_a = mysqli_query($link, $update) OR die(mysqli_error($link));
                echo "<p class='ok'>iconbase erfolgreich editiert.<br></p>";
                echo '<meta http-equiv="refresh" content="1; url=iconbasesverwalten.php">';
            } else {
                echo "<p class='fault'>Ein Feld wurde nicht ausgefüllt!<br></p>";
            }
        }
    }

    echo "<h1>Iconbase bearbeiten</h1>";

    $abfrage_series = "SELECT serie, COUNT(id) as anzahl FROM gfx WHERE typ = 'Iconbases' GROUP BY serie";
    $ergebnis_series = mysqli_query($link, $abfrage_series);
    $serie = "";
    while ($row_series = mysqli_fetch_object($ergebnis_series)) {
        $serie .= "<option value='" . $row_series->serie . "'";
        if (wert("gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'", "serie", $link) == $row_series->serie) {
            $serie .= " selected";
        }
        $serie .= ">" . $row_series->serie . "</option>";


    }

    $abfrage_iconbase = "SELECT id, bild FROM gfx WHERE id ='" . $_REQUEST["id"] . "'";
    $ergebnis_iconbase = mysqli_query($link, $abfrage_iconbase);
    $row_iconbase = mysqli_fetch_object($ergebnis_iconbase);
    echo "Du bearbeitest folgenden Iconbase:<br>";
    echo "<img src='Iconbases/" . $row_iconbase->id . $row_iconbase->bild . "'><br><br>";

    echo "<form action='iconbasesverwalten_edit.php?action=edit&id=" . $_REQUEST["id"] . "' method='POST'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>Series:</td>";
    echo "<td><select name='serie'>" . $serie . "</select></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='2'><input type='submit' value='EDIT!' /></td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";
} else {
    echo "<p class='fault'>Kein Zutritt!</p>";
}
include("footer.php");
?>
