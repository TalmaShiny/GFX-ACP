<?php
include('header.php');
if (isset($_SESSION["acp"])) { // Wenn eingeloggt..

    if (isset($_POST['hochladen'])) { // Wenn Formular abgeschickt, dann..
        $select = mysqli_query($link, "SELECT name FROM benutzer WHERE id ='" . $_SESSION["acp"] . "'");
        $row = mysqli_fetch_object($select);
        $eintrag = "INSERT INTO news (title, text, updates, time, autor) VALUES (
			'" . save($_POST['name'], $link) . "',
			'" . save($_POST['message'], $link) . "',
			'" . save($_POST['updates'], $link) . "',
			'" . time() . "',
			'" . $row->name . "'
			)";
        mysqli_query($link, $eintrag);

        $id = mysqli_insert_id($link);
        if (mysqli_errno($link) == 0) { // Wenn MySQL keine Fehler hat dann...
            echo "<p class='ok'>News erfolgreich eingetragen!</p><br>";
            echo "<meta http-equiv='refresh' content='1; URL=newsverwalten.php'>";
        } else { // Wenn MySQL Fehler..
            echo "<p class='fault'>Fehler " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
        }
    }
    ?>

    <h1>Neuen Newseintrag erstellen</h1>
    <br>
    <script language="Javascript" src="bbcode.js"></script>

    <form action="news_neu.php" method="post" name="bbform">
        <table>
            <tr>
                <td>Title (h1):</td>
                <td><input type='text' name='name' size='45'></td>
            </tr>
            <tr>
                <td>Text:</td>
                <td>
                    <div style="padding-top:5px; margin-left: 5px;">
                        <?php
                        include "bbc-buttons.php";
                        ?>
                    </div>
                    <textarea name='message' rows="10" cols="34"></textarea><br>
                    <center>
                        <div class='gfx' style='text-align: center;'><?= smilies($link); ?></div>
                </td>
            </tr>
            <tr>
                <td>Updates:</td>
                <td><textarea name='updates' rows="5" cols="34"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Hochladen!" name="hochladen"></td>
            </tr>
        </table>
    </form>

    <?php
} else {
    echo "<center>Du hast keinen Zutritt!</center>";
}
include('footer.php');
?>
