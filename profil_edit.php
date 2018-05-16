<?php
include("header.php");
if (isset($_SESSION["acp"])) {

echo "<h1>Profil editieren</h1>";

if (isset($_POST["submit"])) {
    $update = mysqli_query($link, "UPDATE benutzer SET 
			name = '" . save($_POST["name"], $link) . "',
			email = '" . save($_POST["email"], $link) . "',
			hp = '" . save($_POST["hp"], $link) . "',
			tag = '" . save($_POST["tag"], $link) . "',
			monat = '" . save($_POST["monat"], $link) . "',
			jahr = '" . save($_POST["jahr"], $link) . "',
			benutzertext = '" . save($_POST["message"], $link) . "'
			WHERE id = '" . $_SESSION["acp"] . "'");
    echo "<p class='ok'>Dein Profil wurde erfolgreich geändert!</p>";

    // Passwort überprüfen und ändern
    if (!empty($_POST["passwort1"]) && !empty($_POST["passwort2"]) && !empty($_POST["passwort3"])) {
        $abfrage = "SELECT passwort FROM benutzer WHERE id = '" . $_SESSION["acp"] . "'";
        $ergebnis = mysqli_query($link, $abfrage);
        $row = mysqli_fetch_object($ergebnis);

        if (hash_equals($row->passwort, crypt($_POST["passwort1"], $row->passwort))) {
            if ($_POST["passwort2"] == $_POST["passwort3"]) {
                $update = "UPDATE benutzer SET 
						passwort = '" . crypt($_POST['passwort2'], $salt) . "' 
						WHERE id = '" . $_SESSION['acp'] . "'";
                mysqli_query($link, $update);
                echo "<p class='ok'>Dein Paswort wurde erfolgreich geändert!</p>";
            } else {
                echo "<p class='fault'>Dein neues Passwort stimmt nicht mit dessen Wiederholung überein!</p>";
            }
        } else {
            echo "<p class='fault'>Dein altes Passwort scheint nicht korrekt zu sein!</p>";
        }
    }

    // Bild ändern
    if (!empty($_FILES["bild"]["name"])) {
        if ($_FILES["bild"]["size"] <= 30000) {
            if (endung($_FILES["bild"]["name"]) == ".gif"
                || endung($_FILES["bild"]["name"]) == ".jpg"
                || endung($_FILES["bild"]["name"]) == ".png") {

                $size = getimagesize($_FILES["bild"]["tmp_name"]); // Informationen im Array
                if ($size[0] <= 100 && $size[1] <= 100) { // Wenn nicht grösser als 100*100

                    $abfrage = "SELECT bild FROM benutzer WHERE id = '" . $_SESSION["acp"] . "'";
                    $ergebnis = mysqli_query($link, $abfrage);
                    while ($row = mysqli_fetch_object($ergebnis)) {
                        if (!empty($row->bild)) { // Wenns davor schon ein Bild gibt..
                            unlink("Teamicons/" . $_SESSION["acp"] . $row->bild); // altes Bild löschen
                        }
                    }
                    $update = "UPDATE benutzer SET 
							bild = '" . endung($_FILES["bild"]["name"]) . "' 
							WHERE id = '" . $_SESSION["acp"] . "'";
                    mysqli_query($link, $update);
                    move_uploaded_file($_FILES["bild"]["tmp_name"], "Teamicons/" . $_SESSION["acp"] . endung($_FILES["bild"]["name"]));
                    echo "<p class='ok'>Dein Bild wurde erfolgreich geändert!</p>";

                } else {
                    echo "<p class='fault'>Dein Bild ist nicht 100x100 Pixel gross! Bitte wähle ein anderes...</p>";
                }
            }
        } else {
            echo "<p class='fault'>Dein Bild verbraucht zu viel Speicher! Bitte wähle ein anderes...</p>";
        }
    }
}

$abfrage = "SELECT * FROM benutzer WHERE id = '" . $_SESSION["acp"] . "' LIMIT 0,1";
$ergebnis = mysqli_query($link, $abfrage);
while ($row = mysqli_fetch_object($ergebnis)){
?>
<script language='Javascript' src='bbcode.js'></script>
<form method=post enctype="multipart/form-data" name='bbform'>
    <table width=90%>
        <tr>
            <td width=30%>
                <b>Altes PW:</b>
            </td>
            <td width=70%>
                <input type="password" name="passwort1">
            </td>
        </tr>
        <tr>
            <td width=30%>
                <b>Neues PW:</b>
            </td>
            <td width=70%>
                <input type="password" name="passwort2">
            </td>
        </tr>
        <tr>
            <td width=30%>
                <b>PW Wiederholung:</b>
            </td>
            <td width=70%>
                <input type="password" name="passwort3">
            </td>
        </tr>
        <tr height='15px'></tr>
        <tr>
            <td width=30%>
                <b>Name:</b>
            </td>
            <td width=70%>
                <input type="text" name="name" value="<?= $row->name; ?>">
            </td>
        </tr>
        <tr>
            <td width=30%>
                <b>E-Mail:</b>
            </td>
            <td width=70%>
                <input type="text" name="email" value="<?= $row->email; ?>">
            </td>
        </tr>
        <tr>
            <td width=30%>
                <b>Website:</b>
            </td>
            <td width=70%>
                <input type="text" name="hp" value="<?= $row->hp; ?>">
            </td>
        </tr>
        <tr>
            <td width=30%>
                <b>Geburtstag:</b>
            </td>
            <td width=70%>
                <select size=1 name="tag">
                    <?php
                    if (!empty($row->tag)) {
                        echo "<option>" . $row->tag . "</option>";
                    }
                    for ($i = 1; $i <= 31; $i++) {
                        if ($i < 10) { // Wenn Zahl 1-stellig..
                            $b = "0" . $i;
                        } else {
                            $b = $i;
                        }
                        if ($b != $row->tag) {
                            echo "<option>" . $b . "</option>";
                        }
                    }
                    ?>
                </select> Tag<br>
                <select size=1 name="monat">
                    <?php
                    if (!empty($row->monat)) {
                        echo "<option>" . $row->monat . "</option>";
                    }
                    for ($i = 1; $i <= 12; $i++) {
                        if ($i < 10) { // Wenn Zahl 1-stellig..
                            $b = "0" . $i;
                        } else {
                            $b = $i;
                        }
                        if ($b != $row->monat) {
                            echo "<option>" . $b . "</option>";
                        }
                    }
                    ?>
                </select> Monat<br>
                <select size=1 name="jahr">
                    <?php
                    if (!empty($row->jahr)) {
                        echo "<option>" . $row->jahr . "</option>";
                    }
                    for ($i = 1970; $i <= 2010; $i++) {
                        if ($i != $row->jahr) {
                            echo "<option>" . $i . "</option>";
                        }
                    }
                    ?>
                </select> Jahr
            </td>
        </tr>
        <tr>
            <td width=30%>
                <b>Profiltext:</b>
            </td>
            <td width=70%>
                <div class='commenttext'>
                    <center>
                        <?php
                        include 'bbc-buttons.php'
                        ?>
                    </center>
                    <textarea name="message" cols=34 rows=5><?= save($row->benutzertext, $link); ?></textarea>
                </div>
            </td>
        </tr>
        <tr>
            <td width=30% valign=top>
                <b>Team-Icon:</b><br/>
                <?php
                if (!empty($row->bild)) { // Wenn bild dann anzeigen
                    echo "<br /><img src=Teamicons/" . $_SESSION["acp"] . $row->bild . " border=0>";
                }
                ?>
            </td>
            <td width=70%>
                <b>Info:</b><br>
                - max. 30 000 Bytes = 29 KB<br/>
                - max. 100*100<br/>
                - nur .gif, .png und .jpg<br><br>
                <input type="file" name="bild">
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" value="Editieren" name="submit">
            </td>
        </tr>
    </table>
</form><br/>
<center>Info: PW und Bild bitte leer lassen, wenn es nicht geändert werden soll.<br><br/>
    <?php
    }
    }
    else {
        echo "Du bist nicht eingeloggt!<br>Einlogen?-> <a href='login.php'>klick</a>";
    }
    include("footer.php");
    ?>
