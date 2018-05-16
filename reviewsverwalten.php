<?php
include("header.php");
if (isset($_SESSION["acp"])) {

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "deletereview") {
        unlink("Reviews/" . $_REQUEST["id"] . "" . wert("reviews WHERE id = '" . save($_REQUEST["id"], $link) . "'", "vorschau", $link));
        $delete_news = "DELETE FROM reviews WHERE id = '" . save($_REQUEST["id"], $link) . "'";
        $delete_news_a = mysqli_query($link, $delete_news) OR die(mysqli_error($link));

        $delete_comments = "DELETE FROM reviews_kommentare WHERE review_id = '" . save($_REQUEST["id"], $link) . "'";
        $delete_comments_a = mysqli_query($link, $delete_comments) OR die(mysqli_error($link));
        echo "<p class='ok'>Review erfolgreich gelöscht.</p>";
    }

    if (isset($_POST['typedit'])) {
        $abfrage = "UPDATE reviews SET serie ='" . $_POST['serie'] . "' WHERE id='" . $_POST["id"] . "'";
        mysqli_query($link, $abfrage);
        echo "<p class='ok'>Review-Typ erfolgreich geändert!</p><br>";
    }

    echo "<h1>Reviews verwalten</h1><br>";
    echo "<br><center><a href='review_neu.php' class='kommentare'>Neues Review erstellen?</a></center><br><br>";

    echo "<table cellpadding='4' cellspacing='1' border='0' class='tableinborder' width='95%'>";
    echo "<tr>";
    echo "<th>Titel</th>";
    echo "<th>Webby</th>";
    echo "<th>Typ ändern</th>";
    echo "<th>Aktion</th>";
    echo "</tr>";
    $abfragen_contests = "SELECT * FROM reviews ORDER BY id DESC";
    $ausfuehren_contests = mysqli_query($link, $abfragen_contests) OR die(mysqli_error($link));
    while ($row = mysqli_fetch_object($ausfuehren_contests)) {
        echo "<tr>";
        echo "<td>";
        echo substr($row->titel, 0, 15);
        if (strlen($row->titel) > 15) {
            echo "...";
        }
        echo "</td>";
        echo "<td>" . $row->webby . "</td>";
        echo "<td>";
        echo "<form method='post'>";
        echo "<select name='serie'>";

        if ($row->serie == "Buch") {
            echo "<option value='Buch' selected>Buch/Zeitschrift</option>";
        } else {
            echo "<option value='Buch'>Buch/Zeitschrift</option>";
        }
        if ($row->serie == "Film") {
            echo "<option value='Film' selected>Film/Serie</option>";
        } else {
            echo "<option value='Film'>Film/Serie</option>";
        }
        if ($row->serie == "Kosmetik") {
            echo "<option value='Kosmetik' selected>Kosmetik</option>";
        } else {
            echo "<option value='Kosmetik'>Kosmetik</option>";
        }
        if ($row->serie == "Website") {
            echo "<option value='Website' selected>Website</option>";
        } else {
            echo "<option value='Website'>Website</option>";
        }
        if ($row->serie == "Musik") {
            echo "<option value='Musik' selected>Musik/Bands</option>";
        } else {
            echo "<option value='Musik'>Musik/Bands</option>";
        }
        if ($row->serie == "Sonstiges") {
            echo "<option value='Sonstiges' selected>Sonstiges</option>";
        } else {
            echo "<option value='Sonstiges'>Sonstiges</option>";
        }
        echo "</select>";
        echo " <input type='hidden' name='id' value='" . $row->id . "'>";
        echo " <input type='submit' name='typedit' value='ändern'>";
        echo "</form>";
        echo "</td>";
        echo "<td>";
        echo "<a href='?action=deletereview&id=" . $row->id . "'>
			<img src='webicons/delete.png' border='0' /> Delete</a> ";
        echo "<a href='review_edit.php?id=" . $row->id . "'>
			<img src='webicons/edit.png' border='0' /> Edit</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='fault'>Nicht eingeloggt!</p>";
}
include("footer.php");
?>
