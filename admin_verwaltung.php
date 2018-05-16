<?php
include("header.php");
if (isset($_SESSION["acp"]) && wert("benutzer WHERE id='" . $_SESSION["acp"] . "'", "gruppe", $link) == 1) {

    echo "<h1>Benutzerverwaltung</h1>";

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "newadmin" && !empty($_POST["newname"]) && !empty($_POST["newpasswort"])) {
        $newwebby = "INSERT INTO benutzer (name, passwort, email, hp, tag, monat, jahr, bild, benutzertext, since, gruppe, refresh) VALUES (
			'" . save($_POST["newname"], $link) . "', 
			'" . crypt($_POST["newpasswort"], $salt) . "',
			'',
			'',
			'0',
			'0',
			'0',
			'',
			'',
			'" . time() . "',
			'" . save($_POST["newrang"], $link) . "',
			'0'
			)";
        mysqli_query($link, $newwebby) OR die(mysqli_error($link));
        echo "<p class='ok'>Neuen Benutzer erfolgreich erstellt!</p><br /><br />";
    } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "editrang" && !empty($_POST["rang"])) {
        $update = "UPDATE benutzer SET 
			gruppe = '" . $_POST["rang"] . "'
			WHERE id = '" . save($_REQUEST["id"], $link) . "'";
        mysqli_query($link, $update) OR die(mysqli_error($link));
        echo "<p class='ok'>Benutzerrang erfolgreich bearbeitet.</p><br>";
    } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "editpw" && !empty($_POST["passwort"])) {
        $update = "UPDATE benutzer SET 
			passwort = '" . crypt($_POST["passwort"], $salt) . "'
			WHERE id = '" . save($_REQUEST["id"], $link) . "'";
        mysqli_query($link, $update) OR die(mysqli_error($link));
        echo "<p class='ok'>Benutzerpasswort erfolgreich bearbeitet.</p><br>";
    } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "deleteadmin") {
        $delete_gfx = "SELECT name FROM benutzer WHERE id = '" . save($_REQUEST["id"], $link) . "'";
        $query = mysqli_query($link, $delete_gfx) OR die(mysqli_error($link));
        $row = mysqli_fetch_object($query);
        echo "Möchtest du alle Gfx, Tutorials etc. von " . $row->name . " mitlöschen?";
        echo "<form action='admin_verwaltung.php' method='post'>";
        echo "<input type='submit' name='delete_ja' value='Ja!'> ";
        echo "<input type='submit' name='delete_nein' value='Nein!'>";
        echo "<input type='hidden' name='webby' value='" . $row->name . "'>";
        echo "</form>";
        echo "<br>";
    }

    if (!empty($_POST["delete_ja"])) {
        /* GFX */
        $delete1 = "DELETE FROM gfx WHERE webby = '" . $_POST['webby'] . "'";
        mysqli_query($link, $delete1) OR die(mysqli_error($link));
        echo "<p class='ok'>Alle Gfx des Benutzers erfolgreich gelöscht.</p><br>";

        /* TUTS + TUTKOMMENTS */
        $delete2 = "SELECT id FROM tutorials WHERE webby = '" . $_POST['webby'] . "'";
        $query = mysqli_query($link, $delete2) OR die(mysqli_error($link));
        while ($row = mysqli_fetch_object($query)) {
            $delete3 = "DELETE FROM tutorials_kommentare WHERE tutorial_id = '" . $row->id . "'";
            mysqli_query($link, $delete3) OR die(mysqli_error($link));
        }
        $delete4 = "DELETE FROM tutorials WHERE webby = '" . $_POST['webby'] . "'";
        mysqli_query($link, $delete4) OR die(mysqli_error($link));
        echo "<p class='ok'>Alle Tutorials und Tutorialkommentare des Benutzers erfolgreich gelöscht.</p><br>";

        /* WEBBY SELBER */
        $delete5 = "DELETE FROM benutzer WHERE name = '" . $_POST['webby'] . "'";
        mysqli_query($link, $delete5) OR die(mysqli_error($link));
        echo "<p class='ok'>Benutzer auch erfolgreich gelöscht.</p><br>";
    }
    if (!empty($_POST["delete_nein"])) {
        $delete = "DELETE FROM benutzer WHERE name = '" . $_POST['webby'] . "'";
        mysqli_query($link, $delete) OR die(mysqli_error($link));
        echo "<p class='ok'>Nur Benutzer erfolgreich gelöscht.</p><br>";
    }

    echo "<h2>Neuen Benutzer erstellen</h2><br>";

    echo "<form action='admin_verwaltung.php?action=newadmin' method='post'>";
    echo "<table width='500'>";
    echo "<tr>";
    echo "<td>Name:</td>";
    echo "<td><input type='text' name='newname' maxlength='20'/></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Passwort:</td>";
    echo "<td><input type='password' name='newpasswort' value='' maxlength='15'/></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Gruppe:</td>";
    echo "<td>";
    echo "<select name='newrang'>";
    echo "<option value='1'>Admin</option>";
    echo "<option value='2'>Benutzer</option>";
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td></td>";
    echo "<td><input type='submit' name='create' value='OK' /></td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";

    echo "<br><br>";

    echo "<h2>Benutzer bearbeiten</h2><br>";
    echo "<center>";
    echo "<table width='90%' cellpadding='4' cellspacing='1' border='0' class='tableinborder'>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>Passwort</th>";
    echo "<th>Rang</th>";
    echo "<th>Löschen</th>";
    echo "</tr>";

    $abfrage = "SELECT * FROM benutzer ORDER BY id";
    $ergebnis = mysqli_query($link, $abfrage);
    while ($row = mysqli_fetch_object($ergebnis)) {
        $id = $row->id;
        echo "<tr>";
        echo "<td align='center'>" . $row->name . "</td>";
        echo "<td align='center'>";
        echo "<form action='?action=editpw&id=" . $id . "' method='post'>";
        echo "<input type='password' name='passwort' value='1234' size='8'/>";
        echo "<input type='submit' name='editpw' value='OK' />";
        echo "</form>";
        echo "</td>";
        echo "<td align='center'>";
        echo "<form action='?action=editrang&id=" . $id . "' method='post'>";
        echo "<select name='rang'>";
        if ($row->gruppe == 1) {
            echo "<option value='1' selected>Admin</option><option value='2'>Benutzer</option>";
        }
        if ($row->gruppe == 2) {
            echo "<option value='2' selected>Benutzer</option><option value='1'>Admin</option>";
        }
        echo "</select>";
        echo "<input type='submit' name='editrang' value='OK' />";
        echo "</form>";
        echo "</td>";
        echo "<td align='center'>";
        echo "<form action='?action=deleteadmin&id=" . $id . "' method='post'>";
        echo "<input type='submit' name='löschen_webby' value='OK' />";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table><br><br>";
    echo "</center>";
} else {
    echo "Kein Zutritt!";
}
include('footer.php');
?>
