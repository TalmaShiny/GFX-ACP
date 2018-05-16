<?php
include('header.php');
include('bbc.inc.php');
if (isset($_SESSION["acp"])) { // Wenn eingeloggt..

    if (isset($_POST['submit2'])) {
        if (!empty($_POST["message"])) {
            $insert = "INSERT INTO forum_antworten (timestamp, text, themen_id, ersteller_id) 
				VALUES (
				'" . time() . "',
				'" . mysqli_real_escape_string($link, $_POST['message']) . "',
				'" . $_REQUEST['themen_id'] . "',
				'" . $_SESSION["acp"] . "'
				)";
            mysqli_query($link, $insert) OR die(mysqli_error($link));

            echo "<p class='ok'>Dein Post ist eingegangen. Vielen Dank!</p><br>";
            echo "<meta http-equiv='refresh' content='1; URL=forum_posts.php?themen_id=" . $_REQUEST['themen_id'] . "'>"; // Weiterleitung
        } else {
            echo "<p class='fault'>Du hast keinen Text angegeben</p><br>";
        }
    }

    $themen_abfrage = "SELECT * FROM forum_themen WHERE id ='" . $_REQUEST['themen_id'] . "'";
    $themen_ergebnis = mysqli_query($link, $themen_abfrage);
    $themen = mysqli_fetch_object($themen_ergebnis);

    $forum_abfrage = "SELECT name FROM forum_foren WHERE id ='" . $themen->foren_id . "'";
    $forum_ergebnis = mysqli_query($link, $forum_abfrage);
    $for = mysqli_fetch_object($forum_ergebnis);

    echo "<h1>Neue Antwort erstellen</h1>";
    echo "<p class='history'><b>History:</b> <a href='forum_index.php'>Übersicht</a> | <a href='forum_themen.php?foren_id=" . $themen->foren_id . "'>" . $for->name . "</a> | <a href='forum_posts.php?themen_id=" . $_REQUEST['themen_id'] . "'>" . $themen->thema . "</a> | Neue Antwort erstellen</p>";


    /* FORMULAR */
    echo "<script language='Javascript' src='bbcode.js'></script>";
    echo "<form method='post' name='bbform'>";
    echo "<div class='commentinputs' style='padding:5px 30px 5px 30px'>";
    echo "<h2><img src='webicons/comment.png' border='0'> Antwort erstellen</h2>";
    echo "<div class='commenttext'><center>";
    include('bbc-buttons.php');
    echo "<textarea name='message' rows='8' cols='45'>" . (!empty($_POST['message']) ? $_POST['message'] : '') . "</textarea>";
    echo "</div><br>";
    echo "<center><div class='gfx' style='text-align: center;'>" . smilies($link) . "</div>";
    echo "<input type='submit' name='submit2' value='Antwort hinzufügen!'></center>";
    echo "</div>";
    echo "</form><br><br>";

    echo "<h2>Die letzten 10 Antworten</h2>";
    $abfrage = "SELECT * FROM forum_antworten WHERE themen_id='" . $_REQUEST['themen_id'] . "' ORDER BY id DESC LIMIT 0, 10";
    $ergebnis = mysqli_query($link, $abfrage);
    while ($row = mysqli_fetch_object($ergebnis)) {
        $user_abfrage = "SELECT name, id, bild, since, email, hp FROM benutzer WHERE id='" . $row->ersteller_id . "'";
        $user_ergebnis = mysqli_query($link, $user_abfrage);
        $user = mysqli_fetch_object($user_ergebnis);
        echo "<table width='100%'>";
        echo "<td class='left' valign='top' align='center' width='25%'>";
        echo "<img src='webicons/user.png'> <a href='profil.php?user=" . $row->ersteller_id . "'><b>" . $user->name . "</b></a><br>";
        echo "Am " . date("d.m.Y", $row->timestamp) . ",<br> um " . date("H:i", $row->timestamp) . " Uhr";
        echo "</td><td valign='top' class='right' id='news' width='75%'>";
        echo bbccode($row->text, $link) . "<br>";
        echo "</td>";
        echo "</table>";
        echo "<br>";
    }

} else {
    echo "<p class='fault'>Nur eingeloggte Benutzer haben Zugriff auf das Forum!</p>";
}
include('footer.php');
?>
