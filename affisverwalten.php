<?php
include('header.php');
if (isset($_SESSION["acp"])) { // Wenn eingeloggt..

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "ja") {
        if (is_numeric($_REQUEST["id"])) {
            $select = "SELECT * FROM affisbecome WHERE id = '" . $_REQUEST["id"] . "'";
            $selectbecome = mysqli_query($link, $select);
            while ($row = mysqli_fetch_object($selectbecome)) {
                $name = $row->name;
                $url = $row->url;
                $button = $row->button;
            }

            $insert = "INSERT INTO affis (name, url, button) VALUES(
				'" . save($name, $link) . "', 
				'" . save($url, $link) . "', 
				'" . save($button, $link) . "'
				)";
            $insertaffi = mysqli_query($link, $insert);
            $delete = "DELETE FROM affisbecome WHERE id ='" . $_REQUEST["id"] . "'";
            $deleteaffi = mysqli_query($link, $delete);
            echo "<p class='ok'>Affi erfolgreich eingetragen</p><br>";
        }
    } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "nein") {
        if (is_numeric($_REQUEST["id"])) {
            $delete2 = "DELETE FROM affisbecome WHERE id ='" . $_REQUEST["id"] . "'";
            $deleteaffi2 = mysqli_query($link, $delete2);
            echo "<p class='ok'>Affi-Anfrage erfolgreich gelöscht.</p><br>";
        }
    } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "delete") {
        if (is_numeric($_REQUEST["id"])) {
            $delete3 = "DELETE FROM affis WHERE id ='" . $_REQUEST["id"] . "'";
            $deleteaffi3 = mysqli_query($link, $delete3);
            echo "<p class='ok'>Affi erfolgreich gelöscht.</p><br>";
        }
    }

    echo "<h1>Wartende Affis- ja oder nein sagen?</h1>";
    echo "<table align=\"center\"><tr>";

    $become = "SELECT * FROM affisbecome ORDER BY name";
    $becomeaffi = mysqli_query($link, $become);
    $i = 0;
    while ($row = mysqli_fetch_object($becomeaffi)) {
        if ($i % 4 == 0 && $i != 0) {
            echo "</tr><tr>";
        }
        $i++;
        echo "<td align=\"center\">";
        echo "<div class='affi'>";
        echo "<b>" . $row->name . "</b><br>";
        echo "<a href='" . $row->url . "' target=\"_blank\"><img src='" . $row->button . "' border=\"0\"></a><br>";
        echo "<a href='affisverwalten.php?action=ja&id=" . $row->id . "'>Ja</a> ";
        echo "<a href='affisverwalten.php?action=nein&id=" . $row->id . "'>Nein</a></div>";
        echo "</td>";
    }
    if ($i == 0) {
        echo "<td align=\"center\">Momentan keine Bewerbungen vorhanden.</td>";
    }
    echo "</tr></table>";

    echo "<h1>Affiliates</h1>";
    echo "<table align=\"center\"><tr>";

    $affis = "SELECT * FROM affis ORDER BY name";
    $affi_e = mysqli_query($link, $affis);
    $i = 0;
    if (mysqli_num_rows($affi_e) != 0) {
        while ($rowa = mysqli_fetch_object($affi_e)) {
            if ($i % 4 == 0 && $i != 0) {
                echo "</tr><tr>";
            }
            $i++;

            echo "<td align='center'>";
            echo "<div class='affi'>";
            echo "<a href='go_affi.php?id=" . $rowa->id . "' target='_blank'><img src='" . $rowa->button . "' border='0'></a><br>";
            echo "<b>" . $rowa->name . "</b><br>";
            echo "<a href=\"affis_edit.php?action=edit&id=" . $rowa->id . "\"><img src='webicons/edit.png' border='0'></a>";
            echo "<a href=\"affisverwalten.php?action=delete&id=" . $rowa->id . "\"><img src='webicons/delete.png' border='0'></a> ";
            echo "</div></td>";
        }
    } else {
        echo "<td align=\"center\">Momentan keine Affis vorhanden.</td>";
    }
    echo "</tr></table>";
} else {
    echo "<center><<br>Du hast keinen Zutritt!</center>";
}
include("footer.php");
?>
