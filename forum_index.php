<?php
include('header.php');
echo "<h1>Das Forum</h1>";

if (isset($_SESSION["acp"])) {

    if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "delete") {
        echo "<h1>Löschen?</h1>";
        echo "Möchtest du diese Kategorie tatsächlich löschen?";
        echo "<form action='?action=delete2' method='post'>";
        echo "<input type='submit' name='delete_ja' value='Ja!'> ";
        echo "<input type='submit' name='delete_nein' value='Nein!'>";
        echo "<input type='hidden' name='id' value='" . $_REQUEST['id'] . "'>";
        echo "</form>";
        echo "<br>";
    } elseif (isset($_REQUEST["delete_ja"])) {
        if (is_numeric($_REQUEST["id"])) {
            if (exist("forum_kategorien WHERE id = '" . $_REQUEST["id"] . "'", $link)) {
                mysqli_query($link, "DELETE FROM forum_kategorien WHERE id = '" . $_REQUEST["id"] . "'");
                echo "<p class='ok'>Kategorie wurde erfolgreich gelöscht.</p>";
                echo "<meta http-equiv='refresh' content='1; URL=forum_index.php'>"; // Weiterleitung
            }
        }
    }

    $user_abfrage = "SELECT name FROM benutzer WHERE id = '" . $_SESSION["acp"] . "'";
    $user_ergebnis = mysqli_query($link, $user_abfrage);
    $user = mysqli_fetch_object($user_ergebnis);
    echo "<p class='gfx' style='padding:12px; margin:5px 0px 8px 0px'>Hallo und <img src='webicons/heart.png' width='12px'>-lich Willkommen im Forum, <b>" . $user->name . "</b>!</p>";

    if (wert("benutzer WHERE id='" . $_SESSION["acp"] . "'", "gruppe", $link) == 1) {
        echo "<br><b>Admin:</b> ";
        echo "<a href='forum_kategorie_new.php' class='kommentare'>Neue Kategorie erstellen</a> 
			<a href='forum_foren_new.php' class='kommentare'>Neues Unterforum erstellen</a> <br><br>";
    }

    $kategorie_abfrage = "SELECT * FROM forum_kategorien ORDER BY position ASC";
    $kategorie_ergebnis = mysqli_query($link, $kategorie_abfrage);
    while ($kat = mysqli_fetch_object($kategorie_ergebnis)) {

        /* KATEGORIEN NUR ANZEIGEN WENN USER ZUGRIFFSRECHTE BESITZT */
        if ($kat->zugriff >= wert("benutzer WHERE id='" . $_SESSION["acp"] . "'", "gruppe", $link)) {

            /* KATEGORIUE AUSGABE */
            echo "<div class='kategorie'>";
            echo "<table width='100%'>";
            echo "<td align='left' width='50%'>";
            echo "<img src='webicons/kategorie.png' align='left' style='padding-right: 5px;'> " . $kat->name;
            echo "</td><td align='right' width='50%'>";
            if (wert("benutzer WHERE id='" . $_SESSION["acp"] . "'", "gruppe", $link) == 1) {
                echo "<a href='forum_kategorie_edit.php?id=" . $kat->id . "'><img src='webicons/edit.png' border='0'></a> ";
                echo "<a href='forum_index.php?action=delete&id=" . $kat->id . "'><img src='webicons/delete.png' border='0'></a>";
            }
            echo "</td>";
            echo "</table>";
            echo "</div>";
            /* KATEGORIE AUSGABE ENDE */

            $foren_abfrage = "SELECT * FROM forum_foren WHERE kategorie_id ='" . $kat->id . "' ORDER BY position ASC";
            $foren_ergebnis = mysqli_query($link, $foren_abfrage);
            while ($for = mysqli_fetch_object($foren_ergebnis)) {
                ?>

                <![if !IE]>
                <?= "<a href='forum_themen.php?foren_id=" . $for->id . "'>"; ?>
                <![endif]>

                <?php
                echo "<div class='forum'>";
                echo "<table width='100%'>";
                echo "<td align='left' width='50%'>";

                /* WENN UNTERFORUM NOCH NICHT GESCHLOSSEN */
                if ($for->status != "closed") {
                    $new = 0;

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
                        echo "<img src='webicons/forum_new.png' style='border:0px; width:20px; padding-right: 4px;'>";
                        $new = 0;
                    } else { /* Wenn nicht - Icon ohne +-Zeichen */
                        echo "<img src='webicons/forum.png' style='border:0px; width:20px; padding-right: 4px;'>";
                    }
                } /* WENN UNTERFORUM GESCHLOSSEN ... */
                else {
                    echo "<img src='webicons/forum_closed.png' style='border:0px; width:20px; padding-right: 4px;'>";
                }
                ?>
                <!--[if IE]>
                <?= "<a href='forum_themen.php?foren_id=".$for->id."'>";?>
                <![endif]-->

                <?= "<b>" . $for->name . ":</b><br> <i>" . $for->beschreibung . "</i>"; ?>

                <!--[if IE]>
                <?= "</a>";?>
                <![endif]-->
                <?php
                echo "</td>";
                echo "<td align='right' width='15%'>";
                $themen_abfrage = "SELECT count(id) AS anzahl FROM forum_themen WHERE foren_id ='" . $for->id . "'";
                $themen_ergebnis = mysqli_query($link, $themen_abfrage);
                $th = mysqli_fetch_object($themen_ergebnis);
                echo "Themen: " . $th->anzahl;

                echo "</td>";
                echo "<td align='right' width='35%'>";
                $thema_abfrage = "SELECT timestamp, themen_id FROM forum_antworten 
									WHERE themen_id IN(SELECT id FROM forum_themen WHERE foren_id ='" . $for->id . "') 
									ORDER BY timestamp DESC LIMIT 0, 1";
                $thema_ergebnis = mysqli_query($link, $thema_abfrage);
                $thema = mysqli_fetch_object($thema_ergebnis);
                if (!empty($thema) && $thema->themen_id != "") {
                    $name_abfrage = "SELECT thema FROM forum_themen WHERE id='" . $thema->themen_id . "'";
                    $name_ergebnis = mysqli_query($link, $name_abfrage);
                    $name = mysqli_fetch_object($name_ergebnis);
                    echo $name->thema . "<br>
										<i>(" . date("d.m.Y", $thema->timestamp) . ", " . date("H:i", $thema->timestamp) . ")</i>";
                } else {
                    echo "bisher keine Themen";
                }
                echo "</td>";
                echo "</table>";
                echo "</div>";
                ?>
                <![if !IE]>
                </a>
                <![endif]>
                <?php
            }
            echo "<br>";

        }
    }

    echo "<div class='gfx' style='padding:12px; margin:5px 0px 8px 0px'>";
    echo "<b>Online sind:</b><br>";
    $user_time = "SELECT * FROM benutzer";
    $user_time_ergebnis = mysqli_query($link, $user_time);
    $string = "";
    while ($us = mysqli_fetch_object($user_time_ergebnis)) {
        if ($us->refresh > (time() - 60 * 3)) {
            $string .= "<a href='profil.php?user=" . $us->id . "'>" . $us->name . "</a>, ";
        }
    }
    echo substr($string, 0, -2);
    echo "</div><br>";


    /* STATISTIKEN UND LEGENDEN */
    $kategorien = "SELECT count(id) AS anzahl FROM forum_kategorien";
    $kategorien_ergebnis = mysqli_query($link, $kategorien);
    $kat = mysqli_fetch_object($kategorien_ergebnis);

    $foren = "SELECT count(id) AS anzahl FROM forum_foren";
    $foren_ergebnis = mysqli_query($link, $foren);
    $for = mysqli_fetch_object($foren_ergebnis);

    $themen = "SELECT count(id) AS anzahl FROM forum_themen";
    $themen_ergebnis = mysqli_query($link, $themen);
    $th = mysqli_fetch_object($themen_ergebnis);

    $posts = "SELECT count(id) AS anzahl FROM forum_antworten";
    $posts_ergebnis = mysqli_query($link, $posts);
    $post = mysqli_fetch_object($posts_ergebnis);

    echo "<center>";
    echo "<table>";
    echo "<td>";
    echo "<div class='gfx' style='width:200px; height:120px; text-align:left'>";
    echo "<b>Foren-Legende:</b><br><br>";
    echo "<img src='webicons/forum.png' style='border:0px; width:20px; padding-right: 4px;'> = Offenes Forum<br>";
    echo "<img src='webicons/forum_new.png' style='border:0px; width:20px; padding-right: 4px;'> = Forum mit Posts von heute<br>";
    echo "<img src='webicons/forum_closed.png' style='border:0px; width:20px; padding-right: 4px;'> = Geschlossenes Forum<br>";
    echo "</div>";
    echo "</td><td>";
    echo "<div class='gfx' style='width:200px; height:120px; text-align:left'>";
    echo "<b>Statistik:</b><br><br>";
    echo " <img src='webicons/kategorie.png' style='padding-right: 5px;'> <b>" . $kat->anzahl . "</b> Kategorien<br>";
    echo " <img src='webicons/forum.png' style='width:20px; padding-right: 1px;'> <b>" . $for->anzahl . "</b> Foren<br>";
    echo " <img src='webicons/themen.png' style='padding-right: 5px;'> <b>" . $th->anzahl . "</b> Themen<br>";
    echo " <img src='webicons/comment.png' style='padding-right: 5px;'> <b>" . $post->anzahl . "</b> Posts<br>";
    echo "</div>";
    echo "</td>";
    echo "</table>";
    echo "</center>";
} else {
    echo "<p class='fault'>Nur eingeloggte Benutzer haben Zugriff auf das Forum!</p>";
}

include('footer.php');
?>
