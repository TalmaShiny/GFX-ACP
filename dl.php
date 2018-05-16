<?php
include('header.php');
include('bbc.inc.php');

if (is_numeric($_REQUEST["id"])) {
    $abfrage = "SELECT * FROM downloads WHERE id='" . $_REQUEST["id"] . "'";
    $ergebnis = mysqli_query($link, $abfrage);
    while ($row = mysqli_fetch_object($ergebnis)) {
        echo "<h1>Download - " . $row->name . "</h1>";
        echo "<table>";
        echo "<tr>";
        echo "<td valign='top'>";
        echo "<div class='downloads'>";
        echo "<img src='Downloads/vorschau" . $row->id . $row->vorschau . "'>";
        echo "</div>";
        echo "</td>";
        echo "<td>";
        echo "<h2>Einleitungstext:</h2> " . bbccode($row->info, $link) . "<br><br>";
        if ($row->screen != "") {
            echo "<center>Vorweg eine kleine <b>Vorschau</b> des Downloads: 
							<a href='downloads/screen" . $row->id . $row->screen . "' target='_blank'>Screenshot</a></center><br>";
        }
        if ($row->text != "") {
            echo "<h2>Wichtiges zum Download</h2>";
            echo bbccode($row->text, $link) . "<br>";
            echo "<br>";
        } else {
            echo "<br><br><br>";
        }
        echo "</td>";
        echo "</tr>";
        echo "</table>";
    }

    echo "<br><br><h1>Bisherige Kommentare</h1>";

    echo "<table>";

    $select_kommentare = "SELECT * FROM downloads_kommentare WHERE dl_id='" . $_REQUEST["id"] . "'";
    $select_kommentare_a = mysqli_query($link, $select_kommentare) OR die(mysqli_error($link));
    if (mysqli_num_rows($select_kommentare_a) != 0) {
        while ($row_kommentare = mysqli_fetch_object($select_kommentare_a)) {
            echo "<table width='80%' cellpadding='4' cellspacing='1' border='0' class='tableinborder'>";
            echo "<tr>";
            echo "<th width='40%'><b>" . $row_kommentare->name . "</b></th>";
            echo "<th width='20%'>";
            if ($row_kommentare->email != "") {
                echo "<a href='mailto:" . $row_kommentare->email . "' target='_blank'>";
                echo "<img src='webicons/mail.png' border='' alt='Email'></a> ";
            }
            if ($row_kommentare->hp != "") {
                echo "<a href='" . $row_kommentare->hp . "' target='_blank'>";
                echo "<img src='webicons/website.png' border='' alt='Website'></a>";
            }
            echo "</th>";
            echo "<th width='30%'>";
            echo date("d.m.Y", $row_kommentare->time) . ", " . date("H:i", $row_kommentare->time);
            echo "</th>";
            echo "</tr><tr>";
            echo "<td colspan='3'>" . bbccode($row_kommentare->text, $link) . "</td>";
            echo "</tr>";
            echo "</table>";
            echo "<br><br>";
        }
    } else {
        echo "Bisher sind keine Kommentare vorhanden.";
    }
}

if (isset($_REQUEST['submit2'])) {
    if (!empty($_REQUEST["name"]) && !empty($_REQUEST["message"])) {
        if (isset($_SESSION["captchax"]) && $_SESSION["captchax"] == $_REQUEST["code"]) {
            unset($_SESSION["captchax"]);
            if (preg_match("/^[A-Za-z0-9 ]+$/", $_POST["name"])) {
                if (empty($_POST["email"])
                    || (!empty($_POST["email"]) && preg_match("/^[_a-z0-9-.]*@[_a-z0-9-.]*\.[a-z]{2,4}$/i", $_POST["email"]))) {
                    $update = "INSERT INTO downloads_kommentare (dl_id, name, email, hp, time, text) 
						VALUES (
						'" . $_REQUEST["id"] . "',
						'" . save($_POST['name'], $link) . "',
						'" . save($_POST['email'], $link) . "',
						'" . save($_POST['website'], $link) . "',
						'" . time() . "',
						'" . save($_POST['message'], $link) . "'
						)";
                    $update_a = mysqli_query($link, $update) OR die(mysqli_error($link));

                    echo "<p class='ok'>Kommentar erfolgreich hinzugefügt.<br></p>";
                    echo "<meta http-equiv='refresh' content='1; URL=?action=more&id=" . $_REQUEST['id'] . "'>"; // Weiterleitung
                } else {
                    echo "<p class='fault'>Deine Email-Adresse ist ungültig!</p><br>";
                }
            } else {
                echo "<p class='fault'>Dein Name ist ungültig!</p><br>";
            }
        } else {
            echo "<p class='fault'>Der Code ist falsch!<br></p>";
        }
    } else {
        echo "<p class='fault'>Bitte gebe einen Namen und eine Nachricht ein!<br></p>";
    }
}
?>

<br>
<script language="Javascript" src="bbcode.js"></script>
<form action="?action=comment&id=<?= $_REQUEST['id']; ?>" method="post" name="bbform">
    <table width='80%' class='commentinputs'>
        <tr>
            <td colspan='2'><h2><img src='webicons/comment.png' border='0'> Kommentar hinterlassen</h2></td>
        </tr>
        <tr>
            <td>Name:</td>
            <td><input type="text" name="name" value="<?= (!empty($_POST['name']) ? $_POST['name'] : "") ?>"/></td>
        </tr>
        <tr>
            <td>Homepage:</td>
            <td><input type="text" name="website" value="<?= (!empty($_POST['website']) ? $_POST['website'] : "") ?>"/>
            </td>
        </tr>
        <tr>
            <td>E-Mail:</td>
            <td><input type="text" name="email" value="<?= (!empty($_POST['email']) ? $_POST['email'] : "") ?>"/></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <div class='commenttext'>
                    <?php
                    include('bbc-buttons.php');
                    ?>
                    <textarea name="message" cols=31
                              rows=5><?= (!empty($_POST['message']) ? $_POST['message'] : "") ?></textarea></div>
                <div class='gfx' style='text-align: center;'><?= smilies($link); ?></div>
            </td>
        </tr>
        <tr>
            <td>Sicherheitscode:</td>
            <td><img src="sicher.php" border="0"><input type="text" name="code" size="5"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit2" value="Speichern"/></td>
        </tr>
    </table>
</form><br><br>
</center>

<?php
include("footer.php");
?>
