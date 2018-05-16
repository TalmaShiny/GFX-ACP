<?php
include("header.php");
if (isset($_SESSION["acp"])) { // Wenn eingeloggt..

    echo "<h1>Neuen Download hinzufügen</h1>";

    if (isset($_REQUEST['hochladen'])) { // Wenn Formular abgeschickt, dann..
        $select = mysqli_query($link, "SELECT name FROM benutzer WHERE id ='" . $_SESSION["acp"] . "'");
        $row = mysqli_fetch_object($select);
        $endung = strstr($_FILES['vorschau']['name'], "."); // Nach Punkt im Namen -> Endung
        $endung2 = strstr($_FILES['screen']['name'], "."); // Nach Punkt im Namen -> Endung
        $zip = strstr($_FILES['zip']['name'], "."); // Nach Punkt im Namen -> Endung

        $eintrag = "INSERT INTO downloads (name, typ, info, vorschau, screen, zip, text, webby, views, downloads) 
			VALUES (
			'" . save($_POST['name'], $link) . "', 
			'" . save($_POST['typ'], $link) . "', 
			'" . save($_POST['info'], $link) . "', 
			'" . $endung . "',
			'" . $endung2 . "', 
			'" . $zip . "', 
			'" . save($_POST['message'], $link) . "', 
			'" . $row->name . "', 
			0, 
			0)";

        mysqli_query($link, $eintrag);
        $id = mysqli_insert_id($link);

        if (mysqli_errno($link) == 0) { // Wenn MySQL keine Fehler hat dann...
            move_uploaded_file($_FILES['vorschau']['tmp_name'], "Downloads/vorschau" . $id . $endung);
            move_uploaded_file($_FILES['screen']['tmp_name'], "Downloads/screen" . $id . $endung2);
            move_uploaded_file($_FILES['zip']['tmp_name'], "Downloads/load" . $id . $zip);
            echo "<p class='ok'>Erfolgreich eingetragen!</p>";
            echo '<meta http-equiv="refresh" content="1; url=downloadsverwalten.php">';
        } else { // Wenn MySQL Fehler..
            echo "<p class='fault'>Fehler " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
        }
    }
    ?>


    <br>
    <script language="Javascript" src="bbcode.js"></script>
    <form action="dl_neu.php" method="post" enctype="multipart/form-data" name="bbform">
        <table>
            <tr>
                <td>Typ:</td>
                <td>
                    <select name='typ'>
                        <option value='html'>HTML/CSS-Skript</option>
                        <option value='php'>PHP-Skript</option>
                        <option value='psd'>Photoshop-Datei</option>
                        <option value='set'>Resource Set</option>
                </td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><input type='text' name='name'></td>
            </tr>
            <tr>
                <td>Vorschau Gfx:</td>
                <td><input type='file' name='vorschau'> (100x100)</td>
            </tr>
            <tr>
                <td>Screenshot:</td>
                <td><input type='file' name='screen'> (600x400)</td>
            </tr>
            <tr>
                <td>Zip/Rar-Datei:</td>
                <td><input type='file' name='zip'></td>
            </tr>
            <tr>
                <td>Vorschau Text:</td>
                <td><textarea name='info' cols=34
                              rows=5><?= (!empty($_POST['info']) ? $_POST['info'] : "") ?></textarea></td>
            </tr>
            <tr>
                <td>Tutorial Text:<br> (nur bei Skripten)</td>
                <td>
                    <?php
                    include('bbc-buttons.php');
                    ?>
                    <textarea name="message" cols=34
                              rows=5><?= (!empty($_POST['message']) ? $_POST['message'] : "") ?></textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Hochladen!" name="hochladen"></td>
            </tr>
        </table>
    </form>

    <?php
} else {
    echo "<p class='fault'>Du hast keinen Zutritt!</p>";
}
include('footer.php');
?>
