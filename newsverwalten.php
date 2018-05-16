<?php
include("header.php");
include('pagetest.php');

if (isset($_SESSION["acp"])) { // Wenn eingeloggt..

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "edit" && isset($_REQUEST["id"])) {
        if (is_numeric($_REQUEST["id"])) {
            $abfrage = "SELECT * FROM news WHERE id ='" . $_REQUEST["id"] . "'";
            $ergebnis = mysqli_query($link, $abfrage);
            while ($row = mysqli_fetch_object($ergebnis)) {
                echo "<h1>News bearbeiten</h1>";
                echo "<script language='Javascript' src='bbcode.js'></script>";
                echo "<form action=\"newsverwalten.php?&action=update&id=" . $_REQUEST['id'] . "\" 
					method=\"post\" name='bbform'>";
                echo "<table>";
                echo "<tr>";
                echo "<td>Title:</td>";
                echo "<td><input type='text' name='name' value='" . $row->title . "' class='textinput'></td>";
                echo "</tr><tr>";
                echo "<td>Text:</td>";
                echo "<td>";
                echo "<div style='padding-top:5px;'>";
                include "bbc-buttons.php";
                echo "</div>";
                echo "<textarea name='message' rows='10' cols='34'>" . $row->text . "</textarea></td>";
                echo "</tr><tr>";
                echo "<td>Updates:</td>";
                echo "<td><textarea name='updates' rows='5' cols='34'>" . $row->updates . "</textarea></td>";
                echo "</tr><tr><td></td>";
                echo "<td><input type=\"submit\" value=\"Edit!\"></td>";
                echo "</tr></table></form><br><br>";

            }
            $abfrage2 = "SELECT * FROM news_kommentare WHERE news_id='" . $_REQUEST["id"] . "'";
            $ergebnis2 = mysqli_query($link, $abfrage2);
            while ($row2 = mysqli_fetch_object($ergebnis2)) {
                echo "- " . $row2->name . ", am " . date("d.m.Y", $row2->time) . ", " . date("H:i", $row2->time) . " Uhr ";
                echo "<a href=newsverwalten.php?action=delete2&id=" . $row2->id . ">
					<img src='webicons/delete.png' border='0'></a><br>";
            }
            echo "<br><br><br><img src='webicons/delete.png' border='0'> = löschen!<br>";

        }
    } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "update" && isset($_REQUEST["id"])) {
        if (is_numeric($_REQUEST["id"])) {
            $aendern = "UPDATE news Set 
				title= '" . save($_POST['name'], $link) . "',
				text = '" . save($_POST['message'], $link) . "',
				updates = '" . save($_POST['updates'], $link) . "' 
				WHERE id= '" . $_REQUEST["id"] . "'";
            $update = mysqli_query($link, $aendern); // Antwort hinzufügen
            echo "<p class='ok'>News erfolgreich geändert!</p><br /><br />";
            echo "<meta http-equiv='refresh' content='1; URL=newsverwalten.php'>";
        }
    } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "delete") {
        if (is_numeric($_REQUEST["id"])) {
            if (exist("news WHERE id = '" . $_REQUEST["id"] . "'", $link)) {
                mysqli_query($link, "DELETE FROM news WHERE id = '" . $_REQUEST["id"] . "'");
                echo "<p class='ok'>News wurde erfolgreich gelöscht.</p>";
            }
        }
    } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "delete2" && isset($_REQUEST["id"])) {
        if (is_numeric($_REQUEST["id"])) {
            $loeschen = "DELETE FROM news_kommentare WHERE id = '" . $_REQUEST["id"] . "'";
            $loesch = mysqli_query($link, $loeschen); // Eintrag löschen
            echo "<p class='ok'>Kommentar erfolgreich gelöscht</p><br />";
        }
    } else {
        echo "<h1>Bisherige Newseinträge</h1>";
        echo "<center><a href='news_neu.php' class='kommentare'>Neue News hinzufügen</a></center><br>";

        $itemsPerPage = 4;
        $start = 0;
        if (!empty($_GET['go'])) {
            $start = ($_GET['go'] - 1) * $itemsPerPage;
        }
        pagefunc($itemsPerPage, "news", $link);

        if ($start >= 0) {
            $abfrage = "SELECT * FROM news ORDER BY id DESC LIMIT " . $start . ", " . $itemsPerPage;
        } else {
            $abfrage = "SELECT * FROM news ORDER BY id DESC LIMIT 0, " . $itemsPerPage;
        }
        $ergebnis = mysqli_query($link, $abfrage);
        echo "<br>";
        while ($row = mysqli_fetch_object($ergebnis)) {
            echo "<div class='border'>";
            echo "<b>Title:</b> " . $row->title . "<br>";
            echo "<b>Webby:</b> " . $row->autor . "<br>";
            echo "<b>Datum:</b> " . date("d.m.Y", $row->time) . "<br>";
            echo "<div align='right'>";
            echo "<a href=?action=edit&id=" . $row->id . ">
						<img src='webicons/edit.png' border='0'> Bearbeiten</a> ";
            echo " <a href=?action=delete&id=" . $row->id . ">
						<img src='webicons/delete.png' border='0'> Löschen</a>";
            echo "</div>";
            echo "</div>";
            echo "<br><br>";
        }
        echo "<br /><br />";
    }
} else {
    echo "<center><br>Du hast keinen Zutritt!</center>";
}
include('footer.php');
?>
