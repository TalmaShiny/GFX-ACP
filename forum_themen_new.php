<?php
include('header.php');
if (isset($_SESSION["acp"])) { // Wenn eingeloggt..

    $forum_abfrage = "SELECT name FROM forum_foren WHERE id ='" . $_REQUEST['foren_id'] . "'";
    $forum_ergebnis = mysqli_query($link, $forum_abfrage);
    $for = mysqli_fetch_object($forum_ergebnis);

    echo "<h1>Neues Forenthema erstellen</h1>";
    echo "<p class='history'><b>History:</b> <a href='forum_index.php'>Übersicht</a> | <a href='forum_themen.php?foren_id=" . $_REQUEST['foren_id'] . "'>" . $for->name . "</a> | Neues Thema erstellen</p>";

    if (isset($_POST['erstellen'])) { // Wenn Formular abgeschickt, dann...
        if (is_numeric($_REQUEST['foren_id'])) {
            $eintrag = "INSERT INTO forum_themen (thema, timestamp, status, foren_id, ersteller_id) VALUES (
				'" . save($_POST['thema'], $link) . "',
				'" . time() . "',
				'aktiv',
				'" . $_REQUEST['foren_id'] . "',
				'" . $_SESSION["acp"] . "'
				)";
            mysqli_query($link, $eintrag);

            $id = mysqli_insert_id($link);
            $eintrag = "INSERT INTO forum_antworten (timestamp, text, themen_id, ersteller_id) VALUES (
				'" . time() . "',
				'" . save($_POST['message'], $link) . "',
				'" . $id . "',
				'" . $_SESSION["acp"] . "'
				)";
            mysqli_query($link, $eintrag);

            if (mysqli_errno($link) == 0) { // Wenn MySQL keine Fehler hat dann...
                echo "<p class='ok'>Thema erfolgreich erstellt!</p><br>";
                echo "<meta http-equiv='refresh' content='1; URL=forum_themen.php?foren_id=" . $_REQUEST['foren_id'] . "'>";
            } else { // Wenn MySQL Fehler..
                echo "<p class='fault'>Fehler " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
            }
        }
    }
    ?>
    <script language="Javascript" src="bbcode.js"></script>

    <form method="post" name="bbform">
        <table>
            <tr>
                <td>Thema:</td>
                <td><input type='text' name='thema' size='49'></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <div class="commenttext">
                        <div style="padding-top:5px; margin-left: 16px">
                            <?php
                            include('bbc-buttons.php');
                            ?>
                        </div>
                        <textarea name='message' rows="10" cols="37"></textarea><br>
                    </div>
                    <div class='gfx' style='margin-left: 0px; text-align: center;'> <?= smilies($link); ?></div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Erstellen!" name="erstellen"></td>
            </tr>
        </table>
    </form>

    <?php
} else {
    echo "<p class='fault'>Nur eingeloggte Benutzer haben Zugriff auf das Forum!</p>";
}
include('footer.php');
?>
