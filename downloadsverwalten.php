<?php
include("header.php");
include("pagetest.php");
if (isset($_SESSION["acp"])) { // Wenn eingeloggt..

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "delete") {
        if (is_numeric($_REQUEST["id"])) {
            if (exist("downloads WHERE id = '" . $_REQUEST["id"] . "'", $link)) {
                unlink("Downloads/screen" . $_REQUEST["id"] . wert("downloads WHERE id = '" . save($_REQUEST["id"], $link) . "'", "screen", $link) . "");
                unlink("Downloads/vorschau" . $_REQUEST["id"] . wert("downloads WHERE id = '" . save($_REQUEST["id"], $link) . "'", "vorschau", $link) . "");
                unlink("Downloads/load" . $_REQUEST["id"] . wert("downloads WHERE id = '" . save($_REQUEST["id"], $link) . "'", "zip", $link) . "");
                mysqli_query($link, "DELETE FROM downloads WHERE id = '" . $_REQUEST["id"] . "'");
                echo "<p class='ok'>Download wurde erfolgreich gelöscht.</p>";
            }
        }
    } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "delete2" && isset($_REQUEST["id"])) {
        if (is_numeric($_REQUEST["id"])) {
            $loeschen = "DELETE FROM downloads_kommentare WHERE id = '" . $_REQUEST["id"] . "'";
            $loesch = mysqli_query($link, $loeschen); // Eintrag löschen
            echo "<p class='ok'>Kommentar erfolgreich gelöscht</p>";
        }
    } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "delete3" && isset($_REQUEST["id"])) { //delete all
        if (is_numeric($_REQUEST["id"])) {
            $loeschen = "DELETE FROM downloads_kommentare WHERE dl_id = '" . $_REQUEST["id"] . "'";
            $loesch = mysqli_query($link, $loeschen); // Eintrag löschen
            echo "<p class='ok'>Alle Kommentare wurden gelöscht</p>";
        }
    } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "update" && isset($_REQUEST["id"])) {
        if (is_numeric($_REQUEST["id"])) {
            $aendern = "UPDATE downloads Set 
				name= '" . save($_POST['name'], $link) . "',
				typ= '" . save($_POST['typ'], $link) . "',
				info = '" . save($_POST['info'], $link) . "',
				text = '" . save($_POST['message'], $link) . "' 
				WHERE id= '" . $_REQUEST["id"] . "'";
            $update = mysqli_query($link, $aendern);
            echo "<p class='ok'>Downloadtexte wurden erfolgreich geändert<br /></p>";
            echo "<meta http-equiv='refresh' content='1; URL=downloadsverwalten.php'>"; // Weiterleitung
        }
    } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "edit" && isset($_REQUEST["id"])) {
        if (is_numeric($_REQUEST["id"])) {
            $abfrage = "SELECT * FROM downloads WHERE id ='" . $_REQUEST["id"] . "'";
            $ergebnis = mysqli_query($link, $abfrage);
            while ($row = mysqli_fetch_object($ergebnis)) {
                echo "<h1>Download bearbeiten</h1>";
                echo "<script language='Javascript' src='bbcode.js'></script>";
                echo "<form action=\"?&action=update&id=" . $_REQUEST['id'] . "\" name='bbform' method=\"post\">";
                echo "<table>";
                echo "<tr>";
                echo "<td>Name:</td>";
                echo "<td><input type='text' name='name' value='" . $row->name . "'></td>";
                echo "</tr><tr>";
                echo "<td>Typ:</td>";
                echo "<td><select name='typ'>";
                if ($row->typ == "php") {
                    echo "<option value='php' selected>PHP-Skript</option>";
                } else {
                    echo "<option value='php'>PHP-Skript</option>";
                }
                if ($row->typ == "psd") {
                    echo "<option value='psd' selected>Photoshop-Datei</option>";
                } else {
                    echo "<option value='psd'>Photoshop-Datei</option>";
                }
                if ($row->typ == "html") {
                    echo "<option value='html' selected>HTML/CSS-Skript</option>";
                } else {
                    echo "<option value='html'>HTML/CSS-Skript</option>";
                }
                if ($row->typ == "set") {
                    echo "<option value='set' selected>Resource Set</option>";
                } else {
                    echo "<option value='set'>Resource Set</option>";
                }
                echo "</td></tr>";
                echo "<tr>";
                echo "<td>Vorschau Text:</td>";
                echo "<td><textarea name='info' cols=34 rows=5>" . $row->info . "</textarea></td>";
                echo "</tr><tr>";
                echo "<td>Download Text:</td>";
                echo "<td>";
                include('bbc-buttons.php');
                echo "<textarea name='message' cols=34 rows=10>" . $row->text . "</textarea>";
                echo "</td>";
                echo "</tr><tr><td></td>";
                echo "<td><input type=\"submit\" value=\"Edit!\"></td>";
                echo "</tr></table></form><br /><br />";

                if ($row->typ == "php") {
                    $abfrage_kommi = "SELECT * FROM downloads_kommentare WHERE dl_id ='" . $_REQUEST["id"] . "'";
                    $ergebnis_kommi = mysqli_query($link, $abfrage_kommi);
                    $kommentarezaehlen = 0;

                    while ($kom = mysqli_fetch_object($ergebnis_kommi)) {
                        echo "<h2>Kommentare</h2>";
                        echo "Von <B>" . $kom->name . "</B>";
                        if ($kom->email != "") {
                            echo "(" . $kom->email;
                        } else {
                            echo "(";
                        }
                        if ($kom->hp != "") {
                            echo "| " . $kom->hp . "):";
                        } else {
                            echo "):";
                        }

                        $textmax = 60;
                        for ($a = 0; $a <= $textmax; $a++) {
                            $text[$a] = $kom->text[$a];
                        }
                        for ($a = 0; $a <= $textmax; $a++) {
                            echo $text[$a];
                        }
                        if ($text[$textmax] != "") {
                            echo "...";
                        }
                        if ($i == 4) {
                            $i = 0;
                        }
                        $i++;
                        $kommentarezaehlen++;

                        echo " <a href=?action=delete2&id=" . $kom->id . ">Löschen</a><br>";
                        echo "<br>";
                    }
                    echo "<br>";
                    if ($kommentarezaehlen > 1) {
                        echo "Alle löschen?";
                        echo " <a href=?action=delete3&id=" . $_REQUEST["id"] . ">ja</a><br>";
                    }
                }
                echo "<br>";
            }
        }
    } else {

        echo "<h1>Bisherige Downloads</h1>";
        echo "<center><a href='dl_neu.php' class='kommentare'> Neuen Download hinzufügen</a></center><br>";

        /* SEITEN FUNKTION */
        $itemsPerPage = 20;
        $start = 0;
        if (!empty($_GET['go'])) {
            $start = ($_GET['go'] - 1) * $itemsPerPage;
        }
        pagefunc($itemsPerPage, "downloads", $link);
        $i = 0;
        if ($start >= 0) {
            $abfrage = "SELECT * FROM downloads ORDER BY id DESC LIMIT " . $start . ", " . $itemsPerPage;
        } else {
            $abfrage = "SELECT * FROM downloads ORDER BY id DESC LIMIT 0, " . $itemsPerPage;
        }
        $ergebnis = mysqli_query($link, $abfrage);
        echo "<br>";
        echo "<table>";
        while ($row = mysqli_fetch_object($ergebnis)) {
            echo "<tr>";
            echo "<td>";
            echo "<div class='gfx'>";
            echo "<h2>" . $row->name . "</h2>";
            echo "<table>";
            echo "<tr>";
            echo "<td>";
            echo "<div class='downloads'>";
            echo "<img src='Downloads/vorschau" . $row->id . $row->vorschau . "'>";
            echo "</div>";
            echo "</td>";
            echo "<td>";
            echo "<B>Download-Typ:</B> " . $row->typ . "<br>";
            echo "<b>Screenshot:</b> <a href='downloads/screen" . $row->id . $row->screen . " 
											target='_blank'>Link</a><br><br>";
            echo "<a href=?action=edit&id=" . $row->id . " class='kommentare'>Bearbeiten</a> ";
            echo "<a href=?action=delete&id=" . $row->id . " class='kommentare'>Löschen</a>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "</div>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "<br><br>";
    }
} else {
    echo "<p class='fault'>Du hast keinen Zutritt!</p>";
}
include('footer.php');
?>
