<?php
include("header.php");
include("pagetest.php");

if (isset($_SESSION["acp"])) {
    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "delete" && is_numeric($_REQUEST["id"])) {
        $delete = "DELETE FROM updateplan WHERE id = '" . $_REQUEST["id"] . "'";
        $delete_a = mysqli_query($link, $delete) OR die(mysqli_error($link));
        echo "<p class='ok'>Eintrag gelöscht.<br></p>";
    }

    echo "<h1>Bisherige Updateplan-Eintragungen</h1>";
    echo "Hier siehst du alle Einträge/Updates auf deiner Website:<br><center>";

    $itemsPerPage = 15;
    $start = 0;
    if (!empty($_GET['go'])) {
        $start = ($_GET['go'] - 1) * $itemsPerPage;
    }
    pagefunc($itemsPerPage, "updateplan", $link);

    if ($start >= 0) {
        $abfrage = "SELECT * FROM updateplan ORDER BY monat, tag, jahr ASC LIMIT " . $start . ", " . $itemsPerPage;
    } else {
        $abfrage = "SELECT * FROM updateplan ORDER BY monat, tag, jahr ASC LIMIT 0, " . $itemsPerPage;
    }
    echo "<br><table cellpadding='4' cellspacing='1' border='0' class='tableinborder' width='95%'>";
    echo "<th>Datum</th>";
    echo "<th>Webby</th>";
    echo "<th>Event</th>";
    echo "<th colspan='2'></th>";

    $ergebnis = mysqli_query($link, $abfrage);
    while ($up = mysqli_fetch_object($ergebnis)) {
        echo "<tr valign='top'>";
        echo "<td valign='top'>" . $up->tag . "." . $up->monat . "." . $up->jahr . "</td>";
        echo "<td valign='top'>" . $up->name . "</td>";
        if ($up->event != '') {
            echo "<td valign='top'>" . $up->event . "</td>";
        } else {
            echo "<td valign='top'>Kein Event eingetragen.</td>";
        }
        echo "<td>";
        echo "<a href='updateplanverwalten.php?action=delete&id=" . $up->id . "'>
			<img src='webicons/delete.png' border='0' alt=''> Löschen</a>";
        echo "</td>";
        echo "<td>";
        echo "<a href='updateplan_edit.php?id=" . $up->id . "'>
			<img src='webicons/edit.png' border='0' alt=''> Bearbeiten</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table></center>";

    echo "<h1>In Updateplan eintragen</h1>";
    echo "Du hast Lust zu updaten? Na dann trag dich doch einfach gleich ein:<br><br>";

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "eintragen") {
        if ($_REQUEST["schonmal"] == "Ja") {
            $insert = "UPDATE updateplan SET 
				name = '" . $_REQUEST["webby"] . "', 
				event = '" . save($_POST["event"], $link) . "' 
				WHERE tag = '" . save($_POST["tag1"], $link) . "' 
				AND monat = '" . save($_POST["monat1"], $link) . "' 
				AND jahr = '" . save($_POST["jahr1"], $link) . "'";
            $insert_a = mysqli_query($link, $insert) OR die(mysqli_error($link));
            echo "<center><br />Update erfolgreich editiert.<br /></center>";
        }
        if ($_REQUEST["schonmal"] == "Nein") {
            $insert = "INSERT INTO updateplan (name, tag, monat, jahr, event) VALUES(
				'" . $_REQUEST["webby"] . "', 
				'" . save($_POST["tag1"], $link) . "', 
				'" . save($_POST["monat1"], $link) . "', 
				'" . save($_POST["jahr1"], $link) . "', 
				'" . save($_POST["event"], $link) . "')";
            $insert_a = mysqli_query($link, $insert) OR die(mysqli_error($link));
            echo "<center><br />Update erfolgreich eingetragen.<br /></center>";
            echo "<meta http-equiv='refresh' content='0; URL=updateplanverwalten.php'>";
        }
    }

    if (empty($_REQUEST["action"]) || $_REQUEST["action"] != "auswaehlen") {

        echo "<form action='updateplanverwalten.php?action=auswaehlen' method='post'>";
        echo "<table>";
        echo "<tr>";
        echo "<td>";
        $tage = "";
        $monate = "";
        $jahre = "";
        for ($i = 1; $i <= 31; $i++) {
            if ($i < 10) {
                $z = "0" . $i;
            } else {
                $z = $i;
            }
            $tage .= "<option>" . $z . "</option>";
        }

        for ($i = 1; $i <= 12; $i++) {
            if ($i < 10) {
                $z = "0" . $i;
            } else {
                $z = $i;
            }
            $monate .= "<option>" . $z . "</option>";
        }
        for ($i = 10; $i <= 20; $i++) {
            $z = $i;
            $jahre .= "<option>" . $z . "</option>";
        }
        echo "<select name='tag'>" . $tage . "</select>";
        echo "<select name='monat'>" . $monate . "</select>";
        echo "<select name='jahr'>" . $jahre . "</select>";
        echo "</td>";
        echo "<td><input type='submit' value='Ok!' /></td>";
        echo "</tr>";
        echo "</table>";
        echo "</form>";
    }

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "auswaehlen") {
        $webby = "";
        $updateplan = "SELECT * FROM updateplan WHERE 
			tag = '" . $_POST["tag"] . "' 
			AND monat = '" . $_POST["monat"] . "' 
			AND jahr = '" . $_POST["jahr"] . "'";
        $updateplan_a = mysqli_query($link, $updateplan) OR die(mysqli_error($link));
        if (mysqli_num_rows($updateplan_a) != 0) {
            while ($up = mysqli_fetch_object($updateplan_a)) {
                $webby = $up->name;
                $event = $up->event;
            }
            $schonmal = "Ja";
        } else {
            $event = "";
            $schonmal = "Nein";
        }

        echo "<form action='updateplanverwalten.php?action=eintragen' method='post'>";
        echo "<table>";
        echo "<tr>";
        echo "<td>Tag:</td>";
        echo "<td>" . $_POST["tag"] . "." . $_POST["monat"] . "." . $_POST["jahr"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Webby:</td>";
        echo "<td>";
        echo "<select name='webby'>";
        if ($webby != "") {
            echo "<option selected>" . $webby . "</option>";
        }
        $s_webby = "SELECT name FROM benutzer ORDER BY name";
        $s_webby_a = mysqli_query($link, $s_webby);
        while ($web = mysqli_fetch_object($s_webby_a)) {
            echo "<option>" . $web->name . "</option>";
        }
        echo "</select>";
        echo "</td>";
        echo "</tr>";
        echo "<input type='hidden' name='schonmal' value='" . $schonmal . "' />";
        echo "<input type='hidden' name='tag1' value='" . $_REQUEST['tag'] . "' />";
        echo "<input type='hidden' name='monat1' value='" . $_REQUEST['monat'] . "' />";
        echo "<input type='hidden' name='jahr1' value='" . $_REQUEST['jahr'] . "' />";
        echo "<tr>";
        echo "<td valign='top'>Event:</td>";
        echo "<td><textarea name='event'>" . $event . "</textarea></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td></td><td><input type='submit' value='EINTRAGEN!' />";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "</form>";
    }
} else {
    echo "Kein Zutritt!";
}
include("footer.php");
?>
