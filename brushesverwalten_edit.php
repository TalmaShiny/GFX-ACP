<?php
include("header.php");
if (isset($_SESSION["acp"])) {

    echo "<h1>Brushes bearbeiten</h1>";

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "edit") {
        if (is_numeric($_REQUEST["id"])) {
            if (!empty($_POST["series"]) && !empty($_POST["name"])) {
                $update = "UPDATE gfx SET 
					name = '" . save($_POST["name"], $link) . "',
					serie = '" . save($_POST["series"], $link) . "'
					WHERE id = '" . save($_REQUEST["id"], $link) . "'";
                $update_a = mysqli_query($link, $update) OR die(mysqli_error($link));
                echo "<p class='ok'>Brushset erfolgreich editiert.<br></p>";
                echo '<meta http-equiv="refresh" content="1; url=brushesverwalten.php">';
            } else {
                echo "<p class='fault'>Ein Feld wurde nicht ausgefüsllt!<br></p>";
            }
        }
    }

    $abfrage_series = "SELECT serie, COUNT(id) as anzahl FROM gfx WHERE typ = 'Brush' GROUP BY serie";
    $ergebnis_series = mysqli_query($link, $abfrage_series);
    $series = "";
    while ($row_series = mysqli_fetch_object($ergebnis_series)) {
        $series .= "<option value='" . $row_series->serie . "'";
        if (wert("gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'", "serie", $link) == $row_series->serie) {
            $series .= " selected";
        }
        $series .= ">" . $row_series->serie . "</option>";
    }

    $abfrage_design = "SELECT bild, id, vorschau FROM gfx WHERE id='" . $_REQUEST["id"] . "'";
    $ergebnis_design = mysqli_query($link, $abfrage_design);
    $row_design = mysqli_fetch_object($ergebnis_design);
    echo "Du bearbeitest folgendes Brushset:<br>";
    echo "<img src='Brushes/" . $row_design->id . $row_design->bild . "'";
    ?>
    onmouseover="Tip('<img
            src=\'Brushes/<?= $row_design->id; ?>_vorschau<?= $row_design->vorschau; ?>\'>')" onmouseout="UnTip()"
    <?php
    echo "><br><br>";

    echo "<form action='?action=edit&id=" . $_REQUEST["id"] . "' method='POST'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>Name:</td>";
    echo "<td>";
    echo "<input type='text' name='name' size='20' value='" . wert("gfx WHERE id='" . save($_REQUEST["id"], $link) . "'", "name", $link) . "'>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Series:</td>";
    echo "<td><select name='series'>" . $series . "</select></td>";
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