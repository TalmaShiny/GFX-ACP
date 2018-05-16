<?php
include("header.php");
include("pagetest.php");
if (isset($_SESSION["acp"])) { // Wenn eingeloggt..

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "delete") {
        if (is_numeric($_REQUEST["id"])) {
            if (exist("credits WHERE id = '" . $_REQUEST["id"] . "'", $link)) {
                mysqli_query($link, "DELETE FROM credits WHERE id = '" . $_REQUEST["id"] . "'");
                echo "<p class='ok'>Credit wurde erfolgreich gelöscht.</p>";
            }
        }
    } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "edit" && isset($_REQUEST["id"])) {
        if (is_numeric($_REQUEST["id"])) {
            $abfrage = "SELECT * FROM credits WHERE id ='" . $_REQUEST["id"] . "'";
            $ergebnis = mysqli_query($link, $abfrage);
            while ($row = mysqli_fetch_object($ergebnis)) {
                echo "<h1>Credit bearbeiten</h1>";
                echo "<form action=\"creditsverwalten.php?&action=update&id=" . $_REQUEST['id'] . "\" method=\"post\">";
                echo "<table>";
                echo "<tr>";
                echo "<td>Name:</td>";
                echo "<td><input type='text' name='name' value='" . $row->name . "'></td>";
                echo "</tr><tr>";
                echo "<td>Typ:</td>";
                echo "<td><select name='typ'>";
                if ($row->typ == "inspiration") {
                    echo "<option value='inspiration' selected='selected'>Inpiration</option>
						<option value='tutorial'>Tutorial</option>
						<option value='brushes'>Brushes</option>
						<option value='texture'>Texture</option>
						<option value='sonstiges'>Sonstiges</option>";
                }
                if ($row->typ == "tutorial") {
                    echo "<option value='tutorial' selected='selected'>Tutorial</option>
						<option value='inspiration'>Inpiration</option>
						<option value='brushes'>Brushes</option>
						<option value='texture'>Texture</option>
						<option value='sonstiges'>Sonstiges</option>";
                }
                if ($row->typ == "brushes") {
                    echo "<option value='brushes' selected='selected'>Brushes</option>
						<option value='tutorial'>Tutorial</option>
						<option value='inspiration'>Inpiration</option>
						<option value='texture'>Texture</option>
						<option value='sonstiges'>Sonstiges</option>";
                }
                if ($row->typ == "texture") {
                    echo "<option value='texture' selected='selected'>Texture</option>
						<option value='brushes'>Brushes</option>
						<option value='tutorial'>Tutorial</option>
						<option value='inspiration'>Inpiration</option>
						<option value='sonstiges'>Sonstiges</option>";
                }
                if ($row->typ == "sonstiges") {
                    echo "<option value='sonstiges' selected='selected'>Sonstiges</option>
						<option value='texture'>Texture</option>
						<option value='brushes'>Brushes</option>
						<option value='tutorial'>Tutorial</option>
						<option value='inspiration'>Inpiration</option>";
                }
                echo "</td></tr>";
                echo "<tr>";
                echo "<td>URL:</td>";
                echo "<td><input type='text' name='url' value='" . $row->url . "'></td>";
                echo "</tr><tr><td></td>";
                echo "<td><input type=\"submit\" value=\"Edit!\"></td>";
                echo "</tr></table></form><br /><br />";
            }
        }
    } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "update" && isset($_REQUEST["id"])) {
        if (is_numeric($_REQUEST["id"])) {
            $aendern = "UPDATE credits Set 
			typ= '" . save($_POST['typ'], $link) . "',
			name= '" . save($_POST['name'], $link) . "',
			url = '" . save($_POST['url'], $link) . "' 
			WHERE id= '" . $_REQUEST["id"] . "'";
            $update = mysqli_query($link, $aendern); // Antwort hinzufügen
            echo "<p class='ok'>Crediteintrag wurden erfolgreich geändert</p><br />";
        }
    }
    ?>

    <h1>Bisherige Credits</h1>
    <center><a href="credits_neu.php">Neuen Credit hinzufügen</a></center><br>

    <?php
    $itemsPerPage = 4;
    $start = 0;
    if (!empty($_GET['go'])) {
        $start = ($_GET['go'] - 1) * $itemsPerPage;
    }
    pagefunc($itemsPerPage, "credits", $link);

    if ($start >= 0) {
        $abfrage = "SELECT * FROM credits ORDER BY name ASC LIMIT " . $start . ", " . $itemsPerPage;
    } else {
        $abfrage = "SELECT * FROM credits ORDER BY name ASC LIMIT 0, " . $itemsPerPage;
    }
    $ergebnis = mysqli_query($link, $abfrage);
    echo "<br>";
    while ($row = mysqli_fetch_object($ergebnis)) {
        echo "<div class='border'>";
        echo "<b>Name:</b> " . $row->name . "<br>";
        echo "<b>URL:</b> " . $row->url . "<br>";
        echo "<b>Typ:</b> " . $row->typ . "<br>";
        echo "<div align='right'>";
        echo "<a href=?action=edit&id=" . $row->id . ">
						<img src='webicons/edit.png' border='0'> Bearbeiten</a> ";
        echo " <a href=?action=delete&id=" . $row->id . ">
						<img src='webicons/delete.png' border='0'> Löschen</a>";
        echo "</div>";
        echo "</div><br>";
    }
    echo "<br /><br />";
} else {
    echo "<p class='fault'>Du hast keinen Zutritt!</p>";
}
include('footer.php');
?>
