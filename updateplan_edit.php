<?php
include("header.php");
if (isset($_SESSION["acp"])) {

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "edit" && is_numeric($_REQUEST["id"])) {
        $delete = "UPDATE updateplan SET 
			name = '" . $_POST["webby"] . "', 
			event = '" . save($_POST["event"], $link) . "' 
			WHERE id = '" . $_REQUEST["id"] . "'";

        $delete_a = mysqli_query($link, $delete) OR die(mysqli_error($link));
        echo "<center><br>Eintrag geändert.<br></center>";
    }

    echo "<h1>Updateplan ändern</h1>";
    $upa = "SELECT * FROM updateplan WHERE id = '" . save($_REQUEST["id"], $link) . "'";
    $upaa = mysqli_query($link, $upa);
    while ($up = mysqli_fetch_object($upaa)) {

        echo "<form action='updateplan_edit.php?action=edit&id=" . $_REQUEST["id"] . "' method='POST'>";
        echo "<table>";
        echo "<tr>";
        echo "<td>Tag:</td>";
        echo "<td>" . $up->tag . "." . $up->monat . "." . $up->jahr . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Webby:</td>";
        echo "<td>";
        echo "<select name='webby'>";
        echo "<option selected='selected'>" . $up->name . "</option>";
        $s_webby = "SELECT name FROM benutzer ORDER BY name";
        $s_webby_a = mysqli_query($link, $s_webby);
        while ($web = mysqli_fetch_object($s_webby_a)) {
            echo "<option>" . $web->name . "</option>";
        }
        echo "</select>";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td valign='top'>Event:</td>";
        echo "<td><textarea name='event'>" . $up->event . "</textarea></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td></td><td><input type='submit' value='EDIT!' /></td>";
        echo "</tr>";
        echo "</table>";
        echo "</form>";
    }
} else {
    echo "Kein Zutritt!";
}
include("footer.php");
?>
