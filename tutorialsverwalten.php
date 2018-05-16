<?php
include("header.php");
if (isset($_SESSION["acp"])) {

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "deletetutorial") {
        unlink("Tutorials/" . $_REQUEST["id"] . "" . wert("tutorials WHERE id = '" . save($_REQUEST["id"], $link) . "'", "vorschau", $link));
        $delete_news = "DELETE FROM tutorials WHERE id = '" . save($_REQUEST["id"], $link) . "'";
        $delete_news_a = mysqli_query($link, $delete_news) OR die(mysqli_error($link));

        $delete_comments = "DELETE FROM tutorials_kommentare WHERE tutorial_id = '" . save($_REQUEST["id"], $link) . "'";
        $delete_comments_a = mysqli_query($link, $delete_comments) OR die(mysqli_error($link));
        echo "<p class='ok'>Tutorial erfolgreich gelöscht.</p>";
    }
    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "updatetutorial") {
        if ($_POST['message'] != "" && $_POST['title'] != "") {
            $abfrage = "UPDATE tutorials SET
				titel ='" . save($_POST['title'], $link) . "',
				serie ='" . save($_POST['serie'], $link) . "',
				text ='" . save($_POST['message'], $link) . "'
				WHERE id='" . save($_REQUEST["id"], $link) . "'";
            mysqli_query($link, $abfrage);

            echo "<p class='ok'>Tutorial erfolgreich geändert!</p><br>";
        } else {
            echo "<p class='fault'>Du hast den Title oder den Textinhalt des Tutorials vergessen!</p><br>";
        }
    }

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "edittutorial") {
        echo "<h1>Tutorial bearbeiten</h1>";
        $abfrage = "SELECT * FROM tutorials WHERE id='" . save($_REQUEST["id"], $link) . "'";
        $query = mysqli_query($link, $abfrage);
        while ($row = mysqli_fetch_object($query)) {
            echo "<script language='Javascript' src='bbcode.js'></script>";
            echo "<form action='?action=updatetutorial&id=" . save($_REQUEST["id"], $link) . "' method='post' name='bbform' enctype='multipart/form-data'>";
            echo "<table width='500'>";
            echo "<tr>";
            echo "<td valign='top'>Title:</td>";
            echo "<td><input type='text' name='title' value='" . $row->titel . "' /></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td valign='top'>Serie:</td>";
            echo "<td>";
            echo "<select name='serie'>";
            if ($row->serie == "Grafikprogramm") {
                echo "<option value='Grafikprogramm' selected>Grafikprogramm</option>";
            } else {
                echo "<option value='Grafikprogramm'>Grafikprogramm</option>";
            }
            if ($row->serie == "PHP-Programmierung") {
                echo "<option value='PHP-Programmierung' selected>PHP-Programmierung</option>";
            } else {
                echo "<option value='PHP-Programmierung'>PHP-Programmierung</option>";
            }
            if ($row->serie == "HTML/CSS") {
                echo "<option value='HTML/CSS' selected>HTML/CSS</option>";
            } else {
                echo "<option value='HTML/CSS'>HTML/CSS</option>";
            }
            if ($row->serie == "Sonstiges") {
                echo "<option value='Sonstiges' selected>Sonstiges</option>";
            } else {
                echo "<option value='Sonstiges'>Sonstiges</option>";
            }
            echo "</select>";
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td></td>";
            echo "<td>";
            include('bbc-buttons.php');
            echo "<textarea name='message'  rows='10' cols='34'>" . $row->text . "</textarea>";
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td></td>";
            echo "<td><input type='submit' name='create' value='EDIT TUTORIAL' />";
            echo "</td>";
            echo "</tr>";
            echo "</form>";
            echo "</table>";
        }

    } else {
        echo "<h1>Tutorials verwalten</h1>";
        echo "<a href='tutorial_neu.php' class='kommentare'>Neues Tutorial erstellen?</a><br><br>";

        echo "<table width='500'>";
        $abfragen_contests = "SELECT * FROM tutorials ORDER BY id DESC";
        $ausfuehren_contests = mysqli_query($link, $abfragen_contests) OR die(mysqli_error($link));
        while ($row = mysqli_fetch_object($ausfuehren_contests)) {
            echo "<tr>";
            echo "<td>" . $row->titel . "</td>";
            echo "<td>" . $row->webby . "</td>";
            echo "<td>" . date("d.m.Y", $row->date) . "</td>";
            echo "<td>";
            echo "<a href='?action=deletetutorial&id=" . $row->id . "'>
				<img src='webicons/delete.png' border='0' /> Löschen</a> ";
            echo "<a href='?action=edittutorial&id=" . $row->id . "'>
				<img src='webicons/edit.png' border='0' /> Bearbeiten</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    echo "<p class='fault'>Nicht eingeloggt!</p>";
}
include("footer.php");
?>
