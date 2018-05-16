<?php
include('header.php');
include('bbc.inc.php');
if (isset($_SESSION["acp"])) { // Wenn eingeloggt..

    $thema_abfrage = "SELECT text, themen_id FROM forum_antworten WHERE id ='" . $_REQUEST['id'] . "'";
    $thema_ergebnis = mysqli_query($link, $thema_abfrage);
    $thema = mysqli_fetch_object($thema_ergebnis);

    if (isset($_POST['submit2'])) {
        if (!empty($_POST["message"])) {
            $update = "UPDATE forum_antworten SET
				text = '" . save($_POST['message'], $link) . "'
				WHERE id= '" . $_REQUEST['id'] . "'";
            mysqli_query($link, $update) OR die(mysqli_error($link));

            echo "<p class='ok'>Dein Post wurde erfolgreich geändert</p><br>";
            echo "<meta http-equiv='refresh' content='1; URL=forum_posts.php?themen_id=" . $thema->themen_id . "'>"; // Weiterleitung
        } else {
            echo "<p class='fault'>Du hast keinen Text angegeben</p><br>";
        }
    }

    $themen_abfrage = "SELECT thema, foren_id FROM forum_themen WHERE id ='" . $thema->themen_id . "'";
    $themen_ergebnis = mysqli_query($link, $themen_abfrage);
    $themen = mysqli_fetch_object($themen_ergebnis);

    $forum_abfrage = "SELECT name FROM forum_foren WHERE id ='" . $themen->foren_id . "'";
    $forum_ergebnis = mysqli_query($link, $forum_abfrage);
    $for = mysqli_fetch_object($forum_ergebnis);

    echo "<h1>Posts bearbeiten</h1>";
    echo "<p class='history'><b>History:</b> <a href='forum_index.php'>Übersicht</a> | <a href='forum_themen.php?foren_id=" . $themen->foren_id . "'>" . $for->name . "</a> | <a href='forum_posts.php?themen_id=" . $thema->themen_id . "'>" . $themen->thema . "</a> | Post bearbeiten</p>";


    /* FORMULAR */
    echo "<script language='Javascript' src='bbcode.js'></script>";
    echo "<form method='post' name='bbform'>";
    echo "<div class='commentinputs' style='padding:5px 30px 5px 30px'>";
    echo "<h2><img src='webicons/comment.png' border='0'> Antwort erstellen</h2>";
    echo "<div class='commenttext'><center>";
    include('bbc-buttons.php');
    echo "<textarea name='message' rows='8' cols='45'>" . $thema->text . "</textarea></div>";
    echo "<center><div class='gfx' style='text-align: center;'>" . smilies($link) . "</div>";
    echo "<input type='submit' name='submit2' value='Antwort ändern!'></center>";
    echo "</div>";
    echo "</form><br><br>";
} else {
    echo "<p class='fault'>Nur eingeloggte Benutzer haben Zugriff auf das Forum!</p>";
}
include('footer.php');
?>
