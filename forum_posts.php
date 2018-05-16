<?php
include('header.php');
include('pagetest.php');
include('bbc.inc.php');

if (isset($_SESSION["acp"])) {
    $themen_abfrage = "SELECT * FROM forum_themen WHERE id ='" . $_REQUEST['themen_id'] . "'";
    $themen_ergebnis = mysqli_query($link, $themen_abfrage);
    $themen = mysqli_fetch_object($themen_ergebnis);

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "delete_antwort") {
        if (is_numeric($_REQUEST["id"])) {
            if (exist("forum_antworten WHERE id = '" . $_REQUEST["id"] . "'", $link)) {
                mysqli_query($link, "DELETE FROM forum_antworten WHERE id = '" . $_REQUEST["id"] . "'"); /* alle Posts löschen */
                echo "<p class='ok'>Post wurde erfolgreich gelöscht.</p>";
                echo "<meta http-equiv='refresh' content='1; URL=forum_posts.php?themen_id=" . $_REQUEST['themen_id'] . "'>"; // Weiterleitung
            }
        }
    }
    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "delete") {
        echo "<h1>Löschen?</h1>";
        echo "Möchtest du dieses Thema mit allen Posts tatsächlich löschen?";
        echo "<form action='forum_posts.php?themen_id=" . $_REQUEST['themen_id'] . "' method='post'>";
        echo "<input type='submit' name='delete_ja' value='Ja!'> ";
        echo "<input type='submit' name='delete_nein' value='Nein!'>";
        echo "<input type='hidden' name='id' value='" . $_REQUEST['themen_id'] . "'>";
        echo "</form>";
        echo "<br>";
    }

    if (isset($_REQUEST["delete_ja"])) {
        if (is_numeric($_REQUEST["id"])) {
            if (exist("forum_themen WHERE id = '" . $_REQUEST["id"] . "'", $link)) {
                mysqli_query($link, "DELETE FROM forum_antworten WHERE themen_id = '" . $_REQUEST["id"] . "'"); /* alle Posts löschen */
                mysqli_query($link, "DELETE FROM forum_themen WHERE id = '" . $_REQUEST["id"] . "'");

                echo "<p class='ok'>Thema wurde erfolgreich gelöscht.</p>";
                echo "<meta http-equiv='refresh' content='1; URL=forum_themen.php?foren_id=" . $themen->foren_id . "'>"; // Weiterleitung
            }
        }
    } else {
        $forum_abfrage = "SELECT name, status FROM forum_foren WHERE id ='" . $themen->foren_id . "'";
        $forum_ergebnis = mysqli_query($link, $forum_abfrage);
        $for = mysqli_fetch_object($forum_ergebnis);

        echo "<h1>" . $themen->thema . "</h1>";
        echo "<p class='history'><b>History:</b> <a href='forum_index.php'>Übersicht</a> | <a href='forum_themen.php?foren_id=" . $themen->foren_id . "'>" . $for->name . "</a> | " . $themen->thema . "</p>";

        // NEWSEINTRAG AUSGEBEN

        $itemsPerPage = 15;
        $start = 0;
        if (!empty($_GET['go'])) {
            $start = ($_GET['go'] - 1) * $itemsPerPage;
        }
        pageforum($itemsPerPage, "forum_antworten", $_REQUEST['themen_id'], $link);

        if ($start >= 0) {
            $abfrage = "SELECT * FROM forum_antworten WHERE themen_id='" . $_REQUEST['themen_id'] . "'ORDER BY id ASC LIMIT " . $start . ", " . $itemsPerPage;
        } else {
            $abfrage = "SELECT * FROM forum_antworten WHERE themen_id='" . $_REQUEST['themen_id'] . "' ORDER BY id ASC LIMIT 0, " . $itemsPerPage;
        }
        //$abfrage = "SELECT * FROM forum_antworten WHERE themen_id='".$_REQUEST['themen_id']."'";
        $ergebnis = mysqli_query($link, $abfrage);
        while ($row = mysqli_fetch_object($ergebnis)) {
            /* AB HIER FOLGT DAS STYLING DER POSTS */
            $user_abfrage = "SELECT name, id, bild, since, email, hp FROM benutzer WHERE id='" . $row->ersteller_id . "'";
            $user_ergebnis = mysqli_query($link, $user_abfrage);
            $user = mysqli_fetch_object($user_ergebnis);
            echo "<table width='100%'>";
            echo "<td class='left' valign='top' align='center' width='25%'>";
            echo "<img src='webicons/user.png'> <a href='profil.php?user=" . $row->ersteller_id . "'><b>" . $user->name . "</b></a><br>";

            if ($row->ersteller_id == $themen->ersteller_id) {
                echo "<i>Themeneröffner/in</i><br>";
            }
            echo "<br>";

            echo "<div class='gfx' style='width:65px'>";
            if (!empty($user->bild)) {
                echo "<img src=Teamicons/" . $user->id . $user->bild . " border='0' width='65px'>";
            } else {
                echo "<img src='Teamicons/default.png' border='0' width='65px'>";
            }
            echo "</div>";
            echo "<a href='mailto:" . $user->email . "'><img src='webicons/mail.png' border='0'></a> ";
            echo "<a href='" . $user->hp . "' target='_blank'><img src='webicons/website.png' border='0'></a><br>";

            echo "</td><td valign='top' class='right' id='news' width='75%'>";
            echo "<p align='right'>Am " . date("d.m.Y", $row->timestamp) . ", um " . date("H:i", $row->timestamp) . " Uhr</p>";
            echo "<div style='min-height: 100px'>";
            echo bbccode($row->text, $link) . "<br>";
            echo "</div>";

            if ($for->status != "closed" && $themen->status != "closed") {
                if ($row->ersteller_id == $_SESSION["acp"]) {
                    echo "<p align='right'>
									<a href='forum_posts_edit.php?id=" . $row->id . "'><img src='webicons/comment_add.png' border='0'></a> 
									<a href='?id=" . $row->id . "&themen_id=" . $_REQUEST['themen_id'] . "&action=delete_antwort'><img src='webicons/delete.png' border='0'></a> 
								</p>";
                } elseif (wert("benutzer WHERE id='" . $_SESSION["acp"] . "'", "gruppe", $link) == 1) {
                    echo "<p align='right'>
									<a href='?id=" . $row->id . "&themen_id=" . $_REQUEST['themen_id'] . "&action=delete_antwort'><img src='webicons/delete.png' border='0'></a> 
								</p>";
                }
            }
            echo "</td>";
            echo "</table>";
            echo "<br>";
            /* POSTSTYLING ENDE */
        }

        pageforum($itemsPerPage, "forum_antworten", $_REQUEST['themen_id'], $link);

        echo "<table width='100%'>";
        echo "<td align='left' width='70%' valign='top'>";
        if (wert("benutzer WHERE id='" . $_SESSION["acp"] . "'", "gruppe", $link) == 1) {
            echo "<b>Admin:</b> ";
            echo "<a href='?action=delete&themen_id=" . $_REQUEST['themen_id'] . "' class='kommentare'>Thema löschen</a> ";
            echo "<a href='forum_themen_edit.php?themen_id=" . $_REQUEST['themen_id'] . "' class='kommentare'>Thema ändern</a>";
        }
        echo "</td>";
        echo "<td align='right' width='30%' valign='top'>";
        if ($for->status != "closed" && $themen->status != "closed") {
            echo "<a href='forum_posts_new.php?themen_id=" . $_REQUEST['themen_id'] . "' class='kommentare'>Antworten</a>";
        }
        echo "</td>";
        echo "</table><br><br>";
    }

} else {
    echo "<p class='fault'>Nur eingeloggte Benutzer haben Zugriff auf das Forum!</p>";
}

include("footer.php");
?>
