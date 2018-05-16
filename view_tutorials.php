<?php
include("header.php");
include("bbc.inc.php");

echo "<h1>Tutorial &raquo; ";
echo wert("tutorials WHERE id = '" . save($_REQUEST["id"], $link) . "'", "titel", $link) . "</h1>";

$select_news = "SELECT * FROM tutorials WHERE id = '" . save($_REQUEST["id"], $link) . "'";
$select_news_a = mysqli_query($link, $select_news) OR die(mysqli_error($link));
while ($row_news = mysqli_fetch_object($select_news_a)) {
    echo "<img src='Tutorials/" . $row_news->id . wert("tutorials WHERE id = '" . save($_REQUEST["id"], $link) . "'", "vorschau", $link) . "' 
		style='border:5px solid #C3C3C3; margin:4px;' align='left'>";
    echo bbccode($row_news->text, $link);
}

echo "<br><br><h1>Kommentare zum Tutorial</h1>";
echo "<center>";
$select_kommentare = "SELECT * FROM tutorials_kommentare WHERE tutorial_id = '" . save($_REQUEST["id"], $link) . "'";
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

if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "newkommentar") {
    if (!empty($_POST["name"]) && !empty($_POST["message"])) {
        if (isset($_SESSION["captchax"]) && $_SESSION["captchax"] == $_REQUEST["code"]) {
            unset($_SESSION["captchax"]);
            if (preg_match("/^[A-Za-z0-9 ]+$/", $_POST["name"])) {
                if (empty($_POST["email"])
                    || (!empty($_POST["email"]) && preg_match("/^[_a-z0-9-.]*@[_a-z0-9-.]*\.[a-z]{2,4}$/i", $_POST["email"]))) {
                    $newnews = "INSERT INTO tutorials_kommentare (tutorial_id, time, name, hp, email, text) VALUES (
						'" . save($_REQUEST["id"], $link) . "',
						'" . save(time(), $link) . "',
						'" . save($_POST["name"], $link) . "',
						'" . save($_POST["website"], $link) . "',
						'" . save($_POST["email"], $link) . "',
						'" . save($_POST["message"], $link) . "')";
                    $newwebby_query = mysqli_query($link, $newnews) OR die(mysqli_error($link));
                    echo "<p class='ok'>Kommentar erfolgreich erstellt.<br></p>";
                    echo "<meta http-equiv='refresh' content='1; URL=view_tutorials.php?id=" . $_REQUEST['id'] . "'>"; // Weiterleitung
                } else {
                    echo "<p class='fault'>Deine Email-Adresse ist ungültig!</p><br>";
                }
            } else {
                echo "<p class='fault'>Dein Name ist ungültig!</p><br>";
            }
        } else {
            echo "<p class='fault'>Der Sicherheitscode ist falsch!<br></p>";
        }
    } else {
        echo "<p class='fault'>Du hast vergessen, deinen Namen oder einen Text einzugeben!<br></p>";
    }
}

?>

<script language="Javascript" src="bbcode.js"></script>
<form action="view_tutorials.php?action=newkommentar&id=<?= $_REQUEST["id"]; ?>" method="post" name="bbform">
    <table width='80%' class='commentinputs'>
        <tr>
            <td colspan='2'><h2><img src='webicons/comment.png' border='0'> Kommentar hinterlassen</h2></td>
        </tr>
        <tr>
            <td>Name:</td>
            <td><input type="text" name="name" value="<?= (!empty($_POST['name']) ? $_POST['name'] : ""); ?>"/></td>
        </tr>
        <tr>
            <td>Homepage:</td>
            <td><input type="text" name="website" value="<?= (!empty($_POST['website']) ? $_POST['website'] : ""); ?>"/>
            </td>
        </tr>
        <tr>
            <td>E-Mail:</td>
            <td><input type="text" name="email" value="<?= (!empty($_POST['email']) ? $_POST['email'] : ""); ?>"/></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <div class='commenttext'>
                    <?php
                    include('bbc-buttons.php');
                    ?>
                    <textarea name="message" cols=31
                              rows=5><?= (!empty($_POST['message']) ? $_POST['message'] : ""); ?></textarea></div>
                <div class='gfx' style='text-align: center;'><?= smilies($link); ?></div>
            </td>
        </tr>
        <tr>
            <td>Sicherheitscode:</td>
            <td><img src="sicher.php" border="0"> <input type="text" name="code" size="5"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="create" value="Speichern"/></td>
        </tr>
    </table>
</form><br><br>
</center>

<?php
include("footer.php");
?>
