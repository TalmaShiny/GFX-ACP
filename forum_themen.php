<?php
include('header.php');
if (isset($_SESSION["acp"])) {

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "delete") {
        echo "<h1>Löschen?</h1>";
        echo "Möchtest du dieses Forum tatsächlich löschen?";
        echo "<form action='?action=delete2' method='post'>";
        echo "<input type='submit' name='delete_ja' value='Ja!'> ";
        echo "<input type='submit' name='delete_nein' value='Nein!'>";
        echo "<input type='hidden' name='id' value='" . $_REQUEST['foren_id'] . "'>";
        echo "</form>";
        echo "<br>";
    } elseif (isset($_REQUEST["delete_ja"])) {
        if (is_numeric($_REQUEST["id"])) {
            if (exist("forum_foren WHERE id = '" . $_REQUEST["id"] . "'", $link)) {
                mysqli_query($link, "DELETE FROM forum_foren WHERE id = '" . $_REQUEST["id"] . "'");
                echo "<p class='ok'>Forum wurde erfolgreich gelöscht.</p>";
                echo "<meta http-equiv='refresh' content='1; URL=forum_index.php'>"; // Weiterleitung
                include('footer.php');
                return;
            }
        }
    }

    $forum_abfrage = "SELECT * FROM forum_foren WHERE id ='" . $_REQUEST['foren_id'] . "'";
    $forum_ergebnis = mysqli_query($link, $forum_abfrage);
    $for = mysqli_fetch_object($forum_ergebnis);

    if (wert("forum_kategorien WHERE id='" . $for->kategorie_id . "'", "zugriff", $link) >= wert("benutzer WHERE id='" . $_SESSION["acp"] . "'", "gruppe", $link)) {

        echo "<h1>Themen im Forum <i>" . $for->name . "</i></h1>";
        echo "<p class='history'><b>History:</b> <a href='forum_index.php'>Übersicht</a> | Themen im Forum <i>" . $for->name . "</i></p>";

        echo "<p class='kategorie'><img src='webicons/forum.png' align='left' style='width:20px; padding-right: 4px;'>" . $for->name . "</p>";

        $i = 0;
        $themen_abfrage = "SELECT * FROM forum_themen WHERE foren_id ='" . $_REQUEST['foren_id'] . "'";
        $themen_ergebnis = mysqli_query($link, $themen_abfrage);
        while ($th = mysqli_fetch_object($themen_ergebnis)) {
            ?>

            <![if !IE]>
            <?= "<a href='forum_posts.php?themen_id=" . $th->id . "'>"; ?>
            <![endif]>

            <?php
            echo "<div class='forum'>";
            echo "<table width='100%'>";
            echo "<td width='50%' align='left'>";
            if ($for->status != "closed") {
                $heute = date("d.m.Y.", time()); // Heutiges Datum

                $posts2_abfrage = "SELECT timestamp FROM forum_antworten 
									WHERE themen_id IN(SELECT id FROM forum_themen WHERE foren_id ='" . $for->id . "')";
                /* SUCHE TIMESTAMP DER ANTWORTEN VON DEN THEMEN, DIE ZU DEM FORUM GEHÖREN */
                $posts2_ergebnis = mysqli_query($link, $posts2_abfrage);
                while ($posts2 = mysqli_fetch_object($posts2_ergebnis)) {
                    if ($heute == date("d.m.Y.", $posts2->timestamp)) {
                        $new = 1;
                    }
                }

                if ($new == 1) { /* Wenn heute schon Posts Icon mit +-Zeichen*/
                    echo "<img src='webicons/themen_new.png' style='border:0px; padding-right: 4px;'>";
                    $new = 0;
                } else { /* Wenn nicht - Icon ohne +-Zeichen */
                    echo "<img src='webicons/themen.png' style='border:0px; padding-right: 4px;'>";
                }
            } else {
                echo "<img src='webicons/themen_closed.png' style='border:0px; padding-right: 4px;'>";
            }

            $ersteller_abfrage = "SELECT name FROM benutzer WHERE id ='" . $th->ersteller_id . "'";
            $ersteller_ergebnis = mysqli_query($link, $ersteller_abfrage);
            $er = mysqli_fetch_object($ersteller_ergebnis);
            ?>
            <!--[if IE]>
            <?= "<a href='forum_posts.php?themen_id=".$th->id."'>";?>
            <![endif]-->
            <?php
            echo "<b>" . $th->thema . "</b><br>
								erstellt von " . $er->name . " (" . date("d.m.Y", $th->timestamp) . ", " . date("H:i", $th->timestamp) . " Uhr)";
            ?>
            <!--[if IE]>
            </a>
            <![endif]-->
            <?php
            echo "</td>";
            echo "<td width='10%'>";
            $antworten_abf = "SELECT count(id) AS anzahl FROM forum_antworten WHERE themen_id ='" . $th->id . "'";
            $antworten_ergebnis = mysqli_query($link, $antworten_abf);
            $ant = mysqli_fetch_object($antworten_ergebnis);
            echo "Posts: " . $ant->anzahl;
            echo "</td>";
            echo "<td width='30%' align='right'>";
            $thema_abfrage = "SELECT ersteller_id, timestamp FROM forum_antworten WHERE themen_id ='" . $th->id . "' ORDER by timestamp DESC LIMIT 0, 1";
            $thema_ergebnis = mysqli_query($link, $thema_abfrage);
            $thema = mysqli_fetch_object($thema_ergebnis);

            $name_abfrage = "SELECT name FROM benutzer WHERE id='" . $thema->ersteller_id . "'";
            $name_ergebnis = mysqli_query($link, $name_abfrage);
            $name = mysqli_fetch_object($name_ergebnis);

            echo "<b>" . $name->name . "</b><br>
								<i>(" . date("d.m.Y", $thema->timestamp) . ", " . date("H:i", $thema->timestamp) . " Uhr)</i>";
            echo "</td>";
            echo "</table>";
            echo "</div>";
            ?>
            <![if !IE]>
            </a>
            <![endif]>
            <?php
            $i++;
        }
        if ($i == 0) {
            echo "<p class='forum'>Dieses Unterforum ist bisher leer!</p>";
        }
        echo "<br>";

        echo "<table width='100%'>";
        echo "<td align='left' width='70%' valign='top'>";
        if (wert("benutzer WHERE id='" . $_SESSION["acp"] . "'", "gruppe", $link) == 1) {
            echo "<b>Admin:</b> ";
            echo "<a href='?action=delete&foren_id=" . $_REQUEST['foren_id'] . "' class='kommentare'>Unterforum löschen</a> ";
            echo "<a href='forum_foren_edit.php?&foren_id=" . $_REQUEST['foren_id'] . "' class='kommentare'>Unterforum ändern</a>";
        }
        echo "</td>";
        echo "<td align='right' width='30%' valign='top'>";
        if ($for->status != "closed") {
            echo "<a href='forum_themen_new.php?foren_id=" . $_REQUEST['foren_id'] . "' class='kommentare'>Neues Thema erstellen</a><br><br>";
        }
        echo "</td>";
        echo "</table><br><br>";

        echo "<div class='gfx' style='width:200px; height:120px; text-align:left'>";
        echo "<b>Themen-Legende:</b><br><br>";
        echo "<img src='webicons/themen.png' style='border:0px; padding-right: 4px;'> = Offenes Thema<br>";
        echo "<img src='webicons/themen_new.png' style='border:0px; padding-right: 4px;'> = Thema mit Posts von heute<br>";
        echo "<img src='webicons/themen_closed.png' style='border:0px; padding-right: 4px;'> = Geschlossenes Thema<br>";
        echo "</div>";

    } else {
        echo "<p class='fault'>für dieses Forum besitzt du keine Rechte!</p>";
    }
} else {
    echo "<p class='fault'>Nur eingeloggte Benutzer haben Zugriff auf das Forum!</p>";
}
include('footer.php');
?>
