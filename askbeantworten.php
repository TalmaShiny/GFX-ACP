<?php
include('header.php');
include('pagetest.php');
include('bbc.inc.php');

if (isset($_SESSION['acp'])) { // Wenn eingeloggt..

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "answer" && isset($_REQUEST['id'])) {
        $abfrage = "SELECT frage, antwort FROM askme WHERE id ='" . $_REQUEST['id'] . "'";
        $ergebnis = mysqli_query($link, $abfrage);
        while ($row = mysqli_fetch_object($ergebnis)) {
            echo "<h1>Frage bearbeiten</h1>";
            echo "<script language='Javascript' src='bbcode.js'></script>";
            echo "<form action=\"askbeantworten.php?action=update&id=" . $_REQUEST['id'] . "\" method=\"POST\" name='bbform'>";
            echo "<table>";
            echo "<tr>";
            echo "<td><b>Frage:</b></td>";
            echo "<td><textarea rows=5 cols=34 name=\"frage\">" . $row->frage . "</textarea></td>";
            echo "</tr><tr>";
            echo "<td><b>Antwort:</b></td>";
            echo "<td>";
            ?>
            <div style="padding-top:5px;">
                <center>
                    <img src="bbc/bold.gif" alt="fettgedruckter Text" title="fettgedruckter Text" border="0"
                         onclick="bbcode(document.bbform,'B','')" onmouseover="this.style.cursor='hand';"/>
                    <img src="bbc/italic.gif" alt="kursiver Text" title="kursiver Text" border="0"
                         onclick="bbcode(document.bbform,'I','')" onmouseover="this.style.cursor='hand';"/>
                    <img src="bbc/underline.gif" alt="unterstrichener Text" title="unterstrichener Text" border="0"
                         onclick="bbcode(document.bbform,'U','')" onmouseover="this.style.cursor='hand';"/>
                    <img src="bbc/center.gif" alt="zentrierter Text" title="zentrierter Text" border="0"
                         onclick="bbcode(document.bbform,'CENTER','')" onmouseover="this.style.cursor='hand';"/>
                    <img src="bbc/url.gif" alt="Hyperlink einfügen" title="Hyperlink einfügen" border="0"
                         onclick="namedlink(document.bbform,'URL')" onmouseover="this.style.cursor='hand';"/>
                    <img src="bbc/email.gif" alt="E-Mail-Adresse einfügen" title="E-Mail-Adresse einfügen" border="0"
                         onclick="namedlink(document.bbform,'EMAIL')" onmouseover="this.style.cursor='hand';"/>
                    <img src="bbc/image.gif" alt="Bild einfügen" title="Bild einfügen" border="0"
                         onclick="bbcode(document.bbform,'IMG','http://')" onmouseover="this.style.cursor='hand';"/>
                    <img src="bbc/quote.gif" alt="Zitat einfügen" title="Zitat einfügen" border="0"
                         onclick="bbcode(document.bbform,'QUOTE','')" onmouseover="this.style.cursor='hand';"/>
                    <img src="bbc/list.gif" alt="Liste erstellen" title="Liste erstellen" border="0"
                         onclick="dolist(document.bbform)" onmouseover="this.style.cursor='hand';"/>
                    <img src="bbc/code.gif" alt="CODE einfügen" title="CODE einfügen" border="0"
                         onclick="bbcode(document.bbform,'CODE','')" onmouseover="this.style.cursor='hand';"/>
                    <img src="bbc/php.gif" alt="PHP-Code einfügen" title="PHP-Code einfügen" border="0"
                         onclick="bbcode(document.bbform,'PHP','')" onmouseover="this.style.cursor='hand';"/></center>
            </div>
            <?php
            echo "<textarea rows=5 cols=34 name=\"message\">" . $row->antwort . "</textarea></td>";
            echo "</tr><tr>";
            echo "<td></td>";
            echo "<td><input type=\"submit\" value=\"Answer!\"></td>";
            echo "</tr></table></form><br /><br />";
        }
    } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "update" && isset($_REQUEST['id'])) {
        $select = mysqli_query($link, "SELECT name FROM benutzer WHERE id ='" . $_SESSION["acp"] . "'");
        $row = mysqli_fetch_object($select);
        $aendern = "UPDATE askme Set 
			frage= '" . save($_POST['frage'], $link) . "', 
			antwort = '" . save($_POST['message'], $link) . "',
			webby = '" . $row->name . "'
			WHERE id= '" . $_REQUEST['id'] . "'";
        $update = mysqli_query($link, $aendern); // Antwort hinzufügen
        echo "<p class='ok'>Antwort erfolgreich hinzugefügt</p><br />";
        echo "<meta http-equiv='refresh' content='1; URL=askbeantworten.php'>";
    } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "delete" && isset($_REQUEST["id"])) {
        $loeschen = "DELETE FROM askme WHERE id = '" . $_REQUEST['id'] . "'";
        $loesch = mysqli_query($link, $loeschen); // Eintrag löschen
        echo "<p class='ok'>Eintrag erfolgreich gelöscht</p><br />";
    } else {
        echo "<h1>Askme-Fragen</h1>";
        $itemsPerPage = 8;
        $start = 0;
        if (!empty($_GET['go'])) {
            $start = ($_GET['go'] - 1) * $itemsPerPage;
        }
        pagefunc($itemsPerPage, "askme", $link);

        if ($start >= 0) {
            $abfrage = "SELECT * FROM askme ORDER BY time DESC LIMIT " . $start . ", " . $itemsPerPage;
        } else {
            $abfrage = "SELECT * FROM askme ORDER BY time DESC LIMIT 0, " . $itemsPerPage;
        }
        $ergebnis = mysqli_query($link, $abfrage);
        $i = 0;
        while ($row = mysqli_fetch_object($ergebnis)) {
            echo "<div class='border'>";
            echo "<table>";
            echo "<tr>";
            echo "<td><b>Frager:</b></td>";
            echo "<td>" . $row->name . "</td>";
            echo "</tr><tr>";
            echo "<td><b>Am:</b></td>";
            echo "<td>" . date("d.m.Y", $row->time) . " um " . date("H:i", $row->time) . "</td>";
            echo "</tr><tr>";
            echo "<td><b>Frage:</b></td>";
            echo "<td>" . bbccode($row->frage, $link) . "</td>";
            echo "</tr><tr>";
            echo "<td><b>Antwort:</b></td>";
            echo "<td><i>" . bbccode($row->antwort, $link) . "</i></td>";
            echo "</tr>";
            echo "</table>";
            echo "<div align='right'>";
            echo "<a href=askbeantworten.php?action=answer&id=" . $row->id . ">
						<img src='webicons/edit.png' border='0'>Bearbeiten</a>";
            echo "<a href=askbeantworten.php?action=delete&id=" . $row->id . ">
						<img src='webicons/delete.png' border='0'>Löschen</a>";
            echo "</div>";
            echo "</div>";
            $i++;
        }
        if ($i == 0) {
            echo "Keine Fragen vorhanden!";
        }
        echo "<br /><br />";
    }
} else {
    echo "<center><br>Du hast keinen Zutritt!</center>";
}
include('footer.php');
?>
